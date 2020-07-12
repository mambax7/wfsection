<?php
// $Id: brokenfile.php,v 1.4 2004/08/13 12:38:49 phppp Exp $
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
include "header.php";
include_once WFS_ROOT_PATH . "/include/functions.php";
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";
include_once WFS_ROOT_PATH . "/class/wfsindex.php";

if (!empty($_POST['submit']))
{
    global $xoopsModule, $xoopsModuleConfig;

    $sender = (is_object($xoopsUser)) ? $xoopsUser->getVar('uid') : 0;
    $ip = getenv("REMOTE_ADDR");
    $lid = intval($_POST['lid']); 
    // Check if REG user is trying to report twice.
    $result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix(WFS_BROKEN_DB) . " WHERE lid=$lid");
    list ($count) = $xoopsDB->fetchRow($result);
    if ($count > 0)
    {
        redirect_header("index.php", 2, _WFS_ALREADYREPORTED);
        exit();
    }
    else
    {
        $newid = $xoopsDB->genId($xoopsDB->prefix(WFS_BROKEN_DB) . "_reportid_seq");
        $sql = sprintf("INSERT INTO %s (reportid, lid, sender, ip, date) VALUES (%u, %u, %u, '%s', %u)", $xoopsDB->prefix(WFS_BROKEN_DB), $newid, $lid, $sender, $ip, time());
        $xoopsDB->query($sql) or exit(); 
        // $tags = array();
        // $tags['BROKENREPORTS_URL'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/index.php?op=listBrokenDownloads';
        // $notification_handler = &xoops_gethandler('notification');
        // $notification_handler->triggerEvent('global', 0, 'file_broken', $tags);
        /**
         * Send email to the owner of the download stating that it is broken
         */

        $file = new WfsFiles($lid);
        $article = new WfsArticle($file->articleid);

        $user = new XoopsUser($article->uid());
        $subdate = formatTimestamp($file->date, $xoopsModuleConfig['timestamp']);
        $title = $file->getFileShowName();
        $subject = _MD_BROKENREPORTED;

        $xoopsMailer = &getMailer();
        $xoopsMailer->useMail();
        $template_dir = WFS_ROOT_PATH . "/language/" . $xoopsConfig['language'] . "/mail_template";

        $xoopsMailer->setTemplateDir($template_dir);
        $xoopsMailer->setTemplate('filebroken_notify.tpl');
        $xoopsMailer->setToEmails($user->email());
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->assign("X_UNAME", $user->uname());
        $xoopsMailer->assign("SITENAME", $xoopsConfig['sitename']);
        $xoopsMailer->assign("X_ADMINMAIL", $xoopsConfig['adminmail']);
        $xoopsMailer->assign('X_SITEURL', XOOPS_URL . '/');
        $xoopsMailer->assign("X_TITLE", $title);
        $xoopsMailer->assign("X_SUB_DATE", $subdate);
        $xoopsMailer->assign('X_DOWNLOAD', WFS_ROOT_URL . '/download.php?fileid=' . $lid);
        $xoopsMailer->setSubject($subject);
        $xoopsMailer->setBody($message);
        $xoopsMailer->send();
        redirect_header("index.php", 2, _MD_THANKSFORINFO);
        exit();
    }
}
else
{
    $xoopsOption['template_main'] = 'mydownloads_brokenfile.html';
    include XOOPS_ROOT_PATH . '/header.php';
    /**
     * Begin Main page Heading etc
     */
    $index = new WfsIndex(3);
    $catarray['imageheader'] = $index->imageheader();
    $catarray['indexheading'] = $index->indexheading("S");
    $catarray['indexheader'] = $index->indexheader("S");
    $catarray['indexfooter'] = $index->indexfooter("S");
    $catarray['indexheaderalign'] = $index->indexheaderalign();
    $catarray['indexfooteralign'] = $index->indexfooteralign();
    $xoopsTpl->assign('catarray', $catarray);

    $lid = (isset($_GET['lid']) && $_GET['lid'] > 0) ? intval($_GET['lid']) : 0;

    $file = new WfsFiles($lid);
    $totalfiles = WfsFiles::getfilecount();

    $sql = "SELECT * FROM " . $xoopsDB->prefix(WFS_BROKEN_DB) . " WHERE lid = $lid";
    $broke_arr = $xoopsDB->fetchArray($xoopsDB->query($sql));;

    if (is_array($broke_arr))
    {
        global $xoopsModuleConfig;

        $broken['title'] = $file->getFileShowName("S");
        $broken['id'] = trim($broke_arr['reportid']);
        $broken['reporter'] = WFS_getLinkedUnameFromId(intval($broke_arr['sender']), $xoopsModuleConfig['displayname'], 0);
        $broken['date'] = formatTimestamp($broke_arr['date'], $xoopsModuleConfig['timestamp']);
        $broken['acknowledged'] = ($broke_arr['acknowledged'] == 1) ? _YES : _NO ;
        $broken['confirmed'] = ($broke_arr['confirmed'] == 1) ? _YES : _NO ;

        $xoopsTpl->assign('lang_filetitle', _WFS_FILETITLE);
        $xoopsTpl->assign('lang_webmastercon', _WFS_WEBMASTERCONFIRM);
        $xoopsTpl->assign('lang_webmasterack', _WFS_WEBMASTERACKNOW);
        $xoopsTpl->assign('lang_reporter', _WFS_REPORTER);
        $xoopsTpl->assign('lang_sourceid', _WFS_RESOURCEID);
        $xoopsTpl->assign('lang_datereported', _WFS_DATEREPORTED);
        $xoopsTpl->assign('lang_thanksforreporting', _WFS_THANKSFORREPORTING);
        $xoopsTpl->assign('broken', $broken);
        $xoopsTpl->assign('lang_alreadyreported', _WFS_RESOURCEREPORTED);
        $xoopsTpl->assign('brokenreport', true);
    }
    else
    {
        $amount = $xoopsDB->getRowsNum($sql);

        if (!$file->fileid)
        {
            redirect_header('index.php', 0 , _WFS_THISFILEDOESNOTEXIST);
            exit();
        }
        /**
         * file info
         */
        $article = new WfsArticle($file->articleid); 
        // date
        $down['title'] = $file->getFileShowName(); //trim($down_arr['title']);
        $down['homepage'] = $file->getLinkedName(WFS_URL); //$myts->makeClickable(formatURL(trim($down_arr['url']))); 
        $down['updated'] = formatTimestamp($file->date, $xoopsModuleConfig['timestamp']);
        $down['publisher'] = WFS_getLinkedUnameFromId($article->uid(), $xoopsModuleConfig['displayname'], 0);

        $xoopsTpl->assign('lang_subdate' , _WFS_SUBMITDATE);
        $xoopsTpl->assign('down', $down);
        $xoopsTpl->assign('lang_reportbroken', _WFS_BROKENREPORT);
        $xoopsTpl->assign('lang_filesource', _WFS_HOMEPAGEC);
        $xoopsTpl->assign('lang_submitbroken', _WFS_SUBMITBROKEN);
        $xoopsTpl->assign('lang_beforesubmit', _WFS_BEFORESUBMIT);
        $xoopsTpl->assign('lang_publisher' , _WFS_PUBLISHER);
        $xoopsTpl->assign('file_id', $lid);
        $xoopsTpl->assign('lang_thanksforhelp', _WFS_THANKSFORHELP);
        $xoopsTpl->assign('lang_forsecurity', _WFS_FORSECURITY);
        $xoopsTpl->assign('lang_cancel', _WFS_CANCEL);
    }
    include_once XOOPS_ROOT_PATH . '/footer.php';
}

?>
