<?php
// $Id: admin.php,v 1.4 2004/09/23 12:51:24 bender Exp $
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
// Translator: Mr Translatro                                                 //
// URL: http://translator.com                                                //
// Email: translator@translator.com                                          //
// ------------------------------------------------------------------------- //
// %%%%%%        Admin Module Name  Documents         %%%%%
Global $xoopsConfig;
// Action Lang defines
define( "_AM_WFS_YES", "Yes" );
define( "_AM_WFS_NO", "No" );
define( "_AM_WFS_SAVE", "保存" );
define( "_AM_WFS_SAVECHANGE", "保存改变" );
define( "_AM_WFS_ADD", "增加" );
define( "_AM_WFS_EDIT", "编辑" );
define( "_AM_WFS_MODIFY", "修改" );
define( "_AM_WFS_DELETE", "删除" );
define( "_AM_WFS_CANCEL", "取消" );
define( "_AM_WFS_ACTION", "操作" );
define( "_AM_WFS_COPY1", "克隆" );
define( "_AM_WFS_NOARTICLEFOUND", "通知：没有匹配本策略的文章" );
define( "_AM_WFS_DISABLEHTML", "禁用HTML标签" );
define( "_AM_WFS_DISABLESMILEY", "禁用Smilie Icons" );
define( "_AM_WFS_DISABLEXCODE", "禁用XOOPS Codes" );
define( "_AM_WFS_DISABLEIMAGES", "禁用图片Images" );
define( "_AM_WFS_DISABLEBREAK", "使用XOOPS linebreak转换？" );
define( "_AM_WFS_STRIPHTML", "剥离HTML标签" );
define( "_AM_WFS_CLEANHTML", "剥离不需要的MS Word标签" );
define( "_AM_WFS_NORIGHTS", "您没有足够的权利访问此区域" );

/**
 * Database defines
 */
define( "_AD_DBERROR", "当保存信息到数据库中时发生错误：<br /><br />请报告给 <a href=\"http://www.wf-projects.com\" target=\"_blank\">WF-sections支持站点</a><br /><br />Copy and paste the error below to ensure we can quickly help you." );
define( '_AM_WFS_WFSECTIONCONFIG', '配置更新' );
define( '_AM_WFS_WFPATHCONFIG', '路径配置更新' );
define( '_AM_WFS_WFTEMPLATESCONFIG', '模板更新' );
define( "_AM_WFS_DBUPDATED", "数据库成功更新！" );
/**
 * Lang defines for breadcrumb system
 */
define( '_AM_WFS_BREADC1', '设置' );
define( '_AM_WFS_BREADC2', '主索引' );
define( '_AM_WFS_BREADC3', '权限' );
define( '_AM_WFS_BREADC4', '区块' );
define( '_AM_WFS_BREADC5', '路径' );
define( '_AM_WFS_BREADC6', '模板' );
define( "_AM_WFS_BREADC7", "访问模块" );
define( "_AM_WFS_BREADC8", "帮助" );
define( "_AM_WFS_BREADC9", "关于" );
/**
 * Lang defines for menu system
 */
define( '_AM_WFS_ADMENU1', '页面管理' );
define( '_AM_WFS_ADMENU2', '类别管理' );
define( '_AM_WFS_ADMENU3', '创建文章' );
define( '_AM_WFS_ADMENU4', '权重管理' );
define( '_AM_WFS_ADMENU5', '文章恢复' );
define( '_AM_WFS_ADMENU6', '文章下载' );
define( '_AM_WFS_ADMENU7', '相关文章' );
define( '_AM_WFS_ADMENU8', '相关链接' );
define( '_AM_WFS_ADMENU9', '文章焦点' );
define( "_AM_WFS_ADMENUA", "Mimetypes管理" );
define( '_AM_WFS_ADMENUB', '导入文章' );
define( '_AM_WFS_ADMENUC', '投票信息' );
define( "_AM_WFS_ADMENUD", "评论" );
define( "_AM_WFS_ADMENUE", "服务器状态" );
define( "_AM_WFS_ADMENUF", "上传图片" );
/**
 * Summary information
 */
define( "_AM_WFS_SUMMARYINFO1", "概要信息" );
define( "_AM_WFS_SUMMARYINFO2", "类别" );
define( "_AM_WFS_SUMMARYINFO3", "发布" );
define( '_AM_WFS_SUMMARYINFO4', '提交' );
define( '_AM_WFS_SUMMARYINFO5', '修改' );
define( '_AM_WFS_SUMMARYINFO6', '中断' );
define( "_AM_WFS_SUMMARYINFO7", "编辑模式下的文章" );
/**
 * allarticles document management
 */
define( "_AM_WFS_ARTICLEMANAGEMENT", "文章管理" );
define( "_AM_WFS_DOC_SELECTION", "文章选择" );
define( "_AM_WFS_LIST", "<b>列出</b> " );
define( "_AM_WFS_LISTINCAT", " <b>在类别中</b> " );
/**
 * List article types
 */
define( "_AM_WFS_ALLARTICLES", "所有文章" );
define( "_AM_WFS_PUBLARTICLES", "发布的文章" );
define( "_AM_WFS_SUBLARTICLES", "提交的文章" );
define( "_AM_WFS_ONLINARTICLES", "在线文章" );
define( "_AM_WFS_OFFLIARTICLES", "离线文章" );
define( "_AM_WFS_EXPIREDARTICLES", "过期文章" );
define( "_AM_WFS_AUTOEXPIREARTICLES", "自动过期文章" );
define( "_AM_WFS_AUTOARTICLES", "自动发布文章" );
define( "_AM_WFS_NOSHOWARTICLES", "非索引文章" );
define( "_AM_WFS_HTMLFILES", "HTML文件文章" );
/**
 * menu lang defines
 */
define( "_AM_WFS_ALLTXTHEAD", "文章管理" );
define( "_AM_WFS_ALLTXT", "<div>With <b>文章管理</b>您可以编辑，删除或重命名文章。本模式将显示数据库中的每篇文章。" );
define( "_AM_WFS_PUBLISHEDTXTHEAD", "发布的文章" );
define( "_AM_WFS_PUBLISHEDTXT", "<div><b>文章发布管理</b>将显示所有已发布的文章。（由站长审核的）。<br /><br />这些是所有将显示于索引清单中的文章（包括所有由组访问权所控制的文章）." ); //added
define( "_AM_WFS_SUBMITTEDTXTHEAD", "提交文章" );
define( "_AM_WFS_SUBMITTEDTXT", "<div><b>文章提交管理</b>将显示所有由站点用户提交的文章供审核。<br /><br />要审核一篇文章，单击<b>编辑</b>链接，然后选定<b>审核</b>复选框保存文章。提交的文章将被发布。" ); //added
define( "_AM_WFS_ONLINETXTHEAD", "在线文章" );
define( "_AM_WFS_ONLINETXT", "<div><b>文章在线管理</b>将显示所有'在线'文章。<br /><br />要改变文章的状态，单击<b>编辑</b>链接并选定<b>在线</b>复选框off/on。" ); //added
define( "_AM_WFS_OFFLINETXTHEAD", "离线文章" );
define( "_AM_WFS_OFFLINETXT", "<div><b>文章离线管理</b>将显示所有状态设定为<b>离线</b>的文章。<br /><br />要改变文章的状态，单击 <b>编辑</b>链接并选定<b>在线</b>复选框off/on." ); //added
define( "_AM_WFS_EXPIREDTXTHEAD", "过期文章" );
define( "_AM_WFS_EXPIREDTXT", "<div><b>文章过期管理</b>将显示所有过期文章。<br /><br />您可以通过单击<b>编辑</b>链接并修改<b>设置过期时间</b>方便地重置过期时间。" ); //added
define( "_AM_WFS_AUTOEXPIRETXTHEAD", "自动过期文章" );
define( "_AM_WFS_AUTOEXPIRETXT", "<div><b>文章自动过期管理</b>将显示所有设定为某一日期过期的文章。<br /><br />您可以通过单击<b>编辑</b>链接并修改<b>设置过期时间</b>重置过期日。" ); //added
define( "_AM_WFS_AUTOTXTHEAD", "Auto Documents" );
define( "_AM_WFS_AUTOTXT", "<div><b>文章自动发布管理</b>将显示所有设定为将来某时发布的文章。<br /><br />设置可以通过单击<b>编辑</b>链接并修改'设置发布日期'设置来修改。" ); //added
define( "_AM_WFS_NOSHOWTXTHEAD", "非索引文章" );
define( "_AM_WFS_NOSHOWTXT", "<div><b>非索引文章</b>这些是一些特定类型的文章，与其它文章不同，它们将不显示在索引页。&nbsp;&nbsp; 而仅显示于'WF-sections菜单'区块。<br /><br />与'连接选定的HTML文件到此文', `无WF-sections框架`及'非索引文章'一起使用这个选项 (编辑文章页上的选项)您可以按照所希望的方式显示。&nbsp;&nbsp;例子可以是一个 `隐私申明` 页等。<br /><br />所有其它选项也控制此类型文章。例如，发布，过期，在/离线设置等。" ); //added
define( "_AM_WFS_HTMLFILESTXTHEAD", "HTML文章" );
define( "_AM_WFS_HTMLFILESTXT", "HTML文件文章。这将显示所有附带或“连接”HTML文件的文章。" ); //added
/**
 * Article listing defines
 */
define( "_AM_WFS_STORYID", "ID" );
define( "_AM_WFS_TITLE", "标题" );
define( "_AM_WFS_POSTER", "作者" );
define( "_AM_WFS_VERSION", "版本" );
define( "_AM_WFS_SECTION", "类别" );
define( "_AM_WFS_STATUS", "状态" );
define( "_AM_WFS_WEIGHT", "权重" );

