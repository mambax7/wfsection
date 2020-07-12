<?php 
// $Id: wfs_homecenter.php,v 1.4 2004/08/13 12:43:58 phppp Exp $
//  ------------------------------------------------------------------------ //
//                        WFsections for XOOPS                               //
//                 Copyright (c) 2004 WF-section Team                        //
//                  <http://www.wf-projects.com/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: WF-section Team                                                   //
// URL: http://www.wf-projects.com                                         //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
//Important change this to the directory path you have choosen.
include_once XOOPS_ROOT_PATH . "/modules/wfsection/class/common.php";
//
include_once WFS_ROOT_PATH . '/include/groupaccess.php';
include_once WFS_ROOT_PATH . "/include/functions.php";

function b_wfs_homecenter_show( $options )
{

	global $xoopsDB;
    $myts = & MyTextSanitizer :: getInstance();
    $block = array();
    $sql = "SELECT articleid, title, groupid, articleimg, summary FROM " . $xoopsDB -> prefix( "wfs_article" ) . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND noshowart = 0 AND offline = 0 ORDER BY " . $options[0] . " DESC";
    $result = $xoopsDB -> query( $sql, $options[1], 0 );
    while ( $myrow = $xoopsDB -> fetchArray( $result ) )
    {
		if ( wfs_checkAccess( $myrow["groupid"] ) )
        {
            $wfs = array();
            $title = $myts -> makeTboxData4Show( $myrow["title"] );
            if ( !XOOPS_USE_MULTIBYTES )
            {
                if ( strlen( $myrow['title'] ) >= $options[2] )
                {
                    $title = $myts -> makeTboxData4Show( substr( $myrow['title'], 0, ( $options[2] -1 ) ) ) . "...";
                } 
            } 
            $wfs['id'] = $myrow['articleid'];
            $wfs['title'] = "<a href=\"" . XOOPS_URL . "/modules/wfsection/article.php?articleid=" . $wfs['id'] . "\">" . $title . "</a>";
            //$wfs['image'] = wfs_createthumb( $myrow['articleimg'], XOOPS_ROOT_PATH, "/modules/wfsection/images/article/", "thumbs/", 100, 129, 75 ); 
            $wfs['image'] = ($xoopsModuleConfig['use_thumbs'])?wfs_createthumb($myrow['articleimg'], XOOPS_ROOT_PATH."/modules/wfsection/images/article", "thumbs", 100, 129, 75):"thumbs/".$myrow['articleimg'];
            // $wfs['image'] = XOOPS_URL."/modules/wfsection/getthumb.php?image_file=".$myrow['image']."&path=".XOOPS_URL."/modules/wfsection/images/article/&width=100&height=130";
            $summary = $myts -> makeTboxData4Show( $myrow["summary"] );
            if ( !XOOPS_USE_MULTIBYTES )
            {
                if ( strlen( $myrow['summary'] ) >= $options[3] )
                {
                    $summary = $myts -> makeTboxData4Show( substr( $myrow['summary'], 0, ( $options[3] -1 ) ) ) . "...";
                } 
            } 
            $wfs["summary"] = $summary;
            $wfs["more"] = "<a href=\"" . XOOPS_URL . "/modules/wfsection/article.php?articleid=" . $wfs['id'] . "\">" . _MB_WFS_MORE . "</a>";
            $block[] = $wfs;
        } 
    } 
    return $block;
} 

function b_wfs_homecenter_edit( $options )
{
    $form = "" . _MB_WFS_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='published'";
    if ( $options[0] == "published" )
    {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_WFS_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ( $options[0] == "counter" )
    {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_WFS_HITS . "</option>\n";

    $form .= "</select>\n";
    $form .= "&nbsp;" . _MB_WFS_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_WFS_ARTCLS . "";
    $form .= "&nbsp;<br>" . _MB_WFS_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_WFS_LENGTH . "";
    $form .= "&nbsp;<br>" . _MB_WFS_CHARS2 . "&nbsp;<input type='text' name='options[]' value='" . $options[3] . "' />&nbsp;" . _MB_WFS_LENGTH . "";

    return $form;
} 

?>