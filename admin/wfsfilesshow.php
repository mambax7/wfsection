<?php
// $Id: wfsfilesshow.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include 'admin_header.php';
include_once WFS_ROOT_PATH . '/class/wfsarticle.php';
include_once XOOPS_ROOT_PATH . "/include/xoopscodes.php";

accessadmin( "downloads" );

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

if ( isset( $_POST['filesave'] ) ) {
    $op = 'filesave';
} elseif ( isset( $_POST['delete'] ) ) {
    $op = 'delfile';
}

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];

if ( isset( $articleid ) ) {
    $isWfsArticle = new WfsArticle( $articleid );
    if ( !is_object( $isWfsArticle ) ) {
        redirect_header( "wfsfilesshow.php", 2, _AM_WFS_NOARTICLE );
        exit();
    }
}

$headingarray = array( _AM_WFS_FILEID, _AM_WFS_REALFILENAME, _AM_WFS_FILESHOWNAME, _AM_WFS_ARTICLETITLE, _AM_WFS_FILEICON, _AM_WFS_FILEMIMETYPE, _AM_WFS_FILESIZE, _AM_WFS_APPROVED, _AM_WFS_ACTION );
$widtharray = array( 2, 10, 10, 10, 2, 15, 6, 2, 10 );
$alignarray = array( 'center', 'center', 'center', 'center', 'center', 'center', 'center' , 'center', 'center' );
$classarray = array( 'itemHead', 'itemHead nowrap', 'itemHead nowrap', 'itemHead', 'itemHead', 'itemHead', 'itemHead nowrap', 'itemHead', 'itemHead nowrap' );

function showfiles( $fileid, $filerealname, $fileshowname, $articlelink, $iconshow, $mimeshow, $size, $stat, $editlink, $dellink ) {
    echo "<tr>";
    echo "<td class='head' align = 'center'>$fileid</td>";
    echo "<td class='even' align = 'center'>$filerealname</a></td>";
    echo "<td class='even' align = 'center'>$fileshowname</td>";
    echo "<td class='even' align = 'center'>$articlelink</td>";
    echo "<td class='even' align = 'center'>$iconshow</a></td>";
    echo "<td class='even' align = 'center'>$mimeshow</td>";
    echo "<td class='even' align = 'center' nowrap>$size</td>";
    echo "<td class='even' align = 'center'>$stat</td>";
    echo "<td class='even' align = 'center' nowrap>$editlink $dellink</td>";
    echo "</tr>";
}

