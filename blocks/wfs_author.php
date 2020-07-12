<?php 
// $Id: wfs_author.php,v 1.4 2004/08/13 12:43:58 phppp Exp $
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
// include XOOPS_ROOT_PATH . "/mainfile.php";

include_once XOOPS_ROOT_PATH . "/modules/wfsection/class/common.php";
include_once WFS_ROOT_PATH . '/class/wfsarticle.php';
include_once WFS_ROOT_PATH . '/include/functions.php';

function b_wfs_author_show( $options )
{
    global $xoopsDB, $xoopsUser, $xoopsModuleConfig;

    $myts = &MyTextSanitizer::getInstance();
    $block = array();

    $articleid = ( $_GET['articleid'] && $_GET['articleid'] > 0 ) ? $_GET['articleid'] : 0;
    if ( $articleid == 0 ) 
		return false; 
    /*
	*  Get the Authors user ID
	*/ 
    $article = new WfsArticle( $articleid );
    $member_handler = &xoops_gethandler( 'member' );
    $thisUser = &$member_handler->getUser( intval( $article->uid() ) );
    /*
	* Determines the article rating
	*/ 
	$query = "SELECT rating FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " WHERE uid = " . $article->uid();
    $result = $xoopsDB->query( $query );
    $art_count = $xoopsDB->getRowsNum( $result );
    while ( $row = $xoopsDB->fetchArray( $result ) )
    {
        if ( $row["rating"] > 0 )
        {
            $rating = $rating + $row["rating"];
            $rating_count++;
        } 
    } 
    $avg_rating = ( $rating / ( $rating_count * 10 ) ) * 10;
    $block["rating"] = round( ( $avg_rating + 0.0001 ), 2 );

    $block["uid"] = $article->uid();
	$display_auth = $xoopsModuleConfig['displayname'] != 3 ?  $xoopsModuleConfig['displayname'] : 1;
	$block["author"] = WFS_getLinkedUnameFromId( $article->uid(), $display_auth, 0 );
    if ( is_object( $thisUser ) && $thisUser->getVar( 'bio' ) )
        $block["info"] = $myts->displayTarea( $thisUser->getVar( 'bio', 'N' ), 0, 1, 1, 1 );
    else
        $block["info"] = _MB_WFS_DEFUALTTEXT . " <a href=\"" . XOOPS_URL . "/edituser.php\">" . _MB_WFS_CLICKHERE . "</a>.";
    
	$block["artnum"] = "<a href='" . WFS_ROOT_URL . "/topten.php?auth=" . $article->uid() . "'> $art_count</a>";
    /*
	* Atavar information
	*/ 
	$user = new XoopsUser( $article->uid );
    $atavar = $user->user_avatar();
    if ( $atavar == "blank.gif" || $atavar == "" )
        $block["pic"] = WFS_IMAGES_URL . "/no_photo.gif";
    else
        $block["pic"] = ( $xoopsModuleConfig['use_thumbs'] ) ? wfs_createthumb( $atavar, "uploads", "thumbs", 74, 71, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ): XOOPS_UPLOAD_URL."/$atavar";

    
	$block["pips"] = round( ( $block["rating"] / 2 ) );
    if ( is_object( $thisUser ) )
    {
        $block['pm'] = "<a href=\"javascript:openWithSelfMain('" . XOOPS_URL . "/pmlite.php?send2=1&amp;to_userid=" . $thisUser->getVar( 'uid' ) . "', 'pmlite', 450, 380);\">PM This Author</a>";
        $block['email'] = "<a href='mailto:" . $thisUser->getVar( 'email' ) . "'>E-mail This Author</a>";
    } 

    $sql = "SELECT articleid, title, published, expired, counter, groupid, articleimg, url, summary 
		FROM " . $xoopsDB->prefix( "wfs_article" ) . " 
		WHERE published < " . time() . " 
		AND published > 0 
		AND (expired = 0 OR expired > " . time() . ") 
		AND noshowart = 0 
		AND offline = 0 
		AND uid = " . $article->uid() . " 
		ORDER BY " . $options[0] . " DESC
	";
    
	$result2 = $xoopsDB->query( $sql, 10, 0 );
    while ( $myrow = $xoopsDB->fetchArray( $result2 ) )
    {
        //if ( !wfs_checkAccess( $myrow["groupid"] ) ) continue;
        $wfs = array();
        $title = $myts->htmlSpecialChars( stripslashes( $myrow["title"] ) );
        $title = xoops_substr( $title, 0, ( $options[2] -1 ) );
        $wfs['title'] = $title;
        if ( $myrow['url'] )
            $wfs['title'] = "<a href='" . formatURL( $myrow['url'] ) . "' target='_blank'>" . $title . "</a>";
        else
            $wfs['title'] = "<a href='" . WFS_ROOT_URL . "/article.php?articleid=" . $myrow['articleid'] . "'>" . $title . "</a>";

        $wfs['id'] = $myrow['articleid'];
        if ( $options[0] == "published" )
            $wfs['new'] = formatTimestamp( $myrow['published'], "s" );
        elseif ( $options[0] == "counter" )
            $wfs['new'] = $myrow['counter'];
        $block['new'][] = $wfs;
    } 
    // related
    $result3 = $xoopsDB->query( "SELECT related_topicid FROM " . $xoopsDB->prefix( WFS_RELATED ) . " WHERE related_idtopic = " . $_GET['articleid'] . " AND related_mod = 1 Order by related_weight" );
    while ( list( $related_topicid ) = $xoopsDB->fetchrow( $result3 ) )
    {
        $result4 = $xoopsDB->query( "SELECT articleid, title, published, expired, counter, groupid, articleimg, url, summary FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " WHERE articleid = " . $related_topicid );
        list( $articleid, $title, $published, $expired, $counter, $groupid, $articleimg, $url, $summary ) = $xoopsDB->fetchrow( $result4 );

        if ( !wfs_checkAccess( $groupid ) )
            continue;

        $title = $myts->htmlSpecialChars( stripslashes( $title ) );
        $title = xoops_substr( $title, 0, ( $options[2] -1 ) );

        if ( $url )
            $relatedlinks['title'] = "<a href='" . formatURL( $url ) . "' target='_blank'>" . $title . "</a>";
        else
            $relatedlinks['title'] = "<a href='" . WFS_ROOT_URL . "/article.php?articleid=" . $articleid . "'>" . $title . "</a>";

        if ( $options[0] == "published" )
            $relatedlinks['new'] = formatTimestamp( $published, "s" );
        elseif ( $options[0] == "counter" )
            $relatedlinks['new'] = $counter;
        $block['related'][] = $relatedlinks;
    } 
    // end related articles
    
	$modhandler = &xoops_gethandler( 'module' );
    $im = 0;
    
	for( $i = 3;$i < count( $options );$i++ )
    {
        $moddir = $options[$i];
        $xoopsmod = &$modhandler->getByDirname( $moddir );
        if ( is_object( $xoopsmod ) )
        {
            $block['Arelated'][$im]['mid'] = $xoopsmod->mid();
			$block['Arelated'][$im]['name'] = $xoopsmod->name();
            $im ++;
            unset( $xoopsmod );
        } 
    } 

    $block["lang_author"] = "Author:";
    $block["lang_stats"] = "Authors Stats";
    $block["lang_rating"] = "Average Rating:";
    $block["lang_contact"] = "Contact Author";
    $block["lang_Arelated"] = "Author Related Links";
    $block["lang_viewallarts"] = "View all Articles";
    $block["lang_authlatest"] = "Latest Author Articles";

    $block["lang_viewmod"] = "View:";

    $block["lang_relatedarts"] = "Related Articles";
    $block["lang_artwritten"] = "Articles written:";

    $block["dirname"] = WFSECTION;
    return $block;
} 

?>