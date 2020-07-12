<?php
// $Id: articlehtmlform.inc.php,v 1.4 2004/08/13 12:48:53 phppp Exp $
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
include_once WFS_ROOT_PATH . '/class/wfslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

$xt = new WfsCategory();

global $_SERVER, $_POST, $xoopsConfig;;

$doc_type = 2;
$autosummary = 0;
$editing = ( !$article->articleid ) ? _AM_WFS_CREATEARTICLE : _AM_WFS_MODIFYARTICLE;
$create = ( $article->articleid ) ? _AM_WFS_MOVETO : _AM_WFS_IN;
$groups = ( $article->articleid ) ? explode( " ", $article->groupid ) : true;
$userstart = isset( $_GET['userstart'] ) ? intval( $_GET['userstart'] ) : 0;

$sform = new XoopsThemeForm( $editing . $article->title , "op", "index.php" );
/**
 * Group permissions for document
 */
$groupaccess_tray = new XoopsFormElementTray( _AM_WFS_EDITGROUPPROMPT, '<br />' );
$groups = new XoopsFormSelectGroup( '', "groupid", true, $groups, 5, true );
$groupaccess_tray->addElement( $groups );
$catgroup_checkbox = new XoopsFormCheckBox( '', "catgroupid", 0 );
$catgroup_checkbox->addOption( 1, _AM_WFS_USECATEGORYACCESS );
$groupaccess_tray->addElement( $catgroup_checkbox );
$sform->addElement( $groupaccess_tray );
/**
 * Document title
 */
$sform->addElement( new XoopsFormText( _AM_WFS_EDITARTICLETITLE, "title", 50, 255, $article->title( "E" ) ), true );
/**
 * Section pulldown menu
 */
$mytree = new XoopsTree( $xoopsDB->prefix( WFS_CATEGORY_DB ), "id", "pid" );
$movesectiontext = ( $article->articleid ) ? _AM_WFS_EDITSECTION2 : _AM_WFS_EDITSECTION;
ob_start();
$mytree->makeMySelBox( "title", "title", $article->categoryid, 0 );
$sform->addElement( new XoopsFormLabel( $movesectiontext, ob_get_contents() ) );
ob_end_clean();
/**
 * Document weight
 */
$weight_text = ( $xoopsModuleConfig['autoweight'] ) ? _AM_WFS_GL_WEIGHTON : _AM_WFS_GL_WEIGHTOFF;
$sform->addElement( new XoopsFormText( _AM_WFS_EDITWEIGHT . $weight_text, "weight", 5, 5, $article->weight ), false );
// display user array:  Note User list over 400 will use nav for other user selection
$user_id = ( $article->uid ) ? $article->uid : $xoopsUser->uid();

$member_handler = &xoops_gethandler( 'member' );
$usercount = $member_handler->getUserCount();
$criteria = new CriteriaCompo();
$criteria->setSort( 'uname' );
$criteria->setOrder( 'ASC' );
if ( $usercount < $xoopsModuleConfig["user_amount"] ) {
    $criteria->setStart( 0 );

    $user_select = new XoopsFormSelect( _AM_WFS_EDITCAUTH, 'changeuser', $user_id );
    $user_select->addOption( 0, $xoopsConfig['anonymous'] );
    $user_select->addOptionArray( $member_handler->getUserList( $criteria ) );
    $sform->addElement( $user_select );
    // $sform->addElement( new XoopsFormSelect( _AM_WFS_EDITCAUTH, "changeuser", true, $user_id, 1, false ), false );
    $sform->addElement( new XoopsFormHidden( "userset", 1 ) );
} else {
    $criteria->setStart( $userstart );
    $criteria->setLimit( 100 );

    $user_name = isset( $user_id ) ? WFS_getLinkedUnameFromId( $user_id, $xoopsModuleConfig['displayname'], 1 ) : _AM_WFS_NODETAILSRECORDED;
    $user_select = new XoopsFormSelect( '', "changeuser", $user_id );
    $user_select->addOption( 0, $xoopsConfig['anonymous'] );
    $nav = ( $article->articleid )
    ? new XoopsPageNav( $usercount, 100, $userstart, "userstart", "op=edit&articleid=" . $article->articleid . "&users" )
    : new XoopsPageNav( $usercount, 100, $userstart, "userstart" );

    $user_select->addOptionArray( $member_handler->getUserList( $criteria ) );
    $user_select_tray = new XoopsFormElementTray( " Orginal Author: $user_name<br /><br /> New Author:", "<br />" );
    $user_select_tray->addElement( $user_select );

    if ( $usercount > 100 ) {
        $user_select_nav = new XoopsFormLabel( '<b>Nav:</b>', $nav->renderNav( 3 ) );
        $user_select_tray->addElement( $user_select_nav );
    }

    $user_tray = new XoopsFormElementTray( _AM_WFS_EDITCAUTH2, '<br /><br />' );
    $user_tray->addElement( $user_select_tray );
    $user_checkbox = new XoopsFormCheckBox( ' ', 'userset', 0 );
    $user_checkbox->addOption( 1, _AM_WFS_ADDNEWAUTH );
    $user_tray->addElement( $user_checkbox );
    $sform->addElement( $user_tray );
}

