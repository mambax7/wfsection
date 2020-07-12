<?php 
// $Id: pathconfig.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
// Options setting
// Only for users who have admin right to system
include 'admin_header.php';

accessadmin( "paths" );

$op = '';

if ( isset( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        ${$k} = $v;
    } 
} 

$userpath = "";

/**
 * getcorrectpath()
 * 
 * @param  $path 
 * @return 
 */
function wfs_getcorrectpath( $url, $dir, $path )
{
    $ret['url'] = $url . "/" . $path;
    $paths = $dir . "/" . $path;
    $thumb_path = $dir . "/" . $path;

    $ret['path'] = ( is_dir( $paths ) ) ? _AM_WFS_PATHEXIST : "<i><b><font color=\"#FF0000\">" . _AM_WFS_PATHNOTEXIST . "</font></b></i>";
    $ret['pathchmod'] = ( !is_dir( $paths ) or !is_writeable( $paths ) ) ? "<i><b><font color=\"#FF0000\">" . _AM_WFS_CMODERROR . "</font></b></i>" : wfs_get_perms( $paths, 1 );
    $ret['thumbpath'] = ( is_dir( $thumb_path ) ) ? _AM_WFS_THUMBPATHEXIST : "<i><b><font color=\"#FF0000\">" . _AM_WFS_THUMBPATHNOTEXIST . "</font></b></i>";
    $ret['thumbchmod'] = ( !is_dir( $thumb_path ) or !is_writeable( $thumb_path ) ) ? "<i><b><font color=\"#FF0000\">" . _AM_WFS_CMODERROR . "</font></b></i>" : wfs_get_perms( $thumb_path, 1 );

    return $ret;
} 

