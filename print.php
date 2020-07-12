<?php
// $Id: print.php,v 1.4 2004/08/13 12:38:49 phppp Exp $
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
include 'header.php';
include_once "class/common.php";
include_once WFS_ROOT_PATH . "/include/functions.php" ;
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";

$articleid = ( isset( $_GET['articleid'] ) && intval( $_GET['articleid'] > 0 ) ) ? intval( $_GET['articleid'] ) : 0;
if ( $articleid <= 0 ) {
    redirect_header( "index.php" );
}

$article = new WfsArticle( intval( $articleid ) );
if ( !wfs_checkAccess( $article->groupid ) ) {
    redirect_header( "index.php", 2, _NOPERM );
    exit();
}

include_once "class/common.php";
include_once WFS_ROOT_PATH . "/include/functions.php" ;
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";

$datetime = formatTimestamp( $article->published(), $xoopsModuleConfig['timestamp'] );

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
echo '<html><head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=' . _CHARSET . '" />';
echo '<title>' . $xoopsConfig['sitename'] . '</title>';
echo '<meta name="AUTHOR" content="' . $xoopsConfig['sitename'] . '" />';
echo '<meta name="COPYRIGHT" content="Copyright (c) ' . date( 'Y' ) . ' by ' . $xoopsConfig['sitename'] . '" />';
echo '<meta name="DESCRIPTION" content="' . $xoopsConfig['slogan'] . '" />';
echo '<meta name="GENERATOR" content="' . XOOPS_VERSION . '" />';

echo '<body bgcolor="#ffffff" text="#000000" onload="window.print()">';
echo '<table border="0">
		<tr><td align="center">';
echo '<table border="0" width="640" cellpadding="0" cellspacing="1" >
		<tr><td>';
echo '<table border="0" width="640" cellpadding="2" cellspacing="1" bgcolor="#ffffff">';
echo '<tr><td align="center">';
echo '<h3>' . $article->title() . '</h3>';
echo '<div align = "left"><small><b>' . _WFS_DATE . '</b>&nbsp;' . $datetime . ' <br /> <b>' . _WFS_TOPICC . '</b>&nbsp;' . $article->categoryTitle( "S" ) . '</small><div></td></tr>';

if ( !empty( $article->htmlpage ) ) {
    $includepage = WFS_HTML_PATH . "/" . $article->htmlpage( "S" );
    $maintext = include( $includepage );
} else {
    $maintext = $article->maintext( "S" );
    $maintext = str_replace( "[pagebreak]", "<br style=\"page-break-after:always;\">", $maintext );
}
echo '<tr><td>';
if ( $maintext ) {
    echo '' . $maintext . '<br />';
}
echo '</td></tr></table></td></tr></table>';

printf( _WFS_THISCOMESFROM, $xoopsConfig['sitename'] );
echo '<br /><a href="' . XOOPS_URL . '/">' . XOOPS_URL . '</a><br /><br />';
echo '' . _WFS_URLFORSTORY . '<br />';
echo '<a href="' . WFS_ROOT_URL . '/article.php?articleid=' . $article->articleid() . '">' . WFS_ROOT_URL . '/article.php?articleid=' . $article->articleid() . '</a><br /><br />';
echo "<div align ='center'>Copyright (c) " . date( 'Y' ) . " by " . $xoopsConfig['sitename'] . "<div>";
echo '</td></tr></table>';
echo '</body>';
echo '</html>
    	';

?>
