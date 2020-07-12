<?php 
// $Id: wfs_spotlight.php,v 1.6 2004/08/18 03:01:57 phppp Exp $
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
// Important change this to the directory path you have choosen.
include_once XOOPS_ROOT_PATH . "/modules/wfsection/class/common.php";
include_once WFS_ROOT_PATH . "/include/functions.php";
include_once WFS_ROOT_PATH . '/class/wfsarticle.php';

function b_wfsection_spotlight( $options )
{
    global $xoopsDB, $xoopsUser, $wfsPathConfig;

    $myts = &MyTextSanitizer::getInstance();

    $modhandler = &xoops_gethandler( 'module' );
    $xoopsModule = &$modhandler->getByDirname( WFSECTION );
    $config_handler = &xoops_gethandler( 'config' );
    $xoopsModuleConfig = &$config_handler->getConfigsByCat( 0, $xoopsModule->getVar( 'mid' ) );

    $block = array();
    $block["title_wfsection"] = _MB_WFS_SPOTTITLE;
    $block["lang_by"] = _MB_WFS_SPOTAUTORE;
    $block["lang_read"] = _MB_WFS_SPOTREAD; 
    /*
	* 
	*/ 
    $result = $xoopsDB->query( "SELECT item, image, itemlength, imagewidth, imageheight, sum_type FROM " . $xoopsDB->prefix( WFS_SPOTLIGHT ) . " WHERE sid = 1" );
    list ( $item, $image, $itemlength, $imagewidth, $imageheight, $sum_type ) = $xoopsDB->fetchRow( $result );

    $item = ( $item > 0 ) ? $item : WfsArticle::getLastArticleByCategory();

    $result3 = $xoopsDB->query( "SELECT articleid, uid, title, subtitle, maintext, summary FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " WHERE articleid = " . $item . " AND changed < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") ORDER BY changed DESC", 1, 0 );
    list ( $fsid, $fautore, $ftitle, $fsubtitle, $fmaintext, $fsummary ) = $xoopsDB->fetchRow( $result3 );

    $block["articleid"] = intval( $fsid );
    $ftitle = $myts->htmlSpecialChars( stripslashes( $ftitle ) );
    $block["articletitle"] = "<a href='" . WFS_ROOT_URL . "/article.php?articleid=" . $block["articleid"] . "'>" . $ftitle . "</a>";
    $block["author"] = wfs_getLinkedUnameFromId( intval( $fautore ), $xoopsModuleConfig['displayname'] , 0 );
	
	if ( $image ) { 
		$block["image"] = ( $xoopsModuleConfig['use_thumbs'] == 1) ? 
			wfs_createthumb( $image, $wfsPathConfig['graphicspath'], "thumbs", $imagewidth, $imageheight, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : 
			WFS_ARTICLEIMG_URL . '/' . $image;
	}
	switch ( trim( $sum_type ) )
    {
        case 1:
            $maintext = stripslashes($subtitle);
            break;
        case 2:
            $maintext = stripslashes( $fsummary );
            break;
        case 3:
        default:
            
			$maintext = stripslashes( $fmaintext );
            break;
    } 
	$spot_main_text = ($itemlength >= 1) ? wfs_summarize( $maintext, $itemlength ) : $maintext;
    $spot_main_text = preg_replace( "/(\<img)(.*?)(\>)/si", "", $spot_main_text );
    $block["maintext"] = $myts->displayTarea( $spot_main_text, 1, 1, 1, 1, 0 );

    if ( !is_object( $xoopsUser ) )
    {
        $block["readmore"] = "<a href=\"" . XOOPS_URL . "/user.php\">" . _MB_WFS_SPOTREAD . "</a>.";
    } 
    else
    {
        $block["readmore"] = "<a href=\"" . WFS_ROOT_URL . "/article.php?articleid=" . $fsid . "\">" . _MB_WFS_SPOTREADMORE . "</a>.";;
    } 
    return $block;
} 

?>
