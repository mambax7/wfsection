<?php
// $Id: article.php,v 1.6 2004/08/13 12:38:49 phppp Exp $
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
/**
 * items removed but maybe needed
 */
// $articletag['pulldown'] = jumpbox("article.php", $article->categoryid);
// dummy for non multibyte environment
// if (!extension_loaded('mbstring') && !function_exists('mb_convert_encoding'))
// {
// include_once WFS_ROOT_PATH . "/include/mb_dummy.php";
// }
/**
 * end of removed items
 */
include 'header.php';
include_once WFS_ROOT_PATH . "/include/functions.php";
include_once WFS_ROOT_PATH . "/include/groupaccess.php";
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";

$article_id = isset( $_GET['articleid'] ) ? intval( $_GET['articleid'] ) : 0;
$page = ( isset( $_GET['page'] ) ) ? intval( $_GET['page'] ) : 0;
$pagenum = ( isset( $_GET['pagenum'] ) ) ? intval( $_GET['pagenum'] ) : 0;

$articletag = array();

$article = new WfsArticle( $article_id );
if ( !is_object( $article ) ) {
    redirect_header( "index.php", 2, _WFS_NOARTICLE );
    exit();
}

if ( !wfs_checkAccess( $article->groupid ) ) {
    redirect_header( 'index.php', 2 , _WFS_ARTICLENOPERM );
    exit();
}

$xoopsOption['template_main'] = ( $article->isframe ) ? $wfsTemplates['articleplainpage'] : $wfsTemplates['articlepage'];
include_once( XOOPS_ROOT_PATH . "/header.php" );

$article->updateCounter();

$articletag['adminlink'] = "";
$articletag['pagelink'] = "";
$articletag['articleid'] = $article->articleid();
$articletag['categoryid'] = $article->categoryid();

$title_matches = array();
preg_match_all( "/\[title](.*)\[\/title\]/esU", $article->maintext( "S" ), $title_matches );
$subtitle_matches = array();
preg_match_all( "/\[subtitle](.*)\[\/subtitle\]/esU", $article->maintext( "S" ), $subtitle_matches );

if ( $page > 0 && is_array( $title_matches ) ) {
    $article->maintext = preg_replace( "/\[subtitle](.*)\[\/subtitle\]/sU", "", $article->maintext );
    if ( is_array( $title_matches ) ) {
        $page_num = $page + 1;
        $article->setTitle( $title_matches[1][$page-1] . $article->title . " (" . _WFS_PART . " $page_num)" );
        $article->setSubTitle( $subtitle_matches[1][$page-1] );
    }
}

if ( is_array( $title_matches ) && count( $title_matches[1] ) > 0 ) {
    $articletag['morelinks'] = "";
    if ( is_array( $title_matches ) ) {
        for ( $i = 0; $i < count( $title_matches[1] ); $i++ ) {
            $a = $i + 1;
            $articletag['morelinks'][] = array( 'articlelink' => "<a href='article.php?articleid=" . $article->articleid() . "&amp;page=" . $a . "'>" . $title_matches[1][$i] . "</a>" );
        }
    }
}

$articletag['titlemain'] = $article->title( "S" );
$articletag['subtitle'] = $article->subtitle( "S" );
$articletag["image"] = $article->articleimg( "S", $size = 0, 1 );

/**
 * Document information
 */
$articletag['username'] = $article->uname();
$articletag['email'] = $article->email();
$articletag['commentcount'] = ( in_array( 1, $xoopsModuleConfig['displayinfo'] ) ) ? $article->getCommentsCount() : "";
if ( $xoopsModuleConfig['novote'] ) {
    $articletag['rating'] = ( in_array( 3, $xoopsModuleConfig['displayinfo'] ) ) ? number_format( $article->rating(), 2 ) : "";
    $articletag['votes'] = ( in_array( 4, $xoopsModuleConfig['displayinfo'] ) ) ? $article->votes() : "";
    $xoopsTpl->assign( 'wfs_novote', true );
}
$articletag['datetime'] = ( in_array( 5, $xoopsModuleConfig['displayinfo'] ) ) ? formatTimestamp( $article->published(), $xoopsModuleConfig['timestamp'] ) : "";
$articletag['counter'] = ( in_array( 6, $xoopsModuleConfig['displayinfo'] ) ) ? $article->counter() : "";
$articletag['version'] = ( in_array( 9, $xoopsModuleConfig['displayinfo'] ) ) ? $article->version() : "";
$articletag['id'] = ( in_array( 9, $xoopsModuleConfig['displayinfo'] ) ) ? $article->articleid() : "";

