<?php
// $Id: xoops_version.php,v 1.5 2004/08/13 12:38:49 phppp Exp $
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
Global $xoopsDB, $xoopsUser, $xoopsModule;
Global $wfsTemplates, $wfsPathConfig;
Global $xoopsModuleConfig, $xoopsWFModule;

include_once XOOPS_ROOT_PATH . "/modules/wfsection/class/common.php";
include_once WFS_ROOT_PATH . "/include/groupaccess.php";
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";

$modversion['name'] = _MI_WFS_NAME;
$modversion['version'] = 2.92;
$modversion['releasedate'] = "Tues: 10 April 2007";
$modversion['status'] = "Beta";
$modversion['description'] = _MI_WFS_DESC;
$modversion['author'] = "Zarilia CMS";
$modversion['credits'] = "";
$modversion['teammembers'] = "";

$modversion['help'] = "wfsection.html";
$modversion['license'] = "GNU see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/wfs_slogo.gif";
$modversion['dirname'] = WFSECTION;

$modversion['author_website_url'] = "http://www.zarilia.com";
$modversion['author_website_name'] = "Zarilia CMS";
$modversion['author_email'] = "webmaster@zarilia.com";
$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://www.zarilia.com/";
$modversion['support_site_name'] = "Zarilia Support Forum";
$modversion['submit_bug'] = "http://sourceforge.net/tracker/?group_id=113004&atid=663911";
$modversion['submit_feature'] = "http://sourceforge.net/tracker/?atid=663914&group_id=113004&func=browse";
$modversion['maillist_announcements'] = "http://lists.sourceforge.net/lists/listinfo/wfsection-announcement";
$modversion['maillist_bugs'] = "http://lists.sourceforge.net/lists/listinfo/wfsection-bugs";
$modversion['maillist_features'] = "http://lists.sourceforge.net/lists/listinfo/wfsection-features";

$modversion['warning'] = _MI_WFS_WARNINGTEXT;
$modversion['author_credits'] = _MI_WFS_AUTHOR_CREDITSTEXT;
$modversion['sqlfile']['mysql'] = "sql/wfsection.sql";

$modversion['tables'][1] = WFS_ARTICLE_DB;
$modversion['tables'][2] = WFS_ARTICLE_MOD_DB;
$modversion['tables'][3] = WFS_RESTORE_DB;
$modversion['tables'][4] = WFS_BROKEN_DB;
$modversion['tables'][5] = WFS_CATEGORY_DB;
$modversion['tables'][6] = WFS_CHECKIN_DB;
$modversion['tables'][7] = WFS_CONFIG_DB;
$modversion['tables'][8] = WFS_FILES_DB;
$modversion['tables'][9] = WFS_INDEXPAGE;
$modversion['tables'][10] = WFS_MAINMENU_DB;
$modversion['tables'][11] = WFS_PERMISSIONS;
$modversion['tables'][12] = WFS_RELATED;
$modversion['tables'][13] = WFS_RELATEDLINKS;
$modversion['tables'][14] = WFS_REVIEWS;
$modversion['tables'][15] = WFS_SPOTLIGHT;
$modversion['tables'][16] = WFS_TEMPLATES;
$modversion['tables'][17] = WFS_VOTES;
$modversion['tables'][18] = WFS_MIMETYPE;

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/allarticles.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['blocks'][1]['file'] = "wfs_artmenu.php";
$modversion['blocks'][1]['name'] = _MI_WFS_BNAME_ARTMENU;
$modversion['blocks'][1]['description'] = "Shows Article menu";
$modversion['blocks'][1]['show_func'] = "b_wfs_artmenu";
$modversion['blocks'][1]['template'] = $wfsTemplates['artmenublock'];

$modversion['blocks'][2]['file'] = "wfs_menu.php";
$modversion['blocks'][2]['name'] = _MI_WFS_BNAME_MENU;
$modversion['blocks'][2]['description'] = "Shows category menu";
$modversion['blocks'][2]['show_func'] = "b_wfs_menu";
$modversion['blocks'][2]['template'] = $wfsTemplates['mainmenublock'];

$modversion['blocks'][3]['file'] = "wfs_topics.php";
$modversion['blocks'][3]['name'] = _MI_WFS_TOPICS;
$modversion['blocks'][3]['description'] = "WFS Category";
$modversion['blocks'][3]['show_func'] = "b_wfs_topics_show";
$modversion['blocks'][3]['template'] = $wfsTemplates['topicsblock'];

$modversion['blocks'][4]['file'] = "wfs_bigstory.php";
$modversion['blocks'][4]['name'] = _MI_WFS_BNAME3;
$modversion['blocks'][4]['description'] = "Shows most read story of the day";
$modversion['blocks'][4]['show_func'] = "b_wfs_bigstory_show";
$modversion['blocks'][4]['template'] = $wfsTemplates['bigartblock'];

