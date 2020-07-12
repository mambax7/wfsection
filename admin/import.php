<?php
// $Id: import.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
// ------------------------------------------------------------------------ //
// WFsections for XOOPS                               //
// Copyright (c) 2004 WF-section Team                        //
// <http://www.wf-projects.com/>                          //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: WF-section Team                                                   //
// URL: http://www.wf-projects.com                                         //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
// 2004/02/28 K.OHWADA
// add adminmenu flag
// dummy for non multibyte environment
// bug fix
// double addslashes when magic_quotes_gpc is off
// uncomment : $url = XOOPS_URL;
// 2004/01/25 K.OHWADA
// print error message if can't copy image file
// bug fix : japanese -> 'japanese'
// 2003/11/21 K.OHWADA
// multi language
// Shift_JIS -> EUC-JP
// bug
// title occure error in DB processing, whiche have an escape character
// 2003/10/11 K.OHWADA
// create this file
// import html files to db
// =================================================
// Name:     import.php
// Function: Bulk import of HTML files
// Date:     2003/10/11
// Author:   Kenichi OHWADA
// =================================================
include 'admin_header.php';
// dummy for non multibyte environment
if ( !extension_loaded( 'mbstring' ) && !function_exists( 'mb_convert_encoding' ) ) {
    include_once WFS_ROOT_PATH . '/include/mb_dummy.php';
}

accessadmin( "importdoc" );

$op = "";

if ( isset( $_POST ) ) {
    foreach ( $_POST as $k => $v ) {
        ${$k} = $v;
    }
}

if ( isset( $_GET ) ) {
    foreach ( $_GET as $k => $v ) {
        ${$k} = $v;
    }
}

if ( isset( $HTTP_GET_VARS['op'] ) ) $op = $HTTP_GET_VARS['op'];
if ( isset( $HTTP_POST_VARS['op'] ) ) $op = $HTTP_POST_VARS['op'];

$error_flag = false;
xoops_cp_header();

wfs_admin_menu( _AM_WFS_ADMENUB );
wfs_textinfo( _AM_WFS_IMPORT, _AM_WFS_IMPORTTEXT );

if ( $op == 'Save' ) {
    proc_save();
} else {
    register_form();
}
xoops_cp_footer();
exit();

function proc_save() {
    global $HTTP_POST_VARS;
    global $error_flag;

    $dir_src = $HTTP_POST_VARS['dir_src'];
    $dir_image = $HTTP_POST_VARS['dir_image'];
    $filter = $HTTP_POST_VARS['filter'];
    $flag_image = isset( $HTTP_POST_VARS['image'] );
    $flag_copy = isset( $HTTP_POST_VARS['image_copy'] );
    $flag_test = isset( $HTTP_POST_VARS['test'] );

    $dir_image_full = XOOPS_ROOT_PATH . $dir_image;
    // test mode
    if ( $flag_test ) {
        echo "<hr>";
    }

    if ( !file_exists( $dir_src ) ) {
        echo "<font color=red>" . _AM_WFS_IMPORT_ERRDIREXI . "</font><br>$dir_src<br>\n";
        return;
    }

    if ( $filter ) {
        if ( !file_exists( $filter ) ) {
            echo "<font color=red>" . _AM_WFS_IMPORT_ERRFILEXI . "</font><br>$filter<br>\n";
            return;
        }

        if ( !is_executable( $filter ) ) {
            echo "<font color=red>" . _AM_WFS_IMPORT_ERRFILEXEC . "</font><br>$filter<br>\n";
            return;
        }
    }

    if ( $flag_image ) {
        if ( !$flag_copy ) {
            echo "<font color=red>" . _AM_WFS_IMPORT_ERRNOCOPY . "</font><br>\n";
            return;
        }

        if ( !$dir_image ) {
            echo "<font color=red>" . _AM_WFS_IMPORT_ERRNOIMGDIR . "</font><br>\n";
            return;
        }

        if ( file_exists( $dir_image_full ) && !is_dir( $dir_image_full ) ) {
            echo "<font color=red>" . _AM_WFS_IMPORT_ERRIMGDIREXI . "</font><br>$dir_image_full<br>\n";
            return;
        }
    }

    echo "<table><tr><td>\n";
    if ( is_dir( $dir_src ) ) {
        $file_array = XoopsLists::getFileListAsArray( $dir_src );
        $dir = dir_name( $dir_src );
        foreach ( $file_array as $file ) {
            file_proc( "$dir/$file" );
        }
    } else {
        file_proc( $dir_src );
    }
    echo "</td></tr></table><br>\n";

    /**
     * test mode
     */
    if ( $flag_test ) {
        echo "<hr>\n";
        echo "<a href=\"JavaScript:history.back()\">" . _AM_WFS_IMPORT . "</a>";
    } elseif ( $error_flag ) {
        echo "<hr>\n";
        echo "<font color=red>Unsuccessful!!</font><br><br>\n";
        echo "<a href=\"allarticles.php\">" . _AM_WFS_ARTICLEMANAGE . "</a><br>";
        echo "<a href=\"JavaScript:history.back()\">" . _AM_WFS_IMPORT . "</a>";
    } else {
        echo "<hr>\n";
        echo "<b>" . _AM_WFS_DBUPDATED . "</b><br><br>\n";
        echo "<a href=\"allarticles.php\">" . _AM_WFS_ARTICLEMANAGE . "</a>";
    }
}

