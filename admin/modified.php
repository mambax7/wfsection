<?php
// $Id: modified.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include 'admin_header.php';
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/include/xoopscodes.php";

accessadmin( "moderator" );

$op = '';
if ( isset( $_POST ) ) {
    foreach ( $_POST as $k => $v ) {
        ${$k} = $v;
    }
}

if ( isset( $_GET ) ) {
    foreach ( $_GET as $k => $v ) {
        ${$k} = $v;
    }
}

if ( isset( $_POST['deleteModReq'] ) ) {
    $op = "deleteModReq";
} elseif ( isset( $_POST['changeModReq'] ) ) {
    $op = 'changeModReq';
} elseif ( isset( $_POST['post'] ) ) {
    $op = 'post';
} elseif ( isset( $_POST['edit'] ) ) {
    $op = 'edit';
} elseif ( isset( $_POST['save'] ) ) {
    $op = 'save';
}
function edit( $requestid ) {
    global $xoopsDB, $myts, $mytree, $xoopsModule, $xoopsConfig;

    $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " WHERE requestid = $requestid";
    $arr = $xoopsDB->fetchArray( $xoopsDB->query( $sql ) );
    $xt = new WfsCategory( $arr['categoryid'] );

    if ( $arr['maintext'] ) {
        $maintext = $arr['maintext'];
        $words_to_count = strip_tags( $maintext );
        $pattern = "/[^(\w|\d|\'|\"|\.|\!|\?|;|,|\\|\/|\-\-|:|\&|@)]+/";
        $words_to_count = preg_replace ( $pattern, " ", $words_to_count );
        $words_to_count = trim( $words_to_count );
        $total_words = count( explode( " ", $words_to_count ) );
    } else {
        $total_words = 0;
    }

    xoops_cp_header();

    wfs_admin_menu( _AM_WFS_MODIFICATION );
    wfs_textinfo( _AM_WFS_MODIFICATION, _AM_WFS_MODIFICATIONTEXT );

    include XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
    $sform = new XoopsThemeForm( _AM_WFS_POSTNEWARTICLE, "storyform", "modified.php" );
    $sform->addElement( new XoopsFormText( _AM_WFS_EDITARTICLETITLE, 'title', 50, 255, $arr['title'] ), true );
    $sform->addElement( new XoopsFormTextArea( _AM_WFS_EDITSUBTITLE, 'subtitle', $arr['subtitle'] ), false );
    ob_start();
    echo $xt->makeSelBox( 0, $arr['categoryid'], 'categoryid' );
    $sform->addElement( new XoopsFormLabel( _AM_WFS_EDITSECTION2, ob_get_contents() ) );
    ob_end_clean();
    $sform->addElement( new XoopsFormSelectUser( _AM_WFS_EDITCAUTH, "changeuser", true, $arr['modifysubmitter'], 1, false ), false );
    $linked_url_tray = new XoopsFormElementTray( _AM_WFS_EDITLINKURL, "<br />" );
    $linked_url = new XoopsFormText( _AM_WFS_EDITLINKURLADD, "url", 50, 255, $arr['url'] );
    $linked_url_tray->addElement( $linked_url );
    $linked_urlname = new XoopsFormText( _AM_WFS_EDITLINKURLNAME, "urlname", 50, 255, $arr['urlname'] );
    $linked_url_tray->addElement( $linked_urlname );
    $sform->addElement( $linked_url_tray );

    $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_EDITMAINTEXT . " " . $total_words, 'maintext', $arr['maintext'], 15, 60 ), true );
    $sform->addElement( new XoopsFormTextArea( _AM_WFS_EDITSUMMARY, 'summary', $arr['summary'] ), false );
    $sform->addElement( new XoopsFormHidden( 'articleid', $arr['articleid'] ) );
    $sform->addElement( new XoopsFormHidden( 'requestid', $arr['requestid'] ) );
    $button_tray = new XoopsFormElementTray( '', '' );
    $button_tray->addElement( new XoopsFormButton( '', 'save', _AM_WFS_POST, 'submit' ) );
    $button_tray->addElement( new XoopsFormButton( '', 'deleteModReq', _AM_WFS_DELETE, 'submit' ) );
    $sform->addElement( $button_tray );
    $sform->display();
}

