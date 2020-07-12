<?php
// $Id: templates.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
//  ------------------------------------------------------------------------ //
//                        WFsections for XOOPS                               //
//                 Copyright (c) 2004 WF-section Team                        //
//                  <http://www.wf-projects.com/>                          //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: WF-section Team                                                   //
// URL: http://www.wf-projects.com                                         //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
include("admin_header.php");
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once WFS_ROOT_PATH . "/class/wfslists.php";

accessadmin("templates");

$op = '';

if (isset($_POST))
{
    foreach ($_POST as $k => $v)
    {
        ${$k} = $v;
    }
}

if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op)
{
    case "save":
        global $xoopsConfig, $xoopsDB, $myts;

        $xoopsDB->query("update " . $xoopsDB->prefix(WFS_TEMPLATES) . " set 
			downloads = '" . $_POST['downloads'] . "',
			archives = '" . $_POST['archives'] . "', 
			artindex = '" . $_POST['artindex'] . "', 
			catindex = '" . $_POST['catindex'] . "', 
			articlepage = '" . $_POST['articlepage'] . "', 
			articleplainpage = '" . $_POST['articleplainpage'] . "', 
			toptentemp = '" . $_POST['toptentemp'] . "', 
			artmenublock = '" . $_POST['artmenublock'] . "', 
			bigartblock = '" . $_POST['bigartblock'] . "', 
			mainmenublock = '" . $_POST['mainmenublock'] . "', 
			newartblock = '" . $_POST['newartblock'] . "', 
			newdownblock = '" . $_POST['newdownblock'] . "', 
			topartblock = '" . $_POST['topartblock'] . "', 
			topicsblock = '" . $_POST['topicsblock'] . "', 
			authorblock = '" . $_POST['authorblock'] . "', 
			spotlightblock = '" . $_POST['spotlightblock'] . "'
			");
        redirect_header("templates.php", 1, _AM_WFS_WFTEMPLATESCONFIG);
        exit();
        break;

    case "default":
    default:
        xoops_cp_header();
        wfs_admin_menu(_AM_WFS_MODIFYTEMPLATES);

        global $xoopsModule;

        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

        $sql = "SELECT downloads, archives, artindex, catindex, articlepage, articleplainpage, toptentemp, artmenublock, 
			bigartblock, mainmenublock, newartblock, newdownblock, topartblock, topicsblock, authorblock, spotlightblock 
			FROM " . $xoopsDB->prefix(WFS_TEMPLATES) . "";
        $wfsTempl = $xoopsDB->fetchArray($result = $xoopsDB->query($sql));

        $template_array = &WfsLists::getListTypeAsArray(WFS_TEMPLATE_PATH, "html");
        $blocks_array = &WfsLists::getListTypeAsArray(WFS_TEMPLATE_PATH. '/blocks', "html");
        $lang_temp_array = array(_AM_WFS_TEMPLDOWNLOADS, _AM_WFS_TEMPLARCHIVES, _AM_WFS_TEMPLARTINDEX, _AM_WFS_TEMPLSECINDEX, _AM_WFS_TEMPLART, _AM_WFS_TEMPLPLAINART,
            _AM_WFS_TEMPLTOPTEN, _AM_WFS_ARTMENUBLOCK, _AM_WFS_BIGSTORYBLOCK, _AM_WFS_MAINMENUBLOCK, _AM_WFS_NEWARTBLOCK, _AM_WFS_NEWDOWNLOADSBLOCK,
            _AM_WFS_TOPARTBLOCK, _AM_WFS_TOPICSBLOCK, _AM_WFS_AUTHORBLOCK, _AM_WFS_SPOTLIGHTBLOCK
            ); 
        echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . _AM_WFS_USINGTEMPLATES . "</legend>";
        echo "<div style='padding: 8px;'>";
        echo "<div style='padding-bottom: 8px;'>" . _AM_WFS_HOWTOUSETEMP . "</div>";
        echo "<div style='padding-bottom: 8px;'>" . _AM_WFS_ADDINGATEMPLATE . "</div>";
        echo "<div style='padding-bottom: 8px;'>" . _AM_WFS_HOWTOUSETEMP2 . "</div>";
        echo "<div style='padding-bottom: 8px;'>" . _AM_WFS_DISPLAYXOOPSTEMPADMIN . "<a href='" . XOOPS_URL . "/modules/system/admin.php?fct=tplsets&op=listtpl&tplset=default&moddir=" . $xoopsModule->dirname() . "' target=\"_blank\">"._AM_WFS_VIEW."</a></div>";
        echo "</div></fieldset><br />";

        $sform = new XoopsThemeForm(_AM_WFS_MODIFYTEMPLATES, "op", xoops_getenv('PHP_SELF'));
        $i = 0;
        foreach ($wfsTempl as $key => $content)
        {
            if ($i < 7)
            {
                $key_select[$i] = new XoopsFormSelect("<a href=\"" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/templates/$content\" target=\"_blank\">"._AM_WFS_VIEW."</a>", $key, $content);
                $key_select[$i]->addOptionArray($template_array);
                $key_tray[$i] = new XoopsFormElementTray($lang_temp_array[$i], '&nbsp;');
                $key_tray[$i]->addElement($key_select[$i]);
                $sform->addElement($key_tray[$i]);
            }
            else
            {
                if ($i == 7)
                {
                    $sform->insertBreak('&nbsp;', 'odd');
                    $sform->insertBreak("<b>" . _AM_WFS_ISBLOCKS . "</b>", 'even');
                }
                $key_select[$i] = new XoopsFormSelect("<a href=\"" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/templates/blocks/$content\" target=\"_blank\">"._AM_WFS_VIEW."</a>", $key, $content);
                $key_select[$i]->addOptionArray($blocks_array);
                $key_tray[$i] = new XoopsFormElementTray($lang_temp_array[$i], '&nbsp;');
                $key_tray[$i]->addElement($key_select[$i]);
                $sform->addElement($key_tray[$i]);
            }
            $i++;
        }
        $button_tray = new XoopsFormElementTray('', '');
        $hidden = new XoopsFormHidden('op', 'save');
        $button_tray->addElement($hidden);
        $button_tray->addElement(new XoopsFormButton('', 'post', _AM_WFS_SAVECHANGE, 'submit'));
        $sform->addElement($button_tray);
        $sform->display();
        unset($hidden);
}
xoops_cp_footer();

?>