$articletag['adminlink'] = $article->adminlink();
$novotevalue = ( $xoopsModuleConfig['novote'] == 1 ) ? true : false;
$xoopsTpl->assign( 'novote', $novotevalue );

/**
 * Get forum details
 */
$forum = ( $xoopsModuleConfig['atavar'] ) ? "newbb" : "ipboard";
$xoopsforumModule = &$modhandler->getByDirname( $forum );
if ( is_object( $xoopsforumModule ) && $xoopsforumModule->getVar( 'isactive' ) ) {
    $articletag['isforumid'] = ( $article->isforumid() > 0 ) ? $article->isforumid() : 0;
    $articletag['forum_path'] = ( $xoopsModuleConfig['atavar'] ) ? "modules/newbb/viewforum.php?forum={$articletag['isforumid']}" :
    "/modules/ipboard/index.php?showforum={$articletag['isforumid']}" ;
}
/**
 * Select atavar or Section determined by admin choice
 */
$articletag['userimg'] = '';
switch ( $xoopsModuleConfig['atavar'] ) {
    case "1":
        $user = new XoopsUser( $article->uid );
        $atavar = $user->user_avatar();
        if ( !empty( $atavar ) && $atavar != 'blank.gif' ) {
            $articletag["userimg"] = ( $xoopsModuleConfig['use_thumbs'] ) ? wfs_createthumb( $atavar, "uploads", "thumbs", 74, 71, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : "$atavar";
            $articletag["userimg"] = "<img src=" . $articletag["userimg"] . " alt=''>";
        }
        break;
    case "2":
        $onecat = new WfsCategory( $article->categoryid );
        if ( $onecat->imgurl( "S" ) && $xoopsModuleConfig['showcatpic'] == 1 )
            $articletag['userimg'] = $onecat->imgLink();
        break;
    default:
        $articletag['userimg'] = "";
        break;
}
$sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_REVIEWS ) . " WHERE article_id = $article_id";
$review_arr = $xoopsDB->fetchArray( $xoopsDB->query( $sql ) );

if ( $review_arr['display'] ) {
    include_once WFS_ROOT_PATH . "/review.php";
} else {
    /**
     * Get maintext for page
     */
    $pagenum = $article->maintextPages();

    if ( $page > $pagenum ) $page = $pagenum;

    if ( $article->pdfpage ) {
        $xoopsTpl->assign( 'pdfpage', "html/" . $article->pdfpage );
    } else {
        if ( $article->htmlpage ) {
            $ext = ltrim( strrchr( $article->htmlpage, '.' ), '.' );
            if ( $ext == "php" || $ext == "php3" || $ext = "phtml" ) {
                if ( file_exists( WFS_HTML_PATH . "/" . $article->htmlpage ) && false != $fp = fopen( WFS_HTML_PATH . "/" . $article->htmlpage, 'r' ) ) {
                    $articletag['maintext'] = WFS_HTML_PATH . "/" . $article->htmlpage;
                    $xoopsTpl->assign( 'my_template', WFS_HTML_PATH . "/" . $article->htmlpage );
                    $articletag['is_include'] = 1;
                } else {
                    $xoopsTpl->assign( 'my_template', '' );
                    $articletag['is_include'] = 0;
                    $articletag['maintext'] = '';
                }
            } else {
                $fileisthis = WFS_HTML_PATH . "/" . $article->htmlpage ;
                if ( file_exists( $fileisthis ) && false !== $fp = fopen( $fileisthis, 'r' ) ) {
                    $articletag['maintext'] = fread( $fp, filesize( $fileisthis ) );
                    $articletag['maintext'] = str_replace( $article->htmlpage, "article.php?articleid=$article_id&page=$page", $articletag['maintext'] );
                    $articletag['maintext'] = str_replace( "&lt;P&gt;&nbsp;&lt;/P&gt;", "", $articletag['maintext'] );
                    $articletag['maintext'] = str_replace( "/<img src=\'\/(.+?)\'/", "<img src='" . WFS_IMAGES_URL . "/\\1'", $articletag['maintext'] );
                    $articletag['maintext'] = $articletag['maintext'];
                    fclose( $fp );
                }
                if ( preg_match( '/<title>([^<]*)<\/title>/i', $articletag['maintext'], $matches ) ) {
                    $title = $matches[1];
                    $article->setTitle( trim( $title ) );
                    $articletag['title'] = $article->category->textLink() . ": " . $article->title( "S" );
                    $articletag['titlemain'] = $article->title( "S" );
                }
                if ( preg_match( '/<body>([^<]*)<\/body>/i', $articletag['maintext'], $matches ) ) {
                    $matches = preg_replace( $script, "", $matches[1] );
                    $matches = str_replace( $style, "", $matches );
                    $matches = preg_replace( "/^(.*)<body/si", "", $matches );
                    $matches = preg_replace( "/^([^>]*)>/si", "", $matches );
                    $matches = preg_replace( "/<\/body>.*/si", "", $matches );
                    $articletag['maintext'] = $matches;
                }
            }
        } else {
            $pagenum = $article->maintextPages();
            if ( $page > $pagenum ) $page = $pagenum;
            $articletag['maintext'] = $article->maintext( "S", $page );
        }
    }
}
$articletag['size'] = ( in_array( 7, $xoopsModuleConfig['displayinfo'] ) ) ? wfs_myfilesize( strlen( $articletag['maintext'] ) ) : "";

