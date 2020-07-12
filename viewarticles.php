<?php
// $Id: viewarticles.php,v 1.4 2004/08/13 12:38:49 phppp Exp $
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
include_once WFS_ROOT_PATH . "/include/functions.php" ;
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";

$catid = (isset($_GET['category']) && ereg("^[0-9]{1,}$", $_GET['category'])) ? $_GET['category'] : 1;
$op = isset($_GET['category']) ? "category" : "default";
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$orderby = (!empty($_GET['orderby'])) ? wfs_convertorderbyin($_GET['orderby']) : $xoopsModuleConfig['aidxorder'];

switch ($op)
{
    case "category":
    default:
        $xt = new WfsCategory($catid);
        if (!is_object($xt) || $catid == 0) {
            redirect_header('index.php', 1 , _WFS_CATNOTEXIST);
            exit();
        }
        
		if (!empty($xt->template)) {
		  $xoopsOption['template_main'] = $xt->template;  
		} else {
			$xoopsOption['template_main'] = $wfsTemplates['artindex'];
		}
        if (!wfs_checkAccess($xt->groupid)) {
            redirect_header('index.php', 2 , _WFS_CATNOPERM);
            exit();
        }

        include_once(XOOPS_ROOT_PATH . "/header.php");

        $artarray['sectionimage'] = '';
        if ($xt->imgurl("S") && $xoopsModuleConfig['showcatpic'] && $xt->displayimg)
        {
            $artarray['sectionimage'] = $xt->imgLink();
        }
        $artarray['headingtitle'] = $xt->title('S');
        $artarray['catdescription'] = $xt->catdescription('S');
        $artarray['footer'] = $xt->catfooter('S');

        $artarray['pulldown'] = jumpbox("viewarticles.php", $xt->id);
        $xoopsTpl->assign('lang_selectsection', _WFS_SELECTSUBSECTION);
        $sarray = WfsArticle::getAllArticle($xoopsModuleConfig['articlesapage'], $start, 'online|spotlight', $xt->id, 0, $orderby);
        foreach ($sarray as $article)
        {
                $feature['title'] = $article->textLink("S");
                $feature["summary"] = $article->summary("S");
                $feature["image"] = $article->articleimg("S", 2);
                $feature["more"] = $article->morelink("S");
				$xoopsTpl->append('feature', $feature);
        }

        //$sarray = WfsArticle::getAllArticle($xoopsModuleConfig['articlesapage'], $start, $xt->id, 13, 0, $orderby);
        //$sarray = WfsArticle::getAllArticle($xoopsModuleConfig['articlesapage'], $start, 'online|nospotlight', $xt->id, 0, $orderby);
        $sarray = WfsArticle::getAllArticle($xoopsModuleConfig['articlesapage'], $start, 'online', $xt->id, 0, $orderby);
		$articlecount = WfsArticle::countByCategory($xt->id, 0, 0);
		foreach ($sarray as $article)
        {
            $articles['title'] = $article->textLink("S");
            $articles['summary'] = $article->summary("S");
            $articles['username'] = WFS_getLinkedUnameFromId($article -> uid(), $xoopsModuleConfig['displayname'], 0);
            $status = ($article->changed() > 0) ? 1 : 0;
            $articles['icons'] = wfs_displayicons($article->created(), $status, $article->counter());
			
			$articles['commentcount'] = (in_array(1, $xoopsModuleConfig['displayinfolist'])) ? $article->getCommentsCount() : "";
			$articles['filescount'] = (in_array(2, $xoopsModuleConfig['displayinfolist'])) ? strval($article->getFilesCount()) : "";
			$articles['counter'] = (in_array(6, $xoopsModuleConfig['displayinfolist'])) ? $article->counter() : "";
			$articles['published'] = (in_array(5, $xoopsModuleConfig['displayinfolist'])) ? formatTimestamp($article->published(), $xoopsModuleConfig['timestamp']) : "";
			if ($xoopsModuleConfig['novote']) {
            	$articles['rating'] = (in_array(3, $xoopsModuleConfig['displayinfolist'])) ? number_format($article->rating(), 2) : "";
            	$articles['votes'] = (in_array(4, $xoopsModuleConfig['displayinfolist'])) ? $article->votes() : "";
				$xoopsTpl->assign('wfs_novote', true);
			}
            $articles['readmore'] = $article->morelink("S");            
			$articles["image"] = $article->articleimg("S", $size = 2, 0);    
			$articles["adminlink"] = $article->adminlink();
            $xoopsTpl->append('articles', $articles);
        }

        $xoopsTpl->assign('lang_readmore', _WFS_READMORE);
        $xoopsTpl->assign(
			array(
				'lang_author' => _WFS_AUTHER,
                'lang_published' => _WFS_PUBLISHEDHOME,
                'lang_hits' => _WFS_VIEWS,
                'lang_files' => _WFS_FILES,
                'lang_rated' => _WFS_RATED,
                'lang_votes' => _WFS_VOTES,
                'lang_comments' => _WFS_COMMENT,
                'lang_otherarticles' => _WFS_OTHERARTICLES,
                'lang_published' => _WFS_PUBLISHEDHOME,
                'lang_downloadsfor' => _WFS_DOWNLOADS,
                'lang_pages' => _WFS_PAGES
			)
        );

        if ($articlecount > 0)
        {
            $sfigure = $start + 1;
            $efigure = $start + $xoopsModuleConfig['articlesapage'];
            if ($efigure >= $articlecount) $efigure = $articlecount;
        }
        else
        {
            $sfigure = 0;
            $articlecount = 0;
            $efigure = 0;
        }
        $artarray['showartamount'] = sprintf(_WFS_SHOWARTAMOUNT, $sfigure,$efigure,$articlecount);

        if (($articlecount > 0) && $xoopsModuleConfig['orderbox'])
        {
            $artarray['sortmenu'] = "<small><center>" . _WFS_SORTBY1 . "&nbsp;";
            $artarray['sortmenu'] .= "  " . _WFS_TITLE1 . "&nbsp; <a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=titleA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=titleD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>";
            $artarray['sortmenu'] .= "  " . _WFS_DATE1 . "&nbsp; <a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=createdA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=createdD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>";
            if (in_array(4, $xoopsModuleConfig['displayinfolist']))
                $artarray['sortmenu'] .= "	" . _WFS_RATING1 . "&nbsp; <a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=ratingA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href=viewarticles.php?category=$catid&start=" . $start . "&orderby=ratingD><img src='images/down.gif' border='0' align='middle' alt='' /></a>";

            $artarray['sortmenu'] .= "	" . _WFS_POPULARITY1 . "&nbsp; <a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=counterA'><img src='images/up.gif' border='0' align='middle' alt='' /></a><a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=counterD'><img src='images/down.gif' border='0' align='middle' alt='' /></a>";
            $artarray['sortmenu'] .= " &nbsp; <a href='viewarticles.php?category=$catid&start=" . $start . "&orderby=weight'>". _WFS_WEIGHT . "</a>";
            $artarray['sortmenu'] .= "<br /><small>";
            $orderbyTrans = wfs_convertorderbytrans($orderby);
            $artarray['sortmenu'] .= "" . _WFS_CURSORTBY1 . " $orderbyTrans ";
            $artarray['sortmenu'] .= "</center></small><br />";
        }
        $artarray['menu'] = "[ <a href='javascript:history.back(1)'>" . _WFS_BACK2 . "</a> | <a href='./index.php'>" . _WFS_RETURN2INDEX . "</a> ]";

        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new XoopsPageNav($articlecount, $xoopsModuleConfig['articlesapage'] , $start, "start", "category=$catid");
        $artarray['pagenav'] = '' . $pagenav->renderNav() . '';
        $xoopsTpl->assign('artarray', $artarray);
        break;
}
include_once 'footer.php';

?>
