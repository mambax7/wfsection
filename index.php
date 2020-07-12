<?php
// $Id: index.php,v 1.5 2004/08/18 02:40:33 phppp Exp $
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
include_once WFS_ROOT_PATH . "/include/functions.php" ;
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";
include_once WFS_ROOT_PATH . "/class/wfsindex.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

global $xoopsModuleConfig, $wfsTemplates, $wfsPathConfig;

$catid = (isset($_GET['category']) && ereg("^[0-9]{1,}$", $_GET['category'])) ? $_GET['category'] : 0;
$op = isset($_GET['category']) ? "category" : "default";
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

switch ($op)
{
    /**
     * Start of main category index listings
     */
    case "default":
    default:

        include_once(XOOPS_ROOT_PATH . "/header.php");
        $xoopsOption['template_main'] = $wfsTemplates['catindex'];

        $catarray = array();
        $index = new WfsIndex(1);

        $catarray['imageheader'] = $index->imageheader("S");
        $catarray['indexheading'] = $index->indexheading("S");
        $catarray['indexheader'] = $index->indexheader("S");
        $catarray['indexfooter'] = $index->indexfooter("S");
        $catarray['indexheaderalign'] = $index->indexheaderalign();
        $catarray['indexfooteralign'] = $index->indexfooteralign(); 

        $sarray = WfsArticle::getAllArticle(5, 0, 'online|spotlightmain', 0, 0, "published DESC");
        $count = 0;
        foreach ($sarray as $articles)
        {
            if ($articles->spotlightmain == 2 && $count == 0)
            {
                $feature["summary"] = $articles->summary("S");
                $feature["artlink"] = $articles->textLink("S");
                $feature["date"] = $articles->published("S");
                $feature["cat"] = $articles->category->textLink('', 0, 'viewarticles.php');
                $feature["image"] = $articles->articleimg("S", 2);
                $feature["author"] = $articles->uname("S");
                $feature["more"] = $articles->morelink("S");
                $xoopsTpl->assign('featured', $feature);
                $count = 1;
            }
            else
            {
                $features["summary"] = $articles->summary("S");
                $features["artlink"] = $articles->textLink("S");
                $features["date"] = $articles->published("S");
                $features["cat"] = $articles->category->textLink('', 0, 'viewarticles.php');
                $features["image"] = $articles->articleimg("S", 4);
                $features["author"] = $articles->uname("S");
                $features["more"] = $articles->morelink("S");
                $xoopsTpl->append('features', $features);
            }
        }
        /**
         * display categories/sections
         */

        $xt = new WfsCategory();
        $categorys = $xt->getFirstChild();
        $i = 0;
        foreach($categorys as $onecat)
        {
            if ($onecat->status() != 1)
				continue;
			
			$recurse = 0; //$recurse = ($xoopsModuleConfig['submenus']) ? 0 : 1;
            $num = WfsArticle::countByCategory($onecat->id, 0, $recurse) ;

            $category['num'] = $num;
            $category['catid'] = $onecat->id();
            $category['title'] = $onecat->textLink('', 1, 'viewarticles.php');
            $category['sectionimage'] = $onecat->imgLink();
            $category['imgalign'] = $onecat->imgalign("S");
		
			if ($xoopsModuleConfig['showartlistings'] == 1 || $xoopsModuleConfig['showartlistings'] == 3)
            {
                $category['description'] = $onecat->description('S');
            }
            if ($num > 0)
            {
				if ($xoopsModuleConfig['showartlistings'] == 2 || $xoopsModuleConfig['showartlistings'] == 3)
                {
                    $artarray = WfsArticle::getAllArticle($xoopsModuleConfig['showartlistamount'], 0, 'online', $onecat->id());
                    foreach ($artarray as $articles)
                    {
            			$status = ($articles->changed() > 0) ? 1 : 0;
			            $category['icons'] = wfs_displayicons($articles->created(), $status, $articles->counter());
                        $category['content'][] = array('articlelink' => "<li>" . $articles->textLink(). " ". $category['icons']);
                    }
                }
                $updated = WfsArticle::getLastChangedByCategory($onecat->id());
				$category['updated'] = ($updated) ? formatTimestamp($updated , $xoopsModuleConfig['timestamp']) : "";
            }
            $xoopsTpl->append('categories', $category);
            unset($category);

            /**
             * sub sections
             */
            if ($xoopsModuleConfig['submenus'] == 1)
            {
                $deps = 1;
                $childcat = $onecat->getFirstChild();
           		
                if ($childcat)
                {
                    foreach($childcat as $subonecat)
                    {
						if ($subonecat->status() == 0)
							continue;
                       
						$deps ++;
                        $num = WfsArticle::countByCategory($subonecat->id());
                        $category['num'] = $num;
                        $category['catid'] = $subonecat->id();
                        $category['title'] = str_repeat("&nbsp;", $deps) . " : " . $subonecat->textLink('', 1, 'viewarticles.php') . ""; 
                        $category['sectionimage'] = $subonecat->imgLink();
                        $category['imgalign'] = $subonecat->imgalign("S");

                        if ($xoopsModuleConfig['showartlistings'] == 1 || $xoopsModuleConfig['showartlistings'] == 3)
                        {
                            $category['description'] = $subonecat->description('S');
                        }
                        if ($num > 0)
                        {
                            if ($xoopsModuleConfig['showartlistings'] == 2 || $xoopsModuleConfig['showartlistings'] == 3)
                            {
                                $artarray = WfsArticle::getAllArticle($xoopsModuleConfig['showartlistamount'], 0, 'online', $subonecat->id());
                                foreach ($artarray as $articles)
                                {
                                    $category['content'][] = array('articlelink' => "<li>" . $articles->textLink());
                                }
                            }
                            $updated = WfsArticle::getLastChangedByCategory($subonecat->id());
                            $category['aupdated'] = ($updated) ? formatTimestamp($updated , $xoopsModuleConfig['timestamp']) : "";
                        }
                        $xoopsTpl->append('categories', $category);
                        unset($category);
                    }
                }
            }
        }
        $xoopsTpl->assign('lang_sponser', _WFS_SPONSER);
		$xoopsTpl->assign('lang_author', _WFS_AUTHER);
        $xoopsTpl->assign('lang_updated', _WFS_LASTUPDATE);
        $xoopsTpl->assign('lang_articles', _WFS_ARTICLES);
        $xoopsTpl->assign('lang_category', _WFS_CATEGORY);
        $xoopsTpl->assign('lang_readmore', _WFS_READMORE);
        $xoopsTpl->assign('lang_listarticles', _WFS_LISTARTICLES);
        $xoopsTpl->assign('lang_listfeatured', _WFS_FEATUREDARTS);
        $xoopsTpl->assign('lang_listsections', _WFS_SECTIONLISTIN);
        $xoopsTpl->assign('catarray', $catarray);
        break;
}
$xoopsTpl->assign("xoops_module_header", '<link rel="stylesheet" type="text/css" href="wfsection.css" />');
include_once 'footer.php';

?>
