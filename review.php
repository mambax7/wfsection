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
    $diff_array = array( 'None', 'Easy', 'Medium', 'Hard', 'No Chance!', 'You must be a GOD' );
    $online_array = array( 'No', 'Yes' );
    $g_ratings = array( 'None', 'EC - Early Childhood', 'E - Everyone', 'T - Teen', 'M - Mature', 'AO - Adults Only', 'RP - Rating Pending' );
    $grading_array = array( 0 => '--',
        1 => 'A+', 2 => 'A', 3 => 'A-',
        4 => 'B+', 5 => 'B', 6 => 'B-',
        7 => 'C+', 8 => 'C', 9 => 'C-',
        10 => 'D+', 11 => 'D', 12 => 'D-',
        13 => 'E+', 14 => 'E', 15 => 'E-',
        16 => 'F+', 17 => 'F', 18 => 'F-', 
        );

    $image1 = $myts->stripSlashesGPC( $review_arr['img_one'] );
    if ( $image1 )
    {
        $image1 = ( $xoopsModuleConfig['use_thumbs'] ) ? wfs_createthumb( $image2, $wfsPathConfig['graphicspath'], "thumbs", 250, 300, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : WFS_ARTICLEIMG_URL . '/' . $image1;
        $articletag['maintext'] = "<img src='$image1' width='300' height='250' align='left' vspace='5' hspace=5 border='1' alt='" . $articletag['titlemain'] . "' >";
    } 

    $articletag['maintext'] .= "<div><b>" . _WFS_INTROTEXT . "</b></div>";
    $articletag['maintext'] .= "<div>" . $myts->displayTarea( $myts->stripSlashesGPC( $review_arr['introtext'] ), 1, 1, 1, 1, 1 ) . "</div><br />";

    $articletag['maintext'] .= "<div><b>" . _WFS_GAMEPLAYTEXT . "</b></div>";
    $articletag['maintext'] .= "<div>" . $myts->displayTarea( $myts->stripSlashesGPC( $review_arr['gameplaytext'] ), 1, 1, 1, 1, 1 ) . "</div><br />";

    $articletag['maintext'] .= "<div><b>" . _WFS_GRAPHICSTEXT . "</b></div>";
    $articletag['maintext'] .= "<div>" . $myts->displayTarea( $myts->stripSlashesGPC( $review_arr['graphicstext'] ), 1, 1, 1, 1, 1 ) . "</div><br />";

    $image2 = $myts->stripSlashesGPC( $review_arr['img_one'] );
    if ( $image2 )
    {
        $image2 = ( $xoopsModuleConfig['use_thumbs'] ) ? wfs_createthumb( $image2, $wfsPathConfig['graphicspath'], "thumbs", 250, 300, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : WFS_ARTICLEIMG_URL . '/' . $image2;
        $articletag['maintext'] .= "<img src='$image2' width='300' height='250' align='right' vspace='5' hspace=5 border='1' alt='" . $articletag['titlemain'] . "' >";
    } 

    $articletag['maintext'] .= "<div><b>" . _WFS_MUSICTEXT . "</b></div>";
    $articletag['maintext'] .= "<div>" . $myts->displayTarea( $myts->stripSlashesGPC( $review_arr['musictext'] ), 1, 1, 1, 1, 1 ) . "</div><br />";

    $articletag['maintext'] .= "<div><b>" . _WFS_FINALTEXT . "</b></div>";
    $articletag['maintext'] .= "<div>" . $myts->displayTarea( $myts->stripSlashesGPC( $review_arr['finaltext'] ), 1, 1, 1, 1, 1 ) . "</div><br />";

    if ( !empty( $review_arr['grading'] ) )
        $articletag['maintext'] .= "<div><b>" . _WFS_GRADE . "</b> " . $grading_array[$review_arr['grading']] . "</div>";
	if ( !empty( $review_arr['publisher'] ) )
        $articletag['maintext'] .= "<div><b>" . _WFS_PUBLISHER . "</b> " . $review_arr['publisher'] . "</div>";
	if ( !empty( $review_arr['developer'] ) )
    	$articletag['maintext'] .= "<div><b>" . _WFS_DEVELOPER . "</b> " . $review_arr['developer'] . "</div>";
	if ( !empty( $review_arr['developer'] ) && !empty( $review_arr['websitename'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_WEBSITE . "</b> <a href='".$review_arr['websiteurl']."'>".$review_arr['websitename']."</a></div>";    
	if ( !empty( $review_arr['released'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_RELEASED . "</b> " . $review_arr['released'] . "</div><br />";
	if ( !empty( $review_arr['genre'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_GENRE . "</b> " . $review_arr['genre'] . "</div>";
	if ( !empty( $review_arr['players'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_PLAYERS . "</b> " . $review_arr['players'] . "</div>";
	if ( !empty( $review_arr['family'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_ESRB . "</b> " . $g_ratings[$review_arr['family']] . "</div>";
	if ( !empty( $review_arr['platform'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_PLATFORM . "</b> " . $review_arr['platform'] . "</div>";
	if ( !empty( $review_arr['difficulty'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_DIFFICULTY . "</b> " . $diff_array[$review_arr['difficulty']] . "</div>";
	if ( !empty( $review_arr['curve'] ) )
		$articletag['maintext'] .= "<div><b>" . _WFS_LEARNINGCURVE . "</b> " . $diff_array[$review_arr['curve']] . "</div>";


	/*	
	if ( !empty( $review_arr['graphics'] ) )
    	$rating = round(number_format($review_arr['graphics'], 0) / 2);
    	$review['graphics'] = "rate$rating.gif";
	
	if ( !empty( $review_arr['sound'] ) )
    	$rating = round(number_format($review_arr['sound'], 0) / 2);
    	echo $review['sound'] = "rate$rating.gif";
	
	if ( !empty( $review_arr['gameplay'] ) )
    	$rating = round(number_format($review_arr['gameplay'], 0) / 2);
    	$review['gameplay'] = "rate$rating.gif";
	
	if ( !empty( $review_arr['curve'] ) )
    	$rating = round(number_format($review_arr['concept'], 0) / 2);
    	$review['concept'] = "rate$rating.gif";
	
	if ( !empty( $review_arr['curve'] ) )
    	$rating = round(number_format($review_arr['value'], 0) / 2);
    	$review['value'] = "rate$rating.gif";

	if ( !empty( $review_arr['tilt'] ) )
	    $rating = round(number_format($review_arr['tilt'], 0) / 2);
    	$review['tilt'] = "rate$rating.gif";
    $review['overall'] = ($review_arr['graphics'] + $review_arr['sound'] + $review_arr['gameplay'] + $review_arr['concept'] + $review_arr['value']);

	$articletag['maintext'] .= "<p><div style=\"float: right; width: 30%; \">
	    <div style=\"margin-left: 5px; margin-right: 5px; margin-top: 5px;padding: 4px; background-color:#E6E6E6; border-color:#999999;\" class = \"outer\">"; 
    $articletag['maintext'] .= "<div align=\"left\"><b><{$lang_overall}></b>&nbsp;<b><font size=\"4\">".$review['graphics']."/50</font></b></div> 
          <br /> 
          <div align=\"left\"> 
            <div align=\"right\"><b><{$lang_gameplay}></b>&nbsp;<img src=\"images/icon/".$review['overall']."\" alt=\"\" align=\"absmiddle\"></div> 
          </div> 
          <div align=\"left\"> 
            <div align=\"right\"><b><{$lang_publisher}></b>&nbsp;<img src=\"images/icon/".$review['graphics']."\" alt=\"\" align=\"absmiddle\"></div> 
          </div> 
          <div align=\"left\"> 
            <div align=\"right\"><b><{$lang_sound}></b>&nbsp;<img src=\"images/icon/".$review['sound']."\" alt=\"\" align=\"absmiddle\"></div> 
          </div> 
          <div align=\"left\"> 
            <div align=\"right\"><b><{$lang_concept}></b>&nbsp;<img src=\"images/icon/".$review['graphics']."\" alt=\"\" align=\"absmiddle\"></div> 
          </div> 
          <div align=\"left\"> 
            <div align=\"right\"><b><{$lang_value}></b>&nbsp;<img src=\"images/icon/".$review['value']."\" alt=\"\" align=\"absmiddle\"></div> 
          </div> 
          <div align=\"left\"> 
            <div align=\"right\"><b><{$lang_tilt}></b>&nbsp;<img src=\"images/icon/".$review['tilt']."\" alt=\"\" align=\"absmiddle\"></div> 
          </div> 
        </div></p>";
		*/ 	

?>