define( "_AM_WFS_SUBMITTED2", "提交日期" );
define( "_AM_WFS_PUBLISHED", "发布日期" );
define( "_AM_WFS_PUBLISHEDON", "出版日期" );
define( "_AM_WFS_SUBMITTED", "用户提交文章" );
define( "_AM_WFS_NOTPUBLISHED", "未发布" );
define( "_AM_WFS_EXPARTS", "过期文章" );
define( "_AM_WFS_EXPIRED", "自动过期日" );
define( "_AM_WFS_CREATED", "创建日期" );
/**
 * Blocks Management
 */
define( "_AM_WFS_BLOCKSHEADING", "区块管理" );
define( "_AM_WFS_BLOCKSINFO", "区块信息" );
define( "_AM_WFS_BLOCKSTEXT", "区块可以从系统=>区块进行配置。<br />以下显示WFsection区块。您也可以从\"编辑\"区编辑。" );
/**
 * Path Managment
 */
define( "_AM_WFS_PATHCONFIGURATION", "路径配置" );
define( "_AM_WFS_PATHCONFIG", "路径和权限设置" );
define( "_AM_WFS_FILEPATHWARNING", "<li>为WF-sections使用的目录设置路径。
	<li>如果使用的路径不正确将发出一个警告。
	<li>如果您希望WF-sections使用缺省路径就不要填写。" );
define( "_AM_WFS_FILEPATH", "路径配置" );
define( "_AM_WFS_FILEUSEPATH", "改变用户路径" );
define( "_AM_WFS_PATHEXIST", "路径已存在！" );
define( "_AM_WFS_PATHNOTEXIST", "路径不存在。" );
define( "_AM_WFS_THUMBPATHEXIST", "路径存在！" );
define( "_AM_WFS_THUMBPATHNOTEXIST", "路径不存在。" );
define( "_AM_WFS_PATHCHECK", "<b>路径校验：</b> " );
define( "_AM_WFS_PERMISSIONS", "<b>路径权限校验：</b>" );
define( "_AM_WFS_THUMBPATHCHECK", "<b>缩略图路径校验：</b> " );
define( "_AM_WFS_THUMBPERMISSIONS", "<b>缩略图文件夹权限校验：</b>" );
define( "_AM_WFS_RESETDEFUALTS", "重置路径缺省值" );
define( "_AM_WFS_REVERTED", "路径恢复到原始设置" );
/**
 * Path Management form defines
 */
define( "_AM_WFS_CMODERROR", "权限错误：请把此路径的权限设置为0777。" );
define( "_AM_WFS_CMODERRORNOTCORRECTED", "且权限不正确。" );
define( "_AM_WFS_AGRAPHICPATH", "文章图片路径：<div style='padding-top: 8px;'><span style='font-weight: normal;'>文章logo图片的存放路径。</span></div>" );
define( "_AM_WFS_SGRAPHICPATH", "类别图片路径：<div style='padding-top: 8px;'><span style='font-weight: normal;'>类别图片的存放路径。</span></div>" );
define( "_AM_WFS_HTMLCPATH", "HTML文件路径：<div style='padding-top: 8px;'><span style='font-weight: normal;'>HTML文件存放路径。</span></div>" );
define( "_AM_WFS_LOGOPATH", "Logo图片路径：<div style='padding-top: 8px;'><span style='font-weight: normal;'>logo图片存放路径。/span></div>" );
define( "_AM_WFS_FILEUPLOADSPATH", "附件上传路径：<div style='padding-top: 8px;'><span style='font-weight: normal;'>附件上传存放路径。</span></div>" );
define( "_AM_WFS_FILEUPLOADSTEMPPATH", "附件上传临时路径：<div style='padding-top: 8px;'><span style='font-weight: normal;'>路径不再需要将被删除。</span></div>" );
define( "_AM_WFS_AVATARPATH", "Avatar缩略图文件夹：<div style='padding-top: 8px;'><span style='font-weight: normal;'>需要此文件夹创建avatar缩略图。<br />如果路径不存在请创建文件夹。</span></div> " );
/**
 * Template management
 */
define( '_AM_WFS_MODIFYTEMPLATES', '模板管理' );
define( '_AM_WFS_USINGTEMPLATES', '使用模板' );
define( '_AM_WFS_HOWTOUSETEMP', "<li>您现在可以为每部分WF-sections选择使用哪一个模板。<br /><li><b>警告：</b>错误的使用将会对网站造成不可预知的影响，如果您不确定，那么我强烈建议您采用缺省值！" );
define( '_AM_WFS_ADDINGATEMPLATE', "<b>增加一个模板</b>" );
define( '_AM_WFS_HOWTOUSETEMP2', "<li>要增加一个新模板，请拷贝模板文件到WF-sections模板文件夹。<br /><li>然后您必须通过<a href='../../../modules/system/admin.php?fct=modulesadmin&op=update&module=wfsection'>System Admin/Modules</a>更新WF-sections以使修改生效。<br /><li>操作失误会产生空页。" );
define( '_AM_WFS_DISPLAYXOOPSTEMPADMIN', 'Xoops模板设置管理：' );
define( '_AM_WFS_NONBLOCKS', '主模板' );
define( '_AM_WFS_ISBLOCKS', '区块模板' );
define( '_AM_WFS_TEMPLDOWNLOADS', '下载模板' );
define( '_AM_WFS_TEMPLARCHIVES', '文章归档模板' );
define( '_AM_WFS_TEMPLARTINDEX', '文章索引模板' );
define( '_AM_WFS_TEMPLSECINDEX', '类别索引模板' );
define( '_AM_WFS_TEMPLART', '文章页：伴随信息(缺省)' );
define( '_AM_WFS_TEMPLPLAINART', '文章页：没有Frame文章' );
define( '_AM_WFS_TEMPLTOPTEN', 'Top 10页面模板' );
define( '_AM_WFS_ARTMENUBLOCK', '文章菜单区块' );
define( '_AM_WFS_BIGSTORYBLOCK', '重大文章区块' );
define( '_AM_WFS_MAINMENUBLOCK', '主菜单区块' );
define( '_AM_WFS_NEWARTBLOCK', '新文章区块' );
define( '_AM_WFS_NEWDOWNBLOCK', 'WF-sections下载区块' );
define( '_AM_WFS_TOPARTBLOCK', 'Top文章区块' );
define( '_AM_WFS_TOPICSBLOCK', '类别区块' );
define( '_AM_WFS_SPOTLIGHTBLOCK', '焦点区块' );
define( '_AM_WFS_NEWDOWNLOADSBLOCK', '新下载区块' );
define( '_AM_WFS_AUTHORBLOCK', '作者信息区块' );
define( "_AM_WFS_VIEW", "浏览" );
/**
 * Indexpage management
 */
define( '_AM_WFS_INDEXPAGE', '业管理' );
define( '_AM_WFS_INDEXPAGEINFO', '页管理信息' );
define( '_AM_WFS_INDEXPAGEINFOTXT', '<li>此区域允许您\'设计\'多页WF-sections。<li>您可以轻易改变图片logo，页头，主索引头和页脚文字以定制外观。' );
define( '_AM_WFS_INDEXPAGELISTING', '页管理列表' );

define( "_AM_WFS_PAGENAME2", "页名" );
define( "_AM_WFS_MODIFYPAGE", "修改新页" );
define( "_AM_WFS_ADDPAGE", "增加新页" );
define( "_AM_WFS_INDEXHEADING", "页标题：" );
define( "_AM_WFS_INDEXHEADING2", "页标题" );
define( '_AM_WFS_INDEXPAGEEDIT', '编辑页' );
define( "_AM_WFS_SECTIONIMAGE", "页图片：" );
define( "_AM_WFS_SECTIONHEAD", "页头文字：" );
define( "_AM_WFS_SECTIONFOOT", "页脚文字：" );
define( "_AM_WFS_ALIGNMENT", "<b>页对齐：</b>" );
define( "_AM_WFS_ISDEFAULT", "缺省" );
define( "_AM_WFS_PAGENAME", "页名：" );
/**
 * include for wfs_admin wfsection admin permissions
 */
include_once 'wfs_admin_lang.php';
/**
 * include for wfssection icons
 */
include_once 'wfs_icons_lang.php';
/**
 * include for wfssection uploader
 */
include_once 'wfs_icons_upload.php';
/**
 * not done from here
 */
// define('_AM_WFS_ADMENU12', 'WF-sections Admin Management');
define( "_AM_WFS_MINDEX_ACTION", "操作" );
define( "_AM_WFS_MINDEX_PAGE", "<b>页：<b> " );
// Database Lang defines
define( "_AM_WFS_RUSUREDEL", "您想删除此文吗？" );
define( "_AM_WFS_NOTEIMGRESIZE", "图片已被重设为：160 x Width: 200" );
// section Lang Defines
define( "_AM_WFS_CATEGORY", "类别标题" );
define( "_AM_WFS_CATEGORYNAME", "类别标题：" );
define( "_AM_WFS_SECTIONPAGEDETAILS", "类别页细节" );
define( "_AM_WFS_TEXTOPTIONS", "文字格式选项：" );
define( "_AM_WFS_GROUPPROMPT", "类别访问权：<div style='padding-top: 8px;'><span style='font-weight: normal;'>选择有权访问此类别的用户组。</span></div>" );
define( "_AM_WFS_IN", "创建一个子类别：<div style='padding-top: 8px;'><span style='font-weight: normal;'>保留空白创建一个顶级类别。</span></div>" );
define( "_AM_WFS_MOVETO", "移动到类别：" );
define( "_AM_WFS_CATEGORYWEIGHT", "类别权重：<div style='padding-top: 8px;'><span style='font-weight: normal;'>决定类别显示顺序：0最高</span></div>" );
define( "_AM_WFS_CATEGORYDESC", "类别描述：<div style='padding-top: 8px;'><span style='font-weight: normal;'>仅纯文字。没有HTML或Xoops Codes</span></div>" );
define( "_AM_WFS_ADDMCATEGORY", "创建新类别" );
define( "_AM_WFS_CATEGORYTAKEMETO", "单击此处创建一个新类别。" );
define( "_AM_WFS_NOCATEGORY", "错误 - 没有创建类别。" );
define( "_AM_WFS_MODIFYCATEGORY", "修改类别" );
define( "_AM_WFS_MOVECATEGORY", "移动类别文章" );
define( "_AM_WFS_MOVEDEL", "移动文章" );
define( "_AM_WFS_EDITSECTION2", "移动到：文章将出现在此类别中。" );
define( "_AM_WFS_MOVE", "移动" );
define( "_AM_WFS_MOVEARTICLES", "移动文章到类别" );
define( '_AM_WFS_DUPLICATECATEGORY', '复制类别' );
define( '_AM_WFS_COPY', '拷贝类别：' );
define( '_AM_WFS_TO', '到：' );
define( '_AM_WFS_NEWCATEGORYNAME', '新类别标题：' );
define( '_AM_WFS_DUPLICATE', '复制' );
define( '_AM_WFS_DUPLICATEWSUBS', '随子类别复制' );
define( "_AM_WFS_SECTIONCOPYARTICLES", "同时拷贝子类别文章？" );
define( "_AM_WFS_ADDSECTIONTOMENU", "增加类别到Xoops主菜单？" );
define( "_AM_WFS_SECTIONTEMPLATE", "选择类别模板：" );
define( "_AM_WFS_SHOWCATEGORYIMG", "<b>显示类别图片：&nbsp;</b>" );
define( "_AM_WFS_SECTIONIMAGEALIGN", "<b>图片对齐：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>" );
define( "_AM_WFS_SECTIONIMAGEOPTION", "类别图片选项：" );
define( "_AM_WFS_SECTIONSTATUS", "类别状态：<div style='padding-top: 8px;'><span style='font-weight: normal;'>设置为在主类别索引列表中显示类别。如果设置为离线，类别将被隐藏</span></div>" );
define( "_AM_WFS_CATEGORYHEAD", "类别头文字：<div style='padding-top: 8px;'><span style='font-weight: normal;'>若空则创建根类别。</span></div>" );
define( "_AM_WFS_CATEGORYFOOT", "类别脚文字：<div style='padding-top: 8px;'><span style='font-weight: normal;'>若空则创建根类别。</span></div>" );
define( "_AM_WFS_GROUPCREATEPROMPT", "文章创建权：<div style='padding-top: 8px;'><span style='font-weight: normal;'>选择可以在此类别创建文章的用户组。</span></div>" );
// Document Lang defines
define( "_AM_WFS_ADDNEWAUTH", "选择新作者" );
define( "_AM_WFS_EDITARTICLE", "文章管理信息" );
define( "_AM_WFS_MENU_LINKS", "WF-sections菜单" );
// define("_AM_WFS_ARTICLEMANAGEMENT", "文章管理");
define( "_AM_WFS_ARTICLEPREVIEW", "文章预览" );
define( "_AM_WFS_WAYSYWTDTTAL", "警告：您确实想删除此类别和所有它的文章吗？" );
define( "_AM_WFS_CATEGORYSMNGR", "类别管理" );
define( "_AM_WFS_PEARTICLES", "创建新文章" );
define( "_AM_WFS_GENERALCONF", "一般配置" );
define( "_AM_WFS_UPDATEFAIL", "修改失败。" );
define( "_AM_WFS_EDITFILE", "编辑附件" );
define( "_AM_WFS_FILEDEL", "警告：您确实想删除此文件吗？" );
define( "_AM_WFS_IMGNAME", "文件名（空：与原（上传）文件名相同）" );
define( "_AM_WFS_UPLOADED", "上传！" );
define( "_AM_WFS_ISNOTWRITABLE", "不可写！" );
define( "_AM_WFS_UPLOADFAIL", "警告：上传失败。原因：" );
define( "_AM_WFS_NOTALLOWEDMIMETYPE", "Mimetype: %s <br />扩展名：.%s <br />您未被许可上传此类型文件。" );
define( "_AM_WFS_FILETOOBIG", "文件大小超过允许上传的大小！" );
define( "_AM_WFS_IMAGEALIGN", "设置图片对齐：" );
define( "_AM_WFS_ARTICLEPAGEMENU", "文章页配置" );
define( "_AM_WFS_BLOCKMENU", "区块配置" );
define( "_AM_WFS_ADMINEDITMENU", "文章一般配置" );
define( "_AM_WFS_ADMINCONFIGMENU", "管理配置" );
define( "_AM_WFS_SELECTITEM", "选择" );
define( "_AM_WFS_SPOTLIGHT", "在文章索引中焦点此文？" );
define( "_AM_WFS_SPOTLIGHTMAIN", "在主索引中焦点此文？" );
define( "_AM_WFS_SPOTLIGHTSPONSER", "在主索引中赞助文章？" );
define( "_AM_WFS_MENU", "其它设置" );
define( "_AM_WFS_EDITMAINTEXT", "3. 文字文章：（缺省）<div style='padding-top: 8px;'><span style='font-weight: normal;'>字数：%s</span></div> " );
define( "_AM_WFS_DOC_RESTORE", "恢复到文章的前一个版本" );
/**
 * all article information text
 */
define( "_AM_WFS_CMODHEADER", "文件权限检查" );
define( "_AM_WFS_FILE", "文件：" );
define( "_AM_WFS_NOMAINTEXT", "错误：您的文章中没有Text/Html！文章不能为空！" );
define( "_AM_WFS_PATH", "路径：" );
define( "_AM_WFS_ARTICLEMENU", "文章索引配置" );
define( "_AM_WFS_APPROVE", "审核" );
define( "_AM_WFS_MOVETOTOP", "移动此文到顶部" );
define( "_AM_WFS_CHANGEDATETIME", "改变发布时间" );
define( "_AM_WFS_NOWSETTIME", "发布日设定为：%s" );
define( "_AM_WFS_CURRENTTIME", "当前时间试：%s" );
define( "_AM_WFS_SETDATETIME", "设置发布日期/时间" );
define( "_AM_WFS_MONTHC", "月：" );
define( "_AM_WFS_DAYC", "日：" );
define( "_AM_WFS_YEARC", "年：" );
define( "_AM_WFS_TIMEC", "时间：" );
define( "_AM_WFS_IMAGES", "图片配置" );
define( "_AM_WFS_BROKENDOWNLOADS", "断链" );
define( "_AM_WFS_BROKENDOWNLOADSTEXT", "断链信息" );
define( "_AM_WFS_NOBROKEN", "没有中断文件的报告。" );
define( "_AM_WFS_IGNORE", "忽略" );
define( "_AM_WFS_FILEDELETED", "文件删除。" );
define( "_AM_WFS_BROKENDELETED", "中断文件报告删除。" );
define( '_AM_WFS_BROKENTEXT', '<li>忽略（忽略报告，仅删除<b>中断文件报告。</b>
<li>Edit （编辑或修改附件。）
<li>删除（删除<b>报告的下载区域</b>和文件的<b>中断文件报告</b>。）' );
define( "_AM_WFS_REPORTER", "报告发送者" );
define( "_AM_WFS_FILETITLE", "下载标题" );
define( "_AM_WFS_ARTICLETITLE", "文章标题" );
define( "_AM_WFS_UPLOAD", "上传" );
define( "_AM_WFS_VIEWHTML", "编辑HTML" );
define( "_AM_WFS_VIEWWAYSIWIG", "编辑WYSIWYG" );
define( "_AM_WFS_ARTICLEMANAGE", "文件管理" );
define( "_AM_WFS_WEIGHTMANAGE", "权重管理" );
define( "_AM_WFS_UPLOADMAN", "文件管理" );
define( "_AM_WFS_NOADMINRIGHTS", "对不起，仅站长可以改变WF-sections配置" );
define( "_AM_WFS_CANNOTHAVECATTHERE", "错误：类别不能是自己的子类别！！" );
define( "_AM_WFS_SECTIONMANAGE", "类别管理" );
define( "_AM_WFS_FILEID", "文件" );
define( "_AM_WFS_FILEICON", "Icon" );
define( "_AM_WFS_FILESTORE", "存为" );
define( "_AM_WFS_REALFILENAME", "真实姓名" );
define( "_AM_WFS_USERFILENAME", "用户名" );
define( "_AM_WFS_FILEMIMETYPE", "文件类型" );
define( "_AM_WFS_FILESIZE", "文件大小" );
define( "_AM_WFS_CHANGEEXPDATETIME", "改变过期日期/时间" );
define( "_AM_WFS_SETEXPDATETIME", "设置过期日期/时间" );
define( "_AM_WFS_NOWSETEXPTIME", "文章过期日设置为：%s" );
define( "_AM_WFS_ALLOWCOMENTS", "显示此文章的Xoops评论？" );
define( "_AM_WFS_COMMENT", "评论" );
define( "_AM_WFS_EDITSERVERFILE", "编辑访问权文件" );
define( "_AM_WFS_CURRENTFILENAME", "当前文件名：" );
define( "_AM_WFS_CURRENTFILESIZE", "文件大小：" );
define( "_AM_WFS_UPLOADFOLD", "上传文件夹：" );
define( "_AM_WFS_UPLOADPATH", "路径：" );
define( "_AM_WFS_FREEDISKSPACE", "自由空间：" );
define( "_AM_WFS_RENAMEFILE", "重命名文件" );
define( "_AM_WFS_ARTICLEWEIGHT", "文章权重" );
define( '_AM_WFS_MODIFYFILE', '修改文章文件' );
define( '_AM_WFS_FILESTATS', '附件状态' );
define( '_AM_WFS_FILESTAT', '文章的文件状态：' );
define( '_AM_WFS_IMGESIZETOBIG', '图片高度/宽度大于许可值的允许尺寸：高度：%s x 宽度：%s <br />上传图片尺寸：高度：%s x 宽度：%s' );
define( '_AM_WFS_CATREORDERTEXT', '<li>您可以在此处改变当前类别和文章权重。<br /><li>每个类别和文章按权重列示。<br /><li>主类别灰蓝色，子类别浅蓝和灰。</li><br /><li>要对文章重新排序，单击类别标题就会显示文章列表。</li>' );
define( '_AM_WFS_ATTACHFILEACCESS', '访问权与文章相同。您在编辑附件时可以修改。' );
define( '_AM_WFS_WFSFILESHOW', '附件' );
define( '_AM_WFS_ATTACHEDFILE', '文件上传信息' );
define( '_AM_WFS_TDISPLAYSATTACHEDFILES', '<li>所有附件将以ID顺序显示。<br /><li>您可以在此处编辑或删除文件。' );
define( '_AM_WFS_VOTEDATA', '显示投票区' );
define( '_AM_WFS_VOTEDATATEXT', '<li>投票数据将按ID顺序显示。' );
define( '_AM_WFS_ATTACHEDFILEM', '下载管理' );
define( '_AM_WFS_UPOADMANAGE', '文件管理' );
define( '_AM_WFS_CAREORDER', '权重管理' );
define( '_AM_WFS_CAREORDER2', '类别和文章权重' );
define( '_AM_WFS_CAREORDER3', '设置文章权重' );
define( "_AM_WFS_EDITHTMLFILE", "2. HTML文章：<div style='padding-top: 8px;'><span style='font-weight: normal;'>文件将用作页面正文。</span></div>" );
define( "_AM_WFS_DOCTITLE", "使用HTML文章标题" );
define( "_AM_WFS_DOHTMLDB", "输入到数据库" );
define( "_AM_WFS_EDITCONNECTFILE", "内容页？" );
define( "_AM_WFS_EDITHTMLFILEEDIT", "编辑选定的HTML文件？" );
define( "_AM_WFS_EDITWORDBROWSE", "选择Word文章" );
define( "_AM_WFS_EDITWORDDOCUMENT", "编辑选定的Word文章：" );
define( '_AM_WFS_EDITGROUPPROMPT', "文章访问权：<div style='padding-top: 8px;'><span style='font-weight: normal;'>选择有权访问此文章的用户组。</span></div>" );
define( "_AM_WFS_EDITSECTION", "创建于类别：<div style='padding-top: 8px;'><span style='font-weight: normal;'>文章将被创建显示于此类别。</span></div>" );
define( "_AM_WFS_EDITWEIGHT", "文章权重：<div style='padding-top: 8px;'><span style='font-weight: normal;'>决定文章显示顺序：0 最高。仅在缺省文章顺序设为权重时生效。</span></div>" );
define( "_AM_WFS_EDITCAUTH", "文章作者：" );
define( "_AM_WFS_EDITCAUTH2", "文章作者：<div style='padding-top: 8px;font-weight: normal;color:red;'><br />警告：:<br />
如果您改变了此文的内容请在使用导航条改变作者前保存改变！ <br />（导航条仅用于作者超过300的站点）</span></div>" );
define( "_AM_WFS_EDITLINKURL", "1. 连接文章：<div style='padding-top: 8px;'><span style='font-weight: normal;'>在文章列表中显示一个到另一个站点/页面的链接。</span></div>" );
define( "_AM_WFS_EDITLINKURLADD", "URL地址：<br />" );
define( "_AM_WFS_EDITLINKURLNAME", "URL名：<br />" );
define( "_AM_WFS_EDITARTICLETITLE", "文章标题：<div style='padding-top: 8px;'><span style='font-weight: normal;'>文章名。</span></div>" );
define( "_AM_WFS_PUBLISHDATE", "文章发布日期：" );
define( "_AM_WFS_EXPIREDATESET", "过期日期设置：" );
define( "_AM_WFS_EXPIREDATE", "文章过期日：" );
define( "_AM_WFS_CLEARPUBLISHDATE", "<br /><br />删除发布日：" );
define( "_AM_WFS_CLEAREXPIREDATE", "<br /><br />删除过期日：" );
define( "_AM_WFS_PUBLISHDATESET", "发布日期设置：" );
define( "_AM_WFS_SETDATETIMEPUBLISH", "设置发布日期/时间" );
define( "_AM_WFS_SETDATETIMEEXPIRE", "设置过期日期/时间" );
define( "_AM_WFS_SETPUBLISHDATE", "<b>设置发布日期： </b>" );
define( "_AM_WFS_SETEXPIREDATE", "<b>设置过期日期：</b>" );
define( "_AM_WFS_EXPIREWARNING", "<br />警告：过期日设置于发布日前！" );
define( "_AM_WFS_EDITSUMMARY", "文章概要：<div style='padding-top: 8px;'><span style='font-weight: normal;'>仅概要文本。</span></div>
<div style='padding-top: 8px;'><span style='font-weight: normal;'>在文章列表中显示一个到另一个站点/页面的链接。</span></div>
" );
define( '_AM_WFS_EDITAUTOSUMMARY', '使用自动概要' );
define( '_AM_WFS_EDITREMOVEIMAGES', '删除自动概要的图片' );
define( '_AM_WFS_EDITSUMMARYAMOUNTW', '自动概要的长度：（字）' );
define( '_AM_WFS_EDITSUMMARYAMOUNTC', '自动概要长度：（字符）' );
define( "_AM_WFS_EDITMOVETOTOP", "设置文章状态为新" );
define( "_AM_WFS_EDITAPPROVE", "核准此文章？" );
define( "_AM_WFS_EDITALLOWCOMENTS", "允许评论此文章" );
define( "_AM_WFS_EDITJUSTHTML", "无WF-sections框架" );
define( '_AM_WFS_EDITNOSHOART', '非索引文章' );
define( "_AM_WFS_EDITOFFLINE", "设置文章离线" );
define( "_AM_WFS_EDITMAINMENU", "把文章加入Xoops主菜单" );
define( "_AM_WFS_CHECKOUTOFARTICLE", "登出前一文章并重定向" );
define( "_AM_WFS_SECTIONHASARTICLES", "警告：列表非空。移动这些文章并删除类别？" );
define( "_AM_WFS_CREATEDBY", "原作者" );
define( "_AM_WFS_LASTEDITBY", "最近一次编辑：" );
define( "_AM_WFS_CREATEDON", "创建于：" );
define( "_AM_WFS_EDITEDON", "编辑于：" );
define( "_AM_WFS_ADDAFILETOTHISDOWNLOAD", "加一个文件到本文" );
define( "_AM_WFS_WARNINGUNSAVEDDATA", "（警告：所有未保存的数据将丢失！）" );
define( "_AM_WFS_EDITDISCUSSINFORUM", "增加 '到论坛讨论'到文章？" );
define( "_AM_WFS_EDITDISSUMMARYBREAKS", "关闭概要的行转换？" );
define( "_AM_WFS_NAVIGATION", "导航" );
define( "_AM_WFS_USECATEGORYACCESS", "本文应用类别权限？" );
define( '_AM_WFS_REORDERID', 'ID' );
define( '_AM_WFS_REORDERPID', 'PID' );
define( '_AM_WFS_REORDERTITLE', '标题' );
define( '_AM_WFS_REORDERDESCRIPT', '描述' );
define( '_AM_WFS_REORDERWEIGHT', '权重' );
define( '_AM_WFS_REORDERSUMMARY', '概要' );
define( "_AM_WFS_EXTRADOC_TEXT", "<div style='padding-top: 8px;'><b>Page Break</b>: <span style='font-weight: normal;'>使用 [pagebreak]把文章分隔成较小的常规导航的页面。</span></div>
<div style='padding-top: 8px;'><b>PageNav Breaks</b>: <br /><span style='font-weight: normal;'>使用[title]标题文字[/title]把一篇文章分隔成用标题导航的多个页面。<br />您可以使用[subtitle]子标题[/subtitle]给每个新页一个子标题。</span></div>
" );
/**
 * Main Configuration
 */
define( "_AM_WFS_WFSECTIONMAINCONFIG", "综合设置" );
define( "_AM_WFS_WFSECTIONMAINCONFIGTEXT", "<li>此处允许您改变大部分WF-sections配置。<br /><li>请阅读帮助了解更多细节" );
define( "_AM_WFS_SECTIONSETTINGS", "类别管理信息" );
define( "_AM_WFS_SECTIONSETTINGSTEXT", "<li>您能在此处为您的站点创建一个新类别，它类似存放文章的'文件夹'。<br /><li>您可以在此方便地创建，修改和删除类别<br /><li>请阅读帮助了解本特色更多的使用方法。" );
define( "_AM_WFS_MODIFICATION", "修改请求" );
define( "_AM_WFS_MODIFICATIONINFO", "修改请求信息" );
define( "_AM_WFS_MODIFICATIONTEXT", "<li>本处列出所有被修改重新提交审核的文章。<br /><li>您可以浏览，修改或核定这些改变。" );
/**
 * Index Page management
 */

/**
 * Copyright and Support.  Please do not remove this line as this is part of the only copyright agreement for using WF-sections
 */
define( '_AM_WFS_VISITSUPPORT', '访问WF-sections站点了解更多的信息，更新和使用帮助。<br /> WF-sections v1 Catzwolf &copy; 2003 <a href="http://www.wf-projects.com/" target="_blank">WF-sections</a>' );
// new constants by frankblack
define( '_AM_WFS_CLEAN', '清除' );
define( '_AM_WFS_PREVIEW', '预览' );
define( '_AM_WFS_NOARTWITHINCAT', '本类别没有文章' );
define( '_AM_WFS_RETCATREORDER', '返回类别重排序' );
define( '_AM_WFS_ARTREORDER', '文章已被重排序！' );
define( '_AM_WFS_CATREORDER', '选定的类别已被重排序！' );
define( '_AM_WFS_NOFILESFOUND', '未找到文件' );
define( '_AM_WFS_TOTALATTFILES', '下载总计：' );
define( '_AM_WFS_NOARTFOUND', '未找到文章' );
define( '_AM_WFS_WEIGHTMUSTNUMBER', '权重必须是数值！' );
define( '_AM_WFS_FILENAME', '文件名' );
define( '_AM_WFS_FILETYPE', '类型' );
define( '_AM_WFS_FILEMODIFIED', '修改' );
define( '_AM_WFS_FILEATTRIBUTES', '属性' );
define( '_AM_WFS_FILEACTIONS', '操作' );
define( '_AM_WFS_ALTFOLDER', '文件夹' );
define( '_AM_WFS_ALTCHANGEFOLDER', '修改' );
define( '_AM_WFS_ALTRENAMEFILE', '重命名' );
define( '_AM_WFS_ALTEDITFILE', '编辑' );
define( '_AM_WFS_ALTDELFILE', '删除' );
define( '_AM_WFS_ALTVIEWFILE', '显示' );
define( '_AM_WFS_ALTREFRESH', '刷新' );
define( '_AM_WFS_FILEFILES', '文件' );
define( '_AM_WFS_FILEDIRECTORIES', '目录' );
define( '_AM_WFS_FILENEWFILE', '新文件' );
define( '_AM_WFS_FILEMAKEDIR', '建目录' );
define( '_AM_WFS_FILEPARENTDIR', '父目录' );
define( '_AM_WFS_FILESAVED', '文件保存' );
define( '_AM_WFS_FILECREATED', '文件创建' );
define( '_AM_WFS_FILENOTCREATED', '错误：文件未创建' );
define( '_AM_WFS_FILEFOLDERCREATED', '文件夹创建' );
define( '_AM_WFS_FILEFOLDERNOTCREATED', '错误，文件夹未创建' );
define( '_AM_WFS_FILERENAME', '重命名' );
define( '_AM_WFS_FILERENAMEFILE', '重命名文件：' );
define( '_AM_WFS_FILERENAMEFILEHEAD', '重命名文件' );
define( '_AM_WFS_FILECHMOD', 'CHMOD文件：' );
define( '_AM_WFS_FILECHMODHEAD', 'CHMOD文件' );
define( '_AM_WFS_FILECHMODSAVE', 'CHMOD' );
define( '_AM_WFS_FILEDELETE', '删除' );
define( '_AM_WFS_FILEDELETEFILE', '删除文件' );
define( '_AM_WFS_FILECANNOTDELFOLDEREMPT', '不能删除，文件夹非空！' );
define( '_AM_WFS_FILENOFILEEDIT', '没有文件供编辑' );
define( '_AM_WFS_ISDELETED', '文件删除' );
define( '_AM_WFS_FILEFOLDERDEL', '文件夹删除' );
define( '_AM_WFS_FILEINVALIDFILENAME', '无效的文件名' );
define( '_AM_WFS_FILESAFEMODE1', '应用安全模式限制，不' );
define( '_AM_WFS_FILEUNKWOWN', '未知错误？？！，不能删除！' );
define( '_AM_WFS_FILENOTDELNOTWRITE', '不能删除，不可写！' );
define( '_AM_WFS_FILESAFEMODE2', '开启安全模式（这将引起Filemanager的问题）' );
define( '_AM_WFS_FILESAFEMODE3', '关闭安全模式' );
define( '_AM_WFS_FILEUPLOAD1', '开启上传' );
define( '_AM_WFS_FILEUPLOAD2', '关闭上传' );
define( '_AM_WFS_FILEUPLOAD3', '最大上传大小' );
define( '_AM_WFS_FILEREGISTER1', 'Register Globals打开' );
define( '_AM_WFS_FILEREGISTER2', 'Register Globals关闭' );
define( '_AM_WFS_FILERENAMED', '重命名！' );
define( '_AM_WFS_FILEALREADYEXISTS', '已存在！' );
define( '_AM_WFS_FILESAVEAS', '存为：' );
define( '_AM_WFS_FILEUPLOADEXISTSERVER', '您上传的文件存在于服务器上' );
define( '_AM_WFS_FILEMAXALLOWEDIS', '最大允许是：' );
define( '_AM_WFS_FILEWIDTH', '宽度：' );
define( '_AM_WFS_FILEHEIGHT', '高度：' );
define( '_AM_WFS_FILEIMGDIMENS', '上传图片大小：' );
define( '_AM_WFS_FILEALLOWIMGDIMENS', '允许图片大小：' );
define( '_AM_WFS_FILENONAMECHOOSEN', '未选文件！请选择一个上传文件。' );
define( '_AM_WFS_FILEPATHNOTEXIST', '路径不存在：<br /> %s' );
define( '_AM_WFS_FILEPATHNOTWRITE', '路径不可写：<br /> %s' );
define( '_AM_WFS_FILENODIRSEL', '未选择目录' );
define( '_AM_WFS_FILEERRFILENOTREN', '未知错误，文件未重命名！' );
define( '_AM_WFS_FILECANNOT', '不能' );
define( '_AM_WFS_FILEISNOTWRITABLE', '不可写！' );
define( '_AM_WFS_FILEFILE', '文件' );
define( '_AM_WFS_SAFEMODEAPPLY', '应用安全模式限制，不' );
define( '_AM_WFS_UNKOWNERRORNOTDEL', '未知错误，未删除！' );
define( '_AM_WFS_MIMETYPE', 'Mimetype：' );
define( '_AM_WFS_SERVERSTATUS', '服务器状态' );
define( '_AM_WFS_SAFEMODEISON', '安全模式开启 （这将引起Filemanager的问题）' );
define( '_AM_WFS_SAFEMODEISOFF', '安全模式关闭' );
define( '_AM_WFS_UPLOADSON', '上传开启' );
define( '_AM_WFS_UPLOADSOFF', '上传关闭' );
define( '_AM_WFS_ANDTHEMAX', '最大上传大小＝' );
define( '_AM_WFS_REGISTERON', 'Register Globals开启' );
define( '_AM_WFS_REGISTEROFF', 'Register Globals关闭' );
define( '_AM_WFS_APPROVED', '核准' );
define( '_AM_WFS_ERROR_APPROVED', '核准时发生错误' );
// votedata
define( "_AM_WFS_DLRATINGS", "WF-sections文章得分 （总投票：%s）" );
define( "_AM_WFS_REGUSERVOTES", "注册用户投票（总投票： %s）" );
define( "_AM_WFS_ANONUSERVOTES", "匿名用户投票（总投票： %s）" );
define( "_AM_WFS_USER", "用户" );
define( "_AM_WFS_IP", "IP地址" );
define( "_AM_WFS_USERAVG", "平均用户评分" );
define( "_AM_WFS_TOTALRATE", "总评分" );
define( "_AM_WFS_NOREGVOTES", "无用户投票" );
define( "_AM_WFS_DATE", "日期" );
define( "_AM_WFS_ARTICLE", "文章名" );
define( "_AM_WFS_RATING", "得分" );
define( "_AM_WFS_VOTEDELETED", "投票删除" );
// Modify Document
define( "_MD_DLCONF", "下载配置" );
define( "_MD_USERMODREQ", "用户修改请求" );
define( "_MD_ORIGINAL", "原始" );
define( "_MD_PROPOSED", "建议的" );
define( "_MD_OWNER", "主人：" );
define( "_MD_NOMODREQ", "没有下载修改请求。" );
define( "_MD_DESCRIPTIONC", "描述：" );
define( "_MD_FILEID", "文件ID：" );
define( "_MD_FILETITLE", "下载标题：" );
define( "_MD_DLURL", "下载URL：" );
define( "_MD_DLURLUPLOAD", "上传文件：" );
define( "_MD_HOMEPAGEC", "主页：" );
define( "_MD_VERSIONC", "版本：" );
define( "_MD_FILESIZEC", "文件大小：" );
define( "_MD_NUMBYTES", "%s 字节" );
define( "_MD_PLATFORMC", "平台：" );
define( "_MD_EMAILC", "Email：" );
define( "_MD_CATEGORYC", "分类：" );
define( "_MD_LASTUPDATEC", "上次修改：" );
define( "_MD_APPROVE", "审核" );
define( "_MD_IGNORE", "忽略" );
define( "_MD_SUBMITTER", "提交者：" );
define( "_AM_WFS_MOVETOART", "移到文章：（空：不改变）" );
// Modified Documents
define( "_AM_WFS_MODIFIED", "修改" );
define( "_AM_WFS_ORIGINAL", "原始文章" );
define( "_AM_WFS_AUTHOR", "作者：" );
define( "_AM_WFS_MAINTEXT", "正文：" );
define( "_AM_WFS_SUBTITLE", "子标题：" );
define( "_AM_WFS_SUMMARY", "概述：" );
define( "_AM_WFS_URL", "URL：" );
define( "_AM_WFS_URLNAME", "URL名：" );
// define("_AM_WFS_SECTION", "类别：");
define( "_AM_WFS_TITLE1", "标题：" );
define( "_AM_WFS_PUBLISHEDDATE", "发布：" );
define( "_AM_WFS_SUMITDATE", "修改日期：" );
define( "_AM_WFS_PROPOSED", "修订文章" );
define( "_AM_WFS_POST", "保存" );
define( "_AM_WFS_POSTNEWARTICLE", "编辑修改文章" );
define( "_AM_WFS_WAYSYWTDTTAL2", "删除修改文章？" );
define( "_AM_WFS_MODREQDELETED", "删除修改文章" );
// Admin rights
define( "_AM_WFS_WFsectionADMINRIGHTS", "您无权访问此区！" );
// Document Stats
define( "_AM_WFS_ARTICLESTATS", "文章统计" );
define( "_AM_WFS_ARTICLESTATSFOR", "文章的统计：" );
define( "_AM_WFS_ISLEFT", "左" );
define( "_AM_WFS_ISCENTER", "中" );
define( "_AM_WFS_ISRIGHT", "右" );
define( "_AM_WFS_THISWILLREPLACELINEBREAKS", "(这将用break tag替换linebreaks)" );
define( "_AM_WFS_CREATEARTICLE", "创建新文章" );
define( "_AM_WFS_MODIFYARTICLE", "修改文章：" );
define( "_AM_WFS_NODETAILSRECORDED", "没有细节记录" );
define( "_AM_WFS_ISFOLDER", "文件夹" );
define( "_AM_WFS_ISCHANGEFOLDER", "改变文件夹" );
define( "_AM_WFS_ISRENAMEFILE", "重命名文件" );
define( "_AM_WFS_ISEDITFILE", "编辑文件" );
define( "_AM_WFS_ISDOWNLOAD", "下载" );
define( "_AM_WFS_ISDELFILE", "删除文件" );
define( "_AM_WFS_ISVIEWFILE", "浏览文件" );
define( "_AM_WFS_ISHOME", "Home" );
define( "_AM_WFS_ISREFRESH", "刷新" );
define( "_AM_WFS_ISADMINNOTICE", "管理通知：您需要改正这个" );
define( "_AM_WFS_ISSORRYMESSAGE", "" );
define( "_AM_WFS_ISSORRYMESSAGE2", "<div><b>Sorry</b>，文章 <i>%s</i>不可编辑！</div><br /><div>用户 %s 此时在编辑此文。编辑始于： %s </div>" );
define( "_AM_WFS_STATARTICLEID", "文章id：" );
define( "_AM_WFS_STATTITLE", "标题：" );
define( "_AM_WFS_STATWEIGHT", "权重：" );
define( "_AM_WFS_STATSECTION", "在类别下：" );
define( "_AM_WFS_STATAUTHOR", "原始作者：" );
define( "_AM_WFS_STATCREATED", "创建日：" );
define( "_AM_WFS_STATPUBLISHED", "发布日：" );
define( "_AM_WFS_STATPUBLISH", "发布日：" );
define( "_AM_WFS_STATEXPIRED", "过期日" );
define( "_AM_WFS_STATLASTEDITED", "在：" );
define( "_AM_WFS_STATLASTEDITEDBY", "最后一次编辑：" );
define( "_AM_WFS_STATTIMESEDITEDBYAUTHOR", "作者编辑的次数：" );
define( "_AM_WFS_STATTIMESEDITEDBYLASTEDITOR", "最近编者编辑次数：" );
define( "_AM_WFS_STATTIMESEDITEDTOTAL", "总共编辑次数" );
define( "_AM_WFS_STATCOUNTER", "文章阅读：" );
define( "_AM_WFS_STATRATING", "文章得分：" );
define( "_AM_WFS_STATRATINGHIGH", "最高得分：" );
define( "_AM_WFS_STATRATINGLOW", "最低得分：" );
define( "_AM_WFS_STATVOTES", "投票次数：" );
define( "_AM_WFS_STATDOWNLOADS", "附件数：" );
define( "_AM_WFS_STATCOMMENTSALLOWED", "允许评论？" );
define( "_AM_WFS_STATCOMMENTS", "总共评论：" );
define( "_AM_WFS_STATSTATUS", "文章状态：" );
define( "_AM_WFS_RELATEDART", "相关文章管理" );

define( "_AM_WFS_RELATEDARTADMIN", "相关文章信息" );
define( "_AM_WFS_RELATEDARTADMINTXT", "相关文章可以是WF-sections文章或新闻文章：
<br /><li><b>文章：</b>这将带你到文章选择列表。</li>
<li><b>News:</b>这将带你到新闻文章选择列表。</li>
" );

define( "_AM_WFS_RELATEDDOCLIST", "相关文章选择列表：
<br /><li><b>文章：</b>这将带你到文章选择列表。</li>
<li><b>News:</b>这将带你到新闻文章选择列表。</li>
" );

define( "_AM_WFS_RELATEDNEWSLIST", "相关新闻文章选择列表" );
define( "_AM_WFS_RELATEDDOCUMENTLIST", "相关文章选择列表" );

define( "_AM_WFS_RELATEDNEWSLISTTXT", "
<li><b>ID:</b> 列出的ID。</li>
<li><b>Title:</b>这将显示表中项的标题。</li>
<li><b>Weight:</b>这是每个项目的显示顺序。您可以为每个项指定新值。</li>
<li><b>Add Releted Item:</b>选中或取消将从相关项目列表中增加或删除一项。</li>
<li><b>Select All/None:</b>快速切换列表项。</li>
" );

define( "_AM_WFS_RELATEDLINKLIST", "相关链接选择列表" );
define( "_AM_WFS_RELATEDLINKLISTTXT", "
<li><b>ID:</b>列出的ID。</li>
<li><b>标题：</b>这将显示表中项的标题。</li>
<li><b>权重：</b>这是每项的显示顺序。</li>
<li><b>增加相关项：</b>选中或取消将从相关项目列表中增加或删除一项。</li>
<li><b>Action:</b>执行特别任务。</li>
" );

define( "_AM_WFS_RELATEDLINKLIST2", "创建相关链接" );
define( "_AM_WFS_RELATEDLINKLISTTXT2", "
<li><b>Releated Link:</b>链接的Url地址。</li>
<li><b>Related Link Name:</b>显示在链接列表中的友好名。</li>
<li><b>Weight:</b>这是列表中每项的显示顺序。</li>
<li><b>Action:</b>执行诸如编辑或删除当前链接的特别任务。</li>
" );

define( "_AM_WFS_NO_DOCS_CREATEDYET", "还没有文章创建。请创建一些再尝试。" );
define( "_AM_WFS_RELATED_DOC", "文章" );
define( "_AM_WFS_RELATED_NEWS", "新闻" );
define( "_AM_WFS_ADDRELATEDART", "增加相关文章" );
define( "_AM_WFS_RELATEDITEM", "增加相关项" );
define( "_AM_WFS_RELATEDART_WEIGHT", "权重" );
define( "_AM_WFS_ARTID", "ID" );
define( "_AM_WFS_SHOWALL", "选中所有/None" );
define( "_AM_WFS_FAILTOSEE", "Ok? 出错！！！ 不知您为何要把这些文章拷贝到同一类别？确实如此吗？" );
define( "_AM_WFS_NOARTICLE", "此文不存在" );
define( "_AM_WFS_NOARTICLESSELECTED", "没有选择文章" );
define( "_AM_WFS_ARTICLESMOVED", "选中的文章已移到新类别" );
define( "_AM_WFS_ANDMOVED", "同时移到类别：" );
define( "_AM_WFS_SELECTALLNONE", "选择所有/None" );
define( "_AM_WFS_SUBMIT1", "提交" );
define( "_AM_WFS_VOTES", "投票：" );
define( "_AM_WFS_SORTBY1", "排序：" );
define( "_AM_WFS_DATE1", "日期" );
define( "_AM_WFS_ARTICLEID1", "文章ID" );
define( "_AM_WFS_POPULARITY1", "点击率" );
define( "_AM_WFS_CURSORTBY1", "文章当前排序：" );
define( "_AM_WFS_RATING1", "得分" );
define( "_AM_WFS_RESET", "重置" );
define( "_AM_WFS_NOSUCHSECTION", "<b>错误</b>：没有此类别" );
define( "_AM_WFS_NOTITLESET", "没有设置标题" );
define( "_AM_WFS_EDITSUBTITLE", "文章子标题：<div style='padding-top: 8px;'><span style='font-weight: normal;'>文字将以粗体出现在正文上部。</span></div>" );
define( "_AM_WFS_EDITNEWARTTITLE", "新文章" );
define( "_AM_WFS_EDITWRAPURL", "Wrap外部HTML文章：" );
define( "_AM_WFS_SELECT_IMG", "文章图片：" );
define( "_AM_WFS_TOTALNUMARTS", "总计文章数：" );
define( "_AM_WFS_STATUSERTYPE", "文章用户类型：" );
define( "_AM_WFS_DATEIN", "编辑时间始于：" );
define( "_AM_WFS_DATEOUT", "编辑时间结束：" );
define( "_AM_WFS_DOCEDITHISTORY", "文章编辑历史" );
define( "_AM_WFS_STILLEDITING", "仍编辑文章" );
define( "_AM_WFS_DOCSINEDITING", "被编辑的文章" );
define( "_AM_WFS_EDITVERSION", "保存时递增版本" );
define( "_AM_WFS_EDITVERSIONNUM", "文章版本：" );
define( "_AM_WFS_OTHEROPTIONS", "其它选项：" );
// wfs_fileshow defines
define( "_AM_WFS_ATTACHEDFILES", "附件配置" );
define( "_AM_WFS_FILEUPLOAD", "上传文件给文章：" );
define( "_AM_WFS_ATTACHEDFILEEDITH", "创建新上传" );
define( "_AM_WFS_ATTACHFILE", "上传的文件" );
define( "_AM_WFS_FILESHOWNAME", "显示的文件名" );
define( "_AM_WFS_FILEDESCRIPT", "文件描述" );
define( "_AM_WFS_FILETEXT", "文件搜索文字" );
define( "_AM_WFS_NOT_PUBLISHED", "不发布" );
define( "_AM_WFS_NOT_SET", "不设置" );
define( "_AM_WFS_NOT_CHANGED", "不改变" );
define( "_AM_WFS_TIMES", " 次数" );
define( "_AM_WFS_ONLINE", "在线" );
define( "_AM_WFS_OFFLINE", "离线" );
define( "_AM_WFS_DISPLAYPAGES", "显示页数：" );
define( "_AM_WFS_ARTICLERESTOREHEADING", "文章回复管理" );
define( "_AM_WFS_ARTICLERESTOREINFO", "文章回复信息" );
define( "_AM_WFS_ARTICLERESTORETEXT", "从一个备份的旧版本恢复文章。" );
define( "_AM_WFS_RESTORE_ID", "RID" );
define( "_AM_WFS_RESTORE_DATE", "恢复日期" );
define( "_AM_WFS_RESTORE_ARTICLEID", "ArID" );
define( "_AM_WFS_RESTORE_TITLE", "恢复标题" );
define( "_AM_WFS_RESTORE_VERSION", "版本" );
define( "_AM_WFS_RESTORE_ACTION", "操作" );
define( "_AM_WFS_RESTORE_CREATED", "创建" );
define( "_AM_WFS_RESTORE_PUBLISHED", "发布" );
define( "_AM_WFS_NORESTORE", "恢复id不存在" );
define( "_AM_WFS_NORESTORE_POINTS", "本文没有恢复点" );
define( "_AM_WFS_DELETERESTORE", "删除本恢复点？" );
define( "_AM_WFS_RESTOREDELETED", "恢复点已被删除。" );
define( "_AM_WFS_ERROR_RESTOREDELETED", "删除恢复点时产生错误。" );
define( "_AM_WFS_FILEEXISTS", "（文件存在）" );
define( "_AM_WFS_FILEERROR", "错误：" );
define( "_AM_WFS_FILEERRORPLEASECHECK", "请检查文件！" );
define( "_AM_WFS_NUMBER", " NO: " );
define( "_AM_WFS_ATTACHEDARTICLE", "文件附加到文章：" );
define( "_AM_WFS_RATINGID", "RID" );
// Uploader
define( "_AM_WFS_FILENOTFOUND", "未找到文件" );
define( "_AM_WFS_INVALIDFILESIZE", "无效文件大小：%s 字节" );
define( "_AM_WFS_ERRORUPLOADINGFILE", "没有文件上传" );
define( "_AM_WFS_INVALIDCHARCS", "文件名中的无效字符" );
define( "_AM_WFS_FAILEDUPLOADING", "上传失败：" );
define( "_AM_WFS_ERRORSRETURNED", "<h4>上传时返回错误</h4>" );
define( "_AM_WFS_FILESIZEGRTMAX", "不允许的文件大小 %s (%s)<br />最大允许是：%s (%s)." );
define( "_AM_WFS_EXTNOTSAME", "文件Mimetype不匹配文件扩展名！<br />文件Mimetype： %s <br />文件扩展名：%s" );
// Related LINKS
define( "_AM_WFS_RELATEDLINKS", "相关链接管理" );
define( "_AM_WFS_RELATEDLINKSADMIN", "相关链接信息" );
define( "_AM_WFS_RELATEDLINKSLIST", "相关链接列表" );
define( "_AM_WFS_ADDRELATEDLINK", "增加相关文章链接" );
define( "_AM_WFS_RELATED_URL", "相关链接" );
define( "_AM_WFS_RELATED_URLNAME", "相关链接名" );
define( "_AM_WFS_RELATED_WEIGHT", "权重" );
define( "_AM_WFS_ID", "ID" );
define( '_AM_WFS_NOURLFOUND', '无相关链接' );
define( '_AM_WFS_DELETERELEATEDLINK', '确实删除相关链接？' );
define( '_AM_WFS_RELATED_DELETED', '相关链接删除！' );
define( '_AM_WFS_RELATED_DBUPDATED', '相关链接创建/修改' );
// Reviews
define( "_AM_WFS_ADDREVIEW", "增加/修改评论细节" );
define( "_AM_WFS_PUBLISHER", "发布者：" );
define( "_AM_WFS_INTROTEXT", "评论简介：" );
define( "_AM_WFS_GAMEPLAYTEXT", "Gameplay文字：" );
define( "_AM_WFS_GRAPHICSTEXT", "图片文字：" );
define( "_AM_WFS_MUSIC", "音乐文字：" );
define( "_AM_WFS_FINALTHOUGHTS", "结语：" );
define( "_AM_WFS_PLATFORM", "平台：" );
define( "_AM_WFS_DEVELOPER", "开发者：" );
define( "_AM_WFS_WEBSITE", "官方Website URL：" );
define( "_AM_WFS_WEBSITEFREINDLY", "官方友好站点名：" );
define( "_AM_WFS_DIFFICULTY", "难点：" );
define( "_AM_WFS_RELEASED", "发布日：" );
define( "_AM_WFS_GRADING", "等级：" );
define( "_AM_WFS_GENRE", "流派：" );
define( "_AM_WFS_PLAYERS", "玩家：" );
define( "_AM_WFS_PLAYONLINE", "在线玩：" );
define( "_AM_WFS_ESRB", "ESRB 得分：" );
define( "_AM_WFS_LEARNINGCURVE", "学习曲线：" );
define( "_AM_WFS_GRAPHICS", "图像分：" );
define( "_AM_WFS_SOUND", "音乐分：" );
define( "_AM_WFS_GAMEPLAY", "Gameplay 得分：" );
define( "_AM_WFS_CONCEPT", "概念设计分：" );
define( "_AM_WFS_VALUE", "币值：" );
define( "_AM_WFS_TILT", "编者Tilt:" );
define( "_AM_WFS_OVERALL", "总分：" );
define( "_AM_WFS_CONCLUSION", "结论：" );
define( "_AM_WFS_DISPLAYREVIEW", "显示该评述？" );
define( "_AM_WFS_ADD_REVIEW", "增加评述到文章" );
// Import settings
define( "_AM_WFS_IMPORT", "批量导入文章文件" );
define( "_AM_WFS_IMPORTTEXT", "批量导入HTML文章到选定类别:
<br /><li><b>类别标题：</b>导入的文章所属的类别标题。</li>
<li><b>目录名何文件名：</b>HTML文章存放的目录。</li>" );

define( "_AM_WFS_ADD_SETTINGS", "改变其它文章设置" );
define( "_AM_WFS_IMPORTWORD", "导入Word文件" );
define( "_AM_WFS_IMPORTWORDYES", "Com 发现/启用于服务器。似乎您能够转换word文件，但在您使用本功能前要确保您的计算机安装了word。" );
define( "_AM_WFS_IMPORTWORDNO", "Com 未发现/启用于服务器" );
define( "_AM_WFS_CATEGORYT", "类别" );

define( "_AM_WFS_IMPORTWORDINYES", "您的计算机似乎安装了MS Word并且您似可以转换一个word文件。" );
define( "_AM_WFS_IMPORTWORDINNO", "MS Word未发现/安装于您的计算机。" );
/**
 * Check for word
 */
define( "_AM_WFS_IMPORTWORDTXT", "导入Word文章校验：");
define( "_AM_WFS_IMPORTCOMENABLED", "Com启用？");
define( "_AM_WFS_IMPORTWORDINSTALL", "MS Word安装？");
define( "_AM_WFS_IMPORTWORDSELECT", "<b>选择Word文件：</b>选择一个上传导入的Word文件。");
define( "_AM_WFS_WORDNOTINSTALLED", "您的服务器或计算机不满足转换MS Word文件的需求。" );

define( "_AM_WFS_IMPORTPDF", "导入PDF文件" );
define( "_AM_WFS_IMPORTPDFSELECT", "<b>选择PDF文件：</b>选择一个PDF文件上传导入。");
define( "_AM_WFS_EDITPDFBROWSE", "选择PDF文件" );
define( "_AM_WFS_EDITPDFFILE", "2a. PDF文件：<div style='padding-top: 8px;'><span style='font-weight: normal;'>本文将作为页面的正文。</span></div>" );

define( "_AM_WFS_EDITDRAFT", "存为草稿？" );
define( "_AM_WFS_IMPORT_DIRNAME", "目录名或文件名" );
define( "_AM_WFS_IMPORT_HTMLPROC", "处理HTML文件" );
define( "_AM_WFS_IMPORT_EXTFILTER", "外部筛选器程序名" );
define( "_AM_WFS_IMPORT_BODY", "导入HTML文件体" );
define( "_AM_WFS_IMPORT_INDEXHTML", "删除到index.html的链接，在本目录或上级目录已有。" );
define( "_AM_WFS_IMPORT_LINK", "改变一个到标题的链接 = 文件名" );
define( "_AM_WFS_IMPORT_IMAGE", "改变图片文件的链接到图片目录。" );
define( "_AM_WFS_IMPORT_ATMARK", "改变 @ 到 &amp;#064;" );
define( "_AM_WFS_IMPORT_TEXTPROC", "处理文本文件" );
define( "_AM_WFS_IMPORT_TEXTPRE", "用 &lt;pre&gt; &lt;/pre&gt;包围文本文件" );
define( "_AM_WFS_IMPORT_IMAGEPROC", "图片文件处理" );
define( "_AM_WFS_IMPORT_IMAGEDIR", "图片目录名" );
define( "_AM_WFS_IMPORT_IMAGECOPY", "拷贝图片文件到图片目录。" );
define( "_AM_WFS_IMPORT_TESTMODE", "测试模式" );
define( "_AM_WFS_IMPORT_TESTDB", "不存到数据库。保存时请去除一个选定。" );
define( "_AM_WFS_IMPORT_TESTEXEC", "测试" );
define( "_AM_WFS_IMPORT_TESTTEXT", "文字显示" );
define( "_AM_WFS_IMPORT_EXPLANE", "基于文件扩展名判断类型。<br>HTML文件有html或htm扩展名。<br>T文本文件有txt扩展名。<br>图片文件有gif，jpg，jpeg或png扩展名。<br>" );
define( "_AM_WFS_IMPORT_ERRDIREXI", "目录或文件不存在" );
define( "_AM_WFS_IMPORT_ERRFILEXI", "筛选程序不存在" );
define( "_AM_WFS_IMPORT_ERRFILEXEC", "筛选程序不可执行" );
define( "_AM_WFS_IMPORT_ERRNOCOPY", "未指定图片拷贝" );
define( "_AM_WFS_IMPORT_ERRNOIMGDIR", "未指定图片目录" );
define( "_AM_WFS_IMPORT_ERRIMGDIREXI", "指定的图片目录不是目录" );
define( "_AM_WFS_IMPORT_ERRFILEEXI", "文件不存在" );
define( "_AM_WFS_ARTRESTORENOTACT", "此功能尚未激活。" );
define( "_AM_WFS_ERRORFILEALLREADYEXISITS", "文件已在服务器上存在。" );
// define("_AM_WFS_RELATEDARTS", "相关文章列表");
// define("_AM_WFS_RELATEDNEWS", "相关新闻列表");
define( "_AM_WFS_ATTACHEDFILESADMIN", "编辑附件管理" );
define( "_AM_WFS_ATTACHEDFILEPREVIEW", "文件预览" );
define( "_AM_WFS_ATTACHEDFILESTAS", "文件统计" );
define( "_AM_WFS_ATTACHEDFILEEDIT", "文件编辑" );
define( "_AM_WFS_ATTACHEDFILEACCESS", "允许访问：" );
// Document Spotlight
define( "_AM_WFS_DOCSPOTLIGHTHEADING", "文章焦点管理" );
define( "_AM_WFS_DOCSPOTLIGHTINFO", "文章焦点信息" );
define( "_AM_WFS_DOCSPOTLIGHTTEXT", "设置文章显示于焦点区块：
<li>焦点图片Spotlight Image</li>
<li>焦点图片最大宽度</li>
<li>焦点图片最大高度</li>
<li>焦点图片最大长度</li>
<li>概要文字类型</li>
<li>焦点文章：总使用最近文章或选择一篇</li>
" );
define( "_AM_WFS_DOCSPOTLIGHTFORM", "焦点表" );
define( "_AM_WFS_DOCSPOTLIGHTDOC", "焦点文章：" );
define( "_AM_WFS_DOCSPOTLIGHTIMAGE", "焦点预览：" );
define( "_AM_WFS_USE_LASTPUBLISHED", " 使用最近发布文章：" );
define( "_AM_WFS_CURRENT_SPOT", "当前焦点文章：" );
define( "_AM_WFS_OTHERWISE_CHOOSEANARTICLE", "从以下选择一篇文章" );
define( "_AM_WFS_SPOTIT", "选择" ); // select it as spotlight document
define( "_AM_WFS_SPOTIMAGE_MAXWIDTH", "最大焦点图片宽度：" );
define( "_AM_WFS_SPOTIMAGE_MAXHEIGHT", "最大焦点图片高度：" );
define( "_AM_WFS_SPOTDOCUMENT_MAXLENGTH", "最大焦点文本区长度：<div style='padding-top: 8px;'><span style='font-weight: normal;'>文字段落字/字母。0将保留原有长度。</span></div>" );
define( "_AM_WFS_SPOTDOCUMENT_SUMTYPE", "概要文字类型：" );
define( "_AM_WFS_SPOTDOCUMENT_SUBTITLE", "文章子标题" );
define( "_AM_WFS_SPOTDOCUMENT_SUMMARY", "文章概要" );
define( "_AM_WFS_SPOTDOCUMENT_MAINTEXT", "文章正文" );
// index.php
define( "_AM_WFS_ARTICLENOTEXIST", "错误：文章不存在" );
define( "_AM_WFS_NOT_WORDDOC", "错误：这不是一个MS WORD文件" );
define( "_AM_WFS_NO_FORUM", "未选择论坛" );
define( "_AM_WFS_CHECKIN_FAILED", "文件Checkin失败" );
define( "_AM_WFS_SERVERSTATS", "服务器状态" );
define( "_AM_WFS_SPHPINI", "<b>来自PHP ini文件的信息：</b>" );
define( "_AM_WFS_SAFEMODESTATUS", "安全模式状态：" );
define( "_AM_WFS_REGISTERGLOBALS", "Register Globals: " );
define( "_AM_WFS_MAGICQUOTESGPC", "Magic_quotes State For GPC : " );
define( "_AM_WFS_SERVERUPLOADSTATUS", "Server上传状态：" );
define( "_AM_WFS_MAXUPLOADSIZE", "允许的最大上传大小：" );
define( "_AM_WFS_MAXPOSTSIZE", "允许的最大投递大小：" );
define( "_AM_WFS_SAFEMODEPROBLEMS", " （这会引发问题）" );
define( "_AM_WFS_GDLIBSTATUS", "GD 库支持：" );
define( "_AM_WFS_GDLIBVERSION", "GD 库版本：" );
define( "_AM_WFS_GDON", "<b>开启</b> （生成缩略图）" );
define( "_AM_WFS_GDOFF", "<b>禁用</b> （无缩略图）" );
define( "_AM_WFS_OFF", "<b>关闭</b>" );
define( "_AM_WFS_ON", "<b>开启</b>" );
define( "_AM_WFS_ZLIBCOMPRESSION", "ZLib压缩：" );
define( "_AM_WFS_MAXINPUTTIME", "最大输入次数：" );
define( "_AM_WFS_FOPENURL", "FOpen URL：" );

define( "_AM_WFS_EXT", "扩展名：" );
define( "_AM_WFS_UPDATEDATE", "上次修改：" );
define( "_AM_WFS_DOWNLOADNAME", "下载名：" );
define( "_AM_WFS_FILEREALNAME", "保存名：" );
define( "_AM_WFS_ARTICLEID", "文章ID：" );
define( "_AM_WFS_DESCRIPTION", "文件描述" );
define( "_AM_WFS_NODESCRIPT", "文件无描述。" );
define( "_AM_WFS_ERRORCHECK", "文件校验：" );
define( "_AM_WFS_ADD_STATUS", "浏览文章状态" );
define( "_AM_WFS_FILEPERMISSION", "文章权限：" );
define( "_AM_WFS_DOWNLOADED", "下载次数：" );
define( "_AM_WFS_DOWNLOADSIZE", "下载大小：" );
define( "_AM_WFS_LASTACCESS", "上次访问日：" );
define( "_AM_WFS_LASTUPDATED", "上次修改于：" );
define( "_AM_WFS_DEL", "删除" );
// Mimetypes
define( "_AM_WFS_MMIMETYPES", "Mimetypes管理" );
define( "_AM_WFS_MIME_ID", "ID" );
define( "_AM_WFS_MIME_EXT", "EXT" );
define( "_AM_WFS_MIME_NAME", "应用类型" );
define( "_AM_WFS_MIME_ADMIN", "管理员" );
define( "_AM_WFS_MIME_USER", "用户" );
// Mimetype Form
define( "_AM_WFS_MIME_CREATEF", "创建Mimetype" );
define( "_AM_WFS_MIME_MODIFYF", "修改Mimetype" );
define( "_AM_WFS_MIME_EXTF", "文件扩展名：" );
define( "_AM_WFS_MIME_NAMEF", "应用类型/名：<div style='padding-top: 8px;'><span style='font-weight: normal;'>输入关联于此扩展名的应用。</span></div>" );
define( "_AM_WFS_MIME_TYPEF", "Mimetypes:<div style='padding-top: 8px;'><span style='font-weight: normal;'>输入每个关联于此文件扩展名的mimetype。每个mimetype必须由空格分隔。</span></div>" );
define( "_AM_WFS_MIME_ADMINF", "允许管理员Mimetype" );
define( "_AM_WFS_MIME_ADMINFINFO", "<b>可用于管理员上传的Mimetypes：</b>" );
define( "_AM_WFS_MIME_USERF", "允许用户Mimetype" );
define( "_AM_WFS_MIME_USERFINFO", "<b>可用于用户上传的Mimetypes：</b>" );
define( "_AM_WFS_MIME_NOMIMEINFO", "没有选择mimetypes。" );
define( "_AM_WFS_MIME_FINDMIMETYPE", "发现新Mimetype：" );
define( "_AM_WFS_MIME_EXTFIND", "搜索文件扩展名：<div style='padding-top: 8px;'><span style='font-weight: normal;'>输入您想搜索的文件扩展名。</span></div>" );
define( "_AM_WFS_MIME_INFOTEXT", "<ul><li>新mimetypes可以通过此表方便地被创建，编辑或删除。</li>
	<li>通过外部站点搜索新mimetypes。</li>
	<li>浏览管理员和用户上传mimetypes。</li>
	<li>改变mimetype上传状态。</li></ul>
	" );
// Mimetype Buttons
define( "_AM_WFS_MIME_CREATE", "创建" );
define( "_AM_WFS_MIME_CLEAR", "重设" );
define( "_AM_WFS_MIME_CANCEL", "取消" );
define( "_AM_WFS_MIME_MODIFY", "修改" );
define( "_AM_WFS_MIME_DELETE", "删除" );
define( "_AM_WFS_MIME_FINDIT", "取扩展名！" );
// Mimetype Database
define( "_AM_WFS_MIME_DELETETHIS", "删除选定的Mimetype？" );
define( "_AM_WFS_MIME_MIMEDELETED", "Mimetype %s 已删除" );
define( "_AM_WFS_MIME_CREATED", "Mimetype信息创建" );
define( "_AM_WFS_MIME_MODIFIED", "Mimetype信息修改" );

define( "_AM_WFS_GL_WEIGHTON", "<br />启用综合权重" );
define( "_AM_WFS_GL_WEIGHTOFF", "<br />禁用综合权重" );
define( "_AM_WFS_DOCUMENTTYPES", "有三种不同的文章类型选作您的正文。<br />如果选择了超过一种文章类型，那么将先显示高优先级的。（1 = 最高）" );
define( "_AM_WFS_DOCUMENTTYPE", "<b>文章类型</b>" );
define( "_AM_WFS_BIGUESER", "建议Big5用户ON" );

?>