switch ( $op )
{
    case "save":

        if ( !isset( $_POST['defaults'] ) )
        {
            global $xoopsDB;

            if ( isset( $_POST['paths'] ) )
            {
                $thispathy = $_POST['paths'];
            } 
            $graphicspath = ( !empty( $thispathy[0] ) ) ? $thispathy[0] : 'modules/' . WFSECTION . '/images/article';
            $graphicspath = trim( $graphicspath );
            $sgraphicspath = ( !empty( $thispathy[1] ) ) ? $thispathy[1] : 'modules/' . WFSECTION . '/images/category';
            $sgraphicspath = trim( $sgraphicspath );
            $htmlpath = ( !empty( $thispathy[2] ) ) ? $thispathy[2] : 'modules/' . WFSECTION . '/html';
            $htmlpath = trim( $htmlpath );
            $filesbasepath = ( !empty( $thispathy[3] ) ) ? $thispathy[3] : 'modules/' . WFSECTION . '/cache/uploaded';
            $filesbasepath = trim( $filesbasepath );

            $logopath = ( !empty( $thispathy[5] ) ) ? $thispathy[5] : 'modules/' . WFSECTION . '/images/logos';
            $logopath = trim( $logopath );

            $sql = "UPDATE " . $xoopsDB->prefix( WFS_CONFIG_DB ) . " SET 
				filesbasepath='$filesbasepath', 
				graphicspath='$graphicspath', 
				sgraphicspath='$sgraphicspath', 
				htmlpath='$htmlpath', 
				logopath = '$logopath'
			";
            $result = $xoopsDB->query( $sql );
            $error = "" . _AD_DBERROR . ": <br /><br />" . $sql;
            if ( !$result ) trigger_error( $error, E_USER_ERROR );

            redirect_header( xoops_getenv( 'PHP_SELF' ), 1, _AM_WFS_WFPATHCONFIG );
            exit();
        } 
        else
        {
            $sql = "UPDATE " . $xoopsDB->prefix( WFS_CONFIG_DB ) . " SET 
				filesbasepath ='modules/" . WFSECTION . "/cache/uploaded', 
				graphicspath ='modules/" . WFSECTION . "/images/article', 
				sgraphicspath ='modules/" . WFSECTION . "/images/category', 
				filebasepathtemp ='modules/" . WFSECTION . "/cache/uploaded/temp', 
				htmlpath ='modules/" . WFSECTION . "/html', 
				logopath = 'modules/" . WFSECTION . "/images/logos'
			";
            $result = $xoopsDB->query( $sql );
            $error = "" . _AD_DBERROR . ": <br /><br />" . $sql;
            if ( !$result ) trigger_error( $error, E_USER_ERROR );
            redirect_header( xoops_getenv( 'PHP_SELF' ), 1, _AM_WFS_REVERTED );
            exit();
        } 
        break;

    default:

        global $xoopsDB;

        $paths = array();

        $sql = "SELECT 
			graphicspath, 
			sgraphicspath, 
			htmlpath, 
			filesbasepath, 
			logopath 
		FROM " . $xoopsDB->prefix( WFS_CONFIG_DB );
        $thisarray = $xoopsDB->fetchrow( $xoopsDB->query( $sql ) );

        $error = "" . _AD_DBERROR . ": <br /><br />" . $sql;

        if ( empty( $thisarray ) ) trigger_error( $error, E_USER_ERROR );

        $lang_temp_array = array( 
            _AM_WFS_AGRAPHICPATH,
            _AM_WFS_SGRAPHICPATH,
            _AM_WFS_HTMLCPATH,
            _AM_WFS_FILEUPLOADSPATH,
            _AM_WFS_LOGOPATH 
            );

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_PATHCONFIGURATION );

        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_WFS_PATHCONFIG . "</legend>";
        echo "<div style='padding: 8px;'>";
        echo "<div style='padding-bottom: 8px;'>" . _AM_WFS_FILEPATHWARNING . "</div>";
        echo "</div></fieldset><br />";

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $sform = new XoopsThemeForm( _AM_WFS_FILEPATH, "op", xoops_getenv( 'PHP_SELF' ) );
        for ( $i = 0; $i < count( $thisarray ); $i++ )
        {
            $options_tray[$i] = new XoopsFormElementTray( $lang_temp_array[$i], '<br />' );
            $paths_input[$i] = new XoopsFormText( '', 'paths[]', 50, 80, $thisarray[$i] );
            $options_tray[$i]->addElement( $paths_input[$i] );

            $getcorrect = wfs_getcorrectpath( XOOPS_URL, XOOPS_ROOT_PATH, $thisarray[$i] );
            $paths_show[$i] = new XoopsFormLabel( _AM_WFS_PATHCHECK . $getcorrect['path'], "" );
            $options_tray[$i]->addElement( $paths_show[$i] );

            $paths_permission[$i] = new XoopsFormLabel( sprintf( _AM_WFS_PERMISSIONS, basename( $thisarray[$i] ) ), $getcorrect['pathchmod'] );
            $options_tray[$i]->addElement( $paths_permission[$i] );
            switch ( basename( $thisarray[$i] ) )
            {
                case "article":
                case "category":
                case "logos":
                    $getcorrect_thumb = wfs_getcorrectpath( XOOPS_URL, XOOPS_ROOT_PATH, $thisarray[$i] . "/thumbs" );
                    $paths_thumb_show[$i] = new XoopsFormLabel( "<br />" . _AM_WFS_THUMBPATHCHECK . $getcorrect_thumb['thumbpath'], "" );
                    $options_tray[$i]->addElement( $paths_thumb_show[$i] );

                    $paths_thumb_permission[$i] = new XoopsFormLabel( sprintf( _AM_WFS_THUMBPERMISSIONS, basename( $thisarray[$i] ) ), $getcorrect_thumb['pathchmod'] );
                    $options_tray[$i]->addElement( $paths_thumb_permission[$i] );
                    break;
            } 
            $sform->addElement( $options_tray[$i] );
        } 

        $options_tray = new XoopsFormElementTray( _AM_WFS_AVATARPATH, '<br />' );
        $getcorrect_thumb = wfs_getcorrectpath( XOOPS_UPLOAD_URL, XOOPS_UPLOAD_PATH, "/thumbs" );
        
		$paths_thumb_path = new XoopsFormLabel( '', XOOPS_UPLOAD_PATH."/thumbs<br />"  );
        $options_tray->addElement( $paths_thumb_path );
        
		$paths_thumb_pathc = new XoopsFormLabel( sprintf( _AM_WFS_THUMBPATHCHECK ), $getcorrect_thumb['path'] );
        $options_tray->addElement( $paths_thumb_pathc );
        if ($getcorrect_thumb['path'] != 'Path does not exist.') {
        	$paths_thumb_permission = new XoopsFormLabel( sprintf( _AM_WFS_THUMBPERMISSIONS ), $getcorrect_thumb['pathchmod'] );
        	$options_tray->addElement( $paths_thumb_permission );
        }
		$sform->addElement( $options_tray );

        $default_checkbox = new XoopsFormCheckBox( '', 'defaults', 0 );
        $default_checkbox->addOption( 1, _AM_WFS_RESETDEFUALTS );
        $sform->addElement( $default_checkbox );
        $button_tray = new XoopsFormElementTray( '', '' );
        $hidden = new XoopsFormHidden( 'op', 'save' );
        $button_tray->addElement( $hidden );
        $button_tray->addElement( new XoopsFormButton( '', 'save', _AM_WFS_SAVECHANGE, 'submit' ) );
        $sform->addElement( $button_tray );
        $sform->display();
        break;
} 
xoops_cp_footer();

?>