$image_option_tray = new XoopsFormElementTray( _AM_WFS_SELECT_IMG, '<br />' );
$art_image_array = @WfsLists::getListTypeAsArray( WFS_ARTICLEIMG_PATH, $type = "images" );
$indeximage_select = new XoopsFormSelect( '', 'artimage', $article->articleimg );
$indeximage_select->addOptionArray( $art_image_array );
$indeximage_select->setExtra( "onchange='showImgSelected(\"image\", \"artimage\", \"" . $wfsPathConfig['graphicspath'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
$indeximage_tray = new XoopsFormElementTray( '', '&nbsp;' );
$indeximage_tray->addElement( $indeximage_select );
if ( !empty( $article->articleimg ) ) {
    $indeximage_tray->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/" . $wfsPathConfig['graphicspath'] . "/" . $article->articleimg . "' name='image' id='image' alt='' /></div>" ) );
} else {
    $indeximage_tray->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' /></div>" ) );
}
$image_option_tray->addElement( $indeximage_tray );
$sform->addElement( $image_option_tray );

/**
 * Document subtitle
 */
$sform->addElement( new XoopsFormTextArea( _AM_WFS_EDITSUBTITLE, 'subtitle', $article->subtitle( "E" ), 5, 60 ), false );
$sform->insertBreak( "", "even" );
/**
 * Show different Document entry types
 */
$sform->insertBreak( _AM_WFS_DOCUMENTTYPE, "bg3" );
$sform->insertBreak( _AM_WFS_DOCUMENTTYPES, "even" );
/**
 * Document URL LINKS:  Uses an External Link for document listings. Does not display full document for this
 */
$linked_url_tray = new XoopsFormElementTray( _AM_WFS_EDITLINKURL, "<br />" );
$linked_url = new XoopsFormText( _AM_WFS_EDITLINKURLADD, "url", 50, 255, $article->url( "E" ) );
$linked_url_tray->addElement( $linked_url );
$linked_urlname = new XoopsFormText( _AM_WFS_EDITLINKURLNAME, "urlname", 50, 255, $article->urlname( "E" ) );
$linked_url_tray->addElement( $linked_urlname );
$sform->addElement( $linked_url_tray );
$sform->insertBreak( "", "even" );
/**
 * Section pulldown menu
 */
$html_tray = new XoopsFormElementTray( _AM_WFS_EDITHTMLFILE, '<br />' );
$html_array = &WfsLists::getListTypeAsArray( WFS_HTML_PATH, "html" );
$html_select = new XoopsFormSelect( '', 'htmlpage', $article->htmlpage );
$html_select->addOptionArray( $html_array );
$html_tray->addElement( $html_select );
$doctitle_checkbox = new XoopsFormCheckBox( '', 'doctitle', 0 );
$doctitle_checkbox->addOption( 1, _AM_WFS_DOCTITLE );
$html_tray->addElement( $doctitle_checkbox );
$htmldb_checkbox = new XoopsFormCheckBox( '', 'htmldb', 0 );
$htmldb_checkbox->addOption( 1, _AM_WFS_DOHTMLDB );
$html_tray->addElement( $htmldb_checkbox );
$sform->addElement( $html_tray );
$sform->insertBreak( '', 'even' );
/**
 * Section pulldown menu
 */
$pdf_tray = new XoopsFormElementTray( _AM_WFS_EDITPDFFILE, '<br />' );
$pdf_array = &WfsLists::getListTypeAsArray( WFS_HTML_PATH, "pdf" );
$pdf_select = new XoopsFormSelect( '', 'pdfpage', $article->pdfpage );
$pdf_select->addOptionArray( $pdf_array );
$pdf_tray->addElement( $pdf_select );
$sform->addElement( $pdf_tray );
$sform->insertBreak( '', 'even' );
/**
 * Section pulldown menu
 */
$words_to_count = $maintext = $article->maintext;
$pattern = "/[^(\w|\d|\'|\"|\.|\!|\?|;|,|\\|\/|\-\-|:|\&|@)]+/";
$words_to_count = preg_replace ( $pattern, " ", $words_to_count );
$words_to_count = trim( $words_to_count );
$total_words = ( !empty( $words_to_count ) ) ? count( explode( " ", $words_to_count ) ) : 0;
if ( wfs_checkBrowser() == true && $xoopsModuleConfig["wysiwygeditor"] ) {
    include_once XOOPS_ROOT_PATH . "/modules/spaw/spaw_control.class.php";
    ob_start();
    $sw = new SPAW_Wysiwyg( 'maintext', $article->maintext( "E" ), $xoopsConfig['language'], 'full', 'default', '95%', '600px' );
    $sw->show();
    $sform->addElement( new XoopsFormLabel( sprintf( _AM_WFS_EDITMAINTEXT, $total_words ), ob_get_contents(), 1 ) );
    ob_end_clean();
} else {
    $sform->addElement( new XoopsFormDhtmlTextArea( sprintf( _AM_WFS_EDITMAINTEXT, $total_words ), "maintext", $article->maintext( "N" ), 15, 60 ), false );
}
$sform->insertBreak( _AM_WFS_EXTRADOC_TEXT, "even" );
/**
 * Document Text Formatting options
 */
$options_tray = new XoopsFormElementTray( _AM_WFS_TEXTOPTIONS, '<br />' );
$cleanhtml_checkbox = new XoopsFormCheckBox( '', 'cleanhtml', 0 );
$cleanhtml_checkbox->addOption( 1, _AM_WFS_CLEANHTML );
$options_tray->addElement( $cleanhtml_checkbox );

$striphtml_checkbox = new XoopsFormCheckBox( '', 'striptags', 0 );
$striphtml_checkbox->addOption( 1, _AM_WFS_STRIPHTML );
$options_tray->addElement( $striphtml_checkbox );

$smiley_checkbox = new XoopsFormCheckBox( '', 'nosmiley', $article->nosmiley );
$smiley_checkbox->addOption( 1, _AM_WFS_DISABLESMILEY );
$options_tray->addElement( $smiley_checkbox );

$xcodes_checkbox = new XoopsFormCheckBox( '', 'noxcodes', $article->noxcodes );
$xcodes_checkbox->addOption( 1, _AM_WFS_DISABLEXCODE );
$options_tray->addElement( $xcodes_checkbox );

$html_checkbox = new XoopsFormCheckBox( '', 'nohtml', $article->nohtml );
$html_checkbox->addOption( 1, _AM_WFS_DISABLEHTML );
$options_tray->addElement( $html_checkbox );

$breaks_checkbox = new XoopsFormCheckBox( '', 'nobreaks', $article->nobreaks );
$breaks_checkbox->addOption( 1, _AM_WFS_DISABLEBREAK );
$options_tray->addElement( $breaks_checkbox );

$sform->addElement( $options_tray );
$sform->insertBreak( "<b>" . _AM_WFS_MENU . "</b>", 'bg3' );
/**
 * Document Summary
 */
$summary_tray = new XoopsFormElementTray( _AM_WFS_EDITSUMMARY, '<br />' );
$summary = new XoopsFormTextArea( '', "summary", $article->summary( "E" ), 7, 60 );
$summary_tray->addElement( $summary );
$autosummary_checkbox = new XoopsFormCheckBox( '', 'autosummary', 0 );
$autosummary_checkbox->addOption( 1, _AM_WFS_EDITAUTOSUMMARY );
$summary_tray->addElement( $autosummary_checkbox );
$remove_image_checkbox = new XoopsFormCheckBox( '', 'removeimages', 0 );
$remove_image_checkbox->addOption( 1, _AM_WFS_EDITREMOVEIMAGES );
$summary_tray->addElement( $remove_image_checkbox );
if ( isset( $xoopsModuleConfig['summary_type'] ) && $xoopsModuleConfig['summary_type'] == 1 ) {
    $summary_num = 50;
    $summary_text = _AM_WFS_EDITSUMMARYAMOUNTW;
} else {
    $summary_num = 250;
    $summary_text = _AM_WFS_EDITSUMMARYAMOUNTC;
}
$summary_amount = new XoopsFormText( $summary_text, "summaryamount", 4, 4, $summary_num );
$summary_tray->addElement( $summary_amount );
$sform->addElement( $summary_tray );
$sform->insertBreak( "", "even" );
/**
 * Published Date: Set or remove the publish date for document
 */
$time = time();
$publishdate = $article->published( "E" );
$published = ( $publishdate > $time ) ? $publishdate : $time ;
$ispublished = ( $publishdate > $time ) ? 1: 0 ;
$publishdates = ( $publishdate > $time ) ? _AM_WFS_PUBLISHDATESET . formatTimestamp( $publishdate, "Y-m-d H:s" ) : _AM_WFS_SETDATETIMEPUBLISH;

$publishdate_checkbox = new XoopsFormCheckBox( '', 'publishdateactivate', $ispublished );
$publishdate_checkbox->addOption( 1, $publishdates . "<br /><br />" );

$publishdate_tray = new XoopsFormElementTray( _AM_WFS_PUBLISHDATE, '' );
$publishdate_tray->addElement( $publishdate_checkbox );
$publishdate_tray->addElement( new XoopsFormDateTime( _AM_WFS_SETPUBLISHDATE, 'publishdates', 15, $published ) );
$publishdate_tray->addElement( new XoopsFormRadioYN( _AM_WFS_CLEARPUBLISHDATE, 'clearpublish', 0, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' ) );
$sform->addElement( $publishdate_tray );
/**
 * Expired Date:  Set or remove the expire date for document
 */
$expiredate = $article->expired( "E" );
$expired = ( $expiredate < $time ) ? $expiredate : $time ;
$sform->addElement( new XoopsFormHidden( "expiredates", $expired ) );
$sform->addElement( new XoopsFormHidden( "clearexpire", 0 ) );

$isexpired = ( $expiredate > $time ) ? 1: 0 ;
$expiredates = ( $expiredate > $time ) ? _AM_WFS_EXPIREDATESET . formatTimestamp( $expiredate, 'Y-m-d H:s' ) : _AM_WFS_SETDATETIMEEXPIRE;
$warning = ( $publishdate > $expiredate && $expiredate > $time ) ? _AM_WFS_EXPIREWARNING : "";

$expiredate_checkbox = new XoopsFormCheckBox( '', 'expiredateactivate', $isexpired );
$expiredate_checkbox->addOption( 1, $expiredates . "<br /><br />" );
$expiredate_tray = new XoopsFormElementTray( _AM_WFS_EXPIREDATE . $warning, '' );
$expiredate_tray->addElement( $expiredate_checkbox );
$expiredate_tray->addElement( new XoopsFormDateTime( _AM_WFS_SETEXPIREDATE, 'expiredates', 15, $expired ) );
$expiredate_tray->addElement( new XoopsFormRadioYN( _AM_WFS_CLEAREXPIREDATE, 'clearexpire', 0, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' ) );
$sform->addElement( $expiredate_tray );
$sform->addElement( new XoopsFormHidden( "expiredate", $article->expired ) );
$sform->insertBreak( "", "even" );

$spotsponser = ( $article->spotlightmain == 2 ) ? 1 : 0;
$index_spotlightsp_radio = new XoopsFormRadioYN( _AM_WFS_SPOTLIGHTSPONSER, 'spotlightsponser', $spotsponser, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
$sform->addElement( $index_spotlightsp_radio );

$spotmain = ( $article->spotlightmain == 1 ) ? 1 : 0;
$index_spotlight_radio = new XoopsFormRadioYN( _AM_WFS_SPOTLIGHTMAIN, 'spotlightmain', $spotmain, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
$sform->addElement( $index_spotlight_radio );

$spotlight_radio = new XoopsFormRadioYN( _AM_WFS_SPOTLIGHT, 'spotlight', $article->spotlight(), ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
$sform->addElement( $spotlight_radio );

ob_start();
WfsLists::getforum( $xoopsModuleConfig['selectforum'], $article->isforumid() );
$sform->addElement( new XoopsFormLabel( _AM_WFS_EDITDISCUSSINFORUM, ob_get_contents() ) );
ob_end_clean();

$sform->insertBreak( "", "even" );

$other_options_tray = new XoopsFormElementTray( _AM_WFS_OTHEROPTIONS, '<br />' );

$allowcom = ( $article->allowcom ) ? 1 : 0;
$addcomments_checkbox = new XoopsFormCheckBox( '', "allowcom", $allowcom );
$addcomments_checkbox->addOption( 1, _AM_WFS_EDITALLOWCOMENTS );
$other_options_tray->addElement( $addcomments_checkbox );

$isframe = ( $article->isframe ) ? 1 : 0;
$isframe_checkbox = new XoopsFormCheckBox( '', "isframe", $isframe );
$isframe_checkbox->addOption( 1, _AM_WFS_EDITJUSTHTML );
$other_options_tray->addElement( $isframe_checkbox );

$noshowart = ( $article->noshowart ) ? 1 : 0;
$noshowart_checkbox = new XoopsFormCheckBox( '', "noshowart", $noshowart );
$noshowart_checkbox->addOption( 1, _AM_WFS_EDITNOSHOART );
$other_options_tray->addElement( $noshowart_checkbox );

$offline = ( $article->offline ) ? 1 : 0;
$offline_checkbox = new XoopsFormCheckBox( '', "offline", $offline );
$offline_checkbox->addOption( 1, _AM_WFS_EDITOFFLINE );
$other_options_tray->addElement( $offline_checkbox );

$cmainmenu = ( $article->cmainmenu ) ? 1 : 0;
$cmainmenu_checkbox = new XoopsFormCheckBox( '', "cmainmenu", $cmainmenu );
$cmainmenu_checkbox->addOption( 1, _AM_WFS_EDITMAINMENU );
$other_options_tray->addElement( $cmainmenu_checkbox );

$move_checkbox = new XoopsFormCheckBox( '', "movetotop", 0 );
$move_checkbox->addOption( 1, _AM_WFS_EDITMOVETOTOP );
$other_options_tray->addElement( $move_checkbox );

$sform->addElement( $other_options_tray );
$sform->insertBreak( "", "even" );

/**
 * Version tray
 */
$version_tray = new XoopsFormElementTray( _AM_WFS_EDITVERSIONNUM, ' ' );
$version = new XoopsFormText( '', "version", 10, 50, $article->version() );
$version_tray->addElement( $version );
$version_checkbox = new XoopsFormCheckBox( '', "version_update", 1 );
$version_checkbox->addOption( 1, _AM_WFS_EDITVERSION );
$version_tray->addElement( $version_checkbox );
$sform->addElement( $version_tray );
/**
 * Approve checkbox, is checked first to see if admin user ass access
 */
if ( accessadmin( "docapprove", 1, 0 ) == true ) {
    $approved = ( $article->published && $article->articleid ) ? 1 : ( !$article->articleid ) ? 1 : 0;
    $approve_checkbox = new XoopsFormCheckBox( _AM_WFS_EDITAPPROVE, "approved", $approved );
    $approve_checkbox->addOption( 1, " " );
    $sform->addElement( $approve_checkbox );
}

if ( $article->articleid )
    $sform->addElement( new XoopsFormHidden( "articleid", $article->articleid ) );

if ( isset( $checkin_id ) && intval( $checkin_id ) )
    $sform->addElement( new XoopsFormHidden( "checkin_id", intval( $checkin_id ) ) );
/**
 * form Buttons
 */
$button_tray = new XoopsFormElementTray( "", "" );
$hidden = new XoopsFormHidden( "op", "Save" );
$button_tray->addElement( $hidden );

$saveit = ( !$article->articleid ) ? _AM_WFS_SAVE : _AM_WFS_MODIFY;
$butt_save = new XoopsFormButton( "", "", $saveit, "submit" );
$butt_save->setExtra( "onclick='this.form.elements.op.value=\"Save\"'" );
$button_tray->addElement( $butt_save );
if ( $article->articleid ) {
    if ( accessadmin( "deletearticles", 1 , $article->articleid ) ) {
        $butt_del = new XoopsFormButton( "", "", _AM_WFS_DELETE, "submit" );
        $butt_del->setExtra( "onclick='this.form.elements.op.value=\"delete\"'" );
        $button_tray->addElement( $butt_del );
    }
    $butt_copy = new XoopsFormButton( "", "", _AM_WFS_COPY1, "submit" );
    $butt_copy->setExtra( "onclick='this.form.elements.op.value=\"Copy\"'" );
    $button_tray->addElement( $butt_copy );
}
$sform->addElement( $button_tray );
$sform->display();
unset( $hidden );

?>