$modversion['blocks'][5]['file'] = "wfs_new.php";
$modversion['blocks'][5]['name'] = _MI_WFS_BNAME4;
$modversion['blocks'][5]['description'] = "Shows top read news articles";
$modversion['blocks'][5]['show_func'] = "b_wfs_new_show";
$modversion['blocks'][5]['edit_func'] = "b_wfs_new_edit";
// $modversion['blocks'][5]['options'] = "counter|10|19";
$modversion['blocks'][5]['options'] = "counter|10|19|1|1|1|1|100";
$modversion['blocks'][5]['template'] = $wfsTemplates['topartblock'];

$modversion['blocks'][6]['file'] = "wfs_new.php";
$modversion['blocks'][6]['name'] = _MI_WFS_BNAME5;
$modversion['blocks'][6]['description'] = "Shows recent articles";
$modversion['blocks'][6]['show_func'] = "b_wfs_new_show";
$modversion['blocks'][6]['edit_func'] = "b_wfs_new_edit";
// $modversion['blocks'][6]['options'] = "published|10|19";
$modversion['blocks'][6]['options'] = "published|10|19|1|1|1|1|100";
$modversion['blocks'][6]['template'] = $wfsTemplates['newartblock'];

$modversion['blocks'][7]['file'] = "wfs_newdown.php";
$modversion['blocks'][7]['name'] = _MI_WFS_BNAME6;
$modversion['blocks'][7]['description'] = "Shows article downloads";
$modversion['blocks'][7]['show_func'] = "b_wfs_down_show";
$modversion['blocks'][7]['edit_func'] = "b_wfs_down_edit";
$modversion['blocks'][7]['options'] = "date|10|19";
$modversion['blocks'][7]['template'] = $wfsTemplates['newdownblock'];

$modversion['blocks'][8]['file'] = "wfs_author.php";
$modversion['blocks'][8]['name'] = _MI_WFS_BNAME7;
$modversion['blocks'][8]['description'] = "Show Info about Author";
$modversion['blocks'][8]['show_func'] = "b_wfs_author_show";
$modversion['blocks'][8]['options'] = "published|10|25|news|newbb|wfdownloads";
$modversion['blocks'][8]['template'] = $wfsTemplates['authorblock'];

$modversion['blocks'][9]['file'] = 'wfs_spotlight.php';
$modversion['blocks'][9]['name'] = _MI_WFS_BNAME8;
$modversion['blocks'][9]['description'] = 'Article Spotlight';
$modversion['blocks'][9]['show_func'] = 'b_wfsection_spotlight';
$modversion['blocks'][9]['template'] = $wfsTemplates['spotlightblock'];

$modversion['blocks'][10]['file'] = "wfs_new.php";
$modversion['blocks'][10]['name'] = _MI_WFS_BNAME9;
$modversion['blocks'][10]['description'] = "Shows random articles";
$modversion['blocks'][10]['show_func'] = "b_wfs_new_show";
$modversion['blocks'][10]['edit_func'] = "b_wfs_new_edit";
$modversion['blocks'][10]['options'] = "random|10|19|1|1|1|1|100";
$modversion['blocks'][10]['template'] = $wfsTemplates['topartblock'];
// Menu
$modversion['hasMain'] = 1;

$sql = $xoopsDB->query( "SELECT * FROM " . $xoopsDB->prefix( WFS_MAINMENU_DB ) . " Order by weight" );
$i = 1;
while ( list( $mm_id, $ca_id, $title, $type, $groupid ) = $xoopsDB->fetchRow( $sql ) ) {
    if ( isset( $xoopsModuleConfig['shortcatlenmenu'] ) && $xoopsModuleConfig['shortcatlenmenu'] != 0 ) {
        $title = xoops_substr( $title, 0, $xoopsModuleConfig['shortcatlenmenu'], $trimmarker = '...' );
    }

    if ( wfs_checkAccess( $groupid ) ) {
        if ( $type == 1 ) {
            $modversion['sub'][$i]['name'] = $title;
            $modversion['sub'][$i]['url'] = "article.php?articleid=" . $ca_id . "";
        } else {
            $modversion['sub'][$i]['name'] = $title;
            $modversion['sub'][$i]['url'] = "viewarticles.php?category=" . $ca_id . "";
        }
        $i++;
    }
}

if ( is_object( $xoopsUser ) && isset( $xoopsModuleConfig['submitarts'] ) ) {
    if ( is_object( $xoopsWFModule ) && $xoopsWFModule->getVar( 'isactive' ) ) {
        $groups = $xoopsUser->getGroups();
        if ( array_intersect( $xoopsModuleConfig['submitarts'], $groups ) ) {
            $modversion['sub'][$i + 1]['name'] = _MI_WFS_SUBMIT;
            $modversion['sub'][$i + 1]['url'] = "submit.php";
        }
    }
} else {
    if ( is_object( $xoopsWFModule ) && $xoopsWFModule->getVar( 'isactive' ) ) {
        if ( isset( $xoopsModuleConfig['anonpost'] ) && $xoopsModuleConfig['anonpost'] == 1 ) {
            $modversion['sub'][$i + 1]['name'] = _MI_WFS_SUBMIT;
            $modversion['sub'][$i + 1]['url'] = "submit.php";
        }
    }
}