function file_proc( $file ) {
    // file exist check
    if ( !file_exists( $file ) ) {
        echo "$file: <font color=red>" . _AM_WFS_IMPORT_ERRFILEEXI . "</font><br>\n";
        return;
    }
    // .html .htm
    elseif ( preg_match( '/\.html$/i', $file ) || preg_match( '/\.htm$/i', $file ) ) {
        file_html( $file );
    }
    // .txt
    elseif ( preg_match( '/\.txt$/i', $file ) ) {
        file_text( $file );
    }
    // .gif .jpg .jpeg .png
    elseif ( preg_match( '/\.gif$/i', $file ) || preg_match( '/\.jp(e?)g$/i', $file ) || preg_match( '/\.png$/i', $file ) ) {
        file_image( $file );
    }
}

function file_html( $file ) {
    global $xoopsModule, $HTTP_POST_VARS;
    global $error_flag;

    $filter = $HTTP_POST_VARS['filter'];
    $charset = $HTTP_POST_VARS['charset'];
    $flag_html = isset( $HTTP_POST_VARS['html'] );
    $flag_index = isset( $HTTP_POST_VARS['index'] );
    $flag_link = isset( $HTTP_POST_VARS['link'] );
    $flag_image = isset( $HTTP_POST_VARS['image'] );
    $flag_atmark = isset( $HTTP_POST_VARS['atmark'] );
    $flag_test = isset( $HTTP_POST_VARS['test'] );
    $test_text = isset( $HTTP_POST_VARS['test_text'] );
    $dir_image = $HTTP_POST_VARS['dir_image'];

    /**
     * uncomment
     */
    $url = XOOPS_URL;
    $dir = $url . dir_name( $dir_image );
    // $dir = str_replace(,,$dir)
    $script = $url . '/modules/' . $xoopsModule->dirname() . '/article.php?title=';
    $file_temp = '/tmp/import_' . strftime( "%Y%m%d%H%M%S" ) . '.tmp';

    list( $data, $name, $time ) = file_read( $file );
    // external filter
    if ( $filter ) {
        `cat $file | $filter > $file_temp`;
        $data = join( file( $file_temp ), '' );
        unlink( $file_temp );
    }
    // $charset = 0, if not Japanese mode
    // Shift_JIS -> EUC-JP
    if ( ( $charset == '1' ) &&
            ( ( preg_match( '|<\s*meta\s?.*?charset="Shift_JIS"\s?.*?>|is', $data ) ||
                    ( mb_detect_encoding( $data ) == 'SJIS' ) ) ) ||
            ( $charset == '2' ) ) {
        $data = mb_convert_encoding( $data, "EUC-JP", "SJIS" );
    }
    // title
    if ( preg_match( '|<\s*title\s?.*?>(.*)<\s*/\s*title\s*>|is', $data, $match ) ) {
        $title = ucwords( $match[1] );
    }
    // body
    if ( preg_match( '|<\s*body\s?.*?>(.*)<\s*/\s*body\s*>|is', $data, $match ) ) {
        $text = $match[1];
    } else {
        $text = $data;
    }
    // delete index.html
    if ( $flag_index ) {
        $text = preg_replace( '|<\s*a\s?href=[\"\']index\.htm.*?>(.*?)<\s*/\s*a\s*>|is', "$1", $text );
        $text = preg_replace( '|<\s*a\s?href=[\"\']\.\./index\.htm.*?>(.*?)<\s*/\s*a\s*>|is', "$1", $text );
    }
    // link
    if ( $flag_link ) { // {	$text = preg_replace('|<\s*a\s?href=[\"\'](?!http)(?!ftp)(.*?)[\"\']\s*>(.*?)<\s*/\s*a\s*>|is', "<a href=\"$script$1\">$2</a>", $text);	}
        $text = preg_replace( '|<\s*a\s?href=[\"\'](?!http)(?!ftp)(?!#)(.*?)[\"\']\s*>(.*?)<\s*/\s*a\s*>|is', "<a href=\"$script$1\">$2</a>", $text );
    }
    // image
    if ( $flag_image ) {
        $text = preg_replace( '|<\s*img\s?src=[\"\'](?!/)(.*?)[\"\']\s*(.*?)\s*>|is', "<img src=\"$dir/$1\" $2>", $text );
    }
    // atmark
    if ( $flag_atmark ) {
        $text = preg_replace( '|@|', "&#064;", $text );
    }

    if ( empty( $text ) ) {
        $text = $data;
    }
    if ( empty( $title ) ) {
        $title = $name;
    }
    // test mode
    if ( $flag_test ) {
        $date = date( "Y/m/d H:i:s", $time );
        echo "$file: $date <br>\n";
        if ( $test_text ) {
            echo "$text<br><hr>\n";
        }
        return;
    }

    if ( db_store( $text, $title, $time ) ) {
        echo "<b>" . basename( $file ) . "</b> - Imported<br>\n";
    } else {
        echo "$file: <font color=red>save failed</font><br>\n";
        $error_flag = true;
    }
}

