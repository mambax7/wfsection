<?php 
// $Id: search.inc.php,v 1.4 2004/08/13 12:48:54 phppp Exp $
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
global $xoopsModule;

function wfsection_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $articles_arr = array(); 
    // search in attached files
    if (!empty($queryarray))
    {
        $sql = "SELECT articleid,fileshowname FROM " . $xoopsDB->prefix("wfs_files");
        if (is_array($queryarray) && $count = count($queryarray))
        {
            $sql .= " WHERE filetext LIKE '%$queryarray[0]%' OR filedescript LIKE '%$queryarray[0]%'";
            for($i = 1;$i < $count;$i++)
            {
                $sql .= " $andor ";
                $sql .= "filetext LIKE '%$queryarray[$i]%' OR filedescript LIKE '%$queryarray[0]%'";
            }
        }
        $result = $xoopsDB->query($sql);

        $filename_arr = array();
        while($row = $xoopsDB->fetchArray($result))
        {
            $filename_arr[$row['articleid']][] = $row['fileshowname'];
            if (!in_array($row['articleid'], $articles_arr)) $articles_arr[] = $row['articleid'];
        }
    } 
    // search in articles
    $sql = "SELECT articleid,uid,title,published, summary FROM " . $xoopsDB->prefix("wfs_article") . " WHERE published>0 AND published<=" . time() . "";
    if ($userid != 0)
    {
        $sql .= " AND uid=" . $userid . " ";
    } 
    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    if (is_array($queryarray) && $count = count($queryarray))
    {
        $sql .= " AND ((maintext LIKE '%$queryarray[0]%' OR title LIKE '%$queryarray[0]%' OR summary LIKE '%$queryarray[0]%')";
        for($i = 1;$i < $count;$i++)
        {
            $sql .= " $andor ";
            $sql .= "(maintext LIKE '%$queryarray[$i]%' OR title LIKE '%$queryarray[$i]%' OR summary LIKE '%$queryarray[$i]%')";
        }
        $sql .= ") ";
    }

   	$sql .= " ORDER BY published DESC"; 
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result))
    {
        if (in_array($myrow['articleid'], $articles_arr))
        {
            $ret[$i]['image'] = "images/icon/default.gif";
            $ret[$i]['title'] = $myrow['title'];
            foreach($filename_arr[$myrow['articleid']] as $value)
            {
                $ret[$i]['title'] .= " [ " . $value . " ]";
            }
        }
        else
        {
            $ret[$i]['image'] = "images/wf.gif";
            $ret[$i]['title'] = $myrow['title'];
        }
        $ret[$i]['link'] = "article.php?articleid=" . $myrow['articleid'] . "";
        $ret[$i]['time'] = $myrow['published'];
        $ret[$i]['uid'] = $myrow['uid'];
        $i++;
    }
    return $ret;
}

?>