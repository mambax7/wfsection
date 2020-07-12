<?php
// $Id: index.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
// URL: http://www.wf-projects.com                                           //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
// Admin Main
include 'admin_header.php';

$op = "";

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

if ( isset( $articleid ) ) {
    $isWfsArticle = new WfsArticle( $articleid );
    if ( !is_object( $isWfsArticle ) ) {
        redirect_header( "allarticles.php", 1, _AM_WFS_ARTICLENOTEXIST );
        exit();
    }
}
unset( $isWfsArticle ); // should be optimized ...

switch ( $op ) {
    case "edit":
        accessadmin( "editarticle", 0 , $articleid );
        $article = new WfsArticle( $articleid );
        if ( !$checkin_id = checkin( $article->articleid ) ) {
            redirect_header( "javascript:history.go(-1)", 2, _AM_WFS_CHECKIN_FAILED );
            exit();
        }
        xoops_cp_header();

        wfs_admin_menu( _AM_WFS_ARTICLEMANAGEMENT );

        if ( $article->articleid ) {
            $result = $xoopsDB->query( "SELECT article_id, user_id, c_out_time FROM " . $xoopsDB->prefix( "wfs_checkin" ) . " WHERE c_out_time > '0' AND article_id=" . $article->articleid . " ORDER BY c_out_time DESC LIMIT 1" );
            list( $article_id, $user_id, $c_out_time ) = $xoopsDB->fetchrow( $result );
            $user_name = isset( $user_id ) ? WFS_getLinkedUnameFromId( $user_id, $xoopsModuleConfig['displayname'], 1 ) : _AM_WFS_NODETAILSRECORDED;
            $timecreated = isset( $article->created ) ? formatTimestamp( $article->created, "D d-M-Y H:i:s" ) : _AM_WFS_NODETAILSRECORDED ;
            $timestarted = isset( $c_out_time ) ? formatTimestamp( $c_out_time, "D d-M-Y H:i:s" ) : _AM_WFS_NODETAILSRECORDED ;
            $origauthor = isset( $article->uid ) ? WFS_getLinkedUnameFromId( $article->uid, $xoopsModuleConfig['displayname'], 0 ) : _AM_WFS_NODETAILSRECORDED;

            $intro = "<table width ='100%' cellpadding ='2' cellspacing ='1'>";
            $intro .= "<tr>";
            $intro .= "<td width = 50%>";
            $intro .= "<div><b>" . _AM_WFS_TITLE . ":</b> " . $article->textLink() . "</div>";
            $intro .= "<div><b>" . _AM_WFS_CREATEDBY . "</b>" . $origauthor . "</div>";
            $intro .= "<div><b>" . _AM_WFS_CREATEDON . "</b>" . $timecreated . "</div><br />";
            $intro .= "<div><b>" . _AM_WFS_LASTEDITBY . "</b>" . $user_name . "</div>";
            $intro .= "<div><b>" . _AM_WFS_EDITEDON . "</b>" . $timestarted . "</div>";
            $intro .= "</td>";
            $intro .= "<td width = '50%' valign = 'top'>";
            if ( accessadmin( "downloads", 1 ) )
                $intro .= "<div><a href='wfsfilesshow.php?op=uploads&amp;articleid=" . $article->articleid . "'>$uploads " . _AM_WFS_ADDAFILETOTHISDOWNLOAD . "</a></div>";
            if ( accessadmin( "reviews", 1 ) )
                $intro .= "<div><a href='reviews.php?op=default&amp;articleid=" . $article->articleid . "'>$reviews " . _AM_WFS_ADD_REVIEW . "</a></div>";
            if ( accessadmin( "docstats", 1 ) )
                $intro .= "<div><a href='allarticles.php?op=stats&amp;articleid=" . $article->articleid . "'>$statsimg " . _AM_WFS_ADD_STATUS . "</a></div>";
            if ( $xoopsModuleConfig['use_restore'] && accessadmin( "restore", 1 ) ) $intro .= "<div><a href='restore.php?op=default&amp;articleid=" . $article->articleid . "'>$restoreimg " . _AM_WFS_DOC_RESTORE . "</a></div>";
            $intro .= "</td>";
            $intro .= "</tr>";
            $intro .= "</table>";

            wfs_textinfo( _AM_WFS_EDITARTICLE, $intro );
        }
        if ( !empty( $articleid ) ) {
            $isedit = 1;
            include_once WFS_ROOT_PATH . '/include/articleform.inc.php';
        } else {
            die( "Article does not exist!" );
        }
        break;

    case "addword":
        // echo ini_set( 'com.allow_dcom', '0' );
        $article = ( !empty( $articleid ) ) ? new WfsArticle( $articleid ) : new WfsArticle();

        if ( !preg_match( "/[.doc|.rtf|.txt]$/i", $HTTP_POST_VARS['file'] ) ) {
            redirect_header( "import.php", 1, _AM_WFS_NOT_WORDDOC );
            exit();
        }
        include WFS_ROOT_PATH . "/class/wordDocumentHandler.php";
        $w = new wordDocumentHandler();

        $HTMLPath = substr_replace( basename( $HTTP_POST_VARS['file'] ), 'html', -3, 3 );
        $HTMLPath = str_replace( " ", "_", $HTMLPath );
        $htmlfile = strtolower( WFS_HTML_PATH . "/" . $HTMLPath );
        if ( file_exists( $htmlfile ) ) {
            redirect_header( "import.php", 3, _AM_WFS_ERRORFILEALLREADYEXISITS );
        } else {
            $w->convertWordDocumentToFile( $HTTP_POST_VARS['file'], $htmlfile, $outFormat = "html" );
        }
        redirect_header( "import.php", 3, _AM_WFS_DBUPDATED );
        break;

    case "addpdf":

        $article = ( !empty( $articleid ) ) ? new WfsArticle( $articleid ) : new WfsArticle();

        if ( !preg_match( "/.pdf$/i", $_FILES['pdffile']['name'] ) ) {
            redirect_header( "import.php", 10, _AM_WFS_NOT_PDFDOC );
            exit();
        }
        $PDFPath = substr_replace( basename( $_FILES['pdffile']['name'] ), 'pdf', -3, 3 );
        $PDFPath = str_replace( " ", "_", $PDFPath );
        $PDFFile = strtolower( WFS_HTML_PATH . "/" . $PDFPath );
        if ( file_exists( $PDFFile ) ) {
            redirect_header( "import.php", 3, _AM_WFS_ERRORFILEALLREADYEXISITS );
        } else {
            if ( !copy( $_FILES['pdffile']['tmp_name'], $PDFFile ) ) {
                echo( $_FILES['pdffile']['tmp_name'] . "---" . $PDFFile );
                redirect_header( "import.php", 30, _AM_WFS_ERRORCOPYINGPDF );
            }
        }
        redirect_header( "import.php", 3, _AM_WFS_DBUPDATED );
        break;

    case "Copy":
        unset( $_POST['articleid'] );

    case "save":
    case "Save":

        if ( isset( $_POST['checkin_id'] ) && !checkStatus( $_POST['checkin_id'] ) ) {
            redirect_header( "javascript:history.go(-1)", 1, _AM_WFS_CHECKIN_FAILED );
            exit();
        }

        $article = ( isset( $_POST['articleid'] ) && intval( $_POST['articleid'] ) ) ?
        new WfsArticle( intval( $_POST['articleid'] ) ) : new WfsArticle();

        $article->setPage( isset( $_POST['page'] ) && intval( $_POST['page'] ) );
        $article->setUserType( 1 );

        $article->setGroups( $_POST['groupid'], isset( $_POST['catgroupid'] ) );
        $article->setCategoryid( intval( $_POST['id'] ) );

        $userset = ( isset( $_POST['userset'] ) && $_POST['userset'] == 1 ) ? 1 : 0;
        $article->setUid( intval( $_POST['changeuser'] ), $userset );
        $article->setWeight( intval( $_POST['weight'] ), $xoopsModuleConfig['autoweight'] );

        $article->setSubTitle( $_POST['subtitle'] );
        $article->setArtimage( $_POST['artimage'] );

        $article->setNohtml( isset( $_POST['nohtml'] ) );
        $article->setNosmiley( isset( $_POST['nosmiley'] ) );
        $article->setNoxcodes( isset( $_POST['noxcodes'] ) );
        $article->setNobreaks( isset( $_POST['nobreaks'] ) );

        $article->setNotifypub( isset( $_POST['notifypub'] ) );
        $article->setIsframe( isset( $_POST['isframe'] ) );
        $article->setOffline( isset( $_POST['offline'] ) );
        $article->setNoshowart( isset( $_POST['noshowart'] ) );
        $article->setAllowcom( isset( $_POST['allowcom'] ) );
        $article->setCmainmenu( isset( $_POST['cmainmenu'] ) );
        // works
        $article->setApproved( isset( $_POST['approved'] ) );
        $article->setVersion( $_POST['version'], intval( $_POST['version_update'] ) );
        $article->setSpotlight( intval( $_POST['spotlight'] ) );
        $article->setSpotlightMain( $_POST['spotlightmain'], $_POST['spotlightsponser'] );
        $article->isforumid = ( $_POST['isforumid'] ) ? $_POST['isforumid'] : 0;

        $changed = ( isset( $_POST['publishdate'] ) && $_POST['publishdate'] > 0 ) ? time() : 0;
        $article->setChanged( $changed );

        $publishdate = ( isset( $_POST['publishdate'] ) && $_POST['publishdate'] > 0 ) ? $_POST['publishdate'] : time();
        $expiredate = ( isset( $_POST['expiredate'] ) && $_POST['expiredate'] > 0 ) ? $_POST['publishdate'] : 0;
        // $move_to_top = 1;
        $article->setPublished( $publishdate, ( isset( $_POST['movetotop'] ) && $_POST['movetotop'] == 1 ) );
        $article->setExpired( $expiredate );

        if ( isset( $_POST['publishdateactivate'] ) ) {
            $publishdate = strtotime( $_POST['publishdates']['date'] ) + $_POST['publishdates']['time'];
            $article->setPublished( $publishdate );
        }
        if ( $_POST['clearpublish'] ) {
            $publishdate = $article->created;
            $article->setPublished( $publishdate );
        }

        if ( isset( $_POST['expiredateactivate'] ) ) {
            $expiredate = strtotime( $_POST['expiredates']['date'] ) + $_POST['expiredates']['time'];
            $article->setExpired( $expiredate );
        }
        if ( $_POST['clearexpire'] ) {
            $article->setExpired( 0 );
        }

        if ( isset( $_POST['doctitle'] ) && $_POST['doctitle'] == 1 ) {
            $GLOBALS['fileedit'] = wfs_loadfile( $_POST["htmlpage"] );
            if ( preg_match( '_<title>(.*)</title>_is', $GLOBALS['fileedit'], $tmp ) ) {
                $title = $myts->addslashes( trim( $tmp[1] ) );
                $article->setTitle( $title );
                unset( $tmp );
                unset( $GLOBALS );
            } else {
                $article->setTitle( $_POST['title'] );
            }
        } else {
            $article->setTitle( $_POST['title'] );
        }

        if ( !empty( $_POST["htmlpage"] ) && isset( $_POST["htmldb"] ) && $_POST["htmldb"] == 1 ) {
            $maintext = '';
            $GLOBALS['fileedit'] = wfs_loadfile( $_POST["htmlpage"] );
            if ( preg_match( '_<body>(.*)</body>_is', $GLOBALS['fileedit'], $tmp ) ) {
                $maintext = $tmp[0];
            } else {
                $maintext = $GLOBALS['fileedit']; //Dummy entry
            }
            $maintext = preg_replace( '/\<script[\w\W]*?\<\/script\>/i', '', $maintext );
            $maintext = str_replace( '<P>&nbsp;</P>', '', $maintext );
            $maintext = str_replace( "<img src=\"", "<img src=\"html/images/", $maintext );
            $maintext = preg_replace( array( '/[ \t]{2,}/', '/(\n|\r|\r\n){2,}/' ), array( '', '' ), trim( $maintext ) );
            $article->setHtmlpage( '' );
            unset( $GLOBALS['fileedit'] );
        } else {
            $maintext = $_POST["maintext"];
        }

        if ( isset( $_POST["cleanhtml"] ) && $_POST["cleanhtml"] == 1 ) {
            $maintext = wfs_cleanHtml( $maintext );
        }

        if ( isset( $_POST["striptags"] ) && $_POST["striptags"] == 1 ) {
            $maintext = wfs_strip_tags( $maintext );
        }

        if ( !empty( $_POST["htmlpage"] ) && !isset( $_POST["htmldb"] ) ) {
            $article->setMainText( '' );
            $article->setHtmlpage( $_POST['htmlpage'] );
        } else {
            $article->setHtmlpage( '' );
            $article->setMainText( $myts->addslashes( $maintext ) );
        }

        if ( !empty( $_POST["pdfpage"] ) ) {
            $article->setMainText( '' );
            $article->setPDFpage( $_POST['pdfpage'] );
        }

        /**
         * Start of other entries
         */
        $auto_summary = ( isset( $_POST['autosummary'] ) && $_POST['autosummary'] == 1 ) ? 1 : 0;
        $summary_amount = intval( $_POST['summaryamount'] );
        $remove_images = ( isset( $_POST['removeimages'] ) && $_POST['removeimages'] == 1 ) ? 1 : 0;
        $article->setSummary( $_POST['summary'], $auto_summary, $summary_amount, $remove_images );

        $article->setUrl( $_POST['url'] );
        $article->setUrlname( $_POST['urlname'] );
        $article->store();

        if ( !empty( $isnew ) && $article->notifypub() && $article->uid() != 0 ) {
            $poster = new XoopsUser( $article->uid() );
            $subject = _AM_WFS_ARTPUBLISHED;
            $message = sprintf( _AM_WFS_HELLO, $poster->uname() );
            $message .= "\n\n" . _AM_WFS_YOURARTPUB . "\n\n";
            $message .= _AM_WFS_TITLEC . $article->title() . "\n" . _AM_WFS_URLC . WFS_ROOT_PATH . "/article.php?articleryid=" . $article->articleid() . "\n" . _AM_WFS_PUBLISHEDC . formatTimestamp( $article->published(), "$timestanp", 0 ) . "\n\n";
            $message .= $xoopsConfig['sitename'] . "\n" . XOOPS_URL . "";
            $xoopsMailer = &getMailer();
            $xoopsMailer->useMail();
            $xoopsMailer->setToEmails( $poster->getVar( "email" ) );
            $xoopsMailer->setFromEmail( $xoopsConfig['adminmail'] );
            $xoopsMailer->setFromName( $xoopsConfig['sitename'] );
            $xoopsMailer->setSubject( $subject );
            $xoopsMailer->setBody( $message );
            $xoopsMailer->send();
        }
        checkout( intval( isset( $_POST['articleid'] ) && intval( $_POST['articleid'] ) ), $article->uid );
        redirect_header( "allarticles.php", 1, _AM_WFS_DBUPDATED );
        exit();
        break;

    case "approve":
        accessadmin( "docapprove", 0 , $articleid );
        if ( WfsArticle::approve( $articleid ) )
            redirect_header( "allarticles.php", 2, _AM_WFS_APPROVED );
        else
            redirect_header( "allarticles.php", 2, _AM_WFS_ERROR_APPROVED );
        exit();
        break;

    case "delete":
        accessadmin( "deletearticles", 0 , $articleid );
        if ( isset( $_POST['ok'] ) && $_POST['ok'] == 1 ) {
            $article = new WfsArticle( $articleid );
            $article->delete();
            $xoopsDB->query( "DELETE FROM " . $xoopsDB->prefix( WFS_CHECKIN_DB ) . " WHERE article_id=" . $articleid . "" );
            redirect_header( "allarticles.php", 1, _AM_WFS_DBUPDATED );
            exit();
        } else {
            xoops_cp_header();
            echo "";
            xoops_confirm( array( 'op' => 'delete', 'articleid' => $articleid, 'ok' => 1 ), 'index.php', _AM_WFS_RUSUREDEL );
        }
        break;

    case "newarticle":
    case "default":
    default:
        accessadmin( "createarticles" );

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_ARTICLEMANAGEMENT );

        if ( WfsCategory::countCategory() > 0 ) {
            wfs_textinfo( _AM_WFS_EDITARTICLE, _AM_WFS_SECTIONSETTINGSTEXT );
            $article = new WfsArticle();
            include_once WFS_ROOT_PATH . '/include/articleform.inc.php';
        } else {
            echo "<br>";
            xoops_error( "<a href='category.php?op=default'>" . _AM_WFS_CATEGORYTAKEMETO . "</a>", "<h4>" . _AM_WFS_NOCATEGORY . "</h4>" );
        }
        break;
}
xoops_cp_footer();

?>
