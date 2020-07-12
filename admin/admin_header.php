<?php 
// $Id: admin_header.php,v 1.4 2004/08/13 12:41:44 phppp Exp $
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
include("../../../mainfile.php");
include '../../../include/cp_header.php';
include_once "../class/common.php";
include_once WFS_ROOT_PATH . "/include/functions.php";
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";
include_once WFS_ROOT_PATH . "/class/wfsarticleres.php";
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

// following checked in cp_header.php, so ...
/*
if (is_object($xoopsUser))
{
    $xoopsModule = XoopsModule::getByDirname(WFSECTION);
    if (!$xoopsUser->isAdmin($xoopsModule->mid()))
    {
        redirect_header(XOOPS_URL , 1, _NOPERM);
        exit();
    }
}
else
{
    redirect_header(XOOPS_URL , 1, _NOPERM);
    exit();
}
*/
$myts = &MyTextSanitizer::getInstance();

$imagearray = array(
	'editimg' => "<img src='../images/icon/edit.gif' alt='" . _AM_WFS_ICO_EDIT . "' align='middle'>",
    'deleteimg' => "<img src='../images/icon/delete.gif' alt='" . _AM_WFS_ICO_DELETE . "' align='middle'>",
    'online' => "<img src='../images/icon/on.gif' alt='" . _AM_WFS_ICO_ONLINE . "' align='middle'>",
    'offline' => "<img src='../images/icon/off.gif' alt='" . _AM_WFS_ICO_OFFLINE . "' align='middle'>",
    'approved' => "<img src='../images/icon/on.gif' alt=''" . _AM_WFS_ICO_APPROVED . "' align='middle'>",
    'notapproved' => "<img src='../images/icon/off.gif' alt='" . _AM_WFS_ICO_NOTAPPROVED . "' align='middle'>",
    'relatedfaq' => "<img src='../images/icon/link.gif' alt='" . _AM_WFS_ICO_LINK . "' align='absmiddle'>",
    'relatedurl' => "<img src='../images/icon/urllink.gif' alt='" . _AM_WFS_ICO_URL . "' align='middle'>",
    'addfaq' => "<img src='../images/icon/add.gif' alt='" . _AM_WFS_ICO_ADD . "' align='middle'>",
    'approve' => "<img src='../images/icon/approve.gif' alt='" . _AM_WFS_ICO_APPROVE . "' align='middle'>",
    'statsimg' => "<img src='../images/icon/stats.gif' alt='" . _AM_WFS_ICO_STATS . "' align='middle'>",
	'ignore' => "<img src='../images/icon/ignore.gif' alt='" . _AM_WFS_ICO_IGNORE . "' align='middle'>",
    'ack_yes' => "<img src='../images/icon/on.gif' alt='" . _AM_WFS_ICO_ACK . "' align='middle'>",
	'ack_no' => "<img src='../images/icon/off.gif' alt='" . _AM_WFS_ICO_REPORT . "' align='middle'>",
    'con_yes' => "<img src='../images/icon/on.gif' alt='" . _AM_WFS_ICO_CONFIRM . "' align='middle'>",
	'con_no' => "<img src='../images/icon/off.gif' alt='" . _AM_WFS_ICO_CONBROKEN . "' align='middle'>",
	'settings' => "<img src='../images/icon/settings.gif' alt='" . _AM_WFS_ICO_CONBROKEN . "' align='middle'>"
	);

?>