$modversion['sub'][$i + 2]['name'] = _MI_WFS_POPULAR;
$modversion['sub'][$i + 2]['url'] = "topten.php?counter=1";
$modversion['sub'][$i + 3]['name'] = _MI_WFS_RATEFILE;
$modversion['sub'][$i + 3]['url'] = "topten.php?rate=1";
$modversion['sub'][$i + 4]['name'] = _MI_WFS_ARCHIVE;
$modversion['sub'][$i + 4]['url'] = "archive.php";
// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "wfsection_search";
// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'article.php';
$modversion['comments']['itemName'] = 'articleid';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'wfsection_com_approve';
$modversion['comments']['callback']['update'] = 'wfsection_com_update';

/**
 * Templates
 */
$templatedir = WFS_TEMPLATE_PATH;
$files = array();
$dir = opendir( $templatedir );
while ( ( $file = readdir( $dir ) ) !== false ) {
    if ( ( !preg_match( "/^[.]{1,2}$/", $file ) && preg_match( "/html/", $file ) ) ) {
        if ( strtolower( $file ) != 'cvs' && !is_dir( $file ) ) {
            array_push( $files, $file );
        }
    }
}
sort( $files );
closedir( $dir );

for ( $i = 0;$i < Count( $files );$i++ ) {
    $modversion['templates'][$i]['file'] = $files[$i];
    $modversion['templates'][$i]['description'] = '';
}

$modversion['config'][1]['name'] = 'displayname';
$modversion['config'][1]['title'] = '_MI_WFS_NAMEDISPLAY';
$modversion['config'][1]['description'] = '_MI_WFS_DISPLAYNAMEDSC';
$modversion['config'][1]['formtype'] = 'select';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 1;
$modversion['config'][1]['options'] = array( '_MI_WFS_DISPLAYNAME1' => 1, '_MI_WFS_DISPLAYNAME2' => 2, '_MI_WFS_DISPLAYNAME3' => 3 );

$modversion['config'][2]['name'] = 'atavar';
$modversion['config'][2]['title'] = '_MI_WFS_SHOWATAV';
$modversion['config'][2]['description'] = '_MI_WFS_SHOWATAVDSC';
$modversion['config'][2]['formtype'] = 'select';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 1;
$modversion['config'][2]['options'] = array( '_MI_WFS_DISPLAYATAV1' => 1, '_MI_WFS_DISPLAYATAV2' => 2, '_MI_WFS_DISPLAYATAV3' => 3 );

$modversion['config'][3]['name'] = 'displayemail';
$modversion['config'][3]['title'] = '_MI_WFS_USEREMAILDISPLAY';
$modversion['config'][3]['description'] = '_MI_WFS_DISPLAYUSEREMAILDSC';
$modversion['config'][3]['formtype'] = 'select';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 1;
$modversion['config'][3]['options'] = array( '_MI_WFS_DISPLAYEMAIL1' => 1, '_MI_WFS_DISPLAYEMAIL2' => 2, '_MI_WFS_DISPLAYEMAIL3' => 3 );

$modversion['config'][4]['name'] = 'displayinfo';
$modversion['config'][4]['title'] = '_MI_WFS_DISPLAYINFO';
$modversion['config'][4]['description'] = '_MI_WFS_DISPLAYINFODSC';
$modversion['config'][4]['formtype'] = 'select_multi';
$modversion['config'][4]['valuetype'] = 'array';
$modversion['config'][4]['default'] = array( 2, 3, 4, 5, 6, 7, 8 );
$modversion['config'][4]['options'] = array( '_MI_WFS_DISPLAYINFO2' => 2,
    '_MI_WFS_DISPLAYINFO3' => 3, '_MI_WFS_DISPLAYINFO4' => 4,
    '_MI_WFS_DISPLAYINFO5' => 5, '_MI_WFS_DISPLAYINFO6' => 6,
    '_MI_WFS_DISPLAYINFO7' => 7, '_MI_WFS_DISPLAYINFO8' => 8,
    '_MI_WFS_DISPLAYINFO9' => 9 );

$modversion['config'][5]['name'] = 'displayinfolist';
$modversion['config'][5]['title'] = '_MI_WFS_DISPLAYINFOLIST';
$modversion['config'][5]['description'] = '_MI_WFS_DISPLAYINFOLISTDSC';
$modversion['config'][5]['formtype'] = 'select_multi';
$modversion['config'][5]['valuetype'] = 'array';
$modversion['config'][5]['default'] = array( 1, 2, 3, 4, 5, 6 );
$modversion['config'][5]['options'] = array( '_MI_WFS_DISPLAYINFO1' => 1, '_MI_WFS_DISPLAYINFO2' => 2, '_MI_WFS_DISPLAYINFO3' => 3, '_MI_WFS_DISPLAYINFO4' => 4, '_MI_WFS_DISPLAYINFO5' => 5, '_MI_WFS_DISPLAYINFO6' => 6 );

