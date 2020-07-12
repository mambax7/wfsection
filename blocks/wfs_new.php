<?php 
// $Id: wfs_new.php,v 1.4 2004/08/13 12:43:59 phppp Exp $
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
// Important change this to the directory path you have choosen.
include_once XOOPS_ROOT_PATH . "/modules/wfsection/class/common.php";
include_once WFS_ROOT_PATH . '/include/functions.php';
include_once WFS_ROOT_PATH . '/include/groupaccess.php';

function b_wfs_new_show( $options )
{
    global $xoopsDB, $wfsPathConfig;

    $modhandler = &xoops_gethandler( 'module' );
    $xoopsModule = &$modhandler->getByDirname( WFSECTION );
    $config_handler = &xoops_gethandler( 'config' );
    $xoopsModuleConfig = &$config_handler->getConfigsByCat( 0, $xoopsModule->getVar( 'mid' ) );

    if($options[0] == 'random'){
	    $sql = "SELECT MAX(articleid) as maxid FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB );
	    $result = $xoopsDB->query( $sql);
	    $row = $xoopsDB->fetchArray( $result );
	    $maxid = $row['maxid'];
	    srand(time());
	    $ids = array();
	    $id_keys = array_keys($ids);
	    $id_nums = $options[1] * 2;
	    while(count($id_keys)<min($id_nums,$maxid)){
		    $id_id = rand(1,$maxid);
		    $ids[$id_id] = 1;
	    	$id_keys = array_keys($ids);
	    }
	    $id_criteria = " AND articleid IN (".implode(',',$id_keys).")";
	    $od_criteria = "";
    }else {
	    $id_criteria = "";
	    $od_criteria = " ORDER BY " . $options[0] . " DESC";
    }
    
    $myts = &MyTextSanitizer::getInstance();
    $block = array();
    $sql = "SELECT articleid, title, published, expired, counter, groupid, articleimg, url, summary 
			FROM " . $xoopsDB->prefix( WFS_ARTICLE_DB ) . " 
			WHERE published < " . time() . " 
			AND published > 0 
			AND (expired = 0 OR expired > " . time() . ") 
			AND noshowart = 0 
			AND offline = 0 ".
			$id_criteria.
			$od_criteria; 
    $result = $xoopsDB->query( $sql, $options[1], 0 );

    while ( $myrow = $xoopsDB->fetchArray( $result ) )
    {

        $wfs = array();
        $title = $myts->htmlSpecialChars( stripslashes( $myrow["title"] ) );
        if ( $xoopsModuleConfig['shortartlen'] > 0)
        {
            $title = xoops_substr( $title, 0, ( $xoopsModuleConfig['shortartlen'] -1 ) );
        } 
        
		$wfs['title'] = ( $myrow['url'] ) ?
			"<a href='" . formatURL( $myrow['url'] ) . "' target='_blank'>" . $title . "</a>" :
        	"<a href='" . WFS_ROOT_URL . "/article.php?articleid=" . $myrow['articleid'] . "'>" . $title . "</a>" ; 

        $wfs['new'] = ( $options[0] == "published" ) ? formatTimestamp( $myrow['published'], "s" ) : $myrow['counter'];
	
        //display article image
		$wfs['image'] = "";
        $art_image = ( empty( $myrow['articleimg'] ) && $xoopsModuleConfig['default_image'] ) ? $xoopsModuleConfig['default_image'] : $myrow['articleimg'];
		
		if ( $options[3] == 1 && !empty( $art_image ) && $art_image != "blank.png" )
        {
            $wfs['image'] = ( $xoopsModuleConfig['use_thumbs'] ) ? wfs_createthumb( $art_image, $wfsPathConfig['graphicspath'], "thumbs", 47, 62, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : WFS_ARTICLEIMG_URL . '/' . $art_image;
        } 
		//start of summary 
        $wfs['summary'] = "";
        if ( $options[5] == 1 && !empty( $myrow["summary"] ) )
        {
            $wfs['summary'] = $myts->htmlSpecialChars( stripslashes( $myrow["summary"] ) );
            $wfs['summary'] = xoops_substr( $wfs['summary'], 0, ( $options[7] -1 ) );
        } 
        $block['new'][] = $wfs;
    } 
    return $block;
} 

function b_wfs_new_edit( $options )
{
    $form = "";
    //$form = "" . _MB_WFS_ORDER . "&nbsp;<select name='options[]'>";

    /*
    $form .= "<option value='published'";
    if ( $options[0] == "published" )
    {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_WFS_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ( $options[0] == "counter" )
    {
        $form .= " selected='selected'";
    } 
    $form .= ">" . _MB_WFS_HITS . "</option>\n";

    $form .= "</select>\n";
    */
    
    $form .= "<input type='hidden' name='options[]' value='" . $options[0] . "' />";
    $form .= "<br />" . _MB_WFS_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_WFS_ARTCLS . "";
    $form .= "<br />" . _MB_WFS_CHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_WFS_LENGTH . "";

    $form .= "<br />" . _MB_WFS_DISPLAYI . "&nbsp;<input type='radio' name='options[3]' value='1'";
    if ( $options[3] == 1 )
    {
        $form .= " checked='checked'";
    } 
    $form .= " />&nbsp;" . _YES . "<input type='radio' name='options[3]' value='0'";
    if ( $options[3] == 0 )
    {
        $form .= " checked='checked'";
    } 
    $form .= " />&nbsp;" . _NO;

    $form .= '<input type="hidden" name="options[3]" value="' . $options[3] . '">';

    $form .= "<br />" . _MB_WFS_DISPLAYS . "&nbsp;<input type='radio' name='options[5]' value='1'";
    if ( $options[5] == 1 )
    {
        $form .= " checked='checked'";
    } 
    $form .= " />&nbsp;" . _YES . "<input type='radio' name='options[5]' value='0'";
    if ( $options[5] == 0 )
    {
        $form .= " checked='checked'";
    } 
    $form .= " />&nbsp;" . _NO;
    $form .= '<input type="hidden" name="options[6]" value="' . $options[6] . '">';
    $form .= "<br>" . _MB_WFS_SCHARS . "&nbsp;<input type='text' name='options[]' value='" . $options[7] . "' />";

    return $form;
} 

?>