/**
 * include navigation menu
 */
$xoopsTpl->assign( 'pagenav', '' );
if ( $pagenum > 0 ) {
    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
    $pagenav = new XoopsPageNav( $pagenum, 1, $page, 'page', 'articleid=' . $article->articleid );
    $xoopsTpl->assign( 'pagenav', $pagenav->renderNav() );
}
/**
 * Include download files
 */
$files = $article->getAllFiles();
if ( count( $files ) ) {
    foreach( $article->files as $file ) {
        $filename = $file->getFileRealName();
        $filename = WFS_FILE_PATH . "/" . $filename;

        $size = ( is_file( $filename ) ) ? wfs_myfilesize( $filename ) : 0;

        $download['downlink'] = $file->getLinkedName( XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "" );
        $download['description'] = $file->getFiledescript( 'S' );
        $download['description'] = ( $download['description'] ) ? $download['description'] : _WFS_NODESCRIPT ;
        $download['mimetype'] = $file->getMimetype( 'S' );
        $download['size'] = $size;
        $download['icon'] = wfs_getIcon( $filename );
        $download['counter'] = $file->getCounter();
        $download['date'] = formatTimestamp( $file->date, $xoopsModuleConfig['timestamp'] );
        $xoopsTpl->append( 'downloads', $download );
    }
    $xoopsTpl->assign( 'lang_description', _WFS_DESCRIPTION );
    $xoopsTpl->assign( 'lang_filesize', _WFS_FILESIZE );
    $xoopsTpl->assign( 'lang_uploaded', _WFS_UPLOADED );
    $xoopsTpl->assign( 'lang_mimetype', _WFS_FILEMIMETYPE );
    $xoopsTpl->assign( 'lang_hits', _WFS_HITS );
}

/**
 * Get related documents
 */
$query = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATED ) . " WHERE related_idtopic = $article_id AND related_mod = 1";
$result = $xoopsDB->query( $query );
$amount = $xoopsDB->getRowsNum( $result );
if ( $amount > 0 ) {
    while ( $related_arr = $xoopsDB->fetchArray( $result ) ) {
        $ret_article = new WfsArticle( $related_arr['related_topicid'] );
        if ( !wfs_checkAccess( $ret_article->groupid ) ) {
            continue;
        }
        $related_article['title'] = $ret_article->textLink( "S" );
        $xoopsTpl->append( 'related_article', $related_article );
    }
    $related_count = ( isset( $related_article ) && $related_article > 0 ) ? 1 : 0;
    $xoopsTpl->assign( 'relatednum', intval( $related_count ) );
    unset( $query );
    unset( $amount );
}

/**
 * related news story
 */
