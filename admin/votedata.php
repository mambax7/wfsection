<?php 
// $Id: votedata.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
include_once WFS_ROOT_PATH . "/class/wfscategory.php";
include_once WFS_ROOT_PATH . "/class/wfsarticle.php";

accessadmin( "moderator" );

$op = "";

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

if ( isset( $_GET['op'] ) ) $op = $_GET['op'];
if ( isset( $_POST['op'] ) ) $op = $_POST['op'];

switch ( $op )
{
    case "delVote":
        global $xoopsDB, $_GET; 
        // $rid = intval($_GET['rid']);
        // $lid = intval($_GET['lid']);
        $sql = $xoopsDB->queryF( "DELETE FROM " . $xoopsDB->prefix( WFS_VOTES ) . " WHERE ratingid = " . intval( $_GET['rid'] ) );
        $xoopsDB->query( $sql );
        wfs_updaterating( intval( $_GET['lid'] ) );
        redirect_header( "votedata.php", 1, _AM_WFS_VOTEDELETED );
        break;

    case 'main':
    default:

        global $xoopsDB;

        $useravgrating = 0;
        $uservotes = 0;
        $useravgrating = 0;

        $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_VOTES ) . " ORDER BY ratingtimestamp DESC";
        $results = $xoopsDB->query( $sql );
        $results2 = $xoopsDB->query( $sql );

        $uservotes = $xoopsDB->getRowsNum( $results );

        while ( $arr = $xoopsDB->fetchArray( $results ) )
        {
            $useravgrating = $useravgrating + $arr['rating'];
        } 

        if ( $useravgrating > 0 )
        {
            $useravgrating = $useravgrating / $uservotes;
            $useravgrating = number_format( $useravgrating, 2 );
        } 

        xoops_cp_header();

        wfs_admin_menu( _AM_WFS_ARTICLEMANAGEMENT );
        $text_info = "<div>" . _AM_WFS_VOTEDATATEXT . "</div><br />";
        $text_info .= "<div><b>" . _AM_WFS_USERAVG . ": </b>$useravgrating</div>";
        $text_info .= "<div><b>" . _AM_WFS_TOTALRATE . ": </b>$uservotes</div>";
        wfs_textinfo( _AM_WFS_VOTEDATA, $text_info );

        echo "<table width=100% cellspacing = 1 cellpadding = 2 class = outer>";
        echo "<tr>";
        echo "<th align = 'center'>" . _AM_WFS_RATINGID . "</th>";
        echo "<th align = 'left'>" . _AM_WFS_ARTICLE . "</th>";
        echo "<th align = 'center'>" . _AM_WFS_USER . "</th>";
        echo "<th align = 'center'>" . _AM_WFS_IP . "</th>";
        echo "<th align = 'center'>" . _AM_WFS_RATING . "</th>";
        echo "<th align = 'center'>" . _AM_WFS_DATE . "</th>";
        echo "<th align = 'center'>" . _AM_WFS_ACTION . "</th></tr>";

        if ( $uservotes == false )
        {
            echo "<tr><td align='center' colspan='7'  class = 'head'>" . _AM_WFS_NOREGVOTES . "</td></tr>";
        } 
        else
        {
            while ( $arr = $xoopsDB->fetchArray( $results2 ) )
            {
                $article = new WfsArticle( $arr['lid'] );
                if ( $article )
                {

                    $formatted_date = formatTimestamp( $arr['ratingtimestamp'], $xoopsModuleConfig['timestamp'] );
                    $articletitle = $article->admintextLink();
                    $ratinguname = wfs_getLinkedUnameFromId( $article->uid, $xoopsModuleConfig['displayname'], 1 );
                    echo "<tr>";
                    echo "<td class = 'head' align = 'center' >" . $arr['ratingid'] . "</td>";
                    echo "<td class = 'even' align = 'left'>" . $articletitle . "</td>";
                    echo "<td class = 'even' align = 'center' >" . $ratinguname . "</td>";
                    echo "<td class = 'even' align = 'center' >" . $arr['ratinghostname'] . "</td>";
                    echo "<td class = 'even' align = 'center'>" . $arr['rating'] . "</td>";
                    echo "<td class = 'even' align = 'center'>" . $formatted_date . "</td>";
                    echo "<td class = 'even' align = 'center'><b><a href=votedata.php?op=delVote&lid=" . $arr['lid'] . "&rid=" . $arr['ratingid'] . ">$deleteimg</a></b></td>";
                    echo "</tr>";
                } 
            } 
        } 
        echo "</table>";
        break;
} 
xoops_cp_footer();

?>