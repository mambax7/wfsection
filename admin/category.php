<?php
// $Id: category.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include( "admin_header.php" );
accessadmin( "newsection" );

$op = '';
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

function editCategoryForm( $id = 0 ) {
    global $xoopsModuleConfig, $wfsPathConfig;

    include_once WFS_ROOT_PATH . "/class/wfslists.php";

    $xt = new WfsCategory( $id );

    $cateheading = ( $xt->id ) ? _AM_WFS_MODIFYCATEGORY . ": " . $xt->title() : _AM_WFS_ADDMCATEGORY;
    $sform = new XoopsThemeForm( $cateheading, "op", xoops_getenv( 'PHP_SELF' ) );

    $groups = ( $xt->id ) ? explode( " ", $xt->groupid ) : true;
    $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_GROUPPROMPT, 'groupid', true, $groups, 5, true ) );

    $groupcreate = ( $xt->id ) ? explode( " ", $xt->groupcreate ) : true;
    $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_GROUPCREATEPROMPT, 'groupcreate', true, $groupcreate, 5, true ) );

    ob_start();
    echo $xt->makeSelBox( 1, $xt->pid(), "pid" );
    $create = ( $xt->id ) ? _AM_WFS_MOVETO : _AM_WFS_IN;
    $sform->addElement( new XoopsFormLabel( $create, ob_get_contents() ) );
    ob_end_clean();
    $sform->addElement( new XoopsFormText( _AM_WFS_CATEGORYWEIGHT, 'weight', 10, 80, $xt->weight() ), false );
    $sform->addElement( new XoopsFormText( _AM_WFS_CATEGORYNAME, 'title', 50, 255, $xt->title( "E" ) ), true );
    $sform->addElement( new XoopsFormTextArea( _AM_WFS_CATEGORYDESC, 'description', $xt->description( "E" ), 10, 60 ), true );

    /**
     * Show Section Image
     */
    $image_option_tray = new XoopsFormElementTray( _AM_WFS_SECTIONIMAGEOPTION, '<br />' );
    $graph_array = &WfsLists::getListTypeAsArray( WFS_SECTIONIMG_PATH, $type = "images" );
    $indeximage_select = new XoopsFormSelect( '', 'indeximage', $xt->imgurl( "E" ) );
    $indeximage_select->addOptionArray( $graph_array );
    $indeximage_select->setExtra( "onchange='showImgSelected(\"image\", \"indeximage\", \"" . $wfsPathConfig['sgraphicspath'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
    $indeximage_tray = new XoopsFormElementTray( '', '&nbsp;' );
    $indeximage_tray->addElement( $indeximage_select );
    if ( !empty( $xt->imgurl ) ) {
        $indeximage_tray->addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . WFS_SECTIONIMG_URL . "/" . $xt->imgurl( "E" ) . "' name='image' id='image' alt='' />" ) );
    } else {
        $indeximage_tray->addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' />" ) );
    }
    $image_option_tray->addElement( $indeximage_tray );
    $submenus_radio = new XoopsFormRadioYN( _AM_WFS_SHOWCATEGORYIMG, 'displayimg', $xt->displayimg, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
    $image_option_tray->addElement( $submenus_radio );
    $imgalign_radio = new XoopsFormRadioYN( _AM_WFS_SECTIONIMAGEALIGN, 'imgalign', $xt->imgalign , ' ' . _AM_WFS_ISLEFT . '', ' ' . _AM_WFS_ISRIGHT . '' );
    $image_option_tray->addElement( $imgalign_radio );
    $sform->addElement( $image_option_tray );
    /**
     * End Section Image
     */
    $mmenu_radio = new XoopsFormRadioYN( _AM_WFS_ADDSECTIONTOMENU, 'cmainmenu', $xt->cmainmenu, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
    $sform->addElement( $mmenu_radio );
    $online_radio = new XoopsFormRadioYN( _AM_WFS_SECTIONSTATUS, 'status', $xt->status, ' ' . _AM_WFS_ONLINE . '', ' ' . _AM_WFS_OFFLINE . '' );
    $sform->addElement( $online_radio );

    $sform->insertBreak( "", "even" );
    $sform->insertBreak( "<b>" . _AM_WFS_SECTIONPAGEDETAILS . "</b>", "bg3" );

    $html_array = &WfsLists::getListTypeAsArray( WFS_TEMPLATE_PATH, "html" );
    $html_select = new XoopsFormSelect( _AM_WFS_SECTIONTEMPLATE, 'template', $xt->template );
    $html_select->addOptionArray( $html_array );
    $sform->addElement( $html_select );

    $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_CATEGORYHEAD, 'catdescription', $xt->catdescription( "E" ), 10, 60 ), false );
    $htmlarea = ( $xoopsModuleConfig['htmltextarea'] ) ? 'XoopsFormDhtmlTextArea' : 'XoopsFormTextArea';
    $sform->addElement( new $htmlarea( _AM_WFS_CATEGORYFOOT, 'catfooter', $xt->catfooter( "E" ), 10, 60 ), false );

    $options_tray = new XoopsFormElementTray( _AM_WFS_TEXTOPTIONS, '<br />' );
    $striphtml_checkbox = new XoopsFormCheckBox( '', 'striphtml', 0 );
    $striphtml_checkbox->addOption( 1, _AM_WFS_STRIPHTML );
    $options_tray->addElement( $striphtml_checkbox );

    $html_checkbox = new XoopsFormCheckBox( '', 'nohtml', $xt->nohtml );
    $html_checkbox->addOption( 1, _AM_WFS_DISABLEHTML );
    $options_tray->addElement( $html_checkbox );

    $smiley_checkbox = new XoopsFormCheckBox( '', 'nosmileys', $xt->nosmileys );
    $smiley_checkbox->addOption( 1, _AM_WFS_DISABLESMILEY );
    $options_tray->addElement( $smiley_checkbox );

    $xcodes_checkbox = new XoopsFormCheckBox( '', 'noxcodes', $xt->noxcodes );
    $xcodes_checkbox->addOption( 1, _AM_WFS_DISABLEXCODE );
    $options_tray->addElement( $xcodes_checkbox );

    $noimages_checkbox = new XoopsFormCheckBox( '', 'noimages', $xt->noimages );
    $noimages_checkbox->addOption( 1, _AM_WFS_DISABLEIMAGES );
    $options_tray->addElement( $noimages_checkbox );

    $breaks_checkbox = new XoopsFormCheckBox( '', 'nobreaks', $xt->nobreaks );
    $breaks_checkbox->addOption( 1, _AM_WFS_DISABLEBREAK );
    $options_tray->addElement( $breaks_checkbox );
    $sform->addElement( $options_tray );

    $sform->insertBreak( "", "even" );
    $create_tray = new XoopsFormElementTray( '', '' );
    $create_tray->addElement( new XoopsFormHidden( 'op', 'save' ) );
    $butt_save = new XoopsFormButton( '', '', _AM_WFS_SAVECHANGE, 'submit' );
    $butt_save->setExtra( 'onclick="this.form.elements.op.value=\'save\'"' );
    $create_tray->addElement( $butt_save );
    if ( $xt->id ) {
        $create_tray->addElement( new XoopsFormHidden( 'id', $xt->id ) );
        $butt_delete = new XoopsFormButton( '', '', _AM_WFS_DELETE, 'submit' );
        $butt_delete->setExtra( 'onclick="this.form.elements.op.value=\'delete\'"' );
        $create_tray->addElement( $butt_delete );
    } else {
        $create_tray->addElement( new XoopsFormHidden( 'id', '' ) );
        $create_tray->addElement( new XoopsFormHidden( 'op', 'save' ) );
        $butt_save = new XoopsFormButton( '', '', _AM_WFS_SAVECHANGE, 'submit' );
        $butt_save->setExtra( 'onclick="this.form.elements.op.value=\'save\'"' );
    }
    $sform->addElement( $create_tray );
    $sform->display();
}

