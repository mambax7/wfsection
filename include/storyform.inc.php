<?php
// $Id: storyform.inc.php,v 1.4 2004/08/13 12:48:54 phppp Exp $
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
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
include_once WFS_ROOT_PATH . "/class/wfslists.php";

$editing = ( !$this->articleid ) ? _WFS_CREATEARTICLE : _WFS_MODIFYARTICLE;
$title = ( $article->title ) ? $article->title : _WFS_EDITNEWARTTITLE;
$create = ( $article->articleid ) ? _WFS_MOVETO : _WFS_IN;

$sform = new XoopsThemeForm( $editing . ": " . $title , "storyform", xoops_getenv( 'PHP_SELF' ) );
$sform->setExtra( 'enctype="multipart/form-data"' );

$movesectiontext = ( $article->articleid ) ? _WFS_EDITSECTION2 : _WFS_EDITSECTION;
$catid = ( $article->categoryid ) ? $article->categoryid : 0;
$mytree = new XoopsTree( $xoopsDB->prefix( "wfs_category" ), "id", "pid" );
ob_start();
$mytree->makeMySelBox( "title", "title", $catid, 0 );
$sform->addElement( new XoopsFormLabel( $movesectiontext, ob_get_contents() ) );
ob_end_clean();;

$sform->addElement( new XoopsFormText( _WFS_EDITARTICLETITLE, "title", 50, 255, $article->title( "E" ) ), true );
$sform->addElement( new XoopsFormTextArea( _WFS_EDITSUBTITLE, 'subtitle', $article->subtitle( "E" ), 5, 60 ), false );
/*
$linked_url_tray = new XoopsFormElementTray( _WFS_EDITLINKURL, "<br />" );
$linked_url = new XoopsFormText( _WFS_EDITLINKURLADD, "url", 50, 255, $article->url( "E" ) );
$linked_url_tray->addElement( $linked_url );
$linked_urlname = new XoopsFormText( _WFS_EDITLINKURLNAME, "urlname", 50, 255, $article->urlname( "E" ) );
$linked_url_tray->addElement( $linked_urlname );
$sform->addElement( $linked_url_tray );
*/
if ( wfs_checkBrowser() == true && $xoopsModuleConfig["userwysiwygeditor"] == 1 && $has_access == true )
{
    include_once XOOPS_ROOT_PATH . "/modules/spaw/spaw_control.class.php";
    ob_start();
    $sw = new SPAW_Wysiwyg( 'maintext', $article->maintext( "N" ), $xoopsConfig['language'], 'full', 'default', '50%', '400px' );
    $sw->show();
    $sform->addElement( new XoopsFormLabel( _WFS_EDITMAINTEXT , ob_get_contents(), 1 ) );
    ob_end_clean();
}
else
{
    $sform->addElement( new XoopsFormDhtmlTextArea( _WFS_EDITMAINTEXT, "maintext", $article->maintext( "N" ), 15, 60 ), false );
}

$sform->addElement( new XoopsFormTextArea( _WFS_EDITSUMMARY, "summary", $article->summary( "E" ), 7, 60 ) );
$other_options_tray = new XoopsFormElementTray( _WFS_OTHEROPTIONS, '<br />' );
/**
 * if (is_object($xoopsUser) && $xoopsUser->isAdmin($xoopsModule->getVar('mid')))
 * {
 * $html_checkbox = new XoopsFormCheckBox('', "nohtml", $article->nohtml);
 * $html_checkbox->addOption(1, _WFS_EDITDISHTML);
 * $other_options_tray->addElement($html_checkbox);
 * }
 */
$smiley_checkbox = new XoopsFormCheckBox( '', "nosmiley", $article->nosmiley );
$smiley_checkbox->addOption( 1, _WFS_EDITDISAMILEY );
$other_options_tray->addElement( $smiley_checkbox );

$xcodes_checkbox = new XoopsFormCheckBox( '', 'noxcodes', $article->noxcodes );
$xcodes_checkbox->addOption( 1, _WFS_EDITDISCODES );
$other_options_tray->addElement( $xcodes_checkbox );