$modversion['config'][6]['name'] = 'copyright';
$modversion['config'][6]['title'] = '_MI_WFS_ADDCOPYRIGHT';
$modversion['config'][6]['description'] = '_MI_WFS_ADDCOPYRIGHTDSC';
$modversion['config'][6]['formtype'] = 'yesno';
$modversion['config'][6]['valuetype'] = 'int';
$modversion['config'][6]['default'] = 0;

$modversion['config'][7]['name'] = 'novote';
$modversion['config'][7]['title'] = '_MI_WFS_SHOWVOTESINART';
$modversion['config'][7]['description'] = '_MI_WFS_SHOWVOTESINARTDSC';
$modversion['config'][7]['formtype'] = 'yesno';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = 0;

$modversion['config'][8]['name'] = 'displayicons';
$modversion['config'][8]['title'] = '_MI_WFS_ICONDISPLAY';
$modversion['config'][8]['description'] = '_MI_WFS_DISPLAYICONDSC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 1;
$modversion['config'][8]['options'] = array( '_MI_WFS_DISPLAYICON1' => 1, '_MI_WFS_DISPLAYICON2' => 2, '_MI_WFS_DISPLAYICON3' => 3 );

$modversion['config'][9]['name'] = 'daysnew';
$modversion['config'][9]['title'] = '_MI_WFS_DAYSNEW';
$modversion['config'][9]['description'] = '_MI_WFS_DAYSNEWDSC';
$modversion['config'][9]['formtype'] = 'textbox';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 10;

$modversion['config'][10]['name'] = 'daysupdated';
$modversion['config'][10]['title'] = '_MI_WFS_DAYSUPDATED';
$modversion['config'][10]['description'] = '_MI_WFS_DAYSUPDATEDDSC';
$modversion['config'][10]['formtype'] = 'textbox';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 10;

$modversion['config'][11]['name'] = 'popularamount';
$modversion['config'][11]['title'] = '_MI_WFS_POPULARS';
$modversion['config'][11]['description'] = '_MI_WFS_POPULARSDSC';
$modversion['config'][11]['formtype'] = 'select';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 100;
$modversion['config'][11]['options'] = array( '5' => 5, '10' => 10, '50' => 50, '100' => 100, '200' => 200, '500' => 500, '1000' => 1000 );

$modversion['config'][12]['name'] = 'shortcatlenmenu';
$modversion['config'][12]['title'] = '_MI_WFS_SHORTMENLEN';
$modversion['config'][12]['description'] = '_MI_WFS_SHORTMENLENDSC';
$modversion['config'][12]['formtype'] = 'textbox';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 19;

$modversion['config'][13]['name'] = 'shortcatlen';
$modversion['config'][13]['title'] = '_MI_WFS_SHORTCATLEN';
$modversion['config'][13]['description'] = '_MI_WFS_SHORTCATLENDSC';
$modversion['config'][13]['formtype'] = 'textbox';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 19;

$modversion['config'][14]['name'] = 'shortartlen';
$modversion['config'][14]['title'] = '_MI_WFS_SHORTARTLEN';
$modversion['config'][14]['description'] = '_MI_WFS_SHORTARTLENDSC';
$modversion['config'][14]['formtype'] = 'textbox';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 19;

$modversion['config'][15]['name'] = 'showcatpic';
$modversion['config'][15]['title'] = '_MI_WFS_SHOWCATPIC';
$modversion['config'][15]['description'] = '_MI_WFS_SHOWCATPICDSC';
$modversion['config'][15]['formtype'] = 'yesno';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = 1;

$modversion['config'][16]['name'] = 'display_default_image';
$modversion['config'][16]['title'] = '_MI_WFS_DIS_DEF_IMAGE';
$modversion['config'][16]['description'] = '_MI_WFS_DIS_DEF_IMAGEDSC';
$modversion['config'][16]['formtype'] = 'select';
$modversion['config'][16]['valuetype'] = 'int';
$modversion['config'][16]['default'] = 1;
$modversion['config'][16]['options'] = array( '_MI_WFS_DISPLAYDIMAGE1' => 1, '_MI_WFS_DISPLAYDIMAGE2' => 2,
    '_MI_WFS_DISPLAYDIMAGE3' => 3, '_MI_WFS_DISPLAYDIMAGE4' => 4 );

$modversion['config'][17]['name'] = 'default_image';
$modversion['config'][17]['title'] = '_MI_WFS_DEF_IMAGE';
$modversion['config'][17]['description'] = '_MI_WFS_DEF_IMAGEDSC';
$modversion['config'][17]['formtype'] = 'textbox';
$modversion['config'][17]['valuetype'] = 'text';
$modversion['config'][17]['default'] = 'article.jpg';

$modversion['config'][18]['name'] = 'use_thumbs';
$modversion['config'][18]['title'] = '_MI_WFS_USETHUMBS';
$modversion['config'][18]['description'] = '_MI_WFS_USETHUMBSDSC';
$modversion['config'][18]['formtype'] = 'yesno';
$modversion['config'][18]['valuetype'] = 'int';
$modversion['config'][18]['default'] = 1;

