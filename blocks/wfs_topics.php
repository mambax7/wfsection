<?php
// $Id: wfs_topics.php,v 1.4 2004/08/13 12:43:59 phppp Exp $
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
//include_once WFS_ROOT_PATH.'/class/wfstree.php';
//include_once WFS_ROOT_PATH.'/include/groupaccess.php';

include_once XOOPS_ROOT_PATH.'/class/xoopslists.php';
	
function b_wfs_topics_show() {
	define("_WFS_ROOT_CATEGORY","root category");
    $modhandler = &xoops_gethandler('module');
    $xoopsModule = &$modhandler->getByDirname(WFSECTION);

	global $xoopsDB, $xoopsConfig;
	$block = array();
	$tree = new wfsTree($xoopsDB->prefix(WFS_CATEGORY_DB), "id", "pid");
	$jump = WFS_ROOT_URL."/viewarticles.php?";
	$id = !empty($fid) ? intval($_POST['id']) : 0;
	ob_start();
	echo $tree->makeMyRootedSelBox('title', 'title', $id, true, $id, true, "", "location.href='{$jump}category='+this.options[this.selectedIndex].value");
	$block['selectbox'] = ob_get_contents();
	ob_end_clean();
	return $block;
}
?>