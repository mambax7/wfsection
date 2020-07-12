<?php
// $Id: download.php,v 1.4 2004/08/13 12:38:49 phppp Exp $
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

include 'header.php';
include_once "class/common.php";

if ( empty($_GET['fileid']) ) {
	redirect_header("index.php");
}

include WFS_ROOT_PATH.'/class/wfsfiles.php';

//Global $xoopsModuleConfig;

$file = new WfsFiles($_GET['fileid']);
$filename = $file->getFileRealName();

if (!is_readable(WFS_FILE_PATH."/".$filename)) {
        redirect_header(WFS_ROOT_URL."/index.php?articleid=".$file->getArticleid(),1,_WFS_NOFILE);
        exit();
}

$size=filesize(WFS_FILE_PATH."/".$filename);
$dlfilename = $file->getDownloadname();
if (empty($dlfilename)) $dlfilename=$fileid.".".$file->getExt();

if (strstr($HTTP_SERVER_VARS["HTTP_USER_AGENT"], "MSIE")) {      // For IE
        if (file_exists(WFS_ROOT_PATH."/language/".$xoopsConfig['language']."/convert.php")) {
                $langdir = WFS_ROOT_PATH."/language/".$xoopsConfig['language'];
        } else {
                $langdir = WFS_ROOT_PATH."/language/english";
        }
        include_once($langdir."/convert.php");
        $dlfilename = WfsConvert::filenameForWin($dlfilename);
		header("Pragma: public");
        header("Content-Type: ".$file->getMimetype());
        header("Content-Length: $size");
        header("Cache-control: private");
        header("Content-Disposition: attachment; filename=$dlfilename");
}
else {  // For Other browsers
 		header("Content-Type: ".$file->getMimetype());
        header("Content-Length: $size");
        if (preg_match("/[^a-zA-Z0-9_\-\.]/",$dlfilename)) $dlfilename=$fileid.".".$file->getExt();
        header("Content-Disposition: attachment; filename=\"$dlfilename\"");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
}

readfile(WFS_FILE_PATH."/".$filename);
$file->updateCounter();

?>