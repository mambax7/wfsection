<?php
// $Id: topten.php,v 1.4 2004/08/13 12:38:49 phppp Exp $
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
// URL: http://www.wf-projects.com                                         //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
include "header.php";
include_once WFS_ROOT_PATH . "/include/functions.php";
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";
include_once WFS_ROOT_PATH . "/class/wfsindex.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

$mytree = new wfsTree( $xoopsDB->prefix( WFS_CATEGORY_DB ), "id", "pid" );

$xoopsOption['template_main'] = $wfsTemplates['toptentemp'];
include XOOPS_ROOT_PATH . "/header.php";

$xt = new WfsCategory();
$categorys = $xt->getFirstChild();
$arr = array();
$rankings = array();
$rankingart = array();
$rank = 1;
$e = 0;
$indid = 2;
$user = 0;
$query_string = 'online';
$limit = 10;

if ( isset( $_GET['rate'] ) ) {
    $sort = _WFS_RATING;
    $orderby = 'rating DESC';
    $xoopsTpl->assign( 'lang_listings' , _WFS_RATING2 );
}

if ( isset( $_GET['counter'] ) ) {
    $sort = _WFS_HITS;
    $orderby = 'counter DESC';
    $xoopsTpl->assign( 'lang_listings' , _WFS_HITS2 );
}

if ( isset( $_GET['auth'] ) ) {
    $sort = _WFS_AUTH;
    $orderby = 'uid';
    $query_string = 'all';
    $user = intval( $auth );
    $xoopsTpl->assign( 'lang_listings' , _WFS_AUTH2 );
    $limit = 20;
}

$index = new WfsIndex( 2 );
$catarray['imageheader'] = $index->imageheader();
$catarray['indexheading'] = $index->indexheading( "S" );
$catarray['indexheader'] = $index->indexheader( "S" );
$catarray['indexfooter'] = $index->indexfooter( "S" );
$catarray['indexheaderalign'] = $index->indexheaderalign();
$catarray['indexfooteralign'] = $index->indexfooteralign();
$xoopsTpl->assign( 'catarray', $catarray );

foreach( $categorys as $onecat ) {
    $articlecount = WfsArticle::countByCategory( $onecat->id );
    if ( !wfs_checkAccess( $onecat->groupid() ) || !$articlecount ) {
        continue;
    }
    $sarray = WfsArticle::getAllArticle( $limit, 0, $query_string, $onecat->id, $user, $orderby );

    $rankings[$e]['title'] = $onecat->title( "S" );
    $rank = 1;
    foreach ( $sarray as $article ) {
        if ( !wfs_checkAccess( $article->groupid ) ) {
            continue;
        }
        $rankings[$e]['file'][] = array( 'id' => $article->articleid, 'cid' => $article->categoryid, 'rank' => $rank, 'title' => $article->textlink(), 'category' => $onecat->textLink( '', 0 ), 'hits' => $article->counter, 'rating' => number_format( $article->rating, 2 ), 'votes' => $article->votes );
        $xoopsTpl->assign( 'rankings', $rankings );
        $rank++;
    }
    $e++;
}
$xoopsTpl->assign( 'lang_sortby' , $sort );
$xoopsTpl->assign( 'lang_rank' , _WFS_RANK );
$xoopsTpl->assign( 'lang_title' , _WFS_TITLE );
$xoopsTpl->assign( 'lang_category' , _WFS_CATEGORY );
$xoopsTpl->assign( 'lang_hits' , _WFS_HITS );
$xoopsTpl->assign( 'lang_rating' , _WFS_RATING );
$xoopsTpl->assign( 'lang_vote' , _WFS_VOTE );
include XOOPS_ROOT_PATH . '/footer.php';
include "footer.php";

?>