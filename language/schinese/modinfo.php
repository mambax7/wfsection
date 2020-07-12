<?php
// $Id: modinfo.php,v 1.4 2004/08/13 12:51:24 phppp Exp $
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
// Translator: Mr Translatro                                                 //
// URL: http://translator.com                                                //
// Email: translator@translator.com                                          //
// ------------------------------------------------------------------------- //
// Module Info

// The name of this module
define("_MI_WFS_NAME", "WF-Section");

// A brief description of this module
define("_MI_WFS_DESC","");

// Names of blocks for this module (Not all module has blocks)
define("_MI_WFS_BNAME","WF-Section最近");
define("_MI_WFS_BNAME_MENU","WF-Section菜单");
define("_MI_WFS_TOPICS","WF-Section主题");
define("_MI_WFS_BNAME3","WF-Section重要文章");
define("_MI_WFS_BNAME4","WF-Section最热文章");
define("_MI_WFS_BNAME5","WF-Section最近");
define("_MI_WFS_BNAME6","WF-Section下载");
define("_MI_WFS_BNAME7","WF-Section作者信息");
define("_MI_WFS_BNAME8","WF-Section焦点");
define('_MI_WFS_BNAME9','WF-Section随机文章');
define("_MI_WFS_BNAME_ARTMENU","WF-Section文章链接");

// Sub menus in main menu block
define("_MI_WFS_SUBMIT","提交文章");
define("_MI_WFS_POPULAR","最受欢迎");
define("_MI_WFS_RATEFILE","最高评分");
define("_MI_WFS_ARCHIVE","归档");
/*
// Names of admin menu items
define("_MI_WFS_ADMENU1","路径管理");
define("_MI_WFS_ADMENU2","索引页管理");
define("_MI_WFS_ADMENU3","类别管理");
define("_MI_WFS_ADMENU4","文章管理");
define("_MI_WFS_ADMENU5","-- 创建新文章");
define("_MI_WFS_ADMENU6","文件管理");
define("_MI_WFS_ADMENU7","列出中断下载");
define("_MI_WFS_ADMENU8","列出提交文章");
define("_MI_WFS_ADMENU9","权重管理");
define("_MI_WFS_ADMENU10","文章下载");
define("_MI_WFS_ADMENU11","路径管理");
// Names of menu items

//Default
*/
define("_MI_WFS_ADMENU1","主索引");
define("_MI_WFS_ADMENU2","创建文章");
define("_MI_WFS_ADMENU3","页面管理");
define("_MI_WFS_ADMENU4","类别管理");
define("_MI_WFS_ADMENU5","权重管理");
define("_MI_WFS_ADMENU6","文章下载");
define("_MI_WFS_ADMENU7","相关文章");
define("_MI_WFS_ADMENU8","相关链接");
define("_MI_WFS_ADMENU9","列出提交文章");
define("_MI_WFS_ADMENU10","列出中断下载");
//define("_MI_WFS_ADMENU11","路径管理");
define("_MI_WFS_ARTICLEINDEXMENU", "文章索引配置：");

