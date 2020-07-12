<?php 
// $Id: relatedlinks.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
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
// Options setting
// Only for users who have admin right to system
include 'admin_header.php';

accessadmin( "doclinks" );

include_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// global $xoopsDB, $_POST, $myts, $xoopsUser, $num;
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

global $relatedtop, $xoopsDB, $_GET, $xoopsModuleConfig;

switch ( $op )
{
    case "saverelated";

        if ( isset( $relatedlink['relatedlink_topicid'] ) )
        {
            for ( $i = 0; $i < count( $relatedlink['relatedlink_topicid'] ); $i++ )
            {
                $related_link = ( isset( $relatedlink['relatedlink'][$i] ) ) ? 1 : 0;
                if ( $related_link == 1 )
                {
                    $result = $xoopsDB->query( "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " WHERE relatedlink_lid =" . $relatedlink['relatedlink_lid'][$i] . "" );
                    if ( !$xoopsDB->getRowsNum( $result ) )
                    {
                        $query = "INSERT INTO " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " (relatedlink_id, relatedlink_topicid, relatedlink_url, 
							relatedlink_urlname, relatedlink_weight, relatedlink_mod, relatedlink_lid ) 
							VALUES ('', " . $relatedlink['relatedlink_topicid'][$i] . ", '" . $relatedlink['relatedlink_url'][$i] . "', 
							'" . $relatedlink['relatedlink_urlname'][$i] . "', " . $relatedlink['relatedlink_weight'][$i] . ", 
							" . $relatedlink['relatedlink_mod'][$i] . ", " . $relatedlink['relatedlink_lid'][$i] . ")";
                    } 
                    else
                    {
                        $query = "UPDATE " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " set 
						relatedlink_topicid = " . $relatedlink['relatedlink_topicid'][$i] . ", 
						relatedlink_url = '" . $relatedlink['relatedlink_url'][$i] . "', 
						relatedlink_urlname = '" . $relatedlink['relatedlink_urlname'][$i] . "', 
						relatedlink_weight = " . $relatedlink['relatedlink_weight'][$i] . "  
						WHERE relatedlink_id=" . $relatedlink['relatedlink_id'][$i] . "";
                    } 
                } 
                else
                {
                    $query = "DELETE FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " WHERE relatedlink_mod =" . $relatedlink['relatedlink_mod'][$i] . " AND relatedlink_lid = " . $relatedlink['relatedlink_lid'][$i] . "";
                } 
            } 
        } 
        else
        {
            if ( isset( $_POST['relatedlink_id'] ) )
            {
                $query = "UPDATE " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " 
				SET relatedlink_topicid = " . $_POST['relatedlink_topicid'] . ", 
					relatedlink_url = '" . formatURL( $_POST['relatedlink_url'] ) . "', 
					relatedlink_urlname = '" . $_POST['relatedlink_urlname'] . "', 
					relatedlink_weight = " . $_POST['relatedlink_weight'] . ",
					relatedlink_mod = 1
			 	WHERE relatedlink_id =" . $_POST['relatedlink_id'] . "";
            } 
            else
            {
                $query = "INSERT INTO " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " (relatedlink_id, relatedlink_topicid, relatedlink_url, relatedlink_urlname, relatedlink_weight, relatedlink_mod) ";
                $query .= "VALUES ('', " . $_POST['relatedlink_topicid'] . ", '" . $_POST['relatedlink_url'] . "', '" . $_POST['relatedlink_urlname'] . "', " . $_POST['relatedlink_weight'] . ", '1')";
            } 
        } 
        $result = $xoopsDB->queryF( $query );
        /**
         * Show error if there is a problem
         */
        if ( !$result ) wfs_error_report( $query );

        redirect_header( "relatedlinks.php", 1, _AM_WFS_RELATED_DBUPDATED );
        break;

    case "delete";

        if ( isset( $ok ) && $ok == 1 )
        {
            $sql = "DELETE FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " WHERE relatedlink_id=" . $_POST['related'] . "";
            $result = $xoopsDB->query( $sql );
            /**
             * Show error if there is a problem
             */
            if ( !$result ) wfs_error_report( $sql );

            redirect_header( "relatedlinks.php", 1, _AM_WFS_RELATED_DELETED );
            exit();
        } 
        else
        {
            xoops_cp_header();
            xoops_confirm( array( 'op' => 'delete', 'related' => $_GET['related'], 'ok' => 1 ), 'relatedlinks.php', _AM_WFS_DELETERELEATEDLINK );
        } 
        break;

    case "addrelated":

        xoops_cp_header();

        global $num;

        wfs_admin_menu( _AM_WFS_RELATEDLINKS );
        wfs_textinfo( _AM_WFS_RELATEDLINKLIST2, _AM_WFS_RELATEDLINKLISTTXT2 );

        $relatedlink_url = '';
        $relatedlink_urlname = '';
        $relatedlink_weight = 0;

        $sform = new XoopsThemeForm( _AM_WFS_ADDRELATEDLINK, "op", xoops_getenv( 'PHP_SELF' ) );
        if ( isset( $_GET['related'] ) )
        {
            $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . " WHERE relatedlink_id=" . $_GET['related'] . "";
            $related_arr = $xoopsDB->fetchArray( $xoopsDB->query( $sql ) );

            $relatedlink_url = $related_arr['relatedlink_url'];
            $relatedlink_urlname = $related_arr['relatedlink_urlname'];
            $relatedlink_weight = $related_arr['relatedlink_weight'];
            $sform->addElement( new XoopsFormHidden( 'relatedlink_id', $_GET['related'] ) );
        } 
        $sform->addElement( new XoopsFormText( _AM_WFS_RELATED_URL, 'relatedlink_url', 50, 255, $relatedlink_url ), true );
        $sform->addElement( new XoopsFormText( _AM_WFS_RELATED_URLNAME, 'relatedlink_urlname', 50, 255, $relatedlink_urlname ), true );
        $sform->addElement( new XoopsFormText( _AM_WFS_RELATED_WEIGHT, 'relatedlink_weight', 4, 4, $relatedlink_weight ) );
        $articleid = ( isset( $_GET['articleid'] ) ) ? $_GET['articleid'] : $related_arr['relatedlink_topicid'];
        $sform->addElement( new XoopsFormHidden( 'relatedlink_topicid', $articleid ) );

        $button_tray = new XoopsFormElementTray( '', '' );
        $hidden = new XoopsFormHidden( 'op', 'saverelated' );
        $button_tray->addElement( $hidden );
        $button_tray->setExtra( "onclick='this.form.elements.op.value=\"saverelated\"'" );
        $button_tray->addElement( new XoopsFormButton( '', 'saverelated', _AM_WFS_EDIT, 'submit' ) );

        $butt_canc = new XoopsFormButton( '', '', _CANCEL, 'submit' );
        $butt_canc->setExtra( 'onclick="this.form.elements.op.value=\'default\'"' );
        $button_tray->addElement( $butt_canc );
        $sform->addElement( $button_tray );
        $sform->display();

        if ( isset( $_GET['articleid'] ) )
        {
            echo "<h4>" . _AM_WFS_RELATEDLINKSLIST . "</h4>";
            echo "<table border='0' cellpadding='2' cellspacing='1' width = '100%' class = 'outer'>";
            echo "<tr align='left'>";
            echo "<td align='center' class='bg3' width = '3%'><b>" . _AM_WFS_ARTID . "</b></td>";
            echo "<td align='left' width = '50%'class='bg3'><b>" . _AM_WFS_RELATED_URL . "</b></td>";
            echo "<td align='center' width = '10%'class='bg3'><b>" . _AM_WFS_RELATED_WEIGHT . "</b></td>";
            echo "<td align='center' width = '17%' class='bg3'><b>" . _AM_WFS_ACTION . "</td>";
            echo "</tr>";

            $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . "  WHERE relatedlink_topicid = " . $_GET['articleid'] . " ORDER BY relatedlink_id ";
            $result = $xoopsDB->query( $sql );
            $count = $xoopsDB->getRowsNum( $result );

            if ( $count > 0 )
            {
                while ( $arr = $xoopsDB->fetchArray( $result ) )
                {
                    $edit = "<a href='relatedlinks.php?op=addrelated&related=" . $arr['relatedlink_id'] . "'>$editimg</a>";
                    $delete = "<a href='relatedlinks.php?op=delete&related=" . $arr['relatedlink_id'] . "'>$deleteimg</a>";
                    echo "<tr>";
                    echo "<td class='head' align = 'center' width= '3%'>" . $arr['relatedlink_id'] . "</td>";
                    echo "<td class='even' nowrap='nowrap'><a href=" . $arr['relatedlink_url'] . " target='_blank'>" . $arr['relatedlink_urlname'] . "</a></td>";
                    echo "<td class='even' align = 'center' nowrap='nowrap'>" . $arr['relatedlink_weight'] . "</td>";
                    echo "<td class='even' align = 'center' nowrap='nowrap'>$edit $delete</td>";
                    echo "</tr>";
                } 
            } 
            else
            {
                echo "<tr>";
                echo "<td class='head' align = 'center' colspan=4>" . _AM_WFS_NOURLFOUND . "</td>";
                echo "</tr>";
            } 
            echo "</table> ";
        } 
        break;

    case "addrelatedlink":

        global $num;

        xoops_cp_header();

        wfs_admin_menu( _AM_WFS_RELATEDLINKS );
        wfs_textinfo( _AM_WFS_RELATEDNEWS, '' );

        echo "<form name='saverelated_links' METHOD='post'>";
        echo "<table border='0' cellpadding='2' cellspacing='1' width = '100%' class = 'outer'>";
        echo "<tr align='left'>";
        echo "<td align='center' class='bg3' width = '3%'><b>" . _AM_WFS_ARTID . "</b></td>";
        echo "<td align='left' width = '30%'class='bg3'><b>" . _AM_WFS_TITLE . "</b></td>";
        echo "<td align='center' width = '17%' class='bg3'><b>" . _AM_WFS_RELATEDART_WEIGHT . "</b></td>";
        echo "<td align='center' width = '17%' class='bg3'><b>" . _AM_WFS_RELATEDITEM . "</b></td>";
        echo "</tr>";

        $sql = "SELECT lid, title, url FROM " . $xoopsDB->prefix( "mylinks_links" ) . " ORDER BY lid";
        $result = $xoopsDB->query( $sql );

        $a = 0;
        while ( list( $lid, $title, $url ) = $xoopsDB->fetchrow( $result ) )
        {
            echo $lid;

            $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . "  WHERE relatedlink_topicid = " . $_GET['articleid'] . " AND relatedlink_mod = 2 ORDER BY relatedlink_id ";
            $result2 = $xoopsDB->query( $sql );
            list( $relatedlink_id, $relatedlink_topicid, $relatedlink_url, $relatedlink_urlname, $relatedlink_weight, $relatedlink_mod, $relatedlink_lid ) = $xoopsDB->fetchrow( $result2 );

            echo "<tr>";
            echo "<td class='head' align = 'center' width= '3%'>" . $lid . "</td>";
            echo "<td class='even' nowrap='nowrap'>" . $title . "</td>";
            echo "<input type='hidden' name='relatedlink[relatedlink_id][$a]' value='" . $relatedlink_id . "' />";
            echo "<input type='hidden' name='relatedlink[relatedlink_lid][$a]' value='" . $lid . "' />";
            echo "<input type='hidden' name='relatedlink[relatedlink_topicid][$a]' value='" . $_GET['articleid'] . "' />";
            echo "<input type='hidden' name='relatedlink[relatedlink_url][$a]' value='" . $url . "' />";
            echo "<input type='hidden' name='relatedlink[relatedlink_urlname][$a]' value='" . $title . "' />";
            echo "<input type='hidden' name='relatedlink[relatedlink_mod][$a]' value='2' />";
            if ( !isset ( $related_weight ) ) $related_weight = 0;
            echo "<td class='even' align = 'center' width= '3%'><input type='text' name='relatedlink[relatedlink_weight][$a]' value='$related_weight' size='3' /></td>";
            echo "<td align='center' class='even'>";
            echo "<input type='checkbox' name='relatedlink[relatedlink][$a]' value='1'";
            if ( $relatedlink_lid == $lid )
            {
                echo " checked='checked'";
            } 
            echo " />";
            echo "</td>";
            echo "</tr>";
            $a++;
        } 
        echo "
		<tr>
		<td class='head' align='right' colspan='3'>" . _AM_WFS_SHOWALL . "</td>
		<td class='even' align='center' colspan='1'><input name='allbox_links' id='allbox' onclick='xoopsCheckAll(\"saverelated_links\", \"allbox_links\");' type='checkbox' value='Check All' /></td>
		</tr>";
        echo "
		<tr><td class='even' align='center' colspan='4'>
		<input type='hidden' name='num' value=" . $num . " />
		<input type='hidden' name='op' value=saverelated />
		<input type='submit' name='submit' value='" . _SUBMIT . "' />
		</td></tr>";
        echo "</table>";
        echo "</form>";
        break;

    default:

        $start = isset( $_GET['start'] ) ? intval( $_GET['start'] ) : 0;
        $articlearray = WfsArticle::getAllArticle( $xoopsModuleConfig['lastart'], $start, 'online' );
        $totalcount = count( WfsArticle::getAllArticle( 0, 0, 'online' ) );

        xoops_cp_header();
        wfs_admin_menu( _AM_WFS_RELATEDLINKS );
        wfs_textinfo( _AM_WFS_RELATEDLINKLIST, _AM_WFS_RELATEDLINKLISTTXT );
        if ( $totalcount > 0 )
        {
            echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
            echo "<tr>";
            echo "<td class='bg3' align='center'><b>" . _AM_WFS_ARTID . "</b></td>";
            echo "<td class='bg3' align='left'><b>" . _AM_WFS_TITLE . "</b></td>";
            echo "<td class='bg3' align='center'><b>" . _AM_WFS_ACTION . "</b></td>";
            echo "</tr>";
            $x = 0;
            foreach ( $articlearray as $article )
            {
                if ( empty( $article->url ) )
                {
                    $addrelated = "<a href='relatedlinks.php?op=addrelated&articleid=" . $article->articleid() . "'>" . $addart . "</a>";
                    echo "<tr>";
                    echo "<td class='head' align='center' width= '5%'>" . $article->articleid() . "</td>";
                    echo "<td class='even' align='left'>" . $article->textLink( "S" ) . "</td>";
                    echo "<td class='even' align='center' width= '20%'> $addrelated </td>";
                    echo "</tr>";
                    $x++;
                } 
            } 
            echo "</table><br />\n";

            $pagenav = new XoopsPageNav( $totalcount, $xoopsModuleConfig['lastart'], $start, 'start', 'lastarts=' . $xoopsOption, 1 );
            echo "<div style='text-align: right;' >" . $pagenav->renderNav() . "</div>";

            echo "<h4>" . _AM_WFS_RELATEDLINKSLIST . "</h4>";
            echo "<table border='0' cellpadding='2' cellspacing='1' width = '100%' class = 'outer'>";
            echo "<tr align='left'>";
            echo "<td align='center' class='bg3' width = '3%'><b>" . _AM_WFS_ARTID . "</b></td>";
            echo "<td align='left' width = '50%'class='bg3'><b>" . _AM_WFS_RELATED_URL . "</b></td>";
            echo "<td align='center' width = '10%'class='bg3'><b>" . _AM_WFS_RELATED_WEIGHT . "</b></td>";
            echo "<td align='center' width = '17%' class='bg3'><b>" . _AM_WFS_ACTION . "</td>";
            echo "</tr>";

            $sql = "SELECT * FROM " . $xoopsDB->prefix( WFS_RELATEDLINKS ) . "  ORDER BY relatedlink_id ";
            $result = $xoopsDB->query( $sql );
			$count = $xoopsDB->getRowsNum( $result );

            /**
             * Show error if there is a problem
             */
            if ( !$result ) wfs_error_report( $sql );

            if ( $count > 0 )
            {
                while ( $arr = $xoopsDB->fetchArray( $result ) )
                {
                    $edit = "<a href='relatedlinks.php?op=addrelated&related=" . $arr['relatedlink_id'] . "'>$editimg</a>";
                    $delete = "<a href='relatedlinks.php?op=delete&related=" . $arr['relatedlink_id'] . "'>$deleteimg</a>";

                    echo "<tr>";
                    echo "<td class='head' align = 'center' width= '3%'>" . $arr['relatedlink_id'] . "</td>";
                    echo "<td class='even' nowrap='nowrap'><a href=" . $arr['relatedlink_url'] . " target='_blank'>" . $arr['relatedlink_urlname'] . "</a></td>";
                    echo "<td class='even' align = 'center' nowrap='nowrap'>" . $arr['relatedlink_weight'] . "</td>";
                    echo "<td class='even' align = 'center' nowrap='nowrap'>$edit $delete</td>";
                    echo "</tr>";
                } 
            } 
            else
            {
                echo "<tr>";
                echo "<td class='head' align = 'center' colspan=4>" . _AM_WFS_NOURLFOUND . "</td>";
                echo "</tr>";
            } 
            echo "</table> ";
        } 
        break;
} 
xoops_cp_footer();

?>