if ( is_readable( XOOPS_ROOT_PATH . "/modules/news/class/class.newsstory.php" ) ) {
    $modhandler = &xoops_gethandler( 'module' );
    $xoopsNewsModule = &$modhandler->getByDirname( "news" );
    if ( !$xoopsNewsModule ) {
        include_once XOOPS_ROOT_PATH . "/modules/news/class/class.newsstory.php";
        $query = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATED ) . " WHERE related_idtopic = $article_id AND related_mod = 2";
        $result = $xoopsDB->query( $query );
        $amount = $xoopsDB->getRowsNum( $result );
        if ( $amount > 0 ) {
            while ( $related_news = $xoopsDB->fetchArray( $result2 ) ) {
                $ret_news = new NewsStory( $related_news['related_topicid'] );
                $related_newsstory['title'] = $ret_news->textLink();
                $xoopsTpl->append( 'related_newsstory', $related_newsstory );
            }
        }
        unset( $query );
        unset( $amount );
    }
    $relatednews_count = ( isset( $related_newsstory ) && $related_newsstory > 0 ) ? 1 : 0;
    $xoopsTpl->assign( 'relatednewsnum', intval( $relatednews_count ) );
}
/**
 * related links
 */

$query = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " WHERE relatedlink_topicid = $article_id ORDER by relatedlink_weight";
$result = $xoopsDB->query( $query );
$amount = $xoopsDB->getRowsNum( $result );
if ( $amount > 0 ) {
    while ( $related_links = $xoopsDB->fetchArray( $result ) ) {
        $link_url = $myts->htmlSpecialChars( $myts->stripSlashesGPC( $related_links['relatedlink_url'] ) );
        $link_urlname = $myts->htmlSpecialChars( $myts->stripSlashesGPC( $related_links['relatedlink_urlname'] ) );
        $related_link['linktitle'] = "<a href='" . formatURL( $link_url ) . "' target='_blank'>" . $link_urlname . "</a>";;
        $xoopsTpl->append( 'related_link', $related_link );
    }
    $relatedlink_count = ( isset( $related_link ) && $related_link > 0 ) ? 1 : 0;
    $xoopsTpl->assign( 'relatedlink', intval( $relatedlink_count ) );
    unset( $query );
    unset( $amount );
}
// $xoopsTpl->assign('relatedlink', $article->relatedlink());
// assign the article variables to template
$xoopsTpl->assign( 'article', $articletag );
$showfilesvalue = ( $article->getFilesCount() > 0 ) ? true : false;
$xoopsTpl->assign( 'showfilesvalue', $showfilesvalue );

$xoopsTpl->assign( array( 'lang_author' => _WFS_AUTHER,
        'lang_page' => _WFS_PAGES,
        'lang_published' => _WFS_PUBLISHEDHOME,
        'lang_downloadsfor' => _WFS_DOWNLOADS,
        'lang_printer' => _WFS_PRINTERFRIENDLY,
        'lang_subjectsitename' => sprintf( _WFS_INTFILEAT, $xoopsConfig['sitename'] ),
        'lang_subjectfound' => sprintf( _WFS_INTFILEFOUND, $xoopsConfig['sitename'] ),
        'lang_tellafriend' => _WFS_TELLAFRIEND,
        'lang_backtocategory' => _WFS_BACK2CAT,
        'lang_backtoindex' => _WFS_RETURN2INDEX,
        'lang_inforum' => sprintf( _WFS_INFORUMS, $article->title( "S" ) ),
        'lang_rating' => _WFS_RATING,
        'lang_votes' => _WFS_NUMVOTES,
        'lang_views' => _WFS_VIEWS,
        'lang_times' => _WFS_TIMES,
        'lang_relatedart' => _WFS_RELATEDARTS,
        'lang_relatednews' => _WFS_RELATEDNEWS,
        'lang_relatedlinks' => _WFS_RELATEDLINKS,
        'lang_articleid' => _WFS_ARTICLEID,
        'lang_size' => _WFS_ARTSIZE,
        'lang_version' => _WFS_VERSION
        ) );

$xoopsTpl->assign( 'xoops_pagetitle', $myts->htmlSpecialChars( WFSECTION . '-' . $article->title() ) );
$xoopsTpl->assign( 'xoops_module_header', '<link rel="stylesheet" type="text/css" href="wfsection.css" />' );

if ( isset( $xoopsModuleConfig['copyright'] ) && $xoopsModuleConfig['copyright'] == 1 )
    $xoopsTpl->assign( 'lang_copyright', "" . $article->title() . "<br />&copy; " . _WFS_COPYRIGHT . " " . date( "Y" ) . " " . $article->uname() . " & <a href=" . XOOPS_URL . ">" . $xoopsConfig['sitename'] . "</A>" );

if ( $article->allowcom ) {
    include_once XOOPS_ROOT_PATH . '/class/xoopscomments.php';
    include XOOPS_ROOT_PATH . '/include/comment_view.php';
}
include( XOOPS_ROOT_PATH . "/footer.php" );

?>
