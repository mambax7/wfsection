<?php 
// $Id: archive.php,v 1.5 2004/08/13 12:38:49 phppp Exp $
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

global $wfsTemplates;

$xoopsOption['template_main'] = 'wfsection_archive.html';

include XOOPS_ROOT_PATH . '/header.php';
include_once WFS_ROOT_PATH . "/include/functions.php" ;
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";
include_once WFS_ROOT_PATH . "/class/wfsindex.php";
include_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/calendar.php';

$catarray = array();
$index = new WfsIndex( 4 );

$catarray['imageheader'] = $index->imageheader( "S" );
$catarray['indexheading'] = $index->indexheading( "S" );
$catarray['indexheader'] = $index->indexheader( "S" );
$catarray['indexfooter'] = $index->indexfooter( "S" );
$catarray['indexheaderalign'] = $index->indexheaderalign();
$catarray['indexfooteralign'] = $index->indexfooteralign();
$xoopsTpl->assign( 'catarray', $catarray );

$lastyear = 0;
$lastmonth = 0;

$months_arr = array( 1 => _CAL_JANUARY,
    2 => _CAL_FEBRUARY,
    3 => _CAL_MARCH,
    4 => _CAL_APRIL,
    5 => _CAL_MAY,
    6 => _CAL_JUNE,
    7 => _CAL_JULY,
    8 => _CAL_AUGUST,
    9 => _CAL_SEPTEMBER,
    10 => _CAL_OCTOBER,
    11 => _CAL_NOVEMBER,
    12 => _CAL_DECEMBER );

$fromyear = ( isset( $_GET['year'] ) ) ? intval ( $_GET['year'] ): 0;
$frommonth = ( isset( $_GET['month'] ) ) ? intval( $_GET['month'] ) : 0;

$useroffset = "";
if ( is_object( $xoopsUser ) )
{
    $timezone = $xoopsUser->timezone();
    if ( isset( $timezone ) )
    {
        $useroffset = $xoopsUser->timezone();
    } 
    else
    {
        $useroffset = $xoopsConfig['default_TZ'];
    } 
} 
$result = $xoopsDB->query( "SELECT published FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " WHERE published>0 AND published<=" . time() . " AND expired > 0 ORDER BY published DESC" );
if ( !$result )
{
    exit();
} 
else
{
    $years = array();
    $months = array();
    $i = 0;

    while ( list( $time ) = $xoopsDB->fetchRow( $result ) )
    {
        $time = formatTimestamp( $time, "mysql", $useroffset );
        if ( preg_match( "/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/", $time, $datetime ) )
        {
            $this_year = intval( $datetime[1] );
            $this_month = intval( $datetime[2] );
            if ( empty( $lastyear ) )
            {
                $lastyear = $this_year;
            } 
            if ( $lastmonth == 0 )
            {
                $lastmonth = $this_month;
                $months[$lastmonth]['string'] = $months_arr[$lastmonth];
                $months[$lastmonth]['number'] = $lastmonth;
            } 
            if ( $lastyear != $this_year )
            {
                $years[$i]['number'] = $lastyear;
                $years[$i]['months'] = $months;
                $months = array();
                $lastmonth = 0;
                $lastyear = $this_year;
                $i++;
            } 
            if ( $lastmonth != $this_month )
            {
                $lastmonth = $this_month;
                $months[$lastmonth]['string'] = $months_arr[$lastmonth];
                $months[$lastmonth]['number'] = $lastmonth;
            } 
        } 
    } 
    $years[$i]['number'] = isset( $this_year );
    $years[$i]['months'] = $months;
    $xoopsTpl->assign( 'years', $years );
} 

if ( $fromyear != 0 && $frommonth != 0 )
{
    $xoopsTpl->assign( 'show_articles', true );
    $xoopsTpl->assign( 'lang_articles', _WFS_ARTICLES );
    $xoopsTpl->assign( 'currentmonth', $months_arr[$frommonth] );
    $xoopsTpl->assign( 'currentyear', $fromyear );
    $xoopsTpl->assign( 'lang_actions', _WFS_ACTIONS );
    $xoopsTpl->assign( 'lang_date', _WFS_DATE );
    $xoopsTpl->assign( 'lang_views', _WFS_VIEWS ); 
    // must adjust the selected time to server timestamp
    $timeoffset = $useroffset - $xoopsConfig['server_TZ'];
    $monthstart = mktime( 0 - $timeoffset, 0, 0, $frommonth, 1, $fromyear );
    $monthend = mktime( 23 - $timeoffset, 59, 59, $frommonth + 1, 0, $fromyear );
    $monthend = ( $monthend > time() ) ? time() : $monthend;
    $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " WHERE published > $monthstart and published < $monthend AND expired > 0 ORDER by published DESC";
    $result = $xoopsDB->query( $sql );
    $count = 0;
    while ( $myrow = $xoopsDB->fetchArray( $result ) )
    {
        $article = new WfsArticle( $myrow );
        $story = array();
        $story['title'] = $article->category->textLink() . ": " . $article->textLink( "S" );
        $story['counter'] = $article->counter();
        $story['date'] = formatTimestamp( $article->published(), "m", $useroffset );
        $story['print_link'] = 'print.php?articleid=' . $article->articleid();
        $story['mail_link'] = 'mailto:?subject=' . sprintf( _WFS_INTARTICLE, $xoopsConfig['sitename'] ) . '&amp;body=' . sprintf( _WFS_INTARTFOUND, $xoopsConfig['sitename'] ) . ':  ' . XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/article.php?articleid=' . $article->articleid();
        $xoopsTpl->append( 'stories', $story );
        $count++;
    } 
    $xoopsTpl->assign( 'lang_printer', _WFS_PRINTERFRIENDLY );
    $xoopsTpl->assign( 'lang_sendstory', _WFS_SENDSTORY );
    $xoopsTpl->assign( 'lang_storytotal', sprintf( _WFS_THEREAREINTOTAL, $count ) );
} 
else
{
    $xoopsTpl->assign( 'show_articles', false );
} 
$xoopsTpl->assign( 'lang_newsarchives', _WFS_NEWSARCHIVES );
include XOOPS_ROOT_PATH . "/footer.php";

?>