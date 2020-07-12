<?php
// $Id: wfsarticle.php,v 1.6 2004/08/18 03:06:04 phppp Exp $
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
// include_once 'common.php';
include_once WFS_ROOT_PATH . "/class/wfstree.php";
include_once WFS_ROOT_PATH . "/class/wfscategory.php";
include_once WFS_ROOT_PATH . "/include/groupaccess.php";
include_once WFS_ROOT_PATH . "/class/wfsfiles.php";

$myts = &MyTextSanitizer::getInstance();

global $xoopsModuleConfig;
if ( isset( $xoopsModuleConfig['wiki'] ) ) {
    include_once WFS_ROOT_PATH . '/wiki/init.php';
}

/**
 * WfsArticle
 *
 * @package
 * @author John Neill
 * @copyright Copyright (c) 2003
 * @access public
 */
// This class needs to be re-written based on kernel object class ... - phppp
class WfsArticle {
    var $db;
    var $table;
    var $commentstable;
    var $categorytable;
    var $mainmenutable;
    var $restoretable;
    var $filestable;
    var $articleid = 0;
    var $categoryid = 0;
    var $uid = 0;
    var $title = '';
    var $maintext = '';
    var $counter = 0;
    var $created = 0;
    var $changed = 0;
    var $nohtml = 0;
    var $nosmiley = 0;
    var $noxcodes = 0;
    var $nobreaks = 1;
    var $allowcom = 1;
    var $summary = '';
    var $url = 'http://';
    var $urlname = '';
    var $page = -1;
    var $groupid = '1 2 3';
    var $rating = 0;
    var $votes = 0;
    var $popular = 0;
    var $notifypub = 0;
    var $usertype = 'admin';
    var $approved = 0;
    var $htmlpage = '';
    var $pdfpage = '';
    var $isframe = 0;
    var $catgroupid = 0;
    var $offline = 0;
    var $weight = 0;
    var $noshowart = 0;
    var $cmainmenu = 0;
    var $isforumid = 0;
    var $articleimg = "";
    var $subtitle = "";
    var $spotlight = 0;
    var $spotlightmain = 0;
    var $published = 0;
    var $expired = 0;
    var $wrapurl = 'http://';
    var $version = 0.01;
    var $category;
    var $files;
    // constructor
    function WfsArticle( $articleid = -1 ) {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix( WFS_ARTICLE_DB );
        $this->categorytable = $this->db->prefix( WFS_CATEGORY_DB );
        $this->mainmenutable = $this->db->prefix( WFS_MAINMENU_DB );
        $this->restoretable = $this->db->prefix( WFS_RESTORE_DB );

        if ( is_array( $articleid ) ) { // assign values for the article
            $this->makeArticle( $articleid );
            $this->category = $this->category();
        } elseif ( $articleid != -1 ) {
            $this->getArticle( $articleid );
            if ( $this ) // if the article exists in database and loaded
                $this->category = $this->category();
        }
    }
    // create instance of other classes
    function category() {
        return new WfsCategory( $this->categoryid );
    }
    // set property
    function setArticleid( $value ) {
        $this->articleid = intval( $value );
    }

    function setCategoryid( $value ) {
        $this->categoryid = intval( $value );
    }

    function setUserType( $value = 0 ) {
        $this->usertype = ( intval( $value ) == 1 ) ? "admin" : "user";
    }

    function setPage( $value ) {
        $this->page = intval( $value );
    }

    function setUid( $value, $setuser = 0 ) {
        // global $xoopsUser;
        $this->uid = ( $value > 0 && $setuser == 1 ) ? $value : $this->uid;
    }

    function setGroups( $value, $cataccess = 0 ) {
        if ( isset( $cataccess ) && $cataccess == 1 ) {
            $xt = $this->category();
            $this->groupid = $xt->groupid;
        } else {
            $access = !empty( $value ) ? $value : '1' ;
            $this->groupid = wfs_saveAccess( $access );
        }
    }

    function setWeight( $value = 0, $auto_weight ) {
        $this->weight = intval( $value );

        if ( $auto_weight && $this->weight == 0 ) {
            $sql = "SELECT weight FROM " . $this->table . " WHERE categoryid = " . $this->categoryid() . " LIMIT 1 DESC";
            $result = $this->db->query( $sql );
            $this->weight = $count = $this->db->getRowsNum( $result ) + 1;
        }
    }

    function setPublished( $value = 0, $movetotop = 0 ) {
        $this->published = ( isset( $value ) && $value > 0 ) ? intval( $value ) : 0 ;
        if ( $movetotop == 1 ) {
            $this->published = time();
            $this->changed = 0;
        }
    }

    function setExpired( $value = 0 ) {
        $this->expired = ( isset( $value ) && $value > 0 ) ? intval( $value ) : 0 ;
    }

    function setChanged( $value = 0 ) {
        $this->changed = ( isset( $value ) && $value > 0 ) ? intval( $value ) : 0 ;
    }

    function setTitle( $value ) {
        $this->title = ( isset( $value ) && !empty( $value ) ) ? xoops_trim( $value ) : _AM_WFS_NOTITLESET ;
    }

    function setSubTitle( $value ) {
        $this->subtitle = ( isset( $value ) && !empty( $value ) ) ? xoops_trim( $value ) : '' ;
    }

    function setMaintext( $value ) {
        $this->maintext = ( isset( $value ) && !empty( $value ) ) ? $value : '' ;
    }

    function setSummary( $value, $auto = 0, $autoamount = 0, $remove_image = 0 ) {
        global $myts, $xoopsModuleConfig;

        $summarytemp = ( !empty( $value ) ) ? $value : '' ;

        if ( empty( $summarytemp ) ) {
            $this->summary = '';
        }

        $remove_image = ( isset( $remove_image ) && $remove_image == 1 ) ? 1 : 0 ;
        if ( $remove_image == 1 ) {
            $summarytemp = preg_replace( "/(\<img)(.*?)(\>)/si", "", $summarytemp );
        }

        $auto = ( isset( $auto ) && $auto == 1 ) ? 1 : 0 ;
        if ( $auto == 1 ) {
            $autoamount = ( isset( $autoamount ) && $autoamount > 0 ) ? intval( $autoamount ) : $xoopsModuleConfig["summary_amount"] ;
            $summarytemp = wfs_strip_tags( $this->maintext );
            $summarytemp = ( $xoopsModuleConfig['summary_type'] == 1 ) ? wfs_summarize( $summarytemp, $autoamount ) : xoops_substr( $summarytemp, 0, $autoamount );
        }
        $this->summary = $summarytemp;
    }