function file_text( $file ) {
    global $HTTP_POST_VARS;
    global $error_flag;

    $flag_text = $HTTP_POST_VARS['text'];
    $flag_test = $HTTP_POST_VARS['test'];
    $test_text = $HTTP_POST_VARS['test_text'];

    list( $data, $name, $time ) = file_read( $file );

    if ( $flag_text ) {
        $text = "<pre>$data</pre>";
    } else {
        $text = $data;
    }
    // test mode
    if ( $flag_test ) {
        $date = date( "Y/m/d H:i:s", $time );
        echo "$file: $date <br>\n";
        if ( $test_text ) {
            echo "$text<br><hr>\n";
        }
        return;
    }

    if ( db_store( $text, $name, $time ) ) {
        echo "$file<br>\n";
    } else {
        echo "$file: <font color=red>Save failed</font><br>\n";
        $error_flag = true;
    }
}

function file_image( $file ) {
    global $HTTP_POST_VARS;
    global $error_flag;

    $flag_copy = $HTTP_POST_VARS['image_copy'];
    $flag_test = $HTTP_POST_VARS['test'];
    $dir_image = $HTTP_POST_VARS['dir_image'];

    if ( !$flag_copy ) {
        echo "$file: none<br>\n";
        return;
    }

    $dir_image_full = XOOPS_ROOT_PATH . dir_name( $dir_image );
    $file_dest = $dir_image_full . '/' . basename( $file );
    // file exist check
    if ( file_exists( $file_dest ) ) {
        echo "$file: <font color=red>already existed</font><br>\n";
        return;
    }
    // make dir if not exist
    if ( !file_exists( $dir_image_full ) ) {
        // test mode
        if ( $flag_test ) {
            echo "mkdir $dir_image_full: test<br>\n";
        } else {
            // make dir
            if ( mkdir( $dir_image_full, 0707 ) ) {
                echo "mkdir $dir_image_full <br>\n";
            } else {
                echo "<font color=red>mkdir failed $dir_image_full</font><br>\n";
                $error_flag = true;
            }
        }
    }
    // test mode
    if ( $flag_test ) {
        $time = filemtime( $file );
        $date = date( "Y/m/d H:i:s", $time );
        echo "$file: $date <br> -> $file_dest <br>\n";
        return;
    }
    // file copy
    if ( copy( $file, $file_dest ) ) {
        echo "$file <br> -> $file_dest <br>\n";
    } else {
        echo "$file: <font color=red>copy failed</font><br>\n";
        $error_flag = true;
    }
}