$notify_checkbox = new XoopsFormCheckBox( '', "notifypub", $article->notifypub );
$notify_checkbox->addOption( 1, _WFS_NOTIFYPUBLISH );
$other_options_tray->addElement( $notify_checkbox );

$sform->addElement( $other_options_tray );

$break_num = ( $xoopsModuleConfig["userwysiwygeditor"] == 1 ) ? 0 : 1;
$sform->addElement( new XoopsFormHidden( "nobreaks", $break_num ) );
$sform->addElement( new XoopsFormHidden( "nohtml", $break_num ) );

ob_start();
WfsLists::getforum( $xoopsModuleConfig['selectforum'], $article->isforumid());
//wfs_getforum( $article->isforumid() );
$sform->addElement( new XoopsFormLabel( _WFS_EDITDISCUSSINFORUM, ob_get_contents() ) );
ob_end_clean();

if ( $submit_files_access == true )
{
    $sform->insertBreak( _WFS_FILES_CREATE, "even" );
    $sform->addElement( new XoopsFormFile( _WFS_FILES_UPLOAD, 'uploadfile', '' ), false );
    $sform->addElement( new XoopsFormText( _WFS_FILES_TITLE, "fileshowname", 50, 255, '' ), false );
    $sform->addElement( new XoopsFormTextArea( _WFS_FILES_DESCRIPT, 'textfiledescript', '', 5, 60 ), false );
    $sform->addElement( new XoopsFormTextArea( _WFS_FILES_SEARCHTEXT, 'textfilesearch', '', 5, 60 ), false );
    // echo "<br />articleid:".$article->articleid.":uid:$uid";
    $file = false;
    $files = 0;
    if ( $article->articleid )
    {
        $files = WfsFiles::getAllfiles( 0, 0, $article->articleid, $uid );
    }
    // $filecount = count($files);
    if ( $files )
    {
        $upl_tray = new XoopsFormElementTray( _WFS_FILES_ATTACHED, '<br />' );
        $upl_checkbox = new XoopsFormCheckBox( '', 'delupload[]' );
        foreach( $files as $file )
        {
            $link = $file->getLinkedName( XOOPS_URL . "/modules/" . $xoopsModule->dirname() );
            $upl_checkbox->addOption( $file->fileid, _WFS_FILEID . " " . $file->fileid . " " . $link . "<br />" );
        }
        $upl_tray->addElement( $upl_checkbox, false );
        $dellabel = new XoopsFormLabel( _WFS_FILES_DELETE_SELECTED, '' );
        $upl_tray->addElement( $dellabel, false );
        $sform->addElement( $upl_tray );
    }
}
$sform->addElement( new XoopsFormHidden( "is_edit", $is_edit ) );
$sform->addElement( new XoopsFormHidden( "submit_files_access", $submit_files_access ) );

if ( $article->articleid )
    $sform->addElement( new XoopsFormHidden( "articleid", $article->articleid ) );
//if ( intval( $checkin_id ) )
//    $sform->addElement( new XoopsFormHidden( "checkin_id", intval( $checkin_id ) ) );

$button_tray = new XoopsFormElementTray( "", "" );
$hidden = new XoopsFormHidden( "op", "post" );
$button_tray->addElement( $hidden );

$saveit = ( !$article->articleid ) ? _WFS_SAVE : _WFS_MODIFY;
$butt_save = new XoopsFormButton( "", "", $saveit, "submit" );
$butt_save->setExtra( "onclick='this.form.elements.op.value=\"post\"'" );
$button_tray->addElement( $butt_save );

if ( $article->articleid )
{
    $butt_del = new XoopsFormButton( "", "", _WFS_DELETE, "submit" );
    $butt_del->setExtra( "onclick='this.form.elements.op.value=\"delete\"'" );
    $button_tray->addElement( $butt_del );
}
$sform->addElement( $button_tray );
$sform->display();
unset( $hidden );

?>