$modversion['config'][19]['name'] = 'updatethumbs';
$modversion['config'][19]['title'] = '_MI_WFS_IMGUPDATE';
$modversion['config'][19]['description'] = '_MI_WFS_IMGUPDATEDSC';
$modversion['config'][19]['formtype'] = 'yesno';
$modversion['config'][19]['valuetype'] = 'int';
$modversion['config'][19]['default'] = 1;

$modversion['config'][20]['name'] = 'imagequality';
$modversion['config'][20]['title'] = '_MI_WFS_QUALITY';
$modversion['config'][20]['description'] = '_MI_WFS_QUALITYDSC';
$modversion['config'][20]['formtype'] = 'textbox';
$modversion['config'][20]['valuetype'] = 'int';
$modversion['config'][20]['default'] = 100;

$modversion['config'][21]['name'] = 'keepaspect';
$modversion['config'][21]['title'] = '_MI_WFS_KEEPASPECT';
$modversion['config'][21]['description'] = '_MI_WFS_KEEPASPECTDSC';
$modversion['config'][21]['formtype'] = 'yesno';
$modversion['config'][21]['valuetype'] = 'int';
$modversion['config'][21]['default'] = 0;

$modversion['config'][22]['name'] = 'submenus';
$modversion['config'][22]['title'] = '_MI_WFS_SHOWSUBMENU';
$modversion['config'][22]['description'] = '_MI_WFS_SHOWSUBMENUDSC';
$modversion['config'][22]['formtype'] = 'yesno';
$modversion['config'][22]['valuetype'] = 'int';
$modversion['config'][22]['default'] = 0;

$modversion['config'][23]['name'] = 'showartlistings';
$modversion['config'][23]['title'] = '_MI_WFS_SHOWARTLISTINGS';
$modversion['config'][23]['description'] = '_MI_WFS_SHOWARTLISTINGSDSC';
$modversion['config'][23]['formtype'] = 'select';
$modversion['config'][23]['valuetype'] = 'int';
$modversion['config'][23]['default'] = 3;
$modversion['config'][23]['options'] = array( '_MI_WFS_SHOWARTLISTING1' => 1, '_MI_WFS_SHOWARTLISTING2' => 2, '_MI_WFS_SHOWARTLISTING3' => 3, '_MI_WFS_SHOWARTLISTING4' => 4 );

