<?php 
// $Id: wfs_bigstory.php,v 1.5 2004/08/18 02:58:50 phppp Exp $
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
// Important change this to the directory path you have choosen.
include_once XOOPS_ROOT_PATH . "/modules/wfsection/class/common.php";

include_once WFS_ROOT_PATH . '/include/groupaccess.php';

function b_wfs_bigstory_show()
{
    global $xoopsDB, $xoopsUser, $wfsPathConfig;
    
    $modhandler = &xoops_gethandler('module');
    $xoopsModule = &$modhandler->getByDirname(WFSECTION);
    $config_handler = &xoops_gethandler('config');
    $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsModule->getVar('mid'));
    
    $myts = &MyTextSanitizer::getInstance();
    $block = array();
    $tdate = time()-86400;
	
	$result = $xoopsDB->query("SELECT articleid, title, summary, groupid, articleimg 
		FROM " . $xoopsDB->prefix(WFS_ARTICLE_DB) . " 
		WHERE published > ".$tdate." AND published < " . time() . " 
		AND (expired > " . time() . " OR expired = 0) 
		AND noshowart = 0 
		AND offline = 0 
		ORDER BY published DESC", 1, 0)
	;
    list($farticleid, $ftitle, $fsummary, $fgroupid, $farticleimg ) = $xoopsDB->fetchRow($result);
	
	$block['message'] = _MB_WFS_NOTYET;
    //if (wfs_checkAccess($fgroupid))
    //{
        $block['message'] = _MB_WFS_TMRSI;
        $block['story_title'] = "<a href='" . WFS_ROOT_URL . "/article.php?articleid=" . $farticleid . "'>" . $myts->htmlSpecialChars(stripslashes($ftitle)) . "</a>";
        $block['story_summary'] = $myts->htmlSpecialChars(stripslashes($fsummary));
        $block['lang_title'] = _MB_WFS_TITLE;
        $block['lang_summary'] = _MB_WFS_SUMMARY;
        
		if ($farticleimg && $farticleimg != "blank.png")
		$block['image'] = ($xoopsModuleConfig['use_thumbs']) ? wfs_createthumb($farticleimg, $wfsPathConfig['graphicspath'], "thumbs", 47, 62, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect']) : WFS_ARTICLEIMG_URL.'/'.$farticleimg;

     	$block["readmore"] = "<a href=\"" . WFS_ROOT_URL . "/article.php?articleid=" . $farticleid . "\">" . _MB_WFS_SPOTREADMORE . "</a>.";;
    //}
    return $block;
}

?>