<?php 
// $Id: spotlightblock.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include_once WFS_ROOT_PATH . '/class/wfscategory.php';
include_once WFS_ROOT_PATH . '/class/wfsarticle.php';
include_once WFS_ROOT_PATH . '/class/wfstree.php';

$op = '';
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

switch ( $op )
{
    case 'submit':

        $item = addslashes( $_POST["spot_id"] );
        $image = addslashes( $_POST["spot_image"] );
        $itemlength = addslashes( $_POST["itemlength"] );
        $imagewidth = addslashes( $_POST["imagewidth"] );
        $imageheight = addslashes( $_POST["imageheight"] );
        $sum_type = addslashes( $_POST["sum_type"] );

        $sql = "UPDATE " . $xoopsDB->prefix( WFS_SPOTLIGHT )
         . " SET item='" . $item
         . "', image='" . $image
         . "', itemlength=" . $itemlength
         . ", imagewidth=" . $imagewidth
         . ", imageheight=" . $imageheight
         . ", sum_type=" . $sum_type
         . " WHERE sid = 1";
        $result = $xoopsDB->query( $sql );

        if ( $result )
        {
            redirect_header( "spotlightblock.php", 1 , _AM_WFS_DBUPDATED );
        } 
        else
        {
            $error = _AM_WFS_ERROR_CREATESPOTLIGHT . $sql;
            trigger_error( $error, E_USER_ERROR );
        } 
        exit();
        break;

    case 'default':
    default:

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_DOCSPOTLIGHTHEADING );
        wfs_textinfo( _AM_WFS_DOCSPOTLIGHTINFO, _AM_WFS_DOCSPOTLIGHTTEXT );

        $sql = ( "SELECT item, image, itemlength, imagewidth, imageheight, sum_type FROM " . $xoopsDB->prefix( WFS_SPOTLIGHT ) . " WHERE sid=1" );
        $result = $xoopsDB->query( $sql );
        list ( $item, $indeximage, $itemlength, $imagewidth, $imageheight, $sum_type ) = $xoopsDB->fetchRow( $result );

        $currentspot_id = $item;
        if ( $item > 0 )
        {
            $currentspot_desc = $item;
        } 
        else
        {
            $item = WfsArticle::getLastArticleByCategory();
            $currentspot_desc = _AM_WFS_USE_LASTPUBLISHED . " <b>No:</b> " . $item;
        } 

        $current_spot = new WfsArticle( $item );
        echo "<h4>" . _AM_WFS_CURRENT_SPOT . "</h4>";
        if ( $current_spot )
        {
            echo "<table border='0' width='100%' cellpadding ='2' cellspacing='1' class = 'outer'>";
            echo "<tr><td class = \"bg3\" colspan = \"2\">" . _AM_WFS_STORYID . "</td></tr>";
            echo "<tr><td class = \"head\">" . _AM_WFS_STORYID . "</td><td class = \"even\">" . " <b>No:</b> " . $currentspot_desc;
            echo "</td></tr>";
            echo "<tr><td class = \"head\">" . _AM_WFS_TITLE . "</td><td class = \"even\">" . $current_spot->textLink();
            echo "</td></tr>";
            echo "<tr><td class = \"head\">" . _AM_WFS_AUTHOR . "</td><td class = \"even\">" . $current_spot->uname();
            echo "</td></tr>";
            echo "<tr><td class = \"head\">" . _AM_WFS_CATEGORYNAME . "</td><td class = \"even\">" . $current_spot->category->textLink();
            echo "</td></tr>";
            $published_date = ( $current_spot->published() > '0' ) ? formatTimestamp( $current_spot->published(), "$xoopsModuleConfig[timestamp]" ) : "" . _AM_WFS_NOTPUBLISHED . "";
            echo "<tr><td class = \"head\">" . _AM_WFS_PUBLISHED . "</td><td valign = 'top' class = \"even\">" . $published_date;
            echo "</td></tr>";

            echo "<tr><td valign = 'top' class = \"head\">" . _AM_WFS_DOCSPOTLIGHTIMAGE . "</td>";
            echo "<td>";
            if ( $indeximage )
            {
                $index_image = ( $xoopsModuleConfig['use_thumbs'] == 1) ? 
					wfs_createthumb( $indeximage, $wfsPathConfig['graphicspath'], "thumbs", $imagewidth, $imageheight, $xoopsModuleConfig['imagequality'], $xoopsModuleConfig['updatethumbs'], $xoopsModuleConfig['keepaspect'] ) : 
					WFS_ARTICLEIMG_URL . '/' . $indeximage;
				
				echo "<span style='float:left; background-color: transparent;'> 
					<img src='" . $index_image . "' height = '$imageheight' width = '$imagewidth' hspace= '5' vspace= '0'  alt='' style='border: 1px solid black'>
					</span>
					";
            } 
            switch ( trim( $sum_type ) )
            {
                case 1:
                    $maintext = $current_spot->subtitle( "S" );
                    break;
                case 2:
                    $maintext = $current_spot->summary( "S" );
                    break;
                case 3:
                default:
                    $maintext = $current_spot->maintext( "E" );
                    break;
            } 
            $spot_main_text = ( $itemlength >= 1 ) ? wfs_summarize( $maintext, $itemlength ) : $maintext;
            $spot_main_text = preg_replace( "/(\<img)(.*?)(\>)/si", "", $spot_main_text );
            echo "" . $spot_main_text . "";
            echo "</td></tr>\n";
            echo "</table><br />\n";
        } 

        $sform = new XoopsThemeForm( _AM_WFS_DOCSPOTLIGHTFORM , "op", xoops_getenv( 'PHP_SELF' ) );
        $image_option_tray = new XoopsFormElementTray( _AM_WFS_DOCSPOTLIGHTIMAGE, '<br />' );
        $art_image_array = @WfsLists::getListTypeAsArray( WFS_ARTICLEIMG_PATH, $type = "images" );
        $indeximage_select = new XoopsFormSelect( '', 'spot_image', $indeximage );
        $indeximage_select->addOptionArray( $art_image_array );
        $indeximage_select->setExtra( "onchange='showImgSelected(\"image\", \"spot_image\", \"" . $wfsPathConfig['graphicspath'] . "\", \"\", \"" . XOOPS_URL . "\")'" );
        $indeximage_tray = new XoopsFormElementTray( '', '&nbsp;' );
        $indeximage_tray->addElement( $indeximage_select );
        if ( !empty( $indeximage ) )
        {
            $indeximage_tray->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/" . $wfsPathConfig['graphicspath'] . "/" . $indeximage . "' height = '$imageheight' width = '$imagewidth' name='image' id='image' alt='' /></div>" ) );
        } 
        else
        {
            $indeximage_tray->addElement( new XoopsFormLabel( '', "<div style='padding: 8px;'><img src='" . XOOPS_URL . "/images/blank.gif' name='image' id='image' alt='' /></div>" ) );
        } 
        $image_option_tray->addElement( $indeximage_tray );
        $sform->addElement( $image_option_tray );
        if ( is_object( $xoopsUser ) && $xoopsUser->isAdmin() )
        {
            $sform->addElement( new XoopsFormText( _AM_WFS_SPOTIMAGE_MAXWIDTH, 'imagewidth', 10, 80, intval( $imagewidth ) ), true );
            $sform->addElement( new XoopsFormText( _AM_WFS_SPOTIMAGE_MAXHEIGHT, 'imageheight', 10, 80, intval( $imageheight ) ), true );
            $sform->addElement( new XoopsFormText( _AM_WFS_SPOTDOCUMENT_MAXLENGTH, 'itemlength', 10, 80, intval( $itemlength ) ), true );
            $align_select = new XoopsFormSelect( _AM_WFS_SPOTDOCUMENT_SUMTYPE, "sum_type", $sum_type );
            $align_select->addOptionArray( array( 1 => _AM_WFS_SPOTDOCUMENT_SUBTITLE, 2 => _AM_WFS_SPOTDOCUMENT_SUMMARY , 3 => _AM_WFS_SPOTDOCUMENT_MAINTEXT ) );
            $sform->addElement( $align_select );
        } 
        else
        {
            $sform->addElement( new XoopsFormHidden( "imagewidth", 150 ) );
            $sform->addElement( new XoopsFormHidden( "imageheight", 150 ) );
            $sform->addElement( new XoopsFormHidden( "itemlength", 50 ) );
            $sform->addElement( new XoopsFormHidden( "sum_type", 2 ) );
        } 
        $spot_id_radio = new XoopsFormRadio( _AM_WFS_DOCSPOTLIGHTDOC, "spot_id", $currentspot_id );
        $spot_id_radio->addOption( 0, _AM_WFS_USE_LASTPUBLISHED . "; " . _AM_WFS_OTHERWISE_CHOOSEANARTICLE );
        $sform->addElement( $spot_id_radio );

        $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
        $articlearray = WfsArticle::getAllArticle( $xoopsModuleConfig['lastart'], $start, 'online', 0, 0, 'articleid DESC' );
        $totalcount = count( WfsArticle::getAllArticle( 0, 0, 'published' ) );
        $scount = count( $articlearray );

        $heading = array( _AM_WFS_STORYID, _AM_WFS_TITLE, _AM_WFS_SECTION, _AM_WFS_POSTER, _AM_WFS_STATUS, _AM_WFS_PUBLISHED, _AM_WFS_SPOTIT );
        $article_table = "\n<tr><td colspan='2'>";
        $article_table .= "\n<table border='0' width='100%' cellpadding ='2' cellspacing='1' class = 'outer'>";
        $article_table .= "\n<tr >";
        for ( $i = 0; $i < count( $heading ); $i++ )
        {
            $aligntype = ( $i == 1 ) ? 'left' : 'center';
            $article_table .= "<th align='$aligntype'><b>" . $heading[$i] . "</th>";
        } 
        $article_table .= "</tr>";

        if ( count( $articlearray ) == '0' )
            $article_table .= "\n<tr ><td align='center' colspan ='10' class = 'head'><b>" . _AM_WFS_NOARTICLEFOUND . "</b></td></tr>";

        for ( $i = 0; $i < count( $articlearray ); $i++ )
        {
            $allarticles['status'] = ( $articlearray[$i]->offline == '0' ) ? $online : $offline;
            $allarticles['published'] = ( $articlearray[$i]->published() > '0' ) ? formatTimestamp( $articlearray[$i]->published(), "$xoopsModuleConfig[timestamp]" ) : "" . _AM_WFS_NOTPUBLISHED . "";
            $allarticles['topic'] = $articlearray[$i]->category->textLink();
            $allarticles['topic'] = ( !empty( $allarticles['topic'] ) ) ? $allarticles['topic'] : _AM_WFS_NOSUCHSECTION;
            $allarticles['articleid'] = $articlearray[$i]->articleid();
            $allarticles['artlink'] = $articlearray[$i]->admintextLink();
            $allarticles['artuser'] = $articlearray[$i]->uname();

            $article_table .= "\n<tr>";
            $article_table .= "<td align='center' class = 'head'>" . $allarticles['articleid'] . "";
            $article_table .= "</td><td align='left' class = 'even'>" . $allarticles['artlink'] . "";
            $article_table .= "</td><td align='center' class = 'even'>" . $allarticles['topic'] . "";
            $article_table .= "</td><td align='center' class = 'even'>" . $allarticles['artuser'] . "";
            $article_table .= "</td><td align='center' class = 'even'>" . $allarticles['status'] . "";
            $article_table .= "</td><td align='center' class='even'>" . $allarticles['published'] . "";
            $article_table .= "</td>";

            $selected = ( $currentspot_id == $allarticles['articleid'] ) ? " checked" : "";
            $article_table .= "</td><td align='center' class='even'><input type='radio' name='spot_id' value=" . $allarticles['articleid'] . " $selected>" . "";
            $article_table .= "</td></tr>";
            unset( $allarticles );
        } 
        $article_table .= "\n</table><br />\n";
        $article_table .= "\n</tr></td>\n";
        $sform->addElement( $article_table );

        $button_tray = new XoopsFormElementTray( '', '' );
        $hidden = new XoopsFormHidden( 'op', 'submit' );
        $button_tray->addElement( $hidden );

        if ( $current_spot )
        {
            $butt_dup = new XoopsFormButton( '', '', _SUBMIT, 'submit' );
            $butt_dup->setExtra( 'onclick="this.form.elements.op.value=\'submit\'"' );
            $button_tray->addElement( $butt_dup );
        } 

        $butt_dupct = new XoopsFormButton( '', '', _CANCEL, 'submit' );
        $butt_dupct->setExtra( 'onclick="this.form.elements.op.value=\'default\'"' );
        $button_tray->addElement( $butt_dupct );
        $sform->addElement( $button_tray ); - + $sform->display();

        if ( $totalcount > $scount )
        {
            include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $pagenav = new XoopsPageNav( $totalcount, $xoopsModuleConfig['lastart'], $start, 'start', 'lastarts=' . $scount, 1 );
            echo "<div style='text-align: right;' >" . $pagenav->renderSelect() . "</div><br />";
        } 
        break;
} 
xoops_cp_footer();

?>