$modversion['config'][24]['name'] = 'showartlistamount';
$modversion['config'][24]['title'] = '_MI_WFS_SHOWARTLISTAMOUNT';
$modversion['config'][24]['description'] = '_MI_WFS_SHOWARTLISTAMOUNTDSC';
$modversion['config'][24]['formtype'] = 'select';
$modversion['config'][24]['valuetype'] = 'int';
$modversion['config'][24]['default'] = 5;
$modversion['config'][24]['options'] = array( '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7 );

$modversion['config'][25]['name'] = 'articlesapage';
$modversion['config'][25]['title'] = '_MI_WFS_ARTICLESAPAGE';
$modversion['config'][25]['description'] = '_MI_WFS_ARTICLESAPAGEDSC';
$modversion['config'][25]['formtype'] = 'select';
$modversion['config'][25]['valuetype'] = 'int';
$modversion['config'][25]['default'] = 10;
$modversion['config'][25]['options'] = array( '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );

$modversion['config'][26]['name'] = 'lastart';
$modversion['config'][26]['title'] = '_MI_WFS_LASTART';
$modversion['config'][26]['description'] = '_MI_WFS_LASTARTDSC';
$modversion['config'][26]['formtype'] = 'select';
$modversion['config'][26]['valuetype'] = 'int';
$modversion['config'][26]['default'] = 10;
$modversion['config'][26]['options'] = array( '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );

$modversion['config'][27]['name'] = 'aidxpathtype';
$modversion['config'][27]['title'] = '_MI_WFS_PATHTYPE';
$modversion['config'][27]['description'] = '_MI_WFS_PATHTYPEDSC';
$modversion['config'][27]['formtype'] = 'select';
$modversion['config'][27]['valuetype'] = 'int';
$modversion['config'][27]['default'] = 0 ;
$modversion['config'][27]['options'] = array( _MI_WFS_SELECTBOX => 0,
    _MI_WFS_SELECTSUBS => 1,
    _MI_WFS_LINKEDPATH => 2,
    _MI_WFS_LINKSANDSELECT => 3,
    _MI_WFS_NONE => 4 );

$modversion['config'][28]['name'] = 'orderbox';
$modversion['config'][28]['title'] = '_MI_WFS_SHOWORDERBOX';
$modversion['config'][28]['description'] = '_MI_WFS_SHOWORDERBOXDSC';
$modversion['config'][28]['formtype'] = 'yesno';
$modversion['config'][28]['valuetype'] = 'int';
$modversion['config'][28]['default'] = 0;

$qa = ' (A)';
$qd = ' (D)';

$modversion['config'][59]['name'] = 'cidxorder';
$modversion['config'][59]['title'] = '_MI_WFS_SECTIONSORT';
$modversion['config'][59]['description'] = '_MI_WFS_SECTIONSORTDSC';
$modversion['config'][59]['formtype'] = 'select';
$modversion['config'][59]['valuetype'] = 'text';
$modversion['config'][59]['default'] = 'title ASC';
$modversion['config'][59]['options'] = array( _MI_WFS_TITLE . $qa => 'title ASC',
    _MI_WFS_TITLE . $qd => 'title DESC',
    _MI_WFS_WEIGHT => 'weight' );

$modversion['config'][29]['name'] = 'aidxorder';
$modversion['config'][29]['title'] = '_MI_WFS_ARTICLESSORT';
$modversion['config'][29]['description'] = '_MI_WFS_ARTICLESSORTDSC';
$modversion['config'][29]['formtype'] = 'select';
$modversion['config'][29]['valuetype'] = 'text';
$modversion['config'][29]['default'] = 'title ASC';
$modversion['config'][29]['options'] = array( _MI_WFS_TITLE . $qa => 'title ASC',
    _MI_WFS_TITLE . $qd => 'title DESC',
    _MI_WFS_SUBMITTED2 . $qa => 'published ASC' ,
    _MI_WFS_SUBMITTED2 . $qd => 'published DESC',
    _MI_WFS_RATING . $qa => 'rating ASC',
    _MI_WFS_RATING . $qd => 'rating DESC',
    _MI_WFS_POPULARITY . $qa => 'hits ASC',
    _MI_WFS_POPULARITY . $qd => 'hits DESC',
    _MI_WFS_WEIGHT => 'weight' );

$modversion['config'][30]['name'] = 'autoweight';
$modversion['config'][30]['title'] = '_MI_WFS_AUTOWEIGHT';
$modversion['config'][30]['description'] = '_MI_WFS_AUTOWEIGHTDSC';
$modversion['config'][30]['formtype'] = 'yesno';
$modversion['config'][30]['valuetype'] = 'int';
$modversion['config'][30]['default'] = 0;

$modversion['config'][60]['name'] = 'autosummary';
$modversion['config'][60]['title'] = '_MI_WFS_AUTOSUMMARY';
$modversion['config'][60]['description'] = '_MI_WFS_AUTOSUMMARYDSC';
$modversion['config'][60]['formtype'] = 'yesno';
$modversion['config'][60]['valuetype'] = 'int';
$modversion['config'][60]['default'] = 0;

$modversion['config'][61]['name'] = 'summary_type';
$modversion['config'][61]['title'] = '_MI_WFS_NAMESUMTYPE';
$modversion['config'][61]['description'] = '_MI_WFS_NAMESUMTYPEDSC';
$modversion['config'][61]['formtype'] = 'select';
$modversion['config'][61]['valuetype'] = 'int';
$modversion['config'][61]['default'] = 1;
$modversion['config'][61]['options'] = array( '_MI_WFS_NAMESUMTYPE1' => 1, '_MI_WFS_NAMESUMTYPE2' => 2 );

$modversion['config'][62]['name'] = 'summary_amount';
$modversion['config'][62]['title'] = '_MI_WFS_NAMESUMAMOUNT';
$modversion['config'][62]['description'] = '_MI_WFS_NAMESUMAMOUNTDSC';
$modversion['config'][62]['formtype'] = 'textbox';
$modversion['config'][62]['valuetype'] = 'int';
$modversion['config'][62]['default'] = 50;

$modversion['config'][31]['name'] = 'wiki';
$modversion['config'][31]['title'] = '_MI_WFS_WIKI';
$modversion['config'][31]['description'] = '_MI_WFS_WIKIDSC';
$modversion['config'][31]['formtype'] = 'yesno';
$modversion['config'][31]['valuetype'] = 'int';
$modversion['config'][31]['default'] = 1;

$modversion['config'][32]['name'] = 'phpcoding';
$modversion['config'][32]['title'] = '_MI_WFS_PHPCODING';
$modversion['config'][32]['description'] = '_MI_WFS_PHPCODINGDSC';
$modversion['config'][32]['formtype'] = 'yesno';
$modversion['config'][32]['valuetype'] = 'int';
$modversion['config'][32]['default'] = 1;

$modversion['config'][33]['name'] = 'version_inc';
$modversion['config'][33]['title'] = '_MI_WFS_VERSIONINC';
$modversion['config'][33]['description'] = '_MI_WFS_VERSIONINCDSC';
$modversion['config'][33]['formtype'] = 'textbox';
$modversion['config'][33]['valuetype'] = 'text';
$modversion['config'][33]['default'] = 0.01;

$modversion['config'][34]['name'] = 'use_restore';
$modversion['config'][34]['title'] = '_MI_WFS_USERESTORE';
$modversion['config'][34]['description'] = '_MI_WFS_USERESTOREDSC';
$modversion['config'][34]['formtype'] = 'yesno';
$modversion['config'][34]['valuetype'] = 'int';
$modversion['config'][34]['default'] = 0;

$modversion['config'][35]['name'] = 'timestamp';
$modversion['config'][35]['title'] = '_MI_WFS_DEFAULTTIME';
$modversion['config'][35]['description'] = '_MI_WFS_DEFAULTTIMEDSC';
$modversion['config'][35]['formtype'] = 'textbox';
$modversion['config'][35]['valuetype'] = 'text';
$modversion['config'][35]['default'] = 'D, d-M-Y';

$modversion['config'][36]['name'] = 'submitarts';
$modversion['config'][36]['title'] = '_MI_WFS_GROUPSUBMITART';
$modversion['config'][36]['description'] = '_MI_WFS_GROUPSUBMITARTDSC';
$modversion['config'][36]['formtype'] = 'group_multi';
$modversion['config'][36]['valuetype'] = 'array';
$modversion['config'][36]['default'] = '1 2 3';

$modversion['config'][37]['name'] = 'anonpost';
$modversion['config'][37]['title'] = '_MI_WFS_ANONPOST';
$modversion['config'][37]['description'] = '_MI_WFS_ANONPOSTDSC';
$modversion['config'][37]['formtype'] = 'yesno';
$modversion['config'][37]['valuetype'] = 'int';
$modversion['config'][37]['default'] = 0;

$modversion['config'][38]['name'] = 'autoapprove';
$modversion['config'][38]['title'] = '_MI_WFS_AUTOAPPROVE';
$modversion['config'][38]['description'] = '_MI_WFS_AUTOAPPROVEDSC';
$modversion['config'][38]['formtype'] = 'yesno';
$modversion['config'][38]['valuetype'] = 'int';
$modversion['config'][38]['default'] = 0;

$modversion['config'][39]['name'] = 'notifysubmit';
$modversion['config'][39]['title'] = '_MI_WFS_NOTIFYSUBMIT';
$modversion['config'][39]['description'] = '_MI_WFS_NOTIFYSUBMITDSC';
$modversion['config'][39]['formtype'] = 'yesno';
$modversion['config'][39]['valuetype'] = 'int';
$modversion['config'][39]['default'] = 0;

$modversion['config'][40]['name'] = 'wysiwygeditor';
$modversion['config'][40]['title'] = '_MI_WFS_WYSIWYG';
$modversion['config'][40]['description'] = '_MI_WFS_WYSIWYGDSC';
$modversion['config'][40]['formtype'] = 'yesno';
$modversion['config'][40]['valuetype'] = 'int';
$modversion['config'][40]['default'] = 0;

$modversion['config'][41]['name'] = 'userwysiwygeditor';
$modversion['config'][41]['title'] = '_MI_WFS_USERWYSIWYG';
$modversion['config'][41]['description'] = '_MI_WFS_USERWYSIWYGDSC';
$modversion['config'][41]['formtype'] = 'yesno';
$modversion['config'][41]['valuetype'] = 'int';
$modversion['config'][41]['default'] = 0;

$modversion['config'][42]['name'] = 'groupswysiwygeditor';
$modversion['config'][42]['title'] = '_MI_WFS_GROUPUSERWYSIWYG';
$modversion['config'][42]['description'] = '_MI_WFS_SUBMITARTDSC';
$modversion['config'][42]['formtype'] = 'group_multi';
$modversion['config'][42]['valuetype'] = 'array';
$modversion['config'][42]['default'] = '1 2 3';

$modversion['config'][43]['name'] = 'htmltextarea';
$modversion['config'][43]['title'] = '_MI_WFS_USEHTMLAREA';
$modversion['config'][43]['description'] = '_MI_WFS_USEHTMLAREADSC';
$modversion['config'][43]['formtype'] = 'yesno';
$modversion['config'][43]['valuetype'] = 'int';
$modversion['config'][43]['default'] = 0;

$modversion['config'][44]['name'] = 'submitfiles';
$modversion['config'][44]['title'] = '_MI_WFS_SUBMITFILES';
$modversion['config'][44]['description'] = '_MI_WFS_SUBMITFILESDSC';
$modversion['config'][44]['formtype'] = 'group_multi';
$modversion['config'][44]['valuetype'] = 'array';
$modversion['config'][44]['default'] = '1 2 3';
/*
$modversion['config'][45]['name'] = 'selmimetype';
$modversion['config'][45]['title'] = '_MI_WFS_ALLOWEDMIMETYPES';
$modversion['config'][45]['description'] = '_MI_WFS_ALLOWEDMIMETYPESDSC';
$modversion['config'][45]['formtype'] = 'select_multi';
$modversion['config'][45]['valuetype'] = 'array';
$modversion['config'][45]['default'] = array('application/x-zip-compressed');
$modversion['config'][45]['options'] = $mimetypes;

$modversion['config'][46]['name'] = 'submitfilesmimetype';
$modversion['config'][46]['title'] = '_MI_WFS_ALLOWEDUSERMIME';
$modversion['config'][46]['description'] = '_MI_WFS_ALLOWEDUSERMIMEDSC';
$modversion['config'][46]['formtype'] = 'select_multi';
$modversion['config'][46]['valuetype'] = 'array';
$modversion['config'][46]['default'] = array('application/x-zip-compressed');
$modversion['config'][46]['options'] = $mimetypes;
*/
$modversion['config'][47]['name'] = 'adminmimecheck';
$modversion['config'][47]['title'] = '_MI_WFS_ADMINMIMECHECK';
$modversion['config'][47]['description'] = '_MI_WFS_ADMINMIMECHECKDSC';
$modversion['config'][47]['formtype'] = 'yesno';
$modversion['config'][47]['valuetype'] = 'int';
$modversion['config'][47]['default'] = 1;

$modversion['config'][48]['name'] = 'nomaxfilesize';
$modversion['config'][48]['title'] = '_MI_WFS_NOUPLOADFILESIZE';
$modversion['config'][48]['description'] = '_MI_WFS_NOUPLOADFILESIZEDSC';
$modversion['config'][48]['formtype'] = 'yesno';
$modversion['config'][48]['valuetype'] = 'int';
$modversion['config'][48]['default'] = 0;

$modversion['config'][49]['name'] = 'noimgsizecheck';
$modversion['config'][49]['title'] = '_MI_WFS_NOUPIMGSIZE';
$modversion['config'][49]['description'] = '_MI_WFS_NOUPIMGSIZEDSC';
$modversion['config'][49]['formtype'] = 'yesno';
$modversion['config'][49]['valuetype'] = 'int';
$modversion['config'][49]['default'] = 0;

$modversion['config'][50]['name'] = 'maxfilesize';
$modversion['config'][50]['title'] = '_MI_WFS_UPLOADFILESIZE';
$modversion['config'][50]['description'] = '_MI_WFS_UPLOADFILESIZEDSC';
$modversion['config'][50]['formtype'] = 'textbox';
$modversion['config'][50]['valuetype'] = 'int';
$modversion['config'][50]['default'] = 2097152;

$modversion['config'][51]['name'] = 'imgheight';
$modversion['config'][51]['title'] = '_MI_WFS_IMGHEIGHT';
$modversion['config'][51]['description'] = '_MI_WFS_IMGHEIGHTDSC';
$modversion['config'][51]['formtype'] = 'textbox';
$modversion['config'][51]['valuetype'] = 'int';
$modversion['config'][51]['default'] = 400;

$modversion['config'][52]['name'] = 'imgwidth';
$modversion['config'][52]['title'] = '_MI_WFS_IMGWIDTH';
$modversion['config'][52]['description'] = '_MI_WFS_IMGWIDTHDSC';
$modversion['config'][52]['formtype'] = 'textbox';
$modversion['config'][52]['valuetype'] = 'int';
$modversion['config'][52]['default'] = 400;

$modversion['config'][53]['name'] = 'wfsmode';
$modversion['config'][53]['title'] = '_MI_WFS_FILEMODE';
$modversion['config'][53]['description'] = '_MI_WFS_FILEMODEDSC';
$modversion['config'][53]['formtype'] = 'textbox';
$modversion['config'][53]['valuetype'] = 'int';
$modversion['config'][53]['default'] = 644;

$modversion['config'][54]['name'] = 'file_prefix';
$modversion['config'][54]['title'] = '_MI_WFS_FILEPREFIX';
$modversion['config'][54]['description'] = '_MI_WFS_FILEPREFIXDSC';
$modversion['config'][54]['formtype'] = 'textbox';
$modversion['config'][54]['valuetype'] = 'text';
$modversion['config'][54]['default'] = '';

$modversion['config'][55]['name'] = 'checksession';
$modversion['config'][55]['title'] = '_MI_WFS_CHECKSESSION';
$modversion['config'][55]['description'] = '_MI_WFS_CHECKSESSIONDSC';
$modversion['config'][55]['formtype'] = 'textbox';
$modversion['config'][55]['valuetype'] = 'int';
$modversion['config'][55]['default'] = '';

$modversion['config'][56]['name'] = 'selectforum';
$modversion['config'][56]['title'] = '_MI_WFS_SELECTFORUM';
$modversion['config'][56]['description'] = '_MI_WFS_SELECTFORUMDSC';
$modversion['config'][56]['formtype'] = 'select';
$modversion['config'][56]['valuetype'] = 'int';
$modversion['config'][56]['default'] = 1;
$modversion['config'][56]['options'] = array( '_MI_WFS_DISPLAYFORUM1' => 1, '_MI_WFS_DISPLAYFORUM2' => 2, '_MI_WFS_DISPLAYFORUM3' => 3 );

$modversion['config'][57]['name'] = 'user_amount';
$modversion['config'][57]['title'] = '_MI_WFS_USERAMOUNT';
$modversion['config'][57]['description'] = '_MI_WFS_USERAMOUNTDSC';
$modversion['config'][57]['formtype'] = 'textbox';
$modversion['config'][57]['valuetype'] = 'int';
$modversion['config'][57]['default'] = '300';

?>
