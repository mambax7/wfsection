<?php 
// $Id: admin.php,v 1.4 2004/08/13 12:41:44 phppp Exp $
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
// URL: http://www.wf-projects.com                                           //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
include_once 'admin_header.php';

/**
 * Only for users who have admin right to system
 */
accessadmin( "adminrights" );

$op = ( isset( $_POST['op'] ) ) ? $_POST['op'] : '';

switch ( $op )
{
    case "save":

        global $xoopsDB, $_POST; 

        $adminrights = ( isset($_POST['adminrights']) ) ? wfs_saveAccess( $_POST['adminrights'] ) : "1";
        $paths = ( isset( $_POST['paths'] ) ) ? wfs_saveAccess( $_POST['paths'] ) : "1";
        $moderator = ( isset($_POST['moderator']) ) ? wfs_saveAccess( $_POST['moderator'] ) : "1";
        $restore = ( isset($_POST['restore']) ) ? wfs_saveAccess( $_POST['restore'] ) : "1";
        $editarticle = ( isset($_POST['editarticle']) ) ? wfs_saveAccess( $_POST['editarticle'] ) : "1";
        $newsection = ( isset($_POST['newsection']) ) ? wfs_saveAccess( $_POST['newsection'] ) : "1";
        $downloads = ( isset($_POST['downloads']) ) ? wfs_saveAccess( $_POST['downloads'] ) : "1";
        $deletearticles = ( isset($_POST['deletearticles']) ) ?wfs_saveAccess( $_POST['deletearticles'] ) : "1";
        $templates = ( isset($_POST['templates']) ) ? wfs_saveAccess( $_POST['templates'] ) : "1";
        $createarticles = ( isset($_POST['createarticles']) ) ? wfs_saveAccess( $_POST['createarticles'] ) : "1" ;
        $docapprove = ( isset($_POST['docapprove']) ) ? wfs_saveAccess( $_POST['docapprove'] ) : "1";
		$mimetypes = ( isset($_POST['mimetypes']) ) ? wfs_saveAccess( $_POST['mimetypes'] ) : "1";
		$reviews = ( isset($_POST['reviews']) ) ? wfs_saveAccess( $_POST['reviews'] ) : "1";
		$docstats = ( isset($_POST['docstats']) ) ? wfs_saveAccess( $_POST['docstats'] ) : "1";
		$doclinks = ( isset($_POST['doclinks']) ) ? wfs_saveAccess( $_POST['doclinks'] ) : "1";
		$indexpage = ( isset($_POST['indexpage']) ) ? wfs_saveAccess( $_POST['indexpage'] ) : "1";
		$importdoc = ( isset($_POST['importdoc']) ) ? wfs_saveAccess( $_POST['importdoc'] ) : "1";
		$importdoc = ( isset($_POST['importdoc']) ) ? wfs_saveAccess( $_POST['importdoc'] ) : "1";
		$uploads = ( isset($_POST['uploads']) ) ? wfs_saveAccess( $_POST['uploads'] ) : "1";
				
		$sql = "UPDATE " . $xoopsDB->prefix( WFS_PERMISSIONS ) . " SET 
			adminrights = '$adminrights', 
			paths ='$paths', 
			moderator = '$moderator',
			newsection ='$newsection', 
			downloads ='$downloads',
			editarticle = '$editarticle', 
			deletearticles = '$deletearticles', 
			restore = '$restore', 
			templates = '$templates',
			createarticles = '$createarticles',
			docapprove = '$docapprove',
			mimetypes = '$mimetypes',
			reviews = '$reviews',
			docstats = '$docstats',
			doclinks = '$doclinks',
			indexpage = '$indexpage',
			importdoc = '$importdoc',
			uploads = '$uploads'
		 ";
        $result = $xoopsDB->query( $sql );
        /**
         * Show error if there is a problem
         */
        if ( !$result ) wfs_error_report( $sql );

        redirect_header( "wfs_admin.php", 1, _AM_WFS_ACCESSUPDATED );
        break;

    default:

        xoops_cp_header();

        $sql = "SELECT * from " . $xoopsDB->prefix( WFS_PERMISSIONS );
        $permissions = $xoopsDB->fetchArray( $xoopsDB->query( $sql ) );

        wfs_admin_menu( _AM_WFS_ACCESSCONFIG );
        wfs_textinfo( _AM_WFS_ADMINACCESS, _AM_WFS_ADMINACCESSTEXT );

        include XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        $sform = new XoopsThemeForm( _AM_WFS_ADMINCONTROL, "op", xoops_getenv( 'PHP_SELF' ) );
        $sform->insertBreak( _AM_WFS_ADMINSPEC, "even" );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSTOADMINRIGHTS, 'adminrights', false, wfs_getGroupIda( $permissions['adminrights'] ), 5, true ) );
		$sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSTOPATHS, 'paths', false, wfs_getGroupIda( $permissions['paths'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSTOTEMPLA, 'templates', false, wfs_getGroupIda( $permissions['templates'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSTORESTORE, 'restore', false, wfs_getGroupIda( $permissions['restore'] ), 5, true ) );
        $sform->insertBreak( "", "even" );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_MODERATORACCESS, 'moderator', false, wfs_getGroupIda( $permissions['moderator'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_APPROVEART, 'docapprove', false, wfs_getGroupIda( $permissions['docapprove'] ), 5, true ) );
        $sform->insertBreak( "", "even" );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSTOINDEX, 'indexpage', false, wfs_getGroupIda( $permissions['indexpage'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSDOWNLOADS, 'downloads', false, wfs_getGroupIda( $permissions['downloads'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSMIMETYPE, 'mimetypes', false, wfs_getGroupIda( $permissions['mimetypes'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSSTATS, 'docstats', false, wfs_getGroupIda( $permissions['docstats'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSDOCLINKS, 'doclinks', false, wfs_getGroupIda( $permissions['doclinks'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSIMPORT, 'importdoc', false, wfs_getGroupIda( $permissions['importdoc'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSUPLOADS, 'uploads', false, wfs_getGroupIda( $permissions['uploads'] ), 5, true ) );
		$sform->insertBreak( _AM_WFS_USERSPEC, "even" );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_CREATENEWSECTION, 'newsection', false, wfs_getGroupIda( $permissions['newsection'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSREVIEWS, 'reviews', false, wfs_getGroupIda( $permissions['reviews'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_CREATEOWNART, 'createarticles', false, wfs_getGroupIda( $permissions['createarticles'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_ACCESSTOEDITART, 'editarticle', false, wfs_getGroupIda( $permissions['editarticle'] ), 5, true ) );
        $sform->addElement( new XoopsFormSelectGroup( _AM_WFS_DELETEOWNART, 'deletearticles', false, wfs_getGroupIda( $permissions['deletearticles'] ), 5, true ) );
        /**
         * Permission buttons
         */
        $button_tray = new XoopsFormElementTray( '', '' );
        $hidden = new XoopsFormHidden( 'op', 'save' );
        $button_tray->addElement( $hidden );
        $button_tray->addElement( new XoopsFormButton( '', 'post', _AM_WFS_SAVECHANGE, 'submit' ) );
        $sform->addElement( $button_tray );
        $sform->display();
        unset( $hidden );
        break;
} 
xoops_cp_footer();

?>
