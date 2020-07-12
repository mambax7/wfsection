<?php 
// $Id: common.php,v 1.4 2004/08/13 12:46:08 phppp Exp $
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
// Lets set up defines first
/**
 * Modules name and directory.  
 * 
 * If you want to set up WF-Sections as a secondary 
 * module this is where you can do it from.
 */
define("WFSECTION", "wfsection");

/**
 * Define database tables
 */

define('WFS_ARTICLE_DB', "wfs_article");
define('WFS_ARTICLE_MOD_DB', "wfs_article_mod");
define('WFS_RESTORE_DB', "wfs_article_restore");
define('WFS_BROKEN_DB', "wfs_broken");
define('WFS_CATEGORY_DB', "wfs_category");
define('WFS_CHECKIN_DB', "wfs_checkin");
define('WFS_CONFIG_DB', "wfs_config");
define('WFS_FILES_DB', "wfs_files");
define('WFS_INDEXPAGE', "wfs_indexpage");
define('WFS_MAINMENU_DB', "wfs_mainmenu");
define('WFS_PERMISSIONS', "wfs_permissions");
define('WFS_RELATED', "wfs_related");
define('WFS_RELATEDLINKS', "wfs_relatedlink");
define('WFS_REVIEWS', "wfs_reviews");
define('WFS_SPOTLIGHT', "wfs_spotlightblock");
define('WFS_TEMPLATES', "wfs_templates");
define('WFS_VOTES', "wfs_votedata");
define('WFS_MIMETYPE', "wfs_mimetypes");

/**
 * Defines and data for paths
 */
global $xoopsDB, $xoopsConfig, $xoopsModule, $mimetypes, $wfsPathConfig, $wfsTemplates, $xoopsUser;

$sql = "SELECT * FROM " . $xoopsDB->prefix(WFS_CONFIG_DB) . "";
$wfsPathConfig = $xoopsDB->fetchArray($result = $xoopsDB->query($sql));

define('WFS_ROOT_PATH', XOOPS_ROOT_PATH . "/modules/" . WFSECTION . "");
define('WFS_ROOT_URL', XOOPS_URL . "/modules/" . WFSECTION . "");

define('WFS_PATH', XOOPS_ROOT_PATH . "/modules/" . WFSECTION . "");
define('WFS_URL', XOOPS_URL . "/modules/" . WFSECTION . "");

define('WFS_IMAGES_PATH', XOOPS_ROOT_PATH . "/modules/" . WFSECTION . "/images");
define('WFS_IMAGES_URL', XOOPS_URL . "/modules/" . WFSECTION . "/images");

define('WFS_FILE_PATH', XOOPS_ROOT_PATH . "/" . $wfsPathConfig['filesbasepath']);
define('WFS_FILE_URL', XOOPS_URL . "/" . $wfsPathConfig['filesbasepath']);

define('WFS_ARTICLEIMG_PATH', XOOPS_ROOT_PATH . "/" . $wfsPathConfig['graphicspath']);
define('WFS_ARTICLEIMG_URL', XOOPS_URL . "/" . $wfsPathConfig['graphicspath']);

define('WFS_SECTIONIMG_PATH', XOOPS_ROOT_PATH . "/" . $wfsPathConfig['sgraphicspath']);
define('WFS_SECTIONIMG_URL', XOOPS_URL . "/" . $wfsPathConfig['sgraphicspath']);

define('WFS_HTML_PATH', XOOPS_ROOT_PATH . "/" . $wfsPathConfig['htmlpath']);
define('WFS_HTML_URL', XOOPS_URL . "/" . $wfsPathConfig['htmlpath']);

define('WFS_LOGO_PATH', XOOPS_ROOT_PATH . "/" . $wfsPathConfig['logopath']);
define('WFS_LOGO_URL', XOOPS_URL . "/" . $wfsPathConfig['logopath']);

define('WFS_TEMPLATE_PATH', XOOPS_ROOT_PATH . "/modules/" . WFSECTION . "/templates");
define('WFS_TEMPLATE_URL', XOOPS_URL . "/modules/" . WFSECTION . "/templates");

/**
 * Setup globals for later use
 */
$modhandler = &xoops_gethandler('module');
$xoopsWFModule = &$modhandler->getByDirname(WFSECTION);

if (is_object($xoopsWFModule) && $xoopsWFModule->getVar('isactive'))
{
	$config_handler = &xoops_gethandler('config');
    $xoopsModuleConfig = &$config_handler->getConfigsByCat(0, $xoopsWFModule->getVar('mid'));
    $gperm_handler = &xoops_gethandler('groupperm');
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

    $sql = "SELECT * FROM " . $xoopsDB->prefix(WFS_TEMPLATES) . "";
    $wfsTemplates = $xoopsDB->fetchArray($result = $xoopsDB->query($sql));
}
else
{
	$wfsTemplates = array("artmenublock" => "wfs_block_artmenu.html",
        "artmenublock" => "wfs_block_artmenu.html",
        "mainmenublock" => "wfs_block_menu.html",
        "topicsblock" => "wfs_block_topics.html",
        "bigartblock" => "wfs_block_bigstory.html",
        "topartblock" => "wfs_block_top.html",
        "newartblock" => "wfs_block_new.html",
		"newdownblock" => "wfs_block_newdown.html",
		"authorblock" => "wfs_block_author.html",
		"spotlightblock" => "wfs_block_spotlight.html"
		);
}

$IconArray = array("css.gif" => "css", "doc.gif" => "doc", "html.gif" => "html htm shtml htm", "pdf.gif" => "pdf", "txt.gif" => "conf sh shar csh ksh tcl cgi",
    "php.gif" => "php php4 php3 phtml phps", "js.gif" => "js", "sql.gif" => "sql", "pl.gif" => "pl", "gif.gif" => "gif",
    "png.gif" => "png", "bmp.gif" => "bmp", "jpg.gif" => "jpeg jpe jpg", "c.gif" => "c cpp", "rar.gif" => "rar", "zip.gif" => "zip tar gz tgz z ace arj cab bz2",
    "mid.gif" => "mid kar", "wav.gif" => "wav", "wax.gif" => "wax", "xm.gif" => "xm", "ram.gif" => "ram", "mpg.gif" => "mp1 mp2 mp3 wma",
    "mp3.gif" => "mpeg mpg mov avi rm", "exe.gif" => "exe com dll bin dat rpm deb", "txt.gif" => "txt ini xml xsl ini inf cfg log nfo ico",
    );

$WfsHelperDir['application/pdf'] = "xpdf-win32";
$WfsHelperDir['application/vnd.ms-excel'] = "xlhtml-win32";

?>