function file_read( $file ) {
    $name = basename( $file );
    $time = filemtime( $file );
    $data = join( file( $file ), '' );

    if ( empty( $time ) ) $time = time();
    return array( $data, $name, $time );
}

function dir_name( $dir ) {
    $dir = preg_replace( '|/$|', '', $dir );
    return $dir;
}

function db_store( $maintext, $title, $time ) {
    global $xoopsUser, $wfsConfig, $HTTP_POST_VARS;

    $cid = $HTTP_POST_VARS['categoryid'];
    $flag_test = isset( $HTTP_POST_VARS['test'] );

    if ( $flag_test ) {
        return;
    }
    if ( !$maintext ) {
        return false;
    }
    if ( !$title ) {
        return false;
    }
    if ( !$time ) {
        return false;
    }
    if ( !$cid ) {
        return false;
    }

    $myts = &MyTextSanitizer::getInstance();
    $article = new WfsArticle();
    $article->setTitle( $title );

    $text = $myts->htmlSpecialChars( $maintext );
    $article->setMainText( addslashes( $text ) );
    $article->setPublished( time() );
    $article->setCategoryid( $cid );
    $article->setUserType( "admin" );
    $article->setGroups( '1 2 3', 0 );
    $article->noshowart = 0;
    $article->nohtml = 0;
    $article->nosmiley = 0;
    $article->offline = 0;
    $article->notifypub = 0;
    $article->ishtml = 0;
    $article->setApproved( 1 );
    if ( $article->store() ) {
        return true;
    } else {
        return false;
    }
}