/**
 * duplicateSection()
 *
 * @param  $cat
 * @param  $targetid
 * @param string $newtitle
 * @param boolean $recurse
 * @param boolean $dupcontent
 * @return
 */
function duplicateSection( $cat, $targetid, $newtitle = '', $recurse = false, $dupcontent = false ) {
    global $myts;
    $sourceid = $cat->id;
    $category_arr = $cat->getAllChild();

    $cat->setPid( $targetid );
    if ( !empty( $newtitle ) ) {
        $cat->setTitle( $newtitle );
    }
    $cat->id = 0; // Clear object id, so store() will create a new category
    $cat->store(); // Duplicate section
    if ( $cat->id == 0 ) {
        $cat->id = $cat->db->getInsertId();
    }
    if ( $dupcontent ) {
        // Also duplicate each story in this section
        $article_arr = WfsArticle::getByCategory( $sourceid );
        foreach( $article_arr as $eacharticle ) {
            $eacharticle->setApproved( ( $eacharticle->published ) ? 1 : 0 );
            $eacharticle->setCategoryid( $cat->id ); // move (copy) to newly created category
            $eacharticle->articleid = 0; // create new article when storing
            $eacharticle->store( true );
        }
    }
    if ( $recurse ) {
        // Duplicate every sub-section to newly created one
        foreach ( $category_arr as $subcat ) {
            duplicateSection( $subcat, $cat->id, '', true, $dupcontent );
        }
    }
}
// global $xoopsDB, $myts;
switch ( $op ) {
    case "move":
        if ( !isset( $_POST['ok'] ) ) {
            include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

            $xt = new WfsCategory();
            xoops_cp_header();
            wfs_admin_menu( _AM_WFS_SECTIONMANAGE );
            wfs_textinfo( _AM_WFS_SECTIONSETTINGS, _AM_WFS_SECTIONSETTINGSTEXT );
            $source = '0';
            $article_array = array();
            echo "<form name='saverelated' METHOD='post'>";
            echo "<table border='0' cellpadding='2' cellspacing='1' width = '100%' class = 'outer'>";
            echo "<tr align='left'>";
            echo "<th align='center' width = '3%'><b>" . _AM_WFS_ARTID . "</b></th>";
            echo "<th align='left' width = '30%'><b>" . _AM_WFS_TITLE . "</b></th>";
            echo "<th align='center' width = '17%'><b>" . _AM_WFS_SELECTITEM . "</b></th>";
            echo "</tr>";
            $result = $xoopsDB->query( "SELECT articleid, categoryid, title FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " WHERE categoryid = " . $_POST['id'] . " ORDER BY articleid" );
            $a = 0;
            while ( list( $articleid, $categoryid, $title ) = $xoopsDB->fetchrow( $result ) ) {
                echo "<tr>";
                echo "<td class='head' align = 'center' width= '3%'>" . $articleid . "</td>";
                echo "<td class='even' nowrap='nowrap'>" . $title . "</td>";
                echo "<input type='hidden' name='article_array[topic][$a]' value='" . $articleid . "' />";
                echo "<td align='center' class='even'>";
                echo "<input type='checkbox' name='article_array[related][$a]' value='1'";
                echo " />";
                echo "</td>";
                echo "</tr>";
                $a++;
            }
            echo "<input type='hidden' name='source' value='" . $_POST['id'] . "' />";
            echo "<tr>";
            echo "<td class='head' align='right' colspan='2'>" . _AM_WFS_SELECTALLNONE . "</td>";
            echo "<td class='even' align='center' colspan='1'><input name='allbox' id='allbox' onclick='xoopsCheckAll(\"saverelated\", \"allbox\");' type='checkbox' value='Check All' /></td>";
            echo "</tr>";
            echo "<tr><td class='head' align='right' colspan ='2'>" . _AM_WFS_ANDMOVED . "";
            echo "</td><td class='even' align='center'>";
            echo $xt->makeSelBox( 0, -1, 'target' );
            echo "</td></tr>";
            echo "<tr><td class='even' align='center' colspan='4'>";
            echo "<input type='hidden' name='ok' value='1' />";
            echo "<input type='hidden' name='op' value=move />";
            echo "<input type='submit' name='submit' value='" . _AM_WFS_MOVE . "' />";
            echo "</td></tr>";
            echo "</table>";
            echo "</form>";
        } else {
            $source = intval( $_POST['source'] );
            $target = intval( $_POST['target'] );

            if ( $source == $target ) {
                redirect_header( "category.php", 2, _AM_WFS_FAILTOSEE );
            }

            if ( count( $article_array['related'] ) == 0 ) {
                redirect_header( "category.php", 1, _AM_WFS_NOARTICLESSELECTED );
            } else {
                $count = count( $article_array['topic'] );
                for ( $i = 0; $i < count( $article_array['topic'] ); ) {
                    if ( $article_array['related'][$i] == 1 ) {
                        $item_id = $article_array['topic'][$i];
                        $article = new WfsArticle( $item_id );
                        $article->setCategoryid( $target );
                        $article->setApproved( ( $article->published ) ? 1 : 0 );
                        $article->store( true );
                    }
                    $i++;
                }
            }
            redirect_header( xoops_getenv( 'PHP_SELF' ), 1, _AM_WFS_ARTICLESMOVED );
            exit();
        }
        break;

    case "delete":
        if ( isset( $_POST['ok'] ) && $_POST['ok'] == 1 ) {
            $xt = new WfsCategory( intval( $id ) );
            // get all subtopics under the specified topic
            $topic_arr = $xt->getAllChild();
            array_push( $topic_arr, $xt );
            foreach( $topic_arr as $eachtopic ) {
                // get all stories in each topic
                $article_arr = WfsArticle::getByCategory( $eachtopic->id() );
                foreach( $article_arr as $eacharticle ) {
                    $eacharticle->delete();
                }
                // all stories for each topic is deleted, now delete the topic data
                $eachtopic->delete();
            }
            redirect_header( xoops_getenv( 'PHP_SELF' ), 1, _AM_WFS_DBUPDATED );
            exit();
        } else {
            xoops_cp_header();
            $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : intval( $_POST['id'] );
            xoops_confirm( array( 'op' => 'delete', 'id' => intval( $id ), 'ok' => 1 ), xoops_getenv( 'PHP_SELF' ), _AM_WFS_WAYSYWTDTTAL );
        }
        break;

    case "mod":
        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_SECTIONMANAGE );
        wfs_textinfo( _AM_WFS_SECTIONSETTINGS, _AM_WFS_SECTIONSETTINGSTEXT );
        $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : intval( $_POST['id'] );
        editCategoryForm( intval( $id ) );
        break;

    case "save":
        // global $xoopsDB, $xoopsConfig;
        if ( $_POST['id'] > 0 ) {
            if ( intval( $_POST['id'] ) == intval( $_POST['pid'] ) ) {
                redirect_header( $_SERVER['PHP_SELF'], 1, _AM_WFS_CANNOTHAVECATTHERE );
            }
        }
        $xt->id = ( intval( $_POST['id'] ) ) ? intval( $_POST['id'] ) : 0;
        $xt = ( intval( $xt->id ) ) ? new WfsCategory( intval( $xt->id ) ): new WfsCategory();

        $xt->setPid( $_POST['pid'] );
        $xt->setTitle( $_POST['title'] );
        $xt->setDescription( $_POST['description'], isset( $_POST['striphtml'] ) );
        $xt->setCatheader( $_POST['catdescription'], isset( $_POST['striphtml'] ) );
        $xt->setCatfooter( $_POST['catfooter'], isset( $_POST['striphtml'] ) );
        $xt->setGroups( $_POST['groupid'] );
        $xt->setGroupcreate( $_POST['groupcreate'] );
        $xt->setImgurl( $_POST['indeximage'] );
        $xt->setDisplayimg( $_POST['displayimg'] );
        $xt->setImgalign( $_POST['imgalign'] );
        $xt->setSmileys( isset( $_POST['nosmileys'] ) );
        $xt->setHtml( isset( $_POST['nohtml'] ) );
        $xt->setXcodes( isset( $_POST['noxcodes'] ) );
        $xt->setImages( isset( $_POST['noimages'] ) );
        $xt->setBreaks( isset( $_POST['nobreaks'] ) );
        $xt->setCmainmenu( $_POST['cmainmenu'] );
        $xt->setWeight( $_POST['weight'] );
        $xt->setTemplate( $_POST['template'] );
        $xt->setStatus( $_POST['status'] );

        if ( ( $xoopsModuleConfig['autoweight'] ) && $_POST['weight'] == 0 ) {
            $result = $xoopsDB->query( "SELECT * FROM " . $xoopsDB->prefix( "wfs_category" ) );
            $totalcount = $xoopsDB->getRowsNum( $result );
            $totalcount = $totalcount + 1;
            $xt->setWeight( $totalcount );
        }
        $xt->store();
        redirect_header( xoops_getenv( 'PHP_SELF' ), 1, _AM_WFS_DBUPDATED );
        exit();

        break;
    // -- Skalpa Keo 03/05/14: Duplicate Topic
    case "dup":
    case "dupsubs":
        $sourceid = intval( $_POST['source'] );
        $targetid = intval( $_POST['target'] );

        $xt = new WfsCategory( $sourceid );
        $is_magic = get_magic_quotes_gpc();
        $title = $is_magic ? stripslashes( $_POST['title'] ) : $_POST['title'];
        $recurse = ( $op == 'dupsubs' ) ? true : false;
        $dupcontent = intval( $_POST['dupcontent'] ) ? true : false;
        duplicateSection( $xt, $targetid, $title, $recurse, $dupcontent );
        redirect_header( xoops_getenv( 'PHP_SELF' ), 1, _AM_WFS_DBUPDATED );
        exit();
        break;
    // -- Skalpa [/end]
    case "default":
    default:

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_SECTIONMANAGE );
        wfs_textinfo( _AM_WFS_SECTIONSETTINGS, _AM_WFS_SECTIONSETTINGSTEXT );

        if ( WfsCategory::countCategory() > 0 ) {
            $xt = new WfsCategory();
            include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
            $mform = new XoopsThemeForm( _AM_WFS_MODIFYCATEGORY, "modify", xoops_getenv( 'PHP_SELF' ) );

            ob_start();
            echo $xt->makeSelBox( 0 );
            $mform->addElement( new XoopsFormLabel( _AM_WFS_CATEGORYNAME, ob_get_contents() ) );
            ob_end_clean();

            $create_tray = new XoopsFormElementTray( '', '' );
            $create_tray->addElement( new XoopsFormHidden( 'op', 'mod' ) );
            $butt_save = new XoopsFormButton( '', '', _AM_WFS_MODIFY, 'submit' );
            $butt_save->setExtra( 'onclick="this.form.elements.op.value=\'mod\'"' );
            $create_tray->addElement( $butt_save );

            $butt_delete = new XoopsFormButton( '', '', _AM_WFS_DELETE, 'submit' );
            $butt_delete->setExtra( 'onclick="this.form.elements.op.value=\'delete\'"' );
            $create_tray->addElement( $butt_delete );

            $butt_move = new XoopsFormButton( '', '', _AM_WFS_MOVEDEL, 'submit' );
            $butt_move->setExtra( 'onclick="this.form.elements.op.value=\'move\'"' );
            $create_tray->addElement( $butt_move );

            $mform->addElement( $create_tray );
            $mform->display();
            // -- Skalpa Keo 03/05/14: Duplicate Topic
            $dupform = new XoopsThemeForm( _AM_WFS_DUPLICATECATEGORY, "duplicate", xoops_getenv( 'PHP_SELF' ) );

            ob_start();
            echo $xt->makeSelBox( 0, -1, 'source' );
            echo "&nbsp;&nbsp;" . _AM_WFS_TO . "&nbsp;&nbsp;";
            echo $xt->makeSelBox( 1, 0, 'target', 0 );
            $dupform->addElement( new XoopsFormLabel( _AM_WFS_COPY, ob_get_contents() ) );
            ob_end_clean();

            $dupform->addElement( new XoopsFormText( _AM_WFS_NEWCATEGORYNAME, 'title', 50, 80, $xt->title() ), true );
            $dupform->addElement( new XoopsFormRadioYN( _AM_WFS_SECTIONCOPYARTICLES, 'dupcontent', 0 ) );

            $dup_tray = new XoopsFormElementTray( '', '' );
            $dup_tray->addElement( new XoopsFormHidden( 'modify', '1' ) );
            $dup_tray->addElement( new XoopsFormHidden( 'op', 'dup' ) );

            $butt_dup = new XoopsFormButton( '', '', _AM_WFS_DUPLICATE, 'submit' );
            $butt_dup->setExtra( 'onclick="this.form.elements.op.value=\'dup\'"' );
            $dup_tray->addElement( $butt_dup );

            $butt_dupct = new XoopsFormButton( '', '', _AM_WFS_DUPLICATEWSUBS, 'submit' );
            $butt_dupct->setExtra( 'onclick="this.form.elements.op.value=\'dupsubs\'"' );
            $dup_tray->addElement( $butt_dupct );
            $dupform->addElement( $dup_tray );
            $dupform->display();
            // -- Skalpa [/end]
        }
        if ( WfsCategory::countCategory() == 0 ) {
            $xt = new WfsCategory();
        }
        editCategoryForm();
        break;
}
xoops_cp_footer();

?>

