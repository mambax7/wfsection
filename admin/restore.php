<?php
// $Id: restore.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include_once( 'admin_header.php' );

accessadmin( "restore" );
$op = '';

if ( isset( $_POST['op'] ) )
    $op = $_POST['op'];
else if ( isset( $_GET['op'] ) && !isset( $_POST['op'] ) )
    $op = $_GET['op'];
else
    $op = '';

if ( !$xoopsModuleConfig['use_restore'] ) {
    redirect_header( "allarticles.php", 1, _AM_WFS_ARTRESTORENOTACT );
    exit();
}

switch ( $op ) {
    case 'delete_restore':
        if ( isset( $_POST['ok'] ) ) {
            if ( WfsArticleRes::delete( $_POST['restoreid'] ) )
                redirect_header( "restore.php", 2, _AM_WFS_RESTOREDELETED );
            else
                redirect_header( "restore.php", 2, _AM_WFS_ERROR_RESTOREDELETED );
            exit();
        } else {
            xoops_cp_header();
            $restoreid = $_GET['restoreid'];
            xoops_confirm( array( 'op' => 'delete_restore', 'restoreid' => $restoreid, 'ok' => 1 ), 'restore.php', _AM_WFS_DELETERESTORE );
        }
        break;

    case 'restore':

        $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_RESTORE_DB ) . " WHERE restore_id = " . $_GET['restoreid'] . " ";
        $restore_arr = $xoopsDB->fetchArray( $xoopsDB->query( $sql ) );

        if ( $restore_arr['articleid'] )
            $article = new WfsArticle( $restore_arr['articleid'] );
        else
            $article = new WfsArticle();

        $article->categoryid = $restore_arr['categoryid'];
        $article->groupid = $restore_arr['groupid'];
        $article->title = $restore_arr['title'];
        $article->subtitle = $restore_arr['subtitle'];
        $article->maintext = $restore_arr['maintext'];
        $article->summary = $restore_arr['summary'];
        $article->url = $restore_arr['url'];
        $article->urlname = $restore_arr['urlname'];
        $article->wrapurl = $restore_arr['wrapurl'];
        $article->page = $restore_arr['page'];
        $article->usertype = $restore_arr['usertype'];
        $article->offline = $restore_arr['offline'];
        $article->htmlpage = $restore_arr['htmlpage'];
        $article->isframe = $restore_arr['isframe'];
        $article->expired = $restore_arr['expired'];
        $article->notifypub = $restore_arr['notifypub'];
        $article->weight = $restore_arr['weight'];
        $article->noshowart = $restore_arr['noshowart'];
        $article->weight = $restore_arr['weight'];
        $article->cmainmenu = $restore_arr['cmainmenu'];
        $article->isforumid = $restore_arr['isforumid'];
        $article->subtitle = $restore_arr['subtitle'];
        $article->articleimg = $restore_arr['articleimg'];
        $article->uid = $restore_arr['uid'];
        $article->spotlight = $restore_arr['spotlight'];
        $article->spotlightmain = $restore_arr['spotlightmain'];
        $article->subtitle = $restore_arr['subtitle'];
        $article->version = $restore_arr['version'];
        $article->published = $restore_arr['published'];
        $article->changed = $restore_arr['changed'];
        $article->created = $restore_arr['created'];
        $article->expired = $restore_arr['expired'];
        $article->nohtml = $restore_arr['nohtml'];
        $article->nosmiley = $restore_arr['nosmiley'];
        $article->noxcodes = $restore_arr['noxcodes'];
        $article->nobreaks = $restore_arr['nobreaks'];
        $article->notifypub = $restore_arr['notifypub'];
        $article->allowcom = $restore_arr['allowcom'];
        $article->page = $restore_arr['page'];
        $article->counter = $restore_arr['counter'];
        $article->wrapurl = $restore_arr['wrapurl'];

        if ( get_magic_quotes_gpc() ) { // if get_magic_quotes_gpc enabled, module.textsanitizer::addSlashes will skip
            $article->title = addSlashes( $article->title );
            $article->maintext = addSlashes( $article->maintext );
            $article->summary = addSlashes( $article->summary );
            $article->url = addSlashes( $article->url );
            $article->urlname = addSlashes( $article->urlname );
            $article->wrapurl = addSlashes( $article->wrapurl );
            $article->usertype = addSlashes( $article->usertype );
            $article->htmlpage = addSlashes( $article->htmlpage );
            $article->subtitle = addSlashes( $article->subtitle );
            $article->articleimg = addSlashes( $article->articleimg );
        }
        $article->store( $isRestore = true );
        redirect_header( "restore.php", 3, _AM_WFS_DBUPDATED );
        exit();
        break;

    case 'default':
    default:
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_ARTICLERESTOREHEADING );
        wfs_textinfo( _AM_WFS_ARTICLERESTOREINFO, _AM_WFS_ARTICLERESTORETEXT );

        $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;

        $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_RESTORE_DB ) . "";
        if ( isset( $_GET['articleid'] ) ) {
            $sql .= " WHERE articleid = " . $_GET['articleid'] . " ";
            $theArticle = new WfsArticle( $_GET['articleid'] );
            $theArticle_version = $theArticle->version();
        }
        $sql .= " ORDER BY restore_date DESC" ;

        $result = $xoopsDB->query( $sql, $xoopsModuleConfig['lastart'], $start );
        $result2 = $xoopsDB->query( $sql );
        $list = $xoopsDB->getRowsNum( $result2 );

        echo "<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class = \"outer\">\n";
        echo "<th align = \"center\" width=\"5%\">" . _AM_WFS_RESTORE_ID . "</th>";
        echo "<th align = \"center\" width=\"20%\">" . _AM_WFS_RESTORE_DATE . "</th>";
        echo "<th align = \"center\" width=\"5%\">" . _AM_WFS_RESTORE_ARTICLEID . "</th>";
        echo "<th align = \"left\">" . _AM_WFS_RESTORE_TITLE . "</th>";
        echo "<th align = \"left\" width=\"5%\">" . _AM_WFS_RESTORE_VERSION . "</th>";
        echo "<th align = \"center\" width=\"10%\">" . _AM_WFS_RESTORE_CREATED . "</th>";
        echo "<th align = \"center\" width=\"5%\">" . _AM_WFS_RESTORE_ACTION . "</th>";

        if ( $list ) {
            while ( $restore_arr = $xoopsDB->fetchArray( $result ) ) {
                if ( !isset( $theArticle_version ) ) {
                    $theArticle = new WfsArticle( $restore_arr['articleid'] );
                    $theArticle_version = $theArticle->version();
                    unset( $theArticle );
                }
                /**
                 * Removed this option here. I found that if you change the category id and the version number was the same it
                 * would not give a option for restore and delete points.
                 */
                // if($theArticle_version == $restore_arr["version"]) {
                // $restore_action = $blank;
                // $delete_action = $blank;
                // }else{
                $restore_action = "<a href='restore.php?op=restore&amp;restoreid=" . $restore_arr['restore_id'] . "'>$restore</a>";
                $delete_action = "<a href='restore.php?op=delete_restore&amp;restoreid=" . $restore_arr['restore_id'] . "'>$deleteimg</a>";
                // }
                unset( $theArticle_version );

                echo "<tr>";
                $view_restore = WfsArticleRes::admintextLink( $restore_arr['restore_id'] );
                echo "<td class = \"head\" align = \"center\">" . $view_restore . "</td>";
                echo "<td class = \"even\" align = \"center\">" . formatTimestamp( $restore_arr['restore_date'], "d-M-Y H:s" ) . "</td>";
                echo "<td class = \"head\" align = \"center\"><a href='restore.php?articleid=" . $restore_arr['articleid'] . "'>" . $restore_arr['articleid'] . "</a></td>";
                echo "<td class = \"even\" align = \"left\">" . $restore_arr['title'] . "</td>";
                echo "<td class = \"even\" align = \"center\">v" . $restore_arr['version'] . "</td>";
                echo "<td  class = \"even\" align = \"center\" nowrap>" . formatTimestamp( $restore_arr['created'], "d-M-Y" ) . "</td>\n";
                echo "<td nowrap class = \"even\" align =\"center\">" . $restore_action . $delete_action . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr>\n";
            echo "<td colspan =\"7\" class = \"head\" align = \"center\">" . _AM_WFS_NORESTORE_POINTS . "</td>\n";
            echo "</tr>\n";
        }
        echo "</table><br />";
        $pagenav = new XoopsPageNav( $list, $xoopsModuleConfig['lastart'], $start, 'start', 'action=view_archives', 1 );
        echo "<div style=\"text-align: right;\">" . $pagenav->renderNav() . "</div>";
        xoops_cp_footer();
        break;
}

?>