function register_form() {
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig, $HTTP_SERVER_VARS, $HTTP_POST_VARS, $wfsPathConfig;

    $sform = new XoopsThemeForm( _AM_WFS_IMPORT, "op", xoops_getenv( 'PHP_SELF' ) );

    $xt = new WfsCategory();
    ob_start();
    echo $xt->makeSelBox( 0, 0, "categoryid" );
    $sform->addElement( new XoopsFormLabel( _AM_WFS_CATEGORY, ob_get_contents() ) );
    ob_end_clean();

    $dir = WFS_HTML_PATH;
    $sform->addElement( new XoopsFormText( _AM_WFS_IMPORT_DIRNAME, 'dir_src', 50, 255, $dir ), true );

    $sform->insertBreak( "<b>" . _AM_WFS_IMPORT_HTMLPROC . "</b>", "even" );
    $sform->addElement( new XoopsFormText( _AM_WFS_IMPORT_EXTFILTER, 'filter', 50, 255, '' ), false );
    $sform->addElement( new XoopsFormHidden( "charset", 0 ) );

    ob_start();
    echo "<input type='checkbox' name='html' checked> ";
    echo _AM_WFS_IMPORT_BODY . "<br>\n";
    echo "<input type='checkbox' name='index' checked> ";
    echo _AM_WFS_IMPORT_INDEXHTML . "<br>\n";
    echo "<input type='checkbox' name='link' checked> ";
    echo _AM_WFS_IMPORT_LINK . "<br>\n";
    echo "<input type='checkbox' name='image' checked> ";
    echo _AM_WFS_IMPORT_IMAGE . "<br>\n";
    echo "<input type='checkbox' name='atmark' checked> ";
    echo _AM_WFS_IMPORT_ATMARK . "<br><br>\n";
    $sform->addElement( new XoopsFormLabel( '', ob_get_contents() ) );
    ob_end_clean();

    $sform->insertBreak( "<b>" . _AM_WFS_IMPORT_IMAGEPROC . "</b>", "even" );

    $dir = $wfsPathConfig['graphicspath'];
    $sform->addElement( new XoopsFormText( _AM_WFS_IMPORT_IMAGEDIR, 'dir_image', 50, 255, $dir ), false );

    $img_checkbox = new XoopsFormCheckBox( _AM_WFS_IMPORT_IMAGECOPY, "image_copy", 1 );
    $img_checkbox->addOption( 1, " " );
    $sform->addElement( $img_checkbox );

    $sform->insertBreak( "<b>" . _AM_WFS_IMPORT_TESTMODE . "</b><br >" . _AM_WFS_IMPORT_TESTDB, "even" );

    $test_checkbox = new XoopsFormCheckBox( _AM_WFS_IMPORT_TESTEXEC, "test", 1 );
    $test_checkbox->addOption( 1, " " );
    $sform->addElement( $test_checkbox );

    $texttest_checkbox = new XoopsFormCheckBox( _AM_WFS_IMPORT_TESTTEXT, "test_text", 1 );
    $texttest_checkbox->addOption( 1, " " );
    $sform->addElement( $texttest_checkbox );
    if ( !empty( $HTTP_POST_VARS['referer'] ) ) {
        $sform->addElement( new XoopsFormHidden( "referer", $HTTP_POST_VARS['referer'] ) );
    } elseif ( !empty( $HTTP_SERVER_VARS['HTTP_REFERER'] ) ) {
        $sform->addElement( new XoopsFormHidden( "referer", $HTTP_SERVER_VARS['HTTP_REFERER'] ) );
    }

    $button_tray = new XoopsFormElementTray( "", "" );
    $hidden = new XoopsFormHidden( "op", "save" );
    $button_tray->addElement( $hidden );

    $butt_save = new XoopsFormButton( "", "", _AM_WFS_SAVE, "submit" );
    $butt_save->setExtra( "onclick='this.form.elements.op.value=\"Save\"'" );
    $button_tray->addElement( $butt_save );
    $sform->addElement( $button_tray );
    $sform->display();

    /**
     * import word document if current server config allows
     */
    /**
     * Check for word
     */
    $allow_com = wfs_dcom_check();
    $allow_word = ( isset( $allow_com['ini_set'] ) ) ? _AM_WFS_IMPORTWORDINYES : _AM_WFS_IMPORTWORDINNO;
    $allow_com_text = ( isset( $allow_com['word'] ) ) ? _AM_WFS_IMPORTWORDYES : _AM_WFS_IMPORTWORDNO;

    $import_extra = "<br />
		<li><b>" . _AM_WFS_IMPORTCOMENABLED . "</b> $allow_com_text</li>
		<li><b>" . _AM_WFS_IMPORTWORDINSTALL . "</b> $allow_word</li>
		<br /><br /><li>" . _AM_WFS_IMPORTWORDSELECT . "</li>
		";

    wfs_textinfo( _AM_WFS_IMPORTWORD, _AM_WFS_IMPORTWORDTXT . $import_extra );
    if ( $allow_com['ini_set'] && $allow_com['word'] ) {
        echo "<table width = '100%' cellpadding = '2' cellspacing = '1' class = 'outer'>";
        echo "<form action='index.php' method='post' name='coolsus'>";
        echo "<th colspan = '2'>" . _AM_WFS_IMPORTWORD . "</th>";
        echo "<tr>";
        echo "<td class = 'head'>" . _AM_WFS_EDITWORDBROWSE . "</td>";
        echo "<td class = 'even'><input type='file' name='file'>";
        echo "</td></tr>";

        echo "<tr>";
        echo "<td class = 'head'></td>";
        echo "<td class = 'even'>";
        echo "<input type='submit' name='op' class='formButton' value='addword' />";
        echo "</td></tr>";
        echo "</form>";
        echo "</table>";
    } else {
        echo "<h4>" . _AM_WFS_WORDNOTINSTALLED . "</h4>";
    }
    echo "<table width = '100%' cellpadding = '2' cellspacing = '1' class = 'outer'>";
    echo "<form enctype=\"multipart/form-data\" action='index.php' method='post' name='importpdfform'>";
    echo "<th colspan = '2'>" . _AM_WFS_IMPORTPDF . "</th>";
    echo "<tr>";
    echo "<td class = 'head'>" . _AM_WFS_EDITPDFBROWSE . "</td>";
    echo "<td class = 'even'>";
    echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\" />";
    echo "<input type='file' name='pdffile'>";
    echo "</td></tr>";

    echo "<tr>";
    echo "<td class = 'head'></td>";
    echo "<td class = 'even'>";
    echo "<input type='submit' name='op' class='formButton' value='addpdf' />";
    echo "</td></tr>";
    echo "</form>";
    echo "</table>";
}

?>