switch ( $op ) {
    /**
     * Uploads a file to an article
     */
    case "fileup":

        if ( !empty( $_FILES['uploadfile']['name'] ) ) {
            include_once( WFS_ROOT_PATH . "/class/uploader.php" );
            include_once( WFS_ROOT_PATH . "/class/wfsfiles.php" );

            $upload_dir = WFS_FILE_PATH;
            $xoopsUser->isAdmin( $xoopsModule->mid() );
            $usertype = ( $xoopsUser->isAdmin( $xoopsModule->mid() ) ) ? 1 : 0;

            $allowed_mimetypes = wfs_retmime( $_FILES['uploadfile']['name'], $usertype );
            $uploader = new WFuploader( $upload_dir,
                $allowed_mimetypes,
                $xoopsModuleConfig['maxfilesize'],
                $xoopsModuleConfig['imgwidth'],
                $xoopsModuleConfig['imgheight']
                );

            if ( trim( $xoopsModuleConfig['file_prefix'] ) ) $uploader->setPrefix( $xoopsModuleConfig['file_prefix'] );
            if ( $uploader->fetchMedia( $_POST['xoops_upload_file'][0] ) ) {
                if ( !$uploader->upload() )
                    $errors = $uploader->getErrors();
                else {
                    if ( is_file( $uploader->getSavedDestination() ) ) {
                        $file = new WfsFiles();
                        $file->setByUploadFile( $uploader );
                        $file->loadPostVars();
                        $file->store();
                    }
                }
            } else {
                $errors = $uploader->getErrors();
            }
        } else
            $errors = "Error: No file uploaded";

        if ( isset( $errors ) )
            redirect_header( "javascript:history.go(-1)", 2, $errors );
        else
            redirect_header( "wfsfilesshow.php", 2, _AM_WFS_DBUPDATED );
        break;

    /**
     * Edit a attached file
     */
    case "fileedit":
        include_once( WFS_ROOT_URL . "/class/wfsfiles.php" );
        $file = new WfsFiles( $fileid );
        $file->editform();
        xoops_cp_footer();
        break;

    /**
     * Delete a attached file
     */
    case "delfile":
        include_once( WFS_ROOT_URL . "/class/wfsfiles.php" );
        if ( isset( $ok ) ) {
            $file = new WfsFiles( $fileid );
            $articleid = $file->getArticleid();
            $file->delete();
            redirect_header( "" . WFS_ROOT_URL . "/admin/wfsfilesshow.php?op=uploads&articleid=" . $articleid, 1, _AM_WFS_DBUPDATED );
            exit();
        } else {
            xoops_cp_header();
            global $xoopsConfig, $xoopsModuleConfig;

            echo"<table width='100%' border='0' cellspacing='1'><tr><td>";
            echo "<div class='confirmMsg'>";
            echo "<h4>" . _AM_WFS_FILEDEL . "</h4>";
            $file = new WfsFiles( $fileid );
            $articleid = $file->getArticleid();
            echo $file->getFileRealName() . " (" . $file->getDownloadname() . ")\n";
            echo "<table><tr><td><br />";
            echo myTextForm( "wfsfilesshow.php?op=delfile&amp;fileid=" . $fileid . "&amp;ok=1&amp;articleid=" . $articleid , _AM_WFS_YES );
            echo "</td><td><br />";
            echo myTextForm( "javascript:history.go(-1)" , _AM_WFS_NO );
            echo "</td></tr></table>";
            echo "</div>";
            echo"</td></tr></table>";
        }
        break;

    /**
     * Save a attached file
     */
    case "filesave":
        include_once( WFS_ROOT_URL . "/class/wfsfiles.php" );

        $file = ( empty( $fileid ) ) ? new WfsFiles() : new WfsFiles( $fileid );
        $file->loadPostVars();
        $file->store();
        redirect_header( "wfsfilesshow.php", 1, _AM_WFS_DBUPDATED );
        break;

    /**
     * Uploads
     *
     * Shows upload
     */
    case "uploads":

        $article = new WfsArticle( $articleid );

        xoops_cp_header();

        wfs_admin_menu( _AM_WFS_ATTACHEDFILES );

        echo "<div><b>" . _AM_WFS_ATTACHEDARTICLE . $article->textlink() . "</b></div><br />";
        echo "<table border='0' width='100%' cellpadding = '1' cellspacing = '1' class = 'outer' >";

        wfs_headings( $headingarray, $widtharray, $alignarray, $classarray );

        $limit = ( isset( $limit ) )?intval( $limit ):10;
        $start = ( isset( $start ) )?intval( $start ):0;

        $files_array = $article->getAllFiles( $limit, $start );
        $totalfiles = $article->getFilesCount();

        if ( $totalfiles > 0 ) {
            for ( $i = 0; $i < count( $files_array ); $i++ ) {
                if ( $files_array[$i]->articleid > 0 ) {
                    $article = new WfsArticle( $files_array[$i]->articleid );

                    if ( !is_file( WFS_FILE_PATH . "/" . $files_array[$i]->filerealname ) ) $files_array[$i]->filerealname = $alertimg;
                    $icon = wfs_getIcon( WFS_FILE_URL . "/" . $files_array[$i]->filerealname );
                    $iconshow = "<img src=" . WFS_IMAGES_URL . "/icon/" . $icon . " valign = absmiddle>";
                    $mimeshow = $files_array[$i]->mimetype;
                    $stat = ( intval( $files_array[$i]->submit ) == 1 ) ? $onimg : $offimg;
                    $size = 0;

                    if ( file_exists( WFS_FILE_PATH . "/" . $files_array[$i]->filerealname ) ) {
                        $size = wfs_myfilesize( WFS_FILE_PATH . "/" . $files_array[$i]->filerealname );
                    }
                    $articlelink = $article->textlink();
                    $fileshowname = $files_array[$i]->getLinkedName( WFS_URL );
                    $editlink = "<a href='wfsfilesshow.php?op=fileedit&amp;fileid=" . $files_array[$i]->fileid . "'>$editimg</a>";
                    $dellink = "<a href='wfsfilesshow.php?op=delfile&amp;fileid=" . $files_array[$i]->fileid . "'>$deleteimg</a>";
                    showfiles( $files_array[$i]->fileid, $files_array[$i]->filerealname, $fileshowname, $articlelink, $iconshow, $mimeshow, $size, $stat, $editlink, $dellink );
                }
            }
        } else {
            echo "<tr ><td class='head' align = 'center' colspan = '9'>" . _AM_WFS_NOFILESFOUND . "</td></tr>";
        }
        echo "</table>";

        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new XoopsPageNav( $totalfiles, 10, $start, 'start', 'wfsfileshow.php?op=uploads' );

        echo "<div style='text-align: center;'>" . $pagenav->renderNav() . "</div><br />";
        echo "<h4>" . _AM_WFS_FILEUPLOAD . $article->textlink() . "</h4>";

        $sform = new XoopsThemeForm( _AM_WFS_ATTACHEDFILEEDITH, "op", xoops_getenv( 'PHP_SELF' ) );
        $sform->setExtra( 'enctype="multipart/form-data"' );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ATTACHEDFILEACCESS, 'groupid', true, wfs_getGroupIda( $article->groupid ), 5, true ) );
        $sform->addElement( new XoopsFormFile( _AM_WFS_ATTACHFILE, 'uploadfile', '' ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_FILESHOWNAME, "fileshowname", 50, 255, '' ), false );
        $sform->addElement( new XoopsFormTextArea( _AM_WFS_FILEDESCRIPT, 'textfiledescript', '', 5, 60 ), false );
        $sform->addElement( new XoopsFormTextArea( _AM_WFS_FILETEXT, 'textfilesearch', '', 5, 60 ), false );

        $sform->addElement( new XoopsFormHidden( 'submit', 1 ) );
        $submit_radio = new XoopsFormRadioYN( _AM_WFS_APPROVE, 'submit', 1, '' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
        $sform->addElement( $submit_radio );

        $button_tray = new XoopsFormElementTray( '', '' );
        $button_tray->addElement( new XoopsFormHidden( 'op', 'filesave' ) );
        $button_tray->addElement( new XoopsFormHidden( 'articleid', $article->articleid ) );
        $button_tray->addElement( new XoopsFormHidden( 'uid', $xoopsUser->uid() ) );

        $butt_save = new XoopsFormButton( '', '', _AM_WFS_SAVECHANGE, 'submit' );
        $butt_save->setExtra( 'onclick="this.form.elements.op.value=\'fileup\'"' );
        $button_tray->addElement( $butt_save );

        $butt_cancel = new XoopsFormButton( '', '', _AM_WFS_CANCEL, 'button' );
        $butt_cancel->setExtra( 'onclick="javascript:history.go(-1)"' );
        $button_tray->addElement( $butt_cancel );
        $sform->addElement( $button_tray );
        $sform->display();

        xoops_cp_footer();
        break;

    case "allarticles":
    case "default":

    default:

        $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;

        xoops_cp_header();
        $category = new WfsCategory();

        $files_array = WfsFiles::getAllfiles( $xoopsModuleConfig['lastart'], $start );
        $totalfiles = WfsFiles::getfilecount();

        wfs_admin_menu( _AM_WFS_ATTACHEDFILEM );

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_WFS_ATTACHEDFILE . "</legend>";
        echo "<div style='padding: 8px;'>";
        echo "<div>" . _AM_WFS_TDISPLAYSATTACHEDFILES . "</div>";
        echo "</div></fieldset><br />";

        echo "<div><b>" . _AM_WFS_TOTALATTFILES . " </b>" . $totalfiles . "</div><br />";
        echo "<table cellpadding='2' cellspacing='1' width = '100%' class = 'outer'>";
        wfs_headings( $headingarray, $widtharray, $alignarray, $classarray );
        if ( $totalfiles > 0 ) {
            for ( $i = 0; $i < count( $files_array ); $i++ ) {
                if ( $files_array[$i]->articleid != 0 ) {
                    $article = new WfsArticle( $files_array[$i]->articleid );
                    if ( !is_file( WFS_FILE_PATH . "/" . $files_array[$i]->filerealname ) ) $files_array[$i]->filerealname = $alertimg;
                    $icon = wfs_getIcon( WFS_FILE_URL . "/" . $files_array[$i]->filerealname );
                    $iconshow = "<img src=" . WFS_IMAGES_URL . "/icon/" . $icon . " valign = absmiddle>";
                    $mimeshow = $files_array[$i]->mimetype;
                    $stat = ( intval( $files_array[$i]->submit ) == 1 ) ? $onimg : $offimg;
                    $size = 0;
                    if ( file_exists( WFS_FILE_PATH . "/" . $files_array[$i]->filerealname ) ) {
                        $size = wfs_myfilesize( WFS_FILE_PATH . "/" . $files_array[$i]->filerealname );
                    }
                    $articlelink = $article->textlink();
                    $fileshowname = $files_array[$i]->getLinkedName( WFS_URL );
                    $editlink = "<a href='wfsfilesshow.php?op=fileedit&amp;fileid=" . $files_array[$i]->fileid . "'>$editimg</a>";
                    $dellink = "<a href='wfsfilesshow.php?op=delfile&amp;fileid=" . $files_array[$i]->fileid . "'>$deleteimg</a>";

                    showfiles( $files_array[$i]->fileid, $files_array[$i]->filerealname, $fileshowname, $articlelink, $iconshow, $mimeshow, $size, $stat, $editlink, $dellink );
                }
            }
        } else {
            echo "<tr ><td class='head' align = 'center' colspan = '9'>" . _AM_WFS_NOFILESFOUND . "</td></tr>";
        }
        echo "</table>";
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new XoopsPageNav( $totalfiles, $xoopsModuleConfig['lastart'], $start, 'start', 'wfsfileshow.php?op=uploads' );
        echo "<div style='text-align: right;'>" . $pagenav->renderNav() . "</div><br />";
        xoops_cp_footer();
}

?>