<?php 
// $Id: reviews.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include_once WFS_ROOT_PATH . "/class/wfslists.php";

accessadmin( "reviews" );


if ( isset( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        ${$k} = $v;
    } 
} 

if ( isset( $_GET ) )
{
    foreach ( $_GET as $k => $v )
    {
        ${$k} = $v;
    } 
} 

$op = '';

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

switch ( $op )
{
    case "saverelated";

        global $myts;

        foreach ( $_POST as $key => $main )
        {
            if ( is_numeric( $main ) )
            {
                $$key = intval( $main );
            } 
            else
            {
                if ( get_magic_quotes_gpc() )
                {
                    $$key = addslashes( $main );
                } 
                else
                {
                    $$key = $main;
                } 
            } 
        } 

        if ( !$_POST['review_id'] )
        {
            $query = "INSERT INTO " . $xoopsDB->prefix( WFS_REVIEWS ) . " (review_id, article_id, introtext, 
				gameplaytext, graphicstext, musictext, finaltext, img_one, img_two, publisher, developer,websiteurl,
				websitename, released, genre, players, platform, 
				playonline, family, difficulty, curve, grading, 
				graphics, sound, gameplay, concept, value, tilt, display) ";
            $query .= "VALUES (0, $article_id, '$introtext',
				'$gameplaytext', '$graphicstext', '$musictext', '$finaltext', '$img_one', '$img_two', '$publisher', 
				'$developer', '$websiteurl', '$websitename', '$released', '$genre', '$players', '$platform', 
				$playonline, $family, $difficulty, '$curve', $grading, 
				$graphics, $sound, $gameplay, $concept, $value, $tilt, $display)";
        } 
        else
        {
            $query = "UPDATE " . $xoopsDB->prefix( WFS_REVIEWS ) . " SET 
				article_id = $article_id, introtext = '$introtext', gameplaytext = '$gameplaytext', 
				graphicstext = '$graphicstext', musictext = '$musictext', finaltext = '$finaltext', 
				img_one = '$img_one', img_two = '$img_two', publisher = '$publisher', 
				developer = '$developer', websiteurl = '$websiteurl', websitename = '$websitename', 
				released = '$released', genre = '$genre', players = '$players', platform = '$platform', 
				playonline = $playonline, family = $family, difficulty = $difficulty, curve = '$curve', grading = $grading, 
				graphics= $graphics, sound = $sound, gameplay = $gameplay, concept = $concept, value = $value, tilt = $tilt, 
				display = $display			
			WHERE review_id =" . $_POST['review_id'] . "";
        } 

        $error = "Could not create information: <br /><br />";
        $error .= $query;
        $result = $xoopsDB->queryF( $query );
        if ( !$result )
        {
            trigger_error( $error, E_USER_ERROR );
        } 
        redirect_header( "index.php?op=edit&articleid=$article_id", 2, AM_UPDATED ); 
        // review_id  article_id  publisher  developer  website  difficulty  released  genre  players  playonline  family  curve  graphics  sound  gameplay  concept  value  tilt  overall;
        break;


    default:

        $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;

        $count_array = array( 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10 );
        $grading_array = array( 0 => '--',
            1 => 'A+', 2 => 'A', 3 => 'A-',
            4 => 'B+', 5 => 'B', 6 => 'B-',
            7 => 'C+', 8 => 'C', 9 => 'C-',
            10 => 'D+', 11 => 'D', 12 => 'D-',
            13 => 'E+', 14 => 'E', 15 => 'E-',
            16 => 'F+', 17 => 'F', 18 => 'F-', 
            );

        $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_REVIEWS ) . " WHERE article_id = " . $_GET['articleid'] . "";
        $review_arr = $xoopsDB->fetchArray( $xoopsDB->query( $sql ) );

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_ARTICLEMANAGEMENT, 0 );
        echo "<h4>" . _AM_WFS_RELATEDARTADMIN . "</h4>";

        $article = new WfsArticle( $_GET['articleid'] );

        $sform = new XoopsThemeForm( _AM_WFS_ADDREVIEW . $article->textLink( "S" ) , "op", xoops_getenv( 'PHP_SELF' ) );
        $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_INTROTEXT, 'introtext', $myts->stripSlashesGPC($review_arr['introtext']), 10, 60 ), false );
        $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_GAMEPLAYTEXT, 'gameplaytext', $myts->stripSlashesGPC($review_arr['gameplaytext']), 10, 60 ), false );
        $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_GRAPHICSTEXT, 'graphicstext', $myts->stripSlashesGPC($review_arr['graphicstext']), 10, 60 ), false );
        $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_MUSIC, 'musictext', $myts->stripSlashesGPC($review_arr['musictext']), 10, 60 ), false );
        $sform->addElement( new XoopsFormDhtmlTextArea( _AM_WFS_FINALTHOUGHTS, 'finaltext', $myts->stripSlashesGPC($review_arr['finaltext']), 10, 60 ), false );
        $sform->insertBreak( "", "even" );

        $sform->insertBreak( "Publisher/Game Information", "bg3" );

        $image_option_tray = new XoopsFormElementTray( _AM_WFS_SELECT_IMG, '<br />' );
        $art_image_array = @WfsLists::getListTypeAsArray( WFS_ARTICLEIMG_PATH, $type = "images" );
        $indeximage_select = new XoopsFormSelect( '', 'img_one', $myts->stripSlashesGPC($review_arr['img_one']) );
        $indeximage_select->addOptionArray( $art_image_array );
        $indeximage_select->setExtra( "onchange='showImgSelected(\"image\", \"img_one\", \"" . $wfsPathConfig['graphicspath'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
        $indeximage_tray = new XoopsFormElementTray( '', '&nbsp;' );
        $indeximage_tray->addElement( $indeximage_select );
        if ( !empty( $review_arr['img_one'] ) )
        {
            $indeximage_tray->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/" . $wfsPathConfig['graphicspath'] . "/" . $review_arr['img_one'] . "' name='image' id='image' alt='' width = 300 height = 250/></div>" ) );
        } 
        else
        {
            $indeximage_tray->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' width = 300 height = 250/></div>" ) );
        } 
        $image_option_tray->addElement( $indeximage_tray );
        $sform->addElement( $image_option_tray );

        $image_option_tray2 = new XoopsFormElementTray( _AM_WFS_SELECT_IMG, '<br />' );
        $art_image_array2 = @WfsLists::getListTypeAsArray( WFS_ARTICLEIMG_PATH, $type = "images" );
        $indeximage_select2 = new XoopsFormSelect( '', 'img_two', $myts->stripSlashesGPC($review_arr['img_two']) );
        $indeximage_select2->addOptionArray( $art_image_array2 );
        $indeximage_select2->setExtra( "onchange='showImgSelected(\"image2\", \"img_two\", \"" . $wfsPathConfig['graphicspath'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
        $indeximage_tray2 = new XoopsFormElementTray( '', '&nbsp;' );
        $indeximage_tray2->addElement( $indeximage_select2 );
        if ( !empty( $review_arr['img_two'] ) )
        {
            $indeximage_tray2->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/" . $wfsPathConfig['graphicspath'] . "/" . $review_arr['img_two'] . "' name='image2' id='image2' alt='' width = 300 height = 250/></div>" ) );
        } 
        else
        {
            $indeximage_tray2->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image2' id='image2' alt='' width = 300 height = 250/></div>" ) );
        } 
        $image_option_tray2->addElement( $indeximage_tray2 );
        $sform->addElement( $image_option_tray2 );

        $sform->insertBreak( "", "even" );
        $sform->insertBreak( "Publisher/Game Information", "bg3" );
        $sform->addElement( new XoopsFormText( _AM_WFS_PUBLISHER, 'publisher', 50, 255, $review_arr['publisher'] ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_DEVELOPER, 'developer', 50, 255, $review_arr['developer'] ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_WEBSITE, 'websiteurl', 50, 255, $review_arr['websiteurl'] ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_WEBSITEFREINDLY, 'websitename', 50, 255, $review_arr['websitename'] ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_RELEASED, 'released', 50, 255, $review_arr['released'] ), false );

        $sform->insertBreak( "", "even" );
        $sform->insertBreak( "Game Information", "bg3" );

        $sform->addElement( new XoopsFormText( _AM_WFS_GENRE, 'genre', 50, 255, $review_arr['genre'] ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_PLAYERS, 'players', 50, 255, $review_arr['players'] ), false );
        $sform->addElement( new XoopsFormText( _AM_WFS_PLATFORM, 'platform', 50, 255, $review_arr['platform'] ), false );

        $review_playonline = ( $review_arr['playonline'] == 1 ) ? 1 : 0;
        $striphtml_radio = new XoopsFormRadioYN( _AM_WFS_PLAYONLINE, 'playonline', $review_playonline, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
        $sform->addElement( $striphtml_radio );

        $esrb_select = new XoopsFormSelect( _AM_WFS_ESRB, "family", $review_arr['family'] );
        $esrb_select->addOptionArray( array( 0 => 'None', 1 => 'EC - Early Childhood', 2 => 'E - Everyone',
                3 => 'T - Teen', 4 => 'M - Mature', 5 => 'AO - Adults Only', 6 => 'RP - Rating Pending' ) );
        $sform->addElement( $esrb_select );

        $difficulty_select = new XoopsFormSelect( _AM_WFS_DIFFICULTY, "difficulty", $review_arr['difficulty'] );
        $difficulty_select->addOptionArray( array( 0 => 'None', 1 => 'easy', 2 => 'medium', 3 => 'hard', 4 => 'No Chance!', 5 => 'You must be a GOD' ) );
        $sform->addElement( $difficulty_select );

        $sform->addElement( new XoopsFormText( _AM_WFS_LEARNINGCURVE, 'curve', 50, 255, $review_arr['curve'] ), false );

        $sform->insertBreak( "", "even" );
        $sform->insertBreak( "Game Scores", "bg3" );
        $grading_select = new XoopsFormSelect( _AM_WFS_GRADING, "grading", $review_arr['grading'] );
        $grading_select->addOptionArray( $grading_array );
        $sform->addElement( $grading_select );

        $graphics_select = new XoopsFormSelect( _AM_WFS_GRAPHICS, "graphics", $review_arr['graphics'] );
        $graphics_select->addOptionArray( $count_array );
        $sform->addElement( $graphics_select );

        $sound_select = new XoopsFormSelect( _AM_WFS_SOUND, "sound", $review_arr['sound'] );
        $sound_select->addOptionArray( $count_array );
        $sform->addElement( $sound_select );

        $gameplay_select = new XoopsFormSelect( _AM_WFS_GAMEPLAY, "gameplay", $review_arr['gameplay'] );
        $gameplay_select->addOptionArray( $count_array );
        $sform->addElement( $gameplay_select );

        $concept_select = new XoopsFormSelect( _AM_WFS_CONCEPT, "concept", $review_arr['concept'] );
        $concept_select->addOptionArray( $count_array );
        $sform->addElement( $concept_select );

        $value_select = new XoopsFormSelect( _AM_WFS_VALUE, "value", $review_arr['value'] );
        $value_select->addOptionArray( $count_array );
        $sform->addElement( $value_select );

        $tilt_select = new XoopsFormSelect( _AM_WFS_TILT, "tilt", $review_arr['tilt'] );
        $tilt_select->addOptionArray( $count_array );
        $sform->addElement( $tilt_select );

        $sform->insertBreak( "", "even" );

        $review_display = ( $review_arr['display'] == 1 ) ? 1 : 0;
        $display_radio = new XoopsFormRadioYN( _AM_WFS_DISPLAYREVIEW, 'display', $review_display, ' ' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '' );
        $sform->addElement( $display_radio );
        $review_id = ( $review_arr['review_id'] ) ? $review_arr['review_id'] : 0;
        $sform->addElement( new XoopsFormHidden( "review_id", $review_id ) );
        $sform->addElement( new XoopsFormHidden( "article_id", $_GET['articleid'] ) );

        $button_tray = new XoopsFormElementTray( '', '' );
        $hidden = new XoopsFormHidden( 'op', 'saverelated' );
        $button_tray->addElement( $hidden );
        $button_tray->addElement( new XoopsFormButton( '', 'submit', _AM_WFS_SAVE, 'submit' ) );
        $button_tray->addElement( new XoopsFormButton( '', 'reset', _AM_WFS_RESET, 'reset' ) );
        $sform->addElement( $button_tray );
        $sform->display();
        unset( $hidden );
        break;
} 
xoops_cp_footer();

?>