function listModReq( $requestid ) {
    global $xoopsDB, $xoopsModuleConfig, $myts;

    $result = $xoopsDB->query( "SELECT * FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " WHERE requestid = $requestid" );
    list( $requestid, $newarticleid, $categoryid, $title, $subtitle, $maintext, $summary, $url, $urlname, $requested, $modifysubmitter ) = $xoopsDB->fetchRow( $result );

    $article = new WfsArticle( $newarticleid );
    $xt = new WfsCategory( $categoryid );
    xoops_cp_header();

    wfs_admin_menu( _AM_WFS_MODIFICATION );
    wfs_textinfo( _AM_WFS_MODIFICATION, _AM_WFS_MODIFICATIONTEXT );

    $html = ( $article->nohtml ) ? 0 : 1;
    $smiley = ( $article->nosmiley ) ? 0 : 1;
    $xcodes = ( $article->noxcodes ) ? 0 : 1;
    $breaks = ( $article->nobreaks ) ? 1 : 0;

    echo "<table border=0 cellpadding=2 cellspacing=1 align=center width=100% class = outer>";
    echo "<tr><td valign=top class = bg3 colspan = 2><b>" . _AM_WFS_ORIGINAL . "</b></td></tr>";
    echo "<tr><td valign=top width = 30% class  = head>" . _AM_WFS_TITLE1 . "</td><td class  = even>" . $article->admintextLink() . "</td></tr>";
    echo "<tr><td valign=top width = 30% class  = head>" . _AM_WFS_EDITSUBTITLE . "</td><td class  = even>" . $article->subtitle() . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_SECTION . "</td><td class  = even>" . $article->category->textLink() . "</td></tr>";
    $orgiusername = WFS_getLinkedUnameFromId( $article->uid, $xoopsModuleConfig['displayname'], 1 );
    echo "<tr><td valign=top class  = head>" . _AM_WFS_AUTHOR . "</td><td class  = even>" . $orgiusername . "</td></tr>";
    echo "<tr><td valign=top class  = head >" . _AM_WFS_MAINTEXT . "</td><td class  = even wrap>" . $article->maintext( "S" ) . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_SUMMARY . "</td><td class  = even>" . $article->summary( "S" ) . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_URL . "</td><td class  = even>" . $article->url . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_URLNAME . "</td><td class  = even>" . $article->urlname . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_CREATEDON . "</td><td class  = even>" . formatTimestamp( $article->created(), $xoopsModuleConfig['timestamp'] ) . "</td></tr>";
    echo "</table>";
    echo "<div>&nbsp;</div>";
    echo "<table border=0 cellpadding=2 cellspacing=1 align=center width=100% class = outer>";
    echo "<tr><td valign=top class = bg3 colspan = 2><b>" . _AM_WFS_PROPOSED . "</b></td></tr>";
    echo "<tr><td valign=top width = 30% class  = head>" . _AM_WFS_TITLE1 . "</td><td class  = even>$title</td></tr>";
    $sub_title = $myts->displayTarea( trim( $subtitle ), 1, 1, 1, 1, 1 );
    echo "<tr><td valign=top width = 30% class  = head>" . _AM_WFS_EDITSUBTITLE . "</td><td class  = even>$sub_title</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_SECTION . "</td><td class  = even>" . $xt->textLink() . "</td></tr>";
    $username = WFS_getLinkedUnameFromId( $modifysubmitter, $xoopsModuleConfig['displayname'], 1 );
    echo "<tr><td valign=top class  = head>" . _AM_WFS_AUTHOR . "</td><td class  = even>$username</td></tr>";
    echo "<tr><td valign=top class  = head >" . _AM_WFS_MAINTEXT . "</td><td class  = even wrap>" . $myts->displayTarea( $maintext, $html, $smiley, $xcodes, 0, $breaks ) . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_SUMMARY . "</td><td class  = even>" . $summary . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_URL . "</td><td class  = even>" . $url . "</td></tr>";
    echo "<tr><td valign=top class  = head>" . _AM_WFS_URLNAME . "</td><td class  = even>" . $urlname . "</td></tr>";
    echo "<tr><td valign=top class  = head nowrap>" . _AM_WFS_SUMITDATE . "</td><td class  = even>" . formatTimestamp( $requested, $xoopsModuleConfig['timestamp'] ) . "</td></tr>";
    echo "</table>";

    echo "<table align=center width=100%><tr>";
    echo "<td align=right>";
    echo "<table><tr ><td>";
    echo myTextForm( "modified.php?op=changeModReq&requestid=$requestid" , _AM_WFS_APPROVE );
    echo "</td><td>";
    echo myTextForm( "modified.php?op=edit&requestid=$requestid", _EDIT );
    echo "</td><td>";
    echo myTextForm( "modified.php?op=deleteModReq&requestid=$requestid", _AM_WFS_DELETE );
    echo "</td></tr></table>";
    echo "</td></tr>";
    echo "</table>";
    // xoops_cp_footer();
}

function changeModReq( $requestid ) {
    global $xoopsDB, $_GET, $eh, $myts;

    $result = $xoopsDB->query( "SELECT * FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " WHERE requestid = $requestid" );
    list( $requestid, $newarticleid, $categoryid, $title, $subtitle, $maintext, $summary, $url, $urlname, $requested, $modifysubmitter ) = $xoopsDB->fetchRow( $result );

    $title = $myts->censorString( $title );
    $subttitle = $myts->censorString( $subtitle );
    $maintext = $myts->censorString( $maintext );
    $summary = $myts->censorString( $summary );

    $title = $myts->addslashes( $title );
    $subtitle = $myts->addslashes( $subtitle );
    $maintext = $myts->addslashes( $maintext );
    $summary = $myts->addslashes( $summary );
    $url = $myts->addslashes( $url );
    $urlname = $myts->addslashes( $urlname );
    $userid = $myts->addslashes( $modifysubmitter );
    $categoryid = $myts->addslashes( $categoryid );

    $xoopsDB->query( "UPDATE " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " SET uid='$userid', title='$title', subtitle='$subtitle', maintext='$maintext', categoryid='$categoryid', summary='$summary', url='$url', urlname='$urlname' WHERE articleid = $newarticleid" );
    $xoopsDB->query( "DELETE FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " WHERE requestid = $requestid" );
    redirect_header( "modified.php", 1, _AM_WFS_DBUPDATED );
}

function deleteModReq( $requestid ) {
    global $xoopsDB, $_GET;

    if ( !isset( $_POST['ok'] ) ) {
        xoops_cp_header();
        xoops_confirm( array( 'op' => 'deleteModReq', 'requestid' => $_GET['requestid'], 'ok' => 1 ), 'modified.php', _AM_WFS_RUSUREDEL );
    } else {
        global $xoopsDB;
        $xoopsDB->query( "DELETE FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " WHERE requestid = " . $_GET['requestid'] . "" );
        redirect_header( "modified.php", 1, _AM_WFS_MODREQDELETED );
        exit();
    }
}

switch ( $op ) {
    case "edit":
        edit( $_GET['requestid'] );
        break;
    case "listModReq":
        listModReq( $_GET['requestid'] );
        break;
    case "changeModReq":
        changeModReq( $_GET['requestid'] );
        break;

    case "save":

        global $xoopsDB, $_POST;

        $article = new WfsArticle( $_POST['articleid'] );
        $article->setTitle( trim( $_POST['title'] ) );
        $article->setMainText( trim( $_POST['maintext'] ) );
        $article->setSummary( trim( $_POST['summary'] ), 0, 0 );
        $article->setUrl( $_POST['url'] );
        $article->setUrlname( $_POST['urlname'] );
        $article->setUid( $_POST['changeuser'], $article->uid() );
        $article->setCategoryid( $_POST['categoryid'] );
        $published = $article->published;
        $article->setCategoryid( $_POST['categoryid'] );
        $article->setPublished( $published );
        $xoopsDB->query( "DELETE FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " WHERE requestid = " . $_POST['requestid'] . "" );
        redirect_header( "modified.php", 1, _AM_WFS_DBUPDATED );
        break;

    case "deleteModReq":
        deleteModReq( $_POST['requestid'] );
        break;

    case 'main':
    default:

        include_once( WFS_ROOT_PATH . "/class/wfscategory.php" );
        $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;

        global $xoopsDB, $myts, $mytree, $xoopsModuleConfig, $XoopsUser, $xoopsModuleConfig;

        $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_ARTICLE_MOD_DB ) . " ORDER BY requestid";
        $result = $xoopsDB->query( $sql, $xoopsModuleConfig['lastart'], $start );
        $result2 = $xoopsDB->query( $sql );
        $totalmodrequests = $xoopsDB->getRowsNum( $result2 );

        xoops_cp_header();

        wfs_admin_menu( _AM_WFS_MODIFICATION );
        wfs_textinfo( _AM_WFS_MODIFICATION, _AM_WFS_MODIFICATIONTEXT );
        echo "<div><b>" . _MD_USERMODREQ . "</b>: $totalmodrequests</div><br />";
        echo "<table border='0' width='100%' cellpadding ='2' cellspacing='1' class = 'outer'> ";
        echo "<tr >";
        $headingarray = array( _AM_WFS_STORYID, _AM_WFS_TITLE, _AM_WFS_CATEGORYT, _AM_WFS_POSTER, _AM_WFS_MODIFIED, _AM_WFS_ACTION );
        for( $i = 0; $i <= count( $headingarray )-1; $i++ ) {
            echo "<td align='center' class='bg3'><b>" . $headingarray[$i] . "</td>";
        }
        echo "</tr>";

        if ( $totalmodrequests > 0 ) {
            while ( $arr = $xoopsDB->fetchArray( $result ) ) {
                $xt = new WfsCategory( $arr['categoryid'] );
                $article = new WfsArticle( $arr['articleid'] );
                $user = WFS_getLinkedUnameFromId( $arr['modifysubmitter'] );
                $title = $myts->htmlSpecialChars( $arr['title'], ENT_QUOTES );
                $url = $myts->htmlSpecialChars( $arr['url'], ENT_QUOTES );
                $urlname = $myts->htmlSpecialChars( $arr['urlname'], ENT_QUOTES );
                $atitle = $article->textLink();
                $ctitle = $xt->textLink();

                if ( $arr['requested'] ) {
                    $requesteddate = formatTimestamp( $arr['requested'], $xoopsModuleConfig['timestamp'] );
                } else {
                    $requesteddate = formatTimestamp( time(), $xoopsModuleConfig['timestamp'] );
                }

                $headinginfoarray = array( $title, $ctitle, $user, $requesteddate,
                    "<a href='modified.php?op=listModReq&amp;requestid=" . $arr['requestid'] . "'>$approve</a>
					<a href='modified.php?op=edit&amp;requestid=" . $arr['requestid'] . "'>$editimg</a>
					<a href='modified.php?op=deleteModReq&amp;requestid=" . $arr['requestid'] . "'>$deleteimg</a>" );
                echo "<tr>";
                echo "<td align='center' class = 'head'><b>" . $arr['requestid'] . "</b></td>";
                for( $i = 0; $i <= count( $headinginfoarray )-1; $i++ ) {
                    echo "<td align='center' class = 'even'><b>" . $headinginfoarray[$i] . "</b></td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr>";
            echo "<td align='center' class='head' colspan = 6><b>" . _AM_WFS_NOARTICLEFOUND . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
        $pagenav = new XoopsPageNav( $totalmodrequests, $xoopsModuleConfig['lastart'], $start, 'start', 'lastarts=' . $xoopsOption, 1 );
        echo "<div style='text-align: right;' >" . $pagenav->renderNav() . "</div><br />";
        break;
}
xoops_cp_footer();

?>