//author name
define("_MI_WFS_NAMEDISPLAY","作者名：");
define("_MI_WFS_DISPLAYNAMEDSC", "选择如何显示作者名。");
define("_MI_WFS_DISPLAYNAME1", "用户名");
define("_MI_WFS_DISPLAYNAME2", "真实姓名");
define("_MI_WFS_DISPLAYNAME3", "不显示作者");
//Authour Atavar
define("_MI_WFS_SHOWATAV", "作者头像：");
define("_MI_WFS_SHOWATAVDSC", "选择如何在文章中显示作者头像。");
define("_MI_WFS_DISPLAYATAV1", "作者自己头像");
define("_MI_WFS_DISPLAYATAV2", "显示类别图像");
define("_MI_WFS_DISPLAYATAV3", "不显示图像");
//email address
define("_MI_WFS_USEREMAILDISPLAY","作者Email地址：");
define("_MI_WFS_DISPLAYUSEREMAILDSC", "选择如何显示作者email地址。");
define("_MI_WFS_DISPLAYEMAIL1", "显示");
define("_MI_WFS_DISPLAYEMAIL2", "显示并保护");
define("_MI_WFS_DISPLAYEMAIL3", "不显示");
//displayInfo document listing
define("_MI_WFS_DISPLAYINFOLIST","显示文章列表信息：");
define("_MI_WFS_DISPLAYINFOLISTDSC", "<div>将显示在文章列表中的信息。</div><div style='padding-top: 8px;'>注意：投票信息仅在打开'用户投票'时显示</div>");
//displayInfo document
define("_MI_WFS_DISPLAYINFO","显示文章信息");
define("_MI_WFS_DISPLAYINFODSC", "<div>信息将显示于文章信息框。</div><div style='padding-top: 8px;'>注意：投票信息仅在打开'用户投票'时显示</div>");
//display info lang defines
define("_MI_WFS_DISPLAYINFO1", "文章评论计数");
define("_MI_WFS_DISPLAYINFO2", "文章文件计数");
define("_MI_WFS_DISPLAYINFO3", "文章得分计数");
define("_MI_WFS_DISPLAYINFO4", "文章投票计数");
define("_MI_WFS_DISPLAYINFO5", "文章发布日期");
define("_MI_WFS_DISPLAYINFO6", "文章阅读计数");
define("_MI_WFS_DISPLAYINFO7", "文章大小");
define("_MI_WFS_DISPLAYINFO8", "文章ID");
define("_MI_WFS_DISPLAYINFO9", "文章版本");
//Copyright Notice
define("_MI_WFS_ADDCOPYRIGHT", "版权通知：");
define("_MI_WFS_ADDCOPYRIGHTDSC", "选择在文章页上显示版权通知。");
//Allow User Votes
define("_MI_WFS_SHOWVOTESINART", "允许用户投票：");
define("_MI_WFS_SHOWVOTESINARTDSC", "<div>选择允许用户文章投票。</div><div style='padding-top: 8px;'>如果选项未开启将不显示投票信息。</div>");
//Display Icons
define("_MI_WFS_ICONDISPLAY","最热新文章：");
define("_MI_WFS_DISPLAYICONDSC", "选择如何在文章列表中显示最热和新图标。");
define("_MI_WFS_DISPLAYICON1", "显示为图标");
define("_MI_WFS_DISPLAYICON2", "显示为文字");
define("_MI_WFS_DISPLAYICON3", "不显示");
//Amount od days new and popular
define("_MI_WFS_DAYSNEW","标识为新文章的时间依据：");
define("_MI_WFS_DAYSNEWDSC","被认定为新文章的天数。");
define("_MI_WFS_DAYSUPDATED","标识为更新文章的天数：");
define("_MI_WFS_DAYSUPDATEDDSC","被认定为有更新的文章状态变化天数。");
define("_MI_WFS_POPULARS","文章点击计数：");
define("_MI_WFS_POPULARSDSC","被认定为热点文章的点击次数。");
//Title lenght
define("_MI_WFS_SHORTMENLEN", "主菜单标题长度：");
define("_MI_WFS_SHORTMENLENDSC", "输入菜单项的标题长度。<div style='padding-top: 8px;'>保持原始长度：0  缺省：19 </div>");
define("_MI_WFS_SHORTCATLEN", "类别标题长度：");
define("_MI_WFS_SHORTCATLENDSC", "输入类别标题长度。<div style='padding-top: 8px;'>保持原始长度：0  缺省：19 </div>");
define("_MI_WFS_SHORTARTLEN", "文章标题长度：");
define("_MI_WFS_SHORTARTLENDSC", "输入文章标题长度。<div style='padding-top: 8px;'>保持原始长度：0  缺省：19</div>");
//Images
define("_MI_WFS_SHOWCATPIC", "显示类别图片？");
define("_MI_WFS_SHOWCATPICDSC", "综合：如果设定为'off'将不显示类别图片。");
define("_MI_WFS_DEF_IMAGE", "缺省文章图片：");
define("_MI_WFS_DEF_IMAGEDSC", "未选择文章图片时使用的图片。<div style='padding-top: 8px;'>图片必须上传到WF-Section图片文件夹。</div>");
define("_MI_WFS_DIS_DEF_IMAGE", "显示缺省文章图片：");
define("_MI_WFS_DIS_DEF_IMAGEDSC", "选择如何显示缺省文章图片。");
define("_MI_WFS_DISPLAYDIMAGE1", "仅文章列表");
define("_MI_WFS_DISPLAYDIMAGE2", "仅文章");
define("_MI_WFS_DISPLAYDIMAGE3", "文章列表和文章");
define("_MI_WFS_DISPLAYDIMAGE4", "不显示");
//Thumbs nails
define("_MI_WFS_USETHUMBS", "使用缩略图：");
define("_MI_WFS_USETHUMBSDSC", "支持的文件类型：JPG, GIF, PNG.<br /><br />WF-Section将使用图像缩略图。设为 \'No\' 在服务器不支持本选项时使用原图。");
define("_MI_WFS_QUALITY", "缩略图数量：");
define("_MI_WFS_QUALITYDSC", "质量最低：0 最高：100");
define("_MI_WFS_IMGUPDATE", "更新缩略图？");
define("_MI_WFS_IMGUPDATEDSC", "如果选择的话缩略图将按页更新，否则将使用第一个缩略图。<br /><br />");
define("_MI_WFS_KEEPASPECT", "保持图片相对率？");
define("_MI_WFS_KEEPASPECTDSC", "");
//Sections and document listings and navigation
//define("_MI_WFS_SHOWEMPTYSEC", "空类别：");
//define("_MI_WFS_SHOWEMPTYSECDSC", "设置在主类别索引显示空类别。");
define("_MI_WFS_SHOWSUBMENU", "显示子类别：");
define("_MI_WFS_SHOWSUBMENUDSC", "设置在主类别索引显示子类别。");
//artlistings and description
define("_MI_WFS_SHOWARTLISTINGS", "类别文章列表：");
define("_MI_WFS_SHOWARTLISTINGSDSC", "设置在主类别索引中显示列表描述和文章列表的方式。");
define("_MI_WFS_SHOWARTLISTING1", "仅描述");
define("_MI_WFS_SHOWARTLISTING2", "仅文章列表");
define("_MI_WFS_SHOWARTLISTING3", "显示两者");
define("_MI_WFS_SHOWARTLISTING4", "不显示");
define("_MI_WFS_SHOWARTLISTAMOUNT", "类别索引文章计数：");
define("_MI_WFS_SHOWARTLISTAMOUNTDSC", "显示于主类别索引的文章总数。<div style='padding-top: 8px;'>注意：如果启用了'类别文章列表'文章才会显示。</div>");
define("_MI_WFS_ARTICLESAPAGE", "文章索引列表计数");
define("_MI_WFS_ARTICLESAPAGEDSC", "显示于文章列表的文章数。");
define("_MI_WFS_LASTART", "Admin索引文章计数：");
define("_MI_WFS_LASTARTDSC", "显示于模块管理区的新文章数。");
define("_MI_WFS_SHOWORDERBOX", "文章顺序框：");
define("_MI_WFS_SHOWORDERBOXDSC", "允许用户通过xoops顺序框改变文章顺序。");
define("_MI_WFS_PATHTYPE", "导航框：");
define("_MI_WFS_PATHTYPEDSC", "选择文章索引列表的导航类型。");
define("_MI_WFS_SECTIONSORT", "缺省类别顺序：");
define("_MI_WFS_SECTIONSORTDSC", "选择类别索引列表的缺省顺序。");
define("_MI_WFS_ARTICLESSORT", "缺省文章顺序：");
define("_MI_WFS_ARTICLESSORTDSC", "选择文章索引列表的缺省顺序。");
define("_MI_WFS_TITLE", "标题");
define("_MI_WFS_RATING", "得分");
define("_MI_WFS_WEIGHT", "权重");
define("_MI_WFS_POPULARITY", "点击率");
define("_MI_WFS_SUBMITTED2", "提交日");
define("_MI_WFS_SELECTBOX", "选择框");
define("_MI_WFS_SELECTSUBS", "带子类别的选择框");
define("_MI_WFS_LINKEDPATH", "链接路径");
define("_MI_WFS_LINKSANDSELECT", "链接和选择框");
define("_MI_WFS_NONE", "None");
define("_MI_WFS_AUTOWEIGHT", "自动权重：");
define("_MI_WFS_AUTOWEIGHTDSC", "保存时为类别和文章使用自动权重。");
define("_MI_WFS_AUTOSUMMARY", "自动概要：（综合）");
define("_MI_WFS_AUTOSUMMARYDSC", "为文章使用自动概要。仅适用于没有概要的文章。");
define("_MI_WFS_NAMESUMTYPE", "自动概要类型：");
define("_MI_WFS_NAMESUMTYPEDSC", "选择自动概要的方式类型。<div style='padding-top: 8px;'><b>Word计数：</b>这种方式将在使用自动概要特色时计算到最近段落止的字数。</div>
<div style='padding-top: 8px;'><b>字符计数：</b>这种方式将计算自动概要中的字符数。</div>");
define("_MI_WFS_NAMESUMTYPE1", "自动字计数");
define("_MI_WFS_NAMESUMTYPE2", "自动字符计数");
define("_MI_WFS_NAMESUMAMOUNT", "自动概要总数：");
define("_MI_WFS_NAMESUMAMOUNTDSC", "<div style='padding-top: 8px;'>字计数缺省：<b>50</b></div>
<div style='padding-top: 8px;'>字符计数缺省：<b>250</b></div>");
define("_MI_WFS_WIKI", "Wiki:");
define("_MI_WFS_WIKIDSC", "设置允许在文章中使用wiki。");
define("_MI_WFS_PHPCODING", "PHP 代码：");
define("_MI_WFS_PHPCODINGDSC", "设置允许在文中显示PHP码。<div style='padding-top: 8px;'>用[php][/php]标签包含的文本显示为代码。</div>");
define("_MI_WFS_VERSIONINC", "文章版本递增：");
define("_MI_WFS_VERSIONINCDSC", "文章版本将在保存时增长。");
define("_MI_WFS_USERESTORE", "文章恢复：");
define("_MI_WFS_USERESTOREDSC", "此特色将允许之后必要时恢复修改过的文章。<br /><br />Using this feature <b>will</b> increase the size of the MySQL database dramatically and older restore points should be removed at regular perodic intervals.");
define("_MI_WFS_DEFAULTTIME", "Timestamp:");
define("_MI_WFS_DEFAULTTIMEDSC", "WF-Section的缺省Timestamp：");
//submission document and files
define("_MI_WFS_GROUPSUBMITART", "文章提交：");
define("_MI_WFS_GROUPSUBMITARTDSC", "选择能提交新文章的群组。");
define("_MI_WFS_ANONPOST", "匿名文章提交?");
define("_MI_WFS_ANONPOSTDSC", "选择允许匿名用户投递新文章。");
define("_MI_WFS_AUTOAPPROVE", "自动核定提交文章：");
define("_MI_WFS_AUTOAPPROVEDSC", "选择无需审核自动通过提交文章。");
define("_MI_WFS_NOTIFYSUBMIT", "站长提交邮件：");
define("_MI_WFS_NOTIFYSUBMITDSC", "有文章提交时发送邮件给站长。");
define("_MI_WFS_WYSIWYG", "Spaw WYSIWYG 编辑器：（管理端）");
define("_MI_WFS_WYSIWYGDSC", "选择允许管理员在提交文章时使用Spaw编辑器而不是Xoops缺省编辑器？");
define("_MI_WFS_USERWYSIWYG", "Spaw WYSIWYG编辑器：（用户端）");
define("_MI_WFS_USERWYSIWYGDSC", "选择允许用户在提交文章时使用Spaw编辑器而不是Xoops缺省编辑器？");
define("_MI_WFS_GROUPUSERWYSIWYG", "选择有权访问Spaw编辑器的用户组：");
define("_MI_WFS_USEHTMLAREA", "HTMLtextarea页脚：");
define("_MI_WFS_USEHTMLAREADSC", "选择在页管理和类别管理中使用XoopsFormDhtmlTextArea而不是XoopsFormTextArea。<div style='padding-top: 8px;'>如果发现使用本选项您的浏览器崩溃时设为'No'。</div>");
//uploads
define("_MI_WFS_SUBMITFILES", "文件提交：");
define("_MI_WFS_SUBMITFILESDSC", "选择能提交新文件的群组。");
define("_MI_WFS_ALLOWEDMIMETYPES", "允许的管理员Mimetypes：");
define("_MI_WFS_ALLOWEDMIMETYPESDSC", "选择管理员能上传的mimetypes。");
define("_MI_WFS_ALLOWEDUSERMIME", "允许的用户Mimetypes：");
define("_MI_WFS_ALLOWEDUSERMIMEDSC", "选择用户能上传的mimetypes");
define("_MI_WFS_ADMINMIMECHECK", "对于上传的Mimetypes不进行管理员检查：");
define("_MI_WFS_NOUPLOADFILESIZE", "对于上传的文件大小不进行管理员检查：");
define("_MI_WFS_NOUPIMGSIZE", "对于上传的文件宽/高不进行管理员检查：");
define("_MI_WFS_UPLOADFILESIZE", "最大上传文件大小（KB） 1048576 = 1 Meg");
define("_MI_WFS_IMGHEIGHT", "最大上传图像高度");
define("_MI_WFS_IMGWIDTH", "最大上传图像宽度");
define("_MI_WFS_FILEMODE", "CHMOD文件：");
define("_MI_WFS_FILEPREFIX", "增加前缀：");
define("_MI_WFS_ADDEXT", "扩展名：");
define("_MI_WFS_BANNEDCHARS", "文件名筛选器类型：");
define("_MI_WFS_BANNEDCHARSDSC", "上传文件时使用。");
define("_MI_WFS_STRIPCHARS", "拨离文件名中的字符？");
define("_MI_WFS_STRICT","严格（仅字母和数字）");
define("_MI_WFS_MEDIUM","中等要求");
define("_MI_WFS_LIGHT","低要求（推荐用于多字节字符）");
define("_MI_WFS_STRIPSPACES", "从文件名中剥离空格：");
define("_MI_WFS_CHECKSESSION","Checkin Session时间");
define("_MI_WFS_CHECKSESSIONDSC","Session checkin持续时间[minutes, 0 for non-check]");
define("_MI_WFS_BY","开发人：");
define('_MI_WFS_AUTHOR_INFO', "开发者信息");
define('_MI_WFS_AUTHOR_NAME', "开发者");
define('_MI_WFS_AUTHOR_DEVTEAM', "开发者团队");
define('_MI_WFS_AUTHOR_WEBSITE', "开发者站点");
define('_MI_WFS_AUTHOR_EMAIL', "开发者邮件");
define('_MI_WFS_AUTHOR_CREDITS', "Credits");
define('_MI_WFS_MODULE_INFO', "模块开发信息");
define('_MI_WFS_MODULE_STATUS', "开发状态");
define('_MI_WFS_MODULE_DEMO', "演示站点");
define('_MI_WFS_MODULE_SUPPORT', "官方支持站点");
define('_MI_WFS_MODULE_BUG', "报告一个模块bug");
define('_MI_WFS_MODULE_FEATURE', "建议一个模块特色");
define('_MI_WFS_MODULE_DISCLAIMER', "Disclaimer");
define('_MI_WFS_AUTHOR_WORD', "作者的话");
define('_MI_WFS_RELEASE', "发布日：");
define('_MI_WFS_MODULE_MAILLIST', "WF-Section邮件列表");
define('_MI_WFS_MODULE_MAILANNOUNCEMENTS', "申明邮件列表");
define('_MI_WFS_MODULE_MAILBUGS', "Bug邮件列表");
define('_MI_WFS_MODULE_MAILFEATURES', "特色邮件列表");
define('_MI_WFS_MODULE_MAILANNOUNCEMENTSDSC', "从Zarili.com获取最近申明。");
define('_MI_WFS_MODULE_MAILBUGSDSC', "Bug跟踪和提交邮件列表");
define('_MI_WFS_MODULE_MAILFEATURESDSC', "请求新特色邮件列表。");
define('_MI_WFS_WARNINGTEXT', "THE SOFTWARE IS PROVIDED BY ZARILIA CMS \"AS IS\" AND \"WITH ALL FAULTS.\" ZARILIA CMS MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND CONCERNING THE QUALITY, SAFETY OR SUITABILITY OF THE SOFTWARE, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT. FURTHER, ABLEMEDIA MAKES NO REPRESENTATIONS OR WARRANTIES AS TO THE TRUTH, ACCURACY OR COMPLETENESS OF ANY STATEMENTS, INFORMATION OR MATERIALS CONCERNING THE SOFTWARE THAT IS CONTAINED IN WF-SECTIONS WEBSITE. IN NO EVENT WILL ABLEMEDIA BE LIABLE FOR ANY INDIRECT, PUNITIVE, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES HOWEVER THEY MAY ARISE AND EVEN IF WF-SECTIONS HAS BEEN PREVIOUSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.");
define('_MI_WFS_AUTHOR_CREDITSTEXT',"I would like to thank the following people for their help and support during the development phase of this module:<br /><br />
tom, mking, paco1969, mharoun, Talis, m0nty, steenlnielsen, Clubby, Geronimo, bd_csmc, herko, LANG, Stewdio, tedsmith, veggieryan, carnuke, MadFish.
<br /><br />Personally I would like to thank those guys from Xoops China Community, like JFYuan (AKA lab) for helping bug mining and language translation.
");
define('_MI_WFS_AUTHOR_BUGFIXES', "Bug修正历史");

define('_MI_WFS_SELECTFORUM', "选择论坛：");
define('_MI_WFS_SELECTFORUMDSC', "选择您已安装将被WF-Sections使用的论坛。");
define('_MI_WFS_DISPLAYFORUM1', "Newbb （所有）");
define('_MI_WFS_DISPLAYFORUM2', "IPB论坛");
//define('_MI_WFS_DISPLAYFORUM3', "NewBB");

define("_MI_WFS_USERAMOUNT","用户总数显示：");
define("_MI_WFS_USERAMOUNTDSC", "如果您的服务器在显示大量用户出现问题时改变此选项。<br /><br />");

?>