<?php 
// $Id: indexpage.php,v 1.4 2004/08/13 12:41:45 phppp Exp $
//  ------------------------------------------------------------------------ //
//                        WFsections for XOOPS                               //
//                 Copyright (c) 2004 WF-section Team                        //
//                    <http://www.wf-projects.com/>                          //
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
// URL: http://www.wf-projects.com                                           //
// Project: WFsections Project                                               //
// ------------------------------------------------------------------------- //
// Options setting
// Only for users who have admin right to system
include 'admin_header.php';
include_once WFS_ROOT_PATH . '/class/wfsindex.php';

accessadmin("indexpage");

$op = "";

if (isset($_POST))
{
    foreach ($_POST as $k => $v)
    {
        ${$k} = $v;
    }
}

if (isset($_GET))
{
    foreach ($_GET as $k => $v)
    {
        ${$k} = $v;
    }
}

function editpages($id = 0)
{
    global $xoopsConfig, $xoopsModuleConfig, $wfsPathConfig;
	
	include WFS_ROOT_PATH . "/class/wfslists.php";
	
    $index = new WfsIndex($id);
    $cateheading = ($index->indid) ? _AM_WFS_MODIFYPAGE . ": " . $index->pagename("S") : _AM_WFS_ADDPAGE;
    $sform = new XoopsThemeForm($cateheading, "op", xoops_getenv('PHP_SELF'));

    $graph_array = &WfsLists::getListTypeAsArray(WFS_LOGO_PATH, $type = "images");
    $indeximage_select = new XoopsFormSelect('', 'indeximage', $index->indeximage("E"));
    $indeximage_select->addOptionArray($graph_array);
    $indeximage_select->setExtra("onchange='showImgSelected(\"image\", \"indeximage\", \"" . $wfsPathConfig["logopath"] . "\", \"\", \"" . XOOPS_URL . "\")'");
    $indeximage_tray = new XoopsFormElementTray(_AM_WFS_SECTIONIMAGE, '&nbsp;');
    $indeximage_tray->addElement($indeximage_select);
    if (!empty($index->indeximage)){	
		$indeximage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . WFS_LOGO_URL . "/" . $index->indeximage("E") . "' name='image' id='image' alt='' />"));
	} else {
		$indeximage_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . XOOPS_URL . "/uploads/blank.gif' name='image' id='image' alt='' />"));
	}
    $sform->addElement($indeximage_tray);
    
	if ($index->isdefault == TRUE)
    {
        $sform->addElement(new XoopsFormHidden('isdefault', 1));
        $sform->addElement(new XoopsFormHidden('pagename', $index->pagename("E") ));
        $sform->addElement(new XoopsFormLabel(_AM_WFS_PAGENAME, $index->pagename("E") ));
    }
    else
    {
        $sform->addElement(new XoopsFormHidden('isdefault', 0));
        $sform->addElement(new XoopsFormText(_AM_WFS_PAGENAME, 'pagename', 50, 255, $index->pagename("E") ), true);
    }
    
	
	$sform->addElement(new XoopsFormText(_AM_WFS_INDEXHEADING, 'indexheading', 50, 255, $index->indexheading("E")), false);

    $header_tray = new XoopsFormElementTray(_AM_WFS_SECTIONHEAD, '<br /><br />');
	$header = new XoopsFormDhtmlTextArea('', 'indexheader', $index->indexheader("E"), 15, 60);
    $header_tray->addElement($header);
	$headeralign_select = new XoopsFormSelect(_AM_WFS_ALIGNMENT, "indexheaderalign", $index->indexheaderalign );
    $headeralign_select->addOptionArray(array("left" => _AM_WFS_ISLEFT, "right" => _AM_WFS_ISRIGHT, "center" => _AM_WFS_ISCENTER));
    $header_tray->addElement($headeralign_select);
	$sform->addElement($header_tray);
	
	$footer_tray = new XoopsFormElementTray(_AM_WFS_SECTIONFOOT, '<br /><br />');
    $htmlarea = ($xoopsModuleConfig['htmltextarea']) ? 'XoopsFormDhtmlTextArea' : 'XoopsFormTextArea';
    $footer = new $htmlarea('', 'indexfooter', $index->indexfooter, 7, 60);
    $footer_tray->addElement($footer);
    $footeralign_select = new XoopsFormSelect(_AM_WFS_ALIGNMENT, "indexfooteralign", $index->indexfooteralign);
    $footeralign_select->addOptionArray(array("left" => _AM_WFS_ISLEFT, "right" => _AM_WFS_ISRIGHT, "Center" => _AM_WFS_ISCENTER));
	$footer_tray->addElement($footeralign_select);
	$sform->addElement($footer_tray);
	
    $options_tray = new XoopsFormElementTray(_AM_WFS_TEXTOPTIONS, '<br />');
    $striphtml_checkbox = new XoopsFormCheckBox('', 'striphtml', 0);
    $striphtml_checkbox->addOption(1, _AM_WFS_STRIPHTML);
    $options_tray->addElement($striphtml_checkbox);

    $html_checkbox = new XoopsFormCheckBox('', 'nohtml', $index->nohtml);
    $html_checkbox->addOption(1, _AM_WFS_DISABLEHTML);
    $options_tray->addElement($html_checkbox);

    $smiley_checkbox = new XoopsFormCheckBox('', 'nosmileys', $index->nosmileys);
    $smiley_checkbox->addOption(1, _AM_WFS_DISABLESMILEY);
    $options_tray->addElement($smiley_checkbox);

    $xcodes_checkbox = new XoopsFormCheckBox('', 'noxcodes', $index->noxcodes);
    $xcodes_checkbox->addOption(1, _AM_WFS_DISABLEXCODE);
    $options_tray->addElement($xcodes_checkbox);

	$noimages_checkbox = new XoopsFormCheckBox('', 'noimages', $index->noimages);
    $noimages_checkbox->addOption(1, _AM_WFS_DISABLEIMAGES);
    $options_tray->addElement($noimages_checkbox);	

    $breaks_checkbox = new XoopsFormCheckBox('', 'nobreaks', $index->nobreaks);
    $breaks_checkbox->addOption(1, _AM_WFS_DISABLEBREAK);
    $options_tray->addElement($breaks_checkbox);
	$sform->addElement($options_tray);	
	
    $create_tray = new XoopsFormElementTray('', '');
    $create_tray->addElement(new XoopsFormHidden('op', 'save'));
    $butt_save = new XoopsFormButton('', '', _AM_WFS_SAVECHANGE, 'submit');
    $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');

    $create_tray = new XoopsFormElementTray('', '');
    $create_tray->addElement(new XoopsFormHidden('op', 'save'));
    $butt_save = new XoopsFormButton('', '', _AM_WFS_SAVECHANGE, 'submit');
    $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');
    $create_tray->addElement($butt_save);
    $sform->addElement(new XoopsFormHidden('id', $index->indid));

    if ($index->indid)
    {
        $create_tray->addElement(new XoopsFormHidden('id', $index->indid));
		if ($index->isdefault == 0)
        {
            $butt_delete = new XoopsFormButton('', '', _AM_WFS_DELETE, 'submit');
            $butt_delete->setExtra('onclick="this.form.elements.op.value=\'delete\'"');
            $create_tray->addElement($butt_delete);
        }
        $create_tray->addElement(new XoopsFormHidden('op', 'save'));
        $butt_save = new XoopsFormButton('', '', _AM_WFS_SAVECHANGE, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');
    }
    else
    {
        $create_tray->addElement(new XoopsFormHidden('id', ''));
        $create_tray->addElement(new XoopsFormHidden('op', 'save'));
        $butt_save = new XoopsFormButton('', '', _AM_WFS_SAVECHANGE, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'save\'"');    
	}

    $sform->addElement($create_tray);
    $sform->display();
}

