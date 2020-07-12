<?php
// $Id: ratefile.php,v 1.4 2004/08/13 12:38:49 phppp Exp $
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

include("header.php");
include_once WFS_ROOT_PATH . "/include/functions.php";

$submit = (isset($_POST['submit'])) ? $_POST['submit'] : 0;

if ($submit)
{
	$ratinguser = (is_object($xoopsUser)) ? $xoopsUser->uid() : 0; 

	// Make sure only 1 anonymous from an IP in a single day.
    $anonwaitdays = 1;
    $ip = getenv("REMOTE_ADDR");
    $articleid = $_POST['lid'];
    $rating = $_POST['rating'];

    if (!$rating || empty($rating))
    {
        redirect_header("article.php?articleid=" . $articleid . "", 1, _WFS_NORATING);
        exit();
    } 

    // Check if Download POSTER is voting (UNLESS Anonymous users allowed to post)
    if ($ratinguser != 0)
    {
        $result = $xoopsDB->query("SELECT uid FROM " . $xoopsDB->prefix(WFS_ARTICLE_DB) . " WHERE articleid=$articleid");
        while(list($ratinguserDB) = $xoopsDB->fetchRow($result))
        {
            if ($ratinguserDB == $ratinguser)
            {
                redirect_header("index.php", 1 , _WFS_CANTVOTEOWN);
                exit();
            }
        } 
        // Check if REG user is trying to vote twice.
        $result = $xoopsDB->query("SELECT ratinguser FROM " . $xoopsDB->prefix(WFS_VOTES) . " WHERE lid=$articleid");
        while(list($ratinguserDB) = $xoopsDB->fetchRow($result))
        {
            if ($ratinguserDB == $ratinguser)
            {
                redirect_header("index.php", 1 , _WFS_VOTEONCE);
                exit();
            }
        }
    } 
    // Check if ANONYMOUS user is trying to vote more than once per day.
    if ($ratinguser == 0)
    {
        $yesterday = (time() - (86400 * $anonwaitdays));
        $result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix(WFS_VOTES) . " WHERE lid=$articleid AND ratinguser=0 AND ratinghostname = '$ip'  AND ratingtimestamp > $yesterday");

        list($anonvotecount) = $xoopsDB->fetchRow($result);

        if ($anonvotecount >= 1)
        {
            redirect_header("index.php", 1 , _WFS_VOTEONCE);
            exit();
        }
    } 
    // All is well.  Add to Line Item Rate to DB.
    $newid = $xoopsDB->genId($xoopsDB->prefix(WFS_VOTES) . "_ratingid_seq");
    $datetime = time();
    $xoopsDB->query("INSERT INTO " . $xoopsDB->prefix(WFS_VOTES) . " (ratingid, lid, ratinguser, rating, ratinghostname, ratingtimestamp) VALUES ($newid, $articleid, $ratinguser, $rating, '$ip', $datetime)"); 
    // All is well.  Calculate Score & Add to Summary (for quick retrieval & sorting) to DB.
    wfs_updaterating($articleid);
    $ratemessage = _WFS_VOTEAPPRE . "<br>" . sprintf(_WFS_THANKYOU, $xoopsConfig['sitename']);
    redirect_header("index.php", 1 , $ratemessage);
    exit();
}
else
{
}
include 'footer.php';

?>