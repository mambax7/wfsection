<?php 
// $Id: upload.php,v 1.0 2004/08/13 12:51:24 phppp Exp $
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
// Translator: Mr Translatro                                                 //
// URL: http://translator.com                                                //
// Email: translator@translator.com                                          //
// ------------------------------------------------------------------------- //
include 'admin_header.php';
accessadmin( "uploads" );

$op = '';
if ( isset( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        ${$k} = $v;
    } 
} 

if ( isset( $_GET ) )
{
    foreach ( $_GET as $k => $v )
    {
        ${$k} = $v;
    } 
} 
$rootpath = ( isset( $_GET['rootpath'] ) ) ? intval( $_GET['rootpath'] ) : 0;

switch ( $op )
{
    case "upload":

        global $_POST;
        /**
         * This is the actual file uploader
         */
        $orig_uploadpath = XOOPS_ROOT_PATH . "/" . $_POST['uploadpath'];
        $uploadpath = ( $_POST['use_imgman'] ) ? "uploads" : $_POST['uploadpath'];
        define( "_UPLOADS", $uploadpath );

        if ( $_FILES['uploadfile']['name'] != "" )
        {
            if ( file_exists( XOOPS_ROOT_PATH . "/" . _UPLOADS . "/" . $_FILES['uploadfile']['name'] ) )
                redirect_header( 'upload.php', 2, _AM_WFS_DOWN_IMAGEEXIST );

            $allowed_mimetypes = array( 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png' );
            include_once( WFS_ROOT_PATH . "/class/uploader.php" );

            $upload_dir = XOOPS_ROOT_PATH . "/" . _UPLOADS;
            $uploader = new WFuploader( $upload_dir,
                $allowed_mimetypes,
                $xoopsModuleConfig['maxfilesize'],
                $xoopsModuleConfig['imgwidth'],
                $xoopsModuleConfig['imgheight'] 
                );

            if ( !empty( $_POST['img_prefix'] ) )
                $uploader->setPrefix( $_POST['img_prefix'] );

            $uploader->setImageupload( 0 );

            if ( $uploader->fetchMedia( $_POST['xoops_upload_file'][0] ) )
            {
                if ( !$uploader->upload() )
                    $errors = $uploader->getErrors();
            } 
            /**
             * Check to see if there is errors if not continue
             */
            if ( isset( $errors ) )
                redirect_header( "javascript:history.go(-1)", 2, $errors );
        } 
        /**
         * We need to rename all files with spaces so they can be used by the image uploader
         */
        $img_path = XOOPS_ROOT_PATH . "/" . _UPLOADS;
        $working_image = ( isset( $uploader->getSavedFileName ) ) ? $uploader->getSavedFileName() : $_POST['downfile'];
        $working_image2 = preg_replace( '!\s+!', '_', $working_image );
        @rename( "{$img_path}/{$working_image}", "{$img_path}/{$working_image2}" );
        $working_image = $working_image2;
        unset( $working_image2 );
        /**
         * end
         */
        if ( $_POST['img_resize'] && !empty( $working_image ) )
        {
            $thumbnail = wfs_createthumb( $working_image, _UPLOADS, "thumbs", $_POST['img_width'], $_POST['img_height'], $_POST['img_quality'], 1, $_POST['img_aspect'] );
            @chmod( $thumbnail, 0777 );

            $img_path = XOOPS_ROOT_PATH . "/" . _UPLOADS . "/";
            $img_thumb = ( $_POST['img_del'] ) ? $working_image : basename( $thumbnail );

            if ( file_exists( "{$img_path}/thumbs/{$img_thumb}" ) )
            {
                $error = 0;
                if ( !@copy( "{$img_path}/thumbs/{$img_thumb}", "{$img_path}/{$working_image}" ) )
                    $error = 1;
                if ( !@unlink( "{$img_path}/thumbs/{$img_thumb}" ) )
                    $error = 2;
                @touch( "{$img_path}/{$working_image}" );
                @chmod( "{$img_path}/{$working_image}", 0644 );

                if ( $error > 0 )
                    $err_mess = ( $error ) ? "Could not copy new file" : "Could not delete temp file";
                redirect_header( "upload.php", 2, $err_mess );
            } 
            else
                redirect_header( "upload.php", 2, "Error: Could not find temp file to copy." );
        } 

        if ( $_POST['use_imgman'] )
        {
            $image_mimetype = ( isset( $uploader->getMediaType ) ) ? $uploader->getMediaType() : wfs_retmime( "{$img_path}/{$working_image}" );
            $image_mimetype = ( is_array( $image_mimetype ) ) ? $image_mimetype[0] : $image_mimetype;
            $image_nicename = ( empty( $image_nicename ) ) ? 'No title' : $image_nicename;

            $image_handler = &xoops_gethandler( 'image' );
            $image = &$image_handler->create();
            $image->setVar( 'image_name', "{$working_image}" );
            $image->setVar( 'image_nicename', $image_nicename );
            $image->setVar( 'image_mimetype', $image_mimetype );
            $image->setVar( 'image_created', time() );
            $image->setVar( 'image_display', 1 );
            $image->setVar( 'image_weight', 0 );
            $image->setVar( 'imgcat_id', $imgcat_id );

            if ( @!file_exists( XOOPS_UPLOAD_PATH . "/{$working_image}" ) )
                @copy( "{$orig_uploadpath}/{$working_image}", XOOPS_UPLOAD_PATH . "/{$working_image}" );

            if ( !$image_handler->insert( $image ) )
                redirect_header( "upload.php", 2, "Error: Could not save the information to image manager." );
            else
                redirect_header( "upload.php", 2, "Image Manager Updated" );
        } 
        clearstatcache();
        redirect_header( "upload.php", 2, "Image Updated" );
        break;

    case "delfile":

        if ( isset( $confirm ) && $confirm == 1 )
        {
            $filetodelete = XOOPS_ROOT_PATH . "/" . $_POST['uploadpath'] . "/" . $_POST['downfile'];
            if ( file_exists( $filetodelete ) )
            {
                @chmod( $filetodelete, 0666 );
                if ( @unlink( $filetodelete ) )
                    redirect_header( 'upload.php', 1, _AM_WFS_DOWN_FILEDELETED );
                else
                    redirect_header( 'upload.php', 1, _AM_WFS_DOWN_FILEERRORDELETE );
            } 
            exit();
        } 
        else
        {
            if ( empty( $_POST['downfile'] ) )
            {
                redirect_header( 'upload.php', 1, _AM_WFS_DOWN_NOFILEERROR );
                exit();
            } 
            xoops_cp_header();
            xoops_confirm( array( 'op' => 'delfile', 'uploadpath' => $_POST['uploadpath'], 'downfile' => $_POST['downfile'], 'confirm' => 1 ),
                'upload.php', _AM_WFS_DOWN_DELETEFILE . "<br /><br />" . $_POST['downfile'], _AM_WFS_BDELETE );
        } 
        break;

    case "default":
    default:
        include_once '../class/wfslists.php';

        $displayimage = '';
        xoops_cp_header();

        $rootpath = ( $rootpath ) ? $rootpath : 2;

        Global $xoopsDB, $xoopsModuleConfig;

        $imgcat_handler = xoops_gethandler( 'imagecategory' );
        $imagecategorys = &$imgcat_handler->getObjects();

        $dirarray = array( 1 => $wfsPathConfig['sgraphicspath'], 2 => $wfsPathConfig['graphicspath'], 3 => "/modules/" . WFSECTION . "/images" );
        $namearray = array( 1 => _AM_WFS_DOWN_CATIMAGE , 2 => _AM_WFS_DOWN_SCREENSHOTS, 3 => _AM_WFS_DOWN_MAINIMAGEDIR );
        $listarray = array( 1 => _AM_WFS_DOWN_FCATIMAGE , 2 => _AM_WFS_DOWN_FSCREENSHOTS, 3 => _AM_WFS_DOWN_FMAINIMAGEDIR );

        wfs_admin_menu( _AM_WFS_MUPLOADS );
        if ( $rootpath > 0 )
            echo "<div><b>" . _AM_WFS_DOWN_FUPLOADPATH . "</b> " . XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath] . "</div>\n
				  <div><b>" . _AM_WFS_DOWN_FUPLOADURL . "</b> " . XOOPS_URL . "/" . $dirarray[$rootpath] . "</div><br />\n";

        $pathlist = ( isset( $listarray[$rootpath] ) ) ? $namearray[$rootpath] : '';
        $namelist = ( isset( $listarray[$rootpath] ) ) ? $namearray[$rootpath] : '';

        $iform = new XoopsThemeForm( _AM_WFS_DOWN_FUPLOADIMAGETO . $pathlist, "op", xoops_getenv( 'PHP_SELF' ) );
        $iform->setExtra( 'enctype="multipart/form-data"' );

        ob_start();
        $iform->addElement( new XoopsFormHidden( 'dir', $rootpath ) );
        wfs_getDirSelectOption( $namelist, $dirarray, $namearray );
        $iform->addElement( new XoopsFormLabel( _AM_WFS_DOWN_FOLDERSELECTION, ob_get_contents() ) );
        ob_end_clean();

        $free_space = disk_free_space( XOOPS_ROOT_PATH );
        $total_space = disk_total_space( XOOPS_ROOT_PATH );
        $used_space = ( $total_space - $free_space );

        echo "<div><b>Free Disk Space: </b>" . wfs_myfilesize( $free_space ) . "</div>";
        echo "<div><b>Total Used Space: </b>" . wfs_myfilesize( $used_space ) . "</div>";
        echo "<div><b>Total Disk Space: </b>" . wfs_myfilesize( $total_space ) . "</div>";
        
		if ( $rootpath > 0 )
        {
            $graph_array = &WfsLists::getListTypeAsArray( XOOPS_ROOT_PATH . "/" . $dirarray[$rootpath], $type = "images" );
            $indeximage_select = new XoopsFormSelect( '', 'downfile', '' );
            $indeximage_select->addOptionArray( $graph_array );
            $indeximage_select->setExtra( "onchange='showImgSelected(\"image\", \"downfile\", \"" . $dirarray[$rootpath] . "\", \"\", \"" . XOOPS_URL . "\")'" );
            $indeximage_tray = new XoopsFormElementTray( _AM_WFS_DOWN_FSHOWSELECTEDIMAGE, '&nbsp;' );
            $indeximage_tray->addElement( $indeximage_select );
            if ( !empty( $imgurl ) )
                $indeximage_tray->addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . XOOPS_URL . "/" . $dirarray[$rootpath] . "/" . $downfile . "' name='image' id='image' alt='' />" ) );
            else
                $indeximage_tray->addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' />" ) );
            $iform->addElement( $indeximage_tray );
            clearstatcache();
            $iform->addElement( new XoopsFormFile( _AM_WFS_DOWN_FUPLOADIMAGE, 'uploadfile', '' ), false );
            $iform->addElement( new XoopsFormText( _AM_WFS_IMAGEPREFIX, 'img_prefix', 15, 80, '' ), false );
            $iform->insertBreak( '', 'even' );
            $iform->addElement( new XoopsFormRadioYN( _AM_WFS_RESIZEIMAGE, 'img_resize', 0, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' ) );
            $iform->addElement( new XoopsFormRadioYN( _AM_WFS_DELIMAGE, 'img_del', 0, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' ) );
            $iform->insertBreak( _AM_WFS_IMGRESIZEOPTIONS, 'even' );
            $iform->addElement( new XoopsFormText( _AM_WFS_IMAGENEWWIDTH, 'img_width', 10, 80, '300' ), false );
            $iform->addElement( new XoopsFormText( _AM_WFS_IMAGENEWHEIGHT, 'img_height', 10, 80, '250' ), false );
            $iform->addElement( new XoopsFormText( _AM_WFS_IMAGENEWQUALITY, 'img_quality', 3, 30, '100' ), false );
            $iform->addElement( new XoopsFormRadioYN( _AM_WFS_IMAGEKEEPASPECT, 'img_aspect', 0, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' ) );

            $iform->addElement( $asspect_radio );
            $catcount = count( $imagecategorys );
            if ( !empty( $catcount ) )
            {
                $iform->insertBreak( '', 'even' );
                $iform->insertBreak( _AM_WFS_XOOPSIMGMAN, 'bg3' );

                ob_start();
                echo '<ul>';
                $image_handler = &xoops_gethandler( 'image' );
                for ( $i = 0; $i < $catcount; $i++ )
                {
                    $count = $image_handler->getCount( new Criteria( 'imgcat_id', $imagecategorys[$i]->getVar( 'imgcat_id' ) ) );
                    echo '<li>' . $imagecategorys[$i]->getVar( 'imgcat_name' ) . ' (' . sprintf( _NUMIMAGES, '<b>' . $count . '</b>' ) . ') [<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=images&amp;op=listimg&amp;imgcat_id=' . $imagecategorys[$i]->getVar( 'imgcat_id' ) . '">' . _LIST . '</a>] [<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=images&amp;op=editcat&amp;imgcat_id=' . $imagecategorys[$i]->getVar( 'imgcat_id' ) . '">' . _EDIT . '</a>]';
                    if ( $imagecategorys[$i]->getVar( 'imgcat_type' ) == 'C' )
                    {
                        echo ' [<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=images&amp;op=delcat&amp;imgcat_id=' . $imagecategorys[$i]->getVar( 'imgcat_id' ) . '">' . _DELETE . '</a>]';
                    } 
                    echo '</li>';
                } 
                echo '</ul>';
                $iform->insertBreak( ob_get_contents(), 'even' );
                ob_end_clean();

                $iform->addElement( new XoopsFormRadioYN( _AM_WFS_USEIMAGEMANGER, 'use_imgman', 0, _YES, _NO ) );
                $iform->addElement( new XoopsFormText( _IMAGENAME, 'image_nicename', 50, 255 ), false );
                $select = new XoopsFormSelect( _IMAGECAT, 'imgcat_id' );
                $select->addOptionArray( $imgcat_handler->getList() );
                $iform->addElement( $select, true );
                $iform->addElement( new XoopsFormText( _IMGWEIGHT, 'image_weight', 3, 4, 0 ) );
                $iform->addElement( new XoopsFormRadioYN( _IMGDISPLAY, 'image_display', 1, _YES, _NO ) );
            } 
            $iform->addElement( new XoopsFormHidden( 'uploadpath', $dirarray[$rootpath] ) );
            $iform->addElement( new XoopsFormHidden( 'rootnumber', $rootpath ) );
            $iform->insertBreak( '', 'even' );

            $dup_tray = new XoopsFormElementTray( '', '' );
            $dup_tray->addElement( new XoopsFormHidden( 'op', 'upload' ) );
            $butt_dup = new XoopsFormButton( '', '', _AM_WFS_BUPLOAD, 'submit' );
            $butt_dup->setExtra( 'onclick="this.form.elements.op.value=\'upload\'"' );
            $dup_tray->addElement( $butt_dup );

            $butt_dupct = new XoopsFormButton( '', '', _AM_WFS_BDELETEIMAGE, 'submit' );
            $butt_dupct->setExtra( 'onclick="this.form.elements.op.value=\'delfile\'"' );
            $dup_tray->addElement( $butt_dupct );
            $iform->addElement( $dup_tray );
        } 
        $iform->display();
} 
xoops_cp_footer();

?>