switch ($op)
{
    case "edit":
        xoops_cp_header();
        wfs_admin_menu(_AM_WFS_INDEXPAGE);
        wfs_textinfo(_AM_WFS_INDEXPAGEINFO, _AM_WFS_INDEXPAGEINFOTXT);
		echo "<h4>" . _AM_WFS_INDEXPAGEEDIT . "</h4>";
        
		$id = isset($_GET['id']) ? intval($_GET['id']) : intval($_POST['id']);
        editpages(intval($id));
        break;

    case "delete":
        accessadmin("deletearticles");
        if (isset($ok) && $ok == 1)
        {
            $index = new WfsIndex($_POST['id']);
            $index->delete();
            redirect_header("indexpage.php", 1, _AM_WFS_DBUPDATED);
            exit();
        }
        else
        {
            xoops_cp_header();
            xoops_confirm(array('op' => 'delete', 'id' => $_GET['id'], 'ok' => 1), 'indexpage.php', _AM_WFS_RUSUREDEL);
        }
        break;

    case "save":

        global $xoopsConfig, $xoopsDB, $_POST;

        $index->indid = (intval($_POST['id'])) ? intval($_POST['id']) : 0;
        $index = (intval($index->indid)) ? new WfsIndex(intval($index->indid)): new WfsIndex();
        $index->setPagename($_POST['pagename']);
        $index->setIndexheading($_POST['indexheading']);
        $index->setIndexheader($_POST['indexheader'], isset($_POST['striphtml']));
        $index->setIndexfooter($_POST['indexfooter'], isset($_POST['striphtml']));
        $index->setIndeximage($_POST['indeximage']);
        $index->setIndexheaderalign($_POST['indexheaderalign']);
        $index->setIndexfooteralign($_POST['indexfooteralign']);
        $index->setHtml(isset($_POST['nohtml']));
        $index->setSmileys(isset($_POST['nosmileys']));
        $index->setXcodes(isset($_POST['noxcodes']));
        $index->setBreaks(isset($_POST['nobreaks']));
        $index->setImages(isset($_POST['noimages']));
        $index->store();
        redirect_header("indexpage.php", 1, _AM_WFS_DBUPDATED);
        exit();

        break;

    default:

        $start = isset($_GET['start']) ? intval($_GET['start']) : 0;
        $index = WfsIndex::getAllPages($xoopsModuleConfig['lastart'], $start);
        $totalcount = count(WfsIndex::getAllPages(0, 0));
        $scount = count($index);
        $allpages = array();

        xoops_cp_header();

        wfs_admin_menu(_AM_WFS_INDEXPAGE);
        wfs_textinfo(_AM_WFS_INDEXPAGEINFO, _AM_WFS_INDEXPAGEINFOTXT);

		echo "<div><b>" . _AM_WFS_INDEXPAGELISTING . "</b></div><br />";
        echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
        echo "<tr>";
        echo "<td align='center' class='bg3' width='6%'><b>" . _AM_WFS_STORYID . "</td>";
        echo "<td align='left' class='bg3' width='38%'><b>" . _AM_WFS_PAGENAME2 . "</td>";
        echo "<td align='left' class='bg3' width='38%'><b>" . _AM_WFS_INDEXHEADING2 . "</td>";
        echo "<td align='center' class='bg3' width='8%'><b>" . _AM_WFS_ISDEFAULT . "</td>";
        echo "<td align='center' class='bg3' width='10%'><b>" . _AM_WFS_ACTION . "</td>";
        echo "</tr>";

        if (count($index) == '0')
        {
            echo "<tr ><td align='center' colspan ='10' class = 'head'><b>" . _AM_WFS_NOARTICLEFOUND . "</b></td></tr>";
        }

        for ($i = 0; $i < count($index); $i++)
        {
            $allpages['edit'] = "<a href='indexpage.php?op=edit&amp;id=" . $index[$i]->indid() . "'>$editimg</a>";
            if ($index[$i]->isdefault == false)
            {
                $allpages['edit'] .= "<a href='indexpage.php?op=delete&amp;&amp;id=" . $index[$i]->indid() . "'> $deleteimg </a>";
            }
            echo "<tr>";
            echo "<td class='head' align='center'>" . $index[$i]->indid() . "</td>";
            echo "<td class='even' align='left'>" . $index[$i]->pagename() . "</td>";
            echo "<td class='even' align='left'>" . $index[$i]->indexheading() . "</td>";
            $default = ($index[$i]->isdefault == true) ? _YES : _NO;
            echo "<td class='even' align='center'>" . $default . "</td>";
            echo "<td class='even' align='center'>" . $allpages['edit'] . "</td>";
            echo "</tr>";
        }
        echo "</table>\n";

        if ($totalcount > $scount)
        {
            include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $pagenav = new XoopsPageNav($totalcount, $xoopsModuleConfig['lastart'], $start, 'start');
            echo "<br /><div style='text-align: left;'>" . _AM_WFS_DISPLAYPAGES . " " . $pagenav->renderNav() . "</div>";
        }
		echo "<br />";
        /*
		* Edit indexpage form
		*/ 
		editpages($id = 0);
}

xoops_cp_footer();

?>