    function setUrl( $value ) {
        $value = ( isset( $value ) && $value != 'http://' && $value != 'https://' ) ? $value : '';
        $this->url = formatURL( $value );
    }

    function setUrlname( $value ) {
        $this->urlname = xoops_trim( $value );
    }

    function setWrapurl( $value ) {
        $value = ( isset( $value ) && $value != 'http://' && $value != 'https://' ) ? $value : '';
        $this->wrapurl = formatURL( $value );
    }

    function setHtmlpage( $value ) {
        $this->htmlpage = xoops_trim( $value );
    }

    function setPDFpage( $value ) {
        $this->pdfpage = xoops_trim( $value );
    }

    function setIsframe( $value ) {
        $this->isframe = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setOffline( $value = 0 ) {
        $this->offline = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setNoshowart( $value ) {
        $this->noshowart = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setCmainmenu( $value ) {
        $this->cmainmenu = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setAllowcom( $value ) {
        $this->allowcom = ( intval( $value ) ) ? 1 : 0 ;
    }
    // blah blah stuff
    function setNohtml( $value ) {
        $this->nohtml = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setNosmiley( $value ) {
        $this->nosmiley = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setNoxcodes( $value ) {
        $this->noxcodes = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setNobreaks( $value ) {
        $this->nobreaks = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setNotifypub( $value ) {
        $this->notifypub = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setForumid( $value ) {
        $this->isforumid = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setArtimage( $value ) {
        $value = ( isset( $value ) && !empty( $value ) ) ? $value : '' ;
        $this->articleimg = xoops_trim( $value );
    }

    function setSpotlight( $value ) {
        $this->spotlight = ( intval( $value ) ) ? 1 : 0 ;
    }

    function setSpotlightMain( $value, $sponser ) {
        $value = ( isset( $sponser ) && $value == 1 ) ? 1 : 0 ;
        $sponser = ( isset( $sponser ) && $sponser == 1 ) ? 1 : 0 ;
        if ( $sponser == 1 ) {
            $sql = "UPDATE " . $this->table . " SET spotlightmain='0' WHERE spotlightmain = '2' ";
            $result = $this->db->query( $sql );
            $value = 2;
        }
        $this->spotlightmain = $value;
    }

    function setVersion( $value, $update = 0 ) {
        global $xoopsModuleConfig;

        $version = ( $value == $this->version ) ? $this->version : $value;

        if ( ( isset( $update ) && $update == 1 ) && $version == $this->version ) {
            $this->version = ( $value == $this->version ) ? ( $this->version + $xoopsModuleConfig['version_inc'] ) : $value;
        } else {
            $this->version = $version;
        }
        return $this->version;
    }

    function setApproved( $value ) {
        $this->approved = ( intval( $value ) ) ? 1 : 0 ;
    }

    function approve( $articleid = 0 ) {
        if ( !$articleid ) {
            $this->approved = 1;
            $this->published = time();
            $table = $this->table;
            $articleid = $this->articleid;
            $approved = $this->approved;
            $published = $this->published;
            $db = $this->db;
        } else {
            $db = &Database::getInstance();
            $table = $db->prefix( WFS_ARTICLE_DB );
            $published = time();
        }

        $sql = "UPDATE $table SET published = $published WHERE articleid = $articleid";
        if ( !$result = $db->queryF( $sql ) ) {
            $error = "Error while approving this article: <br /><br />" . $sql . "<br /><br />";
            trigger_error( $error, E_USER_ERROR );
        }
        return true;
    }
    // store to database
    // return: true/false
    function store( $isRestore = false ) {
        global $myts, $xoopsDB, $xoopsModuleConfig, $xoopsUser;

        if ( get_magic_quotes_gpc() ) { // if get_magic_quotes_gpc enabled, module.textsanitizer::addSlashes will skip
            $this->title = addSlashes( $this->title );
            $this->maintext = addSlashes( $this->maintext );
            $this->summary = addSlashes( $this->summary );
            $this->usertype = addSlashes( $this->usertype );
            $this->htmlpage = addSlashes( $this->htmlpage );
            $this->pdfpage = addSlashes( $this->pdfpage );
            $this->articleimg = addSlashes( $this->articleimg );
            $this->subtitle = addSlashes( $this->subtitle );
            $this->url = ( $this->url != 'http://' && $this->url != 'https://' ) ? addSlashes( $this->url ) : '';
            $this->urlname = addSlashes( $this->urlname );
            $this->wrapurl = ( $this->wrapurl != 'http://' && $this->wrapurl != 'https://' ) ? addSlashes( $this->wrapurl ) : '';
        } else {
            $this->title = $this->title;
            $this->maintext = $this->maintext;
            $this->summary = $this->summary;
            $this->usertype = $this->usertype;
            $this->htmlpage = $this->htmlpage;
            $this->pdfpage = $this->pdfpage;
            $this->articleimg = $this->articleimg;
            $this->subtitle = $this->subtitle;

            $this->url = ( $this->url != 'http://' && $this->url != 'https://' ) ? $this->url : '';
            $this->urlname = $this->urlname;
            $this->wrapurl = ( $this->wrapurl != 'http://' && $this->wrapurl != 'https://' ) ? $this->wrapurl : '';
        }

        $this->offline = intval( $this->offline );
        $this->page = intval( $this->page );
        $this->version = $this->version;
        $this->spotlightmain = intval( $this->spotlightmain );
        $this->uid = ( intval( $this->uid ) ) ? intval( $this->uid ) : $xoopsUser->uid();
        $this->spotlight = intval( $this->spotlight );
        $this->isframe = intval( $this->isframe );
        $this->expired = intval( $this->expired );
        $this->notifypub = intval( $this->notifypub );
        $this->weight = intval( $this->weight );
        $this->noshowart = intval( $this->noshowart );
        $this->weight = intval( $this->weight );
        $this->cmainmenu = intval( $this->cmainmenu );
        $this->isforumid = intval( $this->isforumid );

        if ( $isRestore ) $this->approved = 1;

        $sql = "SELECT mm_id FROM " . $this->mainmenutable . " WHERE ca_id = " . $this->articleid . "  ";
        $result = $this->db->query( $sql );
        list( $mm_id ) = $this->db->fetchRow( $result );

        if ( $mm_id ) {
            if ( $this->cmainmenu ) {
                $sql = "UPDATE " . $this->mainmenutable . " SET ca_id = " . $this->articleid . ",  mm_title = '" . $this->title . "', groupid = '" . $this->groupid . "', weight = '" . $this->weight . "' WHERE ca_id = " . $this->articleid . " AND istype = 1 ";
            } else {
                $sql = "DELETE FROM " . $this->mainmenutable . " WHERE ca_id = " . $this->articleid . " AND istype = '1' ";
            }
        } else {
            if ( $this->cmainmenu ) {
                $sql = "INSERT INTO " . $this->mainmenutable . " (mm_id, ca_id, mm_title, istype, groupid, weight) VALUES (NULL, " . $this->articleid . ", '" . $this->title . "', '1', '" . $this->groupid . "', '" . $this->weight . "')";
            }
        }
        $result = $this->db->query( $sql );
        unset( $sql );

        $this->expired = !empty( $this->expired ) ? $this->expired : 0;
        $this->published = ( $this->approved == 1 ) ? ( ( $this->published ) ? $this->published : time() ) : 0;

        if ( !$this->articleid ) {
            $this->created = time();
            $this->changed = 0;
            $this->counter = 0;

            $sql = "INSERT INTO " . $this->table . " (
                    articleid, groupid, categoryid, weight, title, subtitle, maintext, summary,
                                url, urlname, created, published, expired, usertype, nohtml, nosmiley,
                                noxcodes, nobreaks, notifypub, allowcom, uid, htmlpage, pdfpage, isframe, offline,
                                page, noshowart, cmainmenu, counter, isforumid, articleimg, wrapurl, version,
                                spotlight, spotlightmain
                                ) VALUES (
                                0, '" . $this->groupid . "', " . $this->categoryid . ", " . $this->weight . ",
                                '" . $this->title . "', '" . $this->subtitle . "', '" . $this->maintext . "', '" . $this->summary . "',
                                '" . $this->url . "', '" . $this->urlname . "', " . $this->created . ", " . $this->published . ",
                                " . $this->expired . ", '" . $this->usertype . "'," . $this->nohtml . ", " . $this->nosmiley . ",
                                " . $this->noxcodes . ", " . $this->nobreaks . ", " . $this->notifypub . ", " . $this->allowcom . ",
                                " . $this->uid . ",        '" . $this->htmlpage . "', '" . $this->pdfpage . "' ," . $this->isframe . ", " . $this->offline . ",
                                " . $this->page . ", " . $this->noshowart . ", " . $this->cmainmenu . ", " . $this->counter . ",
                                " . $this->isforumid . ", '" . $this->articleimg . "', '" . $this->wrapurl . "', " . $this->version . ",
                                " . $this->spotlight . ", " . $this->spotlightmain . " )";
            $error = "Error while creating article: <br /><br />" . $sql . "<br /><br />";
        } else {
            if ( $this->approved != 1 ) {
                $this->changed = time();
            }

            $sql = "UPDATE " . $this->table . " SET
                                groupid = '" . $this->groupid . "',
                                categoryid = " . $this->categoryid . ",
                                weight = " . $this->weight . ",
                    title = '" . $this->title . "',
                                subtitle = '" . $this->subtitle . "',
                                maintext = '" . $this->maintext . "',
                                summary = '" . $this->summary . "',
                    url = '" . $this->url . "',
                                urlname = '" . $this->urlname . "',
                                created = " . $this->created . ",
                                published = " . $this->published . ",
                    expired = " . $this->expired . ",
                                changed = " . $this->changed . ",
                                nohtml = " . $this->nohtml . ",
                                nosmiley = " . $this->nosmiley . ",
                                noxcodes = " . $this->noxcodes . ",
                                nobreaks = " . $this->nobreaks . ",
                                allowcom = " . $this->allowcom . ",
                                uid = " . $this->uid . ",
                                htmlpage = '" . $this->htmlpage . "',
                                pdfpage = '" . $this->pdfpage . "',
                                isframe = " . $this->isframe . ",
                                offline = " . $this->offline . ",
                                page = " . $this->page . ",
                                noshowart = " . $this->noshowart . ",
                                cmainmenu = " . $this->cmainmenu . ",
                                isforumid = " . $this->isforumid . ",
                                articleimg = '" . $this->articleimg . "',
                                wrapurl = '" . $this->wrapurl . "',
                                version = " . $this->version . ",
                                spotlight = " . $this->spotlight . ",
                                spotlightmain = " . $this->spotlightmain . "

                                WHERE articleid=" . $this->articleid;
            $error = "Error while updating this article: <br /><br />" . $sql . "<br /><br />";
        }
        if ( !$result = $this->db->queryF( $sql ) ) {
            trigger_error( $error, E_USER_ERROR );
        } else {
            $this->articleid = ( $this->articleid ) ? $this->articleid : $this->db->getInsertId();
        }

        if ( $xoopsModuleConfig['use_restore'] && !$isRestore ) {
            $restore_date = time();

            $sql2 = "INSERT INTO " . $this->restoretable . " (
                    restore_id, restore_date, articleid, groupid, categoryid, weight,
                                title, subtitle, maintext, summary, url, urlname, created, published, expired, changed, usertype, nohtml,
                                nosmiley, noxcodes, nobreaks, notifypub, allowcom, uid, htmlpage, pdfpage, isframe, offline, page, noshowart, cmainmenu,
                                counter, isforumid, articleimg, wrapurl, version, spotlight, spotlightmain ) VALUES (
                                ''," . $restore_date . "," . $this->articleid . ", '" . $this->groupid . "', " . $this->categoryid . ", " . $this->weight . ",
                                '" . $this->title . "', '" . $this->subtitle . "', '" . $this->maintext . "', '" . $this->summary . "',
                                '" . $this->url . "', '" . $this->urlname . "', " . $this->created . ", " . $this->published . ",
                                " . $this->expired . ", " . $this->changed . ", '" . $this->usertype . "'," . $this->nohtml . ", " . $this->nosmiley . ",
                                " . $this->noxcodes . ", " . $this->nobreaks . ", " . $this->notifypub . ", " . $this->allowcom . ",
                                " . $this->uid . ",        '" . $this->htmlpage . "', '" . $this->pdfpage . "'," . $this->isframe . ", " . $this->offline . ",
                                " . $this->page . ", " . $this->noshowart . ", " . $this->cmainmenu . ", " . $this->counter . ",
                                " . $this->isforumid . ", '" . $this->articleimg . "', '" . $this->wrapurl . "', " . $this->version . ",
                                " . $this->spotlight . ", " . $this->spotlightmain . " )";

            if ( !$result = $this->db->queryF( $sql2 ) ) {
                $error = "Error while backuping article: <br /><br />" . $sql2;
                trigger_error( $error, E_USER_ERROR );
            }
        }
        return true;
    }

    /**
     * Public
     * Get article vars etc from here.
     */
    function getArticle( $articleid ) {
        $sql = "SELECT * FROM " . $this->table . " WHERE articleid=" . $articleid . " ";
        $array = $this->db->fetchArray( $this->db->query( $sql ) );
        if ( !is_array( $array ) ) {
            unset( $this );
            return false;
        }
        $this->makeArticle( $array );
    }

    function makeArticle( $array ) {
        foreach( $array as $key => $value ) {
            $this->$key = $value;
        }
    }

    function delete() {
        global $xoopsDB, $xoopsConfig, $xoopsModule;

        $sql = "DELETE FROM " . $this->table . " WHERE articleid=" . $this->articleid . "";

        if ( !$result = $this->db->query( $sql ) ) {
            return false;
        }

        if ( isset( $this->commentstable ) && $this->commentstable != "" ) {
            xoops_comment_delete( $xoopsModule->getVar( 'mid' ), $this->articleid );
        }
        // $this->getAllFiles = WfsFiles::getAllfiles(0, 0, $this->articleid);
        if ( $this->getAllFiles = WfsFiles::getAllfiles( 0, 0, $this->articleid ) ) {
            foreach( $this->files as $file ) {
                $file->delete();
            }
        }
        $sql = "DELETE FROM " . $this->mainmenutable . " WHERE ca_id = " . $this->articleid . " AND istype =1";
        if ( !$result = $this->db->queryF( $sql ) ) {
            // return false;
        }

        $sql = "DELETE FROM " . $this->restoretable . " WHERE articleid = " . $this->articleid . "";
        if ( !$result = $this->db->queryF( $sql ) ) {
            return false;
        }
        return true;
    }

    function updateCounter() {
        global $xoopsUser, $xoopsModule;

        if ( !( is_object( $xoopsUser ) && $xoopsUser->isAdmin( $xoopsModule->mid() ) ) ) {
            $sql = "UPDATE " . $this->table . " SET counter=counter+1 WHERE articleid=" . $this->articleid . "";
            if ( !$result = $this->db->queryF( $sql ) ) {
                return false;
            }
        }
    }

    function articleid() {
        return $this->articleid;
    }

    function categoryid() {
        return $this->categoryid;
    }

    function categoryTitle() {
        return $this->category->title( "S" );
    }

    function uid() {
        return $this->uid;
    }

    function uname() {
        global $xoopsModuleConfig;
        $user_name = WFS_getLinkedUnameFromId( $this->uid(), $xoopsModuleConfig['displayname'], 1 );
        return $user_name;
    }

    function title( $format = "S" ) {
        global $xoopsModuleConfig;
        $myts = &MyTextSanitizer::getInstance();

        $title = ( get_magic_quotes_gpc() ) ? stripslashes( $this->title ) : $this->title;
        switch ( $format ) {
            case "S":
                if ( $xoopsModuleConfig['shortartlen'] > 0 ) {
                    $title = xoops_substr( $title, 0, intval( $xoopsModuleConfig['shortartlen'] ), $trimmarker = '...' );
                }
                $title = $myts->htmlSpecialChars( $title );
                break;
            case "E":
                $title = $myts->htmlSpecialChars( $title );
                break;
        }
        return $title;
    }

    function subtitle( $format = "S" ) {
        $myts = &MyTextSanitizer::getInstance();

        $subtitle = ( get_magic_quotes_gpc() ) ? stripslashes( $this->subtitle ) : $this->subtitle;
        switch ( $format ) {
            case "S":
                $subtitle = $myts->htmlSpecialChars( $subtitle );
                break;
            case "E":
                $subtitle = $myts->htmlSpecialChars( $subtitle );
                break;
        }
        return $subtitle;
    }

    function maintext( $format = "S", $page = -1 ) {
        global $xoopsModule, $wfsWiki, $xoopsModuleConfig;

        $myts = &MyTextSanitizer::getInstance();

        $html = ( $this->nohtml ) ? 0 : 1;
        $smiley = ( $this->nosmiley ) ? 0 : 1;
        $xcodes = ( $this->noxcodes ) ? 0 : 1;
        $breaks = ( $this->nobreaks ) ? 1 : 0;

        $maintext = ( get_magic_quotes_gpc() ) ? stripslashes( $myts->censorString( $this->maintext ) ) : $myts->censorString( $this->maintext );

        if ( $page >= 0 ) {
            $maintext = preg_replace( "/\[title](.*)\[\/title\]/sU", "[pagebreak]", $maintext );
            $maintext = str_replace( "<P>[pagebreak]</P>", "[pagebreak]", $maintext );
            $maintextarr = explode( "[pagebreak]", $maintext );
            if ( $page > count( $maintextarr ) ) {
                $maintext = $maintextarr[count( $maintextarr )];
            } else {
                $maintext = $maintextarr[$page];
            }
        }

        switch ( $format ) {
            case "S":
                if ( $xoopsModuleConfig['phpcoding'] ) {
                    $maintext = $this->encode_highlight_php( $maintext );
                }
                if ( $xoopsModuleConfig['wiki'] ) {
                    $maintext = make_link( $maintext );
                }
                $maintext = $myts->displayTarea( $maintext, $html, $smiley, $xcodes, 0, $breaks );
                break;

            case "E":
                $maintext = str_replace( "<BR>", "<br />", $maintext );
                $maintext = $myts->displayTarea( $maintext, 1, 0, 0, 0, 0 );
                break;

            case "N":
                $maintext = str_replace( "<BR>", "<br />", $maintext );
                $maintext = $myts->htmlSpecialChars( $maintext );
                break;

            case "O": // get original text from database
                break;
        }
        return $maintext;
    }
    // returns the count of the pages
    function maintextPages() {
        $maintextarr = 1;
        $maintext = preg_replace( "/\[title](.*)\[\/title\]/sU", "[pagebreak]", $this->maintext );
        $maintextarr = explode( "[pagebreak]", $maintext );
        return count( $maintextarr );
    }

    function maintextWithFile( $format = "Show", $page = "" ) {
        global $xoopsModule;

        $maintext = $this->maintext( $format, $page );

        $this->getAllFiles();
        foreach( $this->files as $file ) {
            // $maintext .= "<br>&nbsp;".$file->getIconLink();
            $maintext .= $file->getLinkedName( XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/download.php?fileid=" );
            $maintext .= "&nbsp;(&nbsp;" . $file->getMimetype() . "&nbsp;)";
            $maintext .= "<br>&nbsp;&nbsp;Downloads";
            $maintext .= "&nbsp;(" . $file->getCounter() . ")";
            $maintext .= "<br />";
        }
        return $maintext;
    }

    function summary( $format = "S" ) {
        $myts = &MyTextSanitizer::getInstance();
        $summary = ( get_magic_quotes_gpc() ) ? stripslashes( $myts->censorString( $this->summary ) ) : $myts->censorString( $this->summary );
        switch ( $format ) {
            case "S":
                global $xoopsModuleConfig;

                $html = ( $this->nohtml ) ? 0 : 1;
                $smiley = ( $this->nosmiley ) ? 0 : 1;
                $xcodes = ( $this->noxcodes ) ? 0 : 1;
                $breaks = ( $this->nobreaks ) ? 1 : 0;
                // $summary = $this->summary;
                if ( ( isset( $xoopsModuleConfig['autosummary'] ) && $xoopsModuleConfig['autosummary'] == 1 ) && empty( $this->summary ) ) {
                    $summary = strip_tags( $myts->htmlSpecialChars( $summary ), "<br />" );
                    $summary = wfs_summarize( $summary, $xoopsModuleConfig['summary_amount'] );
                }
                $summary = $myts->displayTarea( $summary, $html, $smiley, $xcodes, 0, $breaks );
                break;
            case "E":
                $summary = $myts->htmlSpecialChars( $summary );
                break;
        }
        return $summary;
    }

    function url( $format = "S" ) {
        global $myts;
        $url = ( get_magic_quotes_gpc() ) ? stripslashes( $this->url ) : $this->url;
        switch ( $format ) {
            case "S":
                $url = $myts->htmlSpecialChars( $url );
                break;
            case "E":
                $url = $myts->htmlSpecialChars( $url );
                break;
        }
        return $url;
    }

    function urlname( $format = "S" ) {
        global $myts;
        $urlname = ( get_magic_quotes_gpc() ) ? stripslashes( $this->urlname ) : $this->urlname;
        switch ( $format ) {
            case "S":
                $urlname = ( !empty( $urlname ) ) ? $urlname: _WFS_VISITWEBSITE;
                break;
            case "E":
                $urlname = $myts->htmlSpecialChars( $urlname );
                break;
        }
        return $urlname;
    }

    function wrapurl( $format = "S" ) {
        global $myts;
        switch ( $format ) {
            case "S":
                $this->wrapurl = ( $this->wrapurl != 'http://' && $this->wrapurl != 'https://' ) ? $this->wrapurl : '';
                $wrapurl = ( !empty( $this->wrapurl ) ) ? $this->wrapurl : _WFS_VISITWEBSITE;
                break;
            case "E":
                $wrapurl = $myts->htmlspecialchars( $this->wrapurl );
                break;
        }
        return $wrapurl;
    }

    function counter() {
        return $this->counter;
    }

    function created( $format = "E" ) {
        global $xoopsModuleConfig;
        switch ( $format ) {
            case "S":
                $created = formatTimestamp( $this->created, "$xoopsModuleConfig[timestamp]" );
                break;
            case "E":
                $created = $this->created;
                break;
        }
        return $created;
    }

    function htmlpage() {
        return $this->htmlpage;
    }

    function pdfpage() {
        return $this->pdfpage;
    }

    function isframe() {
        return $this->isframe;
    }

    function changed() {
        return $this->changed;
    }

    function nohtml() {
        return $this->nohtml;
    }

    function nosmiley() {
        return $this->nosmiley;
    }

    function noxcodes() {
        return $this->noxcodes;
    }
    function nobreaks() {
        return $this->breaks;
    }

    function page() {
        return $this->page;
    }

    function notifypub() {
        return $this->notifypub;
    }

    function usertype() {
        return $this->usertype;
    }

    function published( $format = "E" ) {
        global $xoopsModuleConfig;
        switch ( $format ) {
            case "S":
                $published = ( $this->published > '0' ) ? formatTimestamp( $this->published, "$xoopsModuleConfig[timestamp]" ) : "" . _AM_WFS_NOTPUBLISHED . "";
                break;
            case "E":
                $published = ( $this->published > '0' ) ? $this->published : 0;
                break;
        }
        return $published;
    }

    function expired() {
        return $this->expired;
    }
    function groupid() {
        return $this->groupid;
    }
    function offline() {
        return $this->offline;
    }
    function weight() {
        return $this->weight;
    }
    function approved() {
        return $this->approved;
    }
    function noshowart() {
        return $this->noshowart;
    }
    function rating() {
        return $this->rating;
    }
    function votes() {
        return $this->votes;
    }
    function cmainmenu() {
        $this->cmainmenu = ( $this->cmainmenu == 1 ) ? 1 : 0;
        return $this->cmainmenu;
    }
    function isforumid() {
        return $this->isforumid;
    }
    function summarybreak() {
        return $this->summarybreak;
    }

    function spotlight() {
        $spotlight = ( $this->spotlight == 1 ) ? 1 : 0;
        return $spotlight;
    }

    function spotlightmain() {
        $spotlightmain = ( $this->spotlightmain == 1 ) ? 1 : 0;
        return $spotlightmain;
    }

    function version() {
        return $this->version;
    }

    function articleimg( $format = "S", $size = 0, $artimg = 0 ) {
        global $wfsPathConfig, $xoopsModuleConfig;
        switch ( $format ) {
            case "S":

                $image_thumb = '';

                if ( $xoopsModuleConfig['display_default_image'] == 4 || ( empty( $xoopsModuleConfig['default_image'] ) && !$this->articleimg ) ) {
                    return $image_thumb;
                }
                $this_image = ( $this->articleimg && $this->articleimg != '' ) ? $this->articleimg : $xoopsModuleConfig['default_image'];

                if ( $xoopsModuleConfig['display_default_image'] == 1 && $artimg == 0 ) {
                    $image_thumb = $this_image;
                } elseif ( $xoopsModuleConfig['display_default_image'] == 2 && $artimg == 1 ) {
                    $image_thumb = $this_image;
                } elseif ( $xoopsModuleConfig['display_default_image'] == 3 ) {
                    $image_thumb = $this_image;
                } else {
                    $image_thumb = '';
                }

                if ( !empty( $image_thumb ) ) {
                    switch ( $size ) {
                        case "1":
                        default:
                            $height = 300;
                            $width = 200;
                            break;
                        case "2":
                            $height = 60;
                            $width = 60;
                            break;
                        case "3":
                            $height = 150;
                            $width = 150;
                            break;
                        case "4":
                            $height = 100;
                            $width = 100;
                            break;
                    }
                    $image_thumb = ( $xoopsModuleConfig['use_thumbs'] ) ? wfs_createthumb( $image_thumb, $wfsPathConfig['graphicspath'], "thumbs", $height, $width, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : WFS_ARTICLEIMG_URL . '/' . $image_thumb;
                }
                break;

            case "E":
                $image_thumb = $myts->htmlSpecialChars( stripslashes( $this->articleimg ) );
                break;
        }
        return $image_thumb;
    }

    function email() {
        global $xoopsUser, $xoopsModuleConfig, $myts;

        $email = '';
        if ( $xoopsModuleConfig['displayemail'] != 3 ) {
            $user = new XoopsUser( $this->uid );
            $email = $user->email();

            if ( $xoopsModuleConfig['displayemail'] == 2 ) {
                $email = checkEmail( $email, $antispam = true );
            }
            $email = "(" . $myts->makeclickable( $email ) . ")";
        }
        return $email;
    }
    // Start of html output
    function getCommentsCount() {
        global $xoopsModule;
        $count = xoops_comment_count( $xoopsModule->getVar( 'mid' ), $this->articleid );
        return $count;
    }

    function getNicePathToPid( $funcURL ) {
        $ret = $category->getNicePathToPid( $funcURL );
        return $ret;
    }
    // public - WfsArticle::* style
    function getAllArticle( $limit = 0, $start = 0, $query_sting = '', $category = '', $user = '', $orderby = 'articleid DESC', $asobject = true ) {
        global $xoopsModuleConfig;

        $sql_queries = array( 'all' => '',
            'published' => "published > 0 and published <= " . time() . " and expired = 0",
            'autoart' => "published > " . time(),
            'submitted' => "published = 0 and offline = 0",
            'online' => "published > 0 AND published <= " . time() . " AND noshowart = 0 AND offline = 0 AND (expired = 0 OR expired > " . time() . ")",
            'offline' => "published > 0 and offline = 1",
            'expired' => "expired > 0 and expired < " . time(),
            'autoexpire' => "expired > " . time(),
            'noshowart' => "noshowart = 1",
            'ishtml' => "htmlpage != ''",
            'spotlight' => "spotlight >=1",
            'spotlightmain' => "spotlightmain >=1",
            'nospotlight' => "spotlight =0 ",
            'nospotlightmain' => "spotlightmain =0"
            );

        $queries = explode( "|", $query_sting );
        $sql_query = "";
        foreach( $queries as $query ) {
            $sql_query .= ( trim( $sql_query ) ) ? " AND ":"";
            $sql_query .= $sql_queries[$query];
        }
        $query_category = ( $category )?" categoryid = $category" : "";
        $query_user = ( $user )?" uid=$user":"";
        $query_orderby = ( $orderby ) ? " ORDER BY $orderby": ( $xoopsModuleConfig['cidxorder']?" ORDER BY " . $xoopsModuleConfig['cidxorder'] . "":"" );

        if ( trim( $query_category ) ) {
            if ( trim( $sql_query ) ) $sql_query .= " AND " . $query_category;
            else $sql_query .= $query_category;
        }
        if ( trim( $query_user ) ) {
            if ( trim( $sql_query ) ) $sql_query .= " AND " . $query_user;
            else $sql_query .= $query_user;
        }
        if ( trim( $sql_query ) ) $sql_query = "WHERE " . $sql_query;
        if ( trim( $query_orderby ) ) {
            if ( trim( $sql_query ) ) $sql_query .= " " . $query_orderby;
            else $sql_query .= $query_orderby;
        }

        $db = &Database::getInstance();
        $myts = &MyTextSanitizer::getInstance();
        $ret = array();

        $sql = "SELECT * FROM " . $db->prefix( WFS_ARTICLE_DB ) . " " . $sql_query;
        // echo "<br />sql query:".$sql;
        $result = $db->query( $sql, $limit, $start );

        while ( $myrow = $db->fetchArray( $result ) ) {
            if ( !wfs_checkAccess( $myrow['groupid'] ) )
                Continue;

            if ( $asobject == true ) {
                $ret[] = new WfsArticle( $myrow );
            } else {
                $ret[$myrow['articleid']] = $myts->makeTboxData4Show( $myrow['title'] );
            }
        }
        return $ret;
    }

    function articleselection( $action, $category, &$actions_in ) {
        global $actions;

        $_actions = ( is_array( $actions_in ) ) ? $actions_in : $actions;

        echo "<select size='1' name='typeselect' onchange='location.href=\"allarticles.php?category=$category&action=\"+this.options[this.selectedIndex].value'>";
        foreach( $_actions as $key => $values ) {
            $opt_selected = "";
            if ( $key == $action ) {
                $opt_selected = "selected='selected'";
            }
            echo "<option value='" . $key . "' $opt_selected>" . $values['title'] . "</option>";
        }
        echo "</select>";
    }

    function getByCategory( $categoryid ) {
        $db = &Database::getInstance();
        $ret = array();
        $result = $db->query( "SELECT * FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE categoryid=$categoryid ORDER BY articleid DESC" );
        while ( $myrow = $db->fetchArray( $result ) ) {
            if ( !wfs_checkAccess( $myrow['groupid'] ) )
                Continue;
            $ret[] = new WfsArticle( $myrow );
        }
        return $ret;
    }

    /**
     * WfsArticle::countByCategory()
     *
     * @param integer $categoryid
     * @param integer $nonspotlight
     * @return
     */
    function countByCategory( $categoryid = 0, $nonspotlight = 0, $recurse = 1 ) {
        // global $mytree;
        $count = 0;

        $db = &Database::getInstance();
        $sql = "SELECT groupid FROM " . $db->prefix( WFS_ARTICLE_DB ) . " ";
        $sql .= " where (published > 0 AND published <= " . time() . ") AND (expired = 0 OR expired > " . time() . ") AND noshowart = 0 AND offline = '0' ";

        if ( $nonspotlight == 1 ) {
            $sql .= " and spotlight = 1";
        } elseif ( $nonspotlight == 0 ) {
            $sql .= " and spotlight = 0";
        }
        if ( $categoryid )
            $sql .= " and categoryid=$categoryid";
        $result = $db->query( $sql );

        if ( $result ) {
            while ( $myrow = $db->fetchArray( $result ) ) {
                if ( !wfs_checkAccess( $myrow['groupid'] ) )
                    Continue;
                $count++;
            }
            if ( $recurse == 1 ) {
                $xt = new WfsCategory( $categoryid );
                $arr = $xt->getAllChildId( $categoryid );
                $newcount = 0;
                for( $i = 0;$i < count( $arr );$i++ ) {
                    $sql2 = "SELECT articleid, groupid FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0 AND noshowart = 0 AND categoryid =" . $arr[$i] . "";
                    $result2 = $db->query( $sql2 );
                    while ( $myrow2 = $db->fetchArray( $result2 ) ) {
                        if ( !wfs_checkAccess( $myrow['groupid'] ) )
                            Continue;
                        $newcount++;
                    }
                    $count += $newcount;
                }
            }
            return $count;
        }
    }

    /**
     * WfsArticle::getLastChangedByCategory()
     *
     * @param integer $categoryid
     * @return
     */
    function getLastChangedByCategory( $categoryid = 0 ) {
        $db = &Database::getInstance();

        $xt = new WfsCategory( $categoryid );
        $arr = $xt->getAllChildId( $categoryid );

        $sql = "SELECT MAX(changed) FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0";
        if ( $categoryid != 0 )
            $sql .= " AND categoryid=$categoryid ";
        list( $changed ) = $db->fetchRow( $db->query( $sql ) );

        if ( empty( $changed ) ) {
            $sql = "SELECT MAX(published) FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0";
            if ( $categoryid != 0 )
                $sql .= " AND categoryid=$categoryid ";
            $result = $db->query( $sql );
            list( $changed ) = $db->fetchRow( $result );
        }

        for( $i = 0;$i < count( $arr );$i++ ) {
            $sql2 = "SELECT MAX(changed) FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0 AND noshowart = 0 AND categoryid =" . $arr[$i] . "";
            $result2 = $db->query( $sql2 );
            while ( list( $newchanged ) = $db->fetchRow( $result2 ) ) {
                if ( $newchanged == 0 ) {
                    $sql3 = "SELECT MAX(published) FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE published < " . time() . " AND published > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0 AND noshowart = 0 AND categoryid =" . $arr[$i] . "" ;
                    if ( $categoryid != 0 ) $sql3 .= " AND categoryid=$categoryid ";

                    $result = $db->query( $sql3 );
                    list( $newchanged ) = $db->fetchRow( $result );
                }
                $changed = ( $newchanged > $changed ) ? $newchanged : $changed;
            }
        }
        return $changed;
    }
    /**
     * WfsArticle::getLastChangedByCategory()
     *
     * @param integer $categoryid
     * @return
     */
    function getLastArticleByCategory( $categoryid = 0, $order_flag = "published" ) {
        $db = &Database::getInstance();

        $xt = new WfsCategory( $categoryid );
        $arr = $xt->getAllChildId( $categoryid );

        $sql = "SELECT articleid,$order_flag FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE $order_flag < " . time() . " AND $order_flag > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0";
        if ( $categoryid != 0 )
            $sql .= " AND categoryid=$categoryid";
        $sql .= " ORDER BY $order_flag DESC";
        $result = $db->query( $sql );
        list( $articleid, $order ) = $db->fetchRow( $result );
        $last_article = $articleid;

        for( $i = 0;$i < count( $arr );$i++ ) {
            $sql1 = "SELECT articleid,$order_flag FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE $order_flag < " . time() . " AND $order_flag > 0 AND (expired = 0 OR expired > " . time() . ") AND offline = 0 AND noshowart = 0 AND categoryid =" . $arr[$i] . "" ;
            if ( $categoryid != 0 ) $sql1 .= " AND categoryid=$categoryid ";
            $sql1 .= " ORDER BY order_flag DESC";

            $result = $db->query( $sql1 );
            list( $articleid, $neworder ) = $db->fetchRow( $result );
            if ( $neworder > $order ) {
                $order = $neworder;
                $last_article = $articleid;
            }
        }
        return $last_article;
    }
    /**
     * article title link
     */
    function textLink( $format = "S" ) {
        if ( $this->url ) {
            $ret = "<a href='" . formatURL( $this->url ) . "' target='_blank'>" . $this->title( "S" ) . "</a>";
        } else {
            $ret = "<a href='" . WFS_URL . "/article.php?articleid=" . $this->articleid() . "'>" . $this->title( "S" ) . "</a>";
        }
        return $ret;
    }

    /**
     * read more ...
     */
    function morelink() {
        global $myts;

        if ( $this->url ) {
            $urlname = ( $this->urlname ) ? $this->urlname: $this->url;
            $ret = "<a href='" . formatURL( $this->url ) . "' target='_blank'>" . _WFS_VISIT . $myts->htmlSpecialChars( $myts->stripSlashesGPC( $urlname ) ) . "</a>";
        } else {
            $ret = "<a href='" . WFS_URL . "/article.php?articleid=" . $this->articleid . "'>" . _WFS_READMORE . "</a>";
        }
        return $ret;
    }

    function admintextLink() {
        // global $xoopsModuleConfig;
        $ret = "<a href='" . WFS_URL . "/article.php?articleid=" . $this->articleid() . "'>" . $this->title( "S" ) . "</a>";
        return $ret;
    }
    /**
     * Links for admin eidt and delete
     */
    function adminlink() {
        global $xoopsUser, $xoopsModule;

        if ( is_object( $xoopsUser ) && $xoopsUser->isAdmin( $xoopsModule->mid() ) ) {
            $ret = " [ <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/index.php?op=edit&amp;articleid=" . $this->articleid() . "'>" . _EDIT . "</a> | <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/admin/index.php?op=delete&amp;articleid=" . $this->articleid() . "'>" . _DELETE . "</a> ] ";
        } elseif ( $xoopsUser && $this->uid() == $xoopsUser->getvar( 'uid' ) ) {
            $ret = " [ <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/submit.php?op=edit&amp;articleid=" . $this->articleid() . "'>" . _EDIT . "</a> ]";
        } else {
            $ret = '';
        }
        return $ret;
    }

    /**
     * Link for external links to outside articles
     */
    function relatedlink() {
        global $myts;

        $ret = '';
        $this->url = ( $this->url != 'http://' && $this->url != 'https://' ) ? $this->url : '';
        if ( $this->url ) {
            $urlname = ( $this->urlname ) ? $this->urlname: $this->url;
            $ret = "<a href='" . formatURL( $this->url ) . "' target='_blank'>" . _WFS_VISIT . $myts->htmlSpecialChars( $myts->stripSlashesGPC( $urlname ) ) . "</a>";
        }
        return $ret;
    }

    /**
     * Thanks to Predator for this little one.
     */
    function encode_highlight_php( $text ) {
        $matches = array();
        $match_count = preg_match_all( "#\[php\](.*?)\[/php\]#si", $text, $matches );
        for ( $i = 0; $i < $match_count; $i++ ) {
            $before_replace = $matches[1][$i];
            $after_replace = strip_tags( trim( $matches[1][$i] ) ) ;
            $str_to_match = "[php]" . $before_replace . "[/php]";
            $replacement = "";
            $after_replace = str_replace( '<', '<', $after_replace );
            $after_replace = str_replace( '>', '>', $after_replace );
            $after_replace = str_replace( '&', '&', $after_replace );
            $added = false;
            if ( preg_match( '/^<\?.*?\?>$/si', $after_replace ) <= 0 ) {
                $after_replace = "<?php $after_replace ?>";
                $added = true;
            }
            if ( strcmp( '4.2.0', phpversion() ) > 0 ) {
                ob_start();
                highlight_string( $after_replace );
                $after_replace = ob_get_contents();
                ob_end_clean();
            } else {
                $after_replace = highlight_string( $after_replace, true );
            }
            if ( $added == true ) {
                $after_replace = str_replace( '<font color="#0000BB">&lt;?php <br>', '<font color="#0000BB">', $after_replace );
                $after_replace = str_replace( '<font color="#0000BB"><br>?&gt;</font>', '', $after_replace );
            }
            $after_replace = preg_replace( '/<font color="(.*?)">/si', '<span style="color: \\1;">', $after_replace );
            $after_replace = str_replace( '</font>', '</span>', $after_replace );
            $after_replace = str_replace( "\n", '', $after_replace );
            $replacement .= $after_replace;
            $text = str_replace( $str_to_match, $replacement, $text );
        }
        return $text;
    }

    function searchByTitle( $title, $limit = 0, $start = 0, $category = 0 ) {
        $db = &Database::getInstance();
        $ret = array();
        // full match
        $sql = "SELECT * FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE title='$title'";
        if ( !empty( $category ) ) {
            $sql .= " and categoryid=$category";
        } else {
            $sql .= " ORDER BY categoryid";
        }
        $result = $db->query( $sql, $limit, $start );
        while ( $myrow = $db->fetchArray( $result ) ) {
            $ret[] = new WfsArticle( $myrow );
        }
        if ( $ret ) {
            return $ret;
        }
        // partical match
        $sql = "SELECT * FROM " . $db->prefix( WFS_ARTICLE_DB ) . " WHERE title LIKE '%$title%'";
        if ( !empty( $category ) ) {
            $sql .= " and categoryid=$category";
        } else {
            $sql .= " ORDER BY categoryid";
        }
        $result = $db->query( $sql, $limit, $start );
        while ( $myrow = $db->fetchArray( $result ) ) {
            $ret[] = new WfsArticle( $myrow );
        }

        return $ret;
    }

    function getAllFiles( $limit = 10, $start = 0, $articleid = 0, $uid = 0, $orderby = "fileid DESC", $asobject = true ) {
        $this->files = WfsFiles::getAllfiles( $limit, $start, $this->articleid, $uid, $orderby, $asobject );
        return $this->files;
    }

    function getFilesCount( $uid = 0 ) {
        $filecount = WfsFiles::getfilecount( $this->articleid, $uid );
        return $filecount;
    }
}

?>
