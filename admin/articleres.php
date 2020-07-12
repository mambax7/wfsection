<?php 
// $Id: articleres.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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

$restore_id = isset( $_GET['restore_id'] ) ? intval( $_GET['restore_id'] ) : 0;
if ( !$restore_id ) die( _AM_WFS_NORESTORE );
if ( !( $xoopsUser->isAdmin() ) ) die( _NOPERM );

$article = new WfsArticleRes( $restore_id );
$datetime = formatTimestamp( $article->created(), $xoopsModuleConfig['timestamp'] );
$articletag = $article->articleimg("S", $size = 0, 1);

if ( !empty( $article->htmlpage ) )
{
    $includepage = WFS_HTML_PATH . "/" . $article->htmlpage( "S" );
    $maintext = '';
    $maintext = include( $includepage );
    $maintext = $maintext;
} 
else
{
    $maintext = $article->maintext( "S" );
    $maintext = str_replace( "[pagebreak]", "<br style=\"page-break-after:always;\">", $maintext );
} 

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">';
echo '<html><head>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=' . _CHARSET . '" />';
echo '<title>' . $xoopsConfig['sitename'] . '</title>';
echo '<meta name="AUTHOR" content="' . $xoopsConfig['sitename'] . '" />';
echo '<meta name="COPYRIGHT" content="Copyright (c) ' . date( 'Y' ) . ' by ' . $xoopsConfig['sitename'] . '" />';
echo '<meta name="DESCRIPTION" content="' . $xoopsConfig['slogan'] . '" />';
echo '<meta name="GENERATOR" content="' . XOOPS_VERSION . '" />';

echo '<body bgcolor="#ffffff" text="#000000"">';
echo '
<table width="70%" border="0" cellspacing="1" cellpadding="0" bgcolor="#ffffff">
  <tr>
	<!---<td width="71" rowspan="3" align="center" valign="middle">' . $article->artimage . '</td>-->
    <td width="91%"><b>' . $article->title() . '</b></td>
  </tr>
  <tr>
    <td bgcolor="#000000"><img src="/images/blank.png" alt="" height="0" width="1" border="0"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top" width="75%">
			<div><b>' . _AM_WFS_AUTHOR . '</b> ' . $article->uname() . ' 
            <div><b>' . _AM_WFS_PUBLISHEDDATE . '</b> '.$datetime.'</div> 
			<div><b>' . _AM_WFS_RESTORE_VERSION . ':</b> '.$article->version.'</div>
			<div><b>' . _AM_WFS_ID . '</b> '.$article->articleid.'</div>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="70%" border="0" cellspacing="1" cellpadding="2" bgcolor="#ffffff"> 
  <tr> 
    <td width="100%" align="left" valign="top">'; 
	  if ($articletag) {
		echo '<img src="$articletag" align="right" hspace= "5" vspace= "0"  alt="" style="border: 1px solid black">'; 
	  }
echo '<div><b>'.$article->subtitle().'</b></div><br /> 
		'.$maintext.'';
		echo '<br /><br /><a href="' . WFS_ROOT_URL . '/article.php?articleid=' . $article->articleid() . '">' . WFS_ROOT_URL . '/article.php?articleid=' . $article->articleid() . '</a><br /><br />';
		echo "<div align ='center'>Copyright (c) " . date( 'Y' ) . " by " . $xoopsConfig['sitename'] . "<div>";
echo '</td> 
  </tr> 
</table> 
';

echo '</body>';
echo '</html>';

?>
