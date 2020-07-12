<?php
// $Id: main.php,v 1.5 2004/08/13 12:51:24 phppp Exp $
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

//define("_WFS_NOTITLESET","未设标题");
//define("_WFS_POST","投递");
//define("_WFS_MAINTEXT","文章文字");
//define("_WFS_DISAMILEY","禁用Smilie");
//define("_WFS_DISHTML","禁用HTML");
//define("_WFS_ATTACHEDFILESTXT","<b>文件上传</b><br/><br />这将显示一个附加到当前文章的文件列表。您可以通过单击编辑链接来编辑每个附件。<br /><br />在您编辑一个已保存的文章时才能增加附件。");
//define("_WFS_DOWNLOAD","上传附件");
//define("_WFS_FILEATTACHED","附加文件到文章？");
define("_WFS_NODESCRIPT","没有文件描述。");
define("_WFS_UPLOADED","上传：");
define("_WFS_FILEMIMETYPE","文件Mimetype");
//define("_WFS_ON","On");
//define("_WFS_CAUTH","<b>作者姓名</b> （若为空则使用原作者名）");
//define("_WFS_AFTERREGED","文件不能附加到一个空文章。<br />请创建一篇文章，保存然后再上传附件。");
//define("_WFS_EXT","扩展名：");
//define("_WFS_MIMETYPE","Mime类型：");
//define("_WFS_UPDATEDATE","上次修改：");
//define("_WFS_LINK","链接");
//define("_WFS_DOWNLOADNAME","下载名：");
//define("_WFS_MAININDEX","主索引");
//define("_WFS_LINKURL","链接URL");
//define("_WFS_LINKURLNAME","以上URL的名称");
//define("_WFS_IMGADD","增加");
//define("_WFS_DOWNLOADNAMEDESCRIPT","文件描述");
//define("_WFS_RATETHISFILE","给此文打分");

define("_WFS_INTROTEXT","介绍文字：");
define("_WFS_GAMEPLAYTEXT","Gameplay:");
define("_WFS_GRAPHICSTEXT","图片：");
define("_WFS_MUSICTEXT","音乐：");
define("_WFS_FINALTEXT","Final Thoughts:");
define("_WFS_GRADE","等级：");
define("_WFS_PUBLISHER","发布者：");
define("_WFS_DEVELOPER","开发者：");
define("_WFS_WEBSITE","官方站点：");
define("_WFS_DIFFICULTY","难点：");
define("_WFS_RELEASED","发布日：");
define("_WFS_GENRE","流派：");
define("_WFS_PLAYERS","玩家：");
define("_WFS_PLAYONLINE","在线玩：");
define("_WFS_ESRB","ESRB得分：");
define("_WFS_LEARNINGCURVE","学习曲线：");
define("_WFS_GRAPHICS","图像：");
define("_WFS_SOUND","音响：");
define("_WFS_GAMEPLAY","Gameplay:");
define("_WFS_CONCEPT","概念：");
define("_WFS_VALUE","值：");
define("_WFS_TILT","编者Tilt：");
define("_WFS_PLATFORM","平台：");
define("_WFS_OVERALL","总分：");
define("_WFS_CONCLUSION","结论：");

 
//define("_WFS_PUBLISHDATE","Page Publish Date:");
//define("_WFS_EXPIREDATESET", " Expire date set: ");
//define("_WFS_EXPIREDATE","Page Expire Date:");
//define("_WFS_CLEARPUBLISHDATE","<br /><br />Remove Publish date:");
//define("_WFS_CLEAREXPIREDATE","<br /><br />Remove Expire date:");
//define("_WFS_PUBLISHDATESET"," Publish date set: ");
//define("_WFS_SETDATETIMEPUBLISH"," Set the date/time of publish");
//define("_WFS_SETDATETIMEEXPIRE"," Set the date/time of expire");
//define("_WFS_SETPUBLISHDATE","<b>Set Publish Date: </b>");
//define("_WFS_SETEXPIREDATE","<b>Set Expire Date: </b>");
//define("_WFS_EXPIREWARNING","<br />WARNING: Expire date set before publish date! ");
//define('_WFS_EDITAUTOSUMMARY', 'Auto Document Summary:');
//define('_WFS_EDITSUMMARYAMOUNT', 'Auto Summary lenght:');
//define("_WFS_EDITLINKURL", "Linked URL:<br /><br /><span style='font-weight: normal;'>Displays a link to another website/page in Document listing.</span>");
//define("_WFS_EDITLINKURLNAME", "Friendly Linked URL Name:");
//define("_WFS_EDITDISXCODES", "Disable XCodes: ");
//define('_WFS_EDITDISIMAGES', 'Disable Images:');
//define('_WFS_EDITDISBREAKS', 'Xoops linebreak conversion:');
//define("_WFS_RESET","Reset");

define("_WFS_ISNEW", "新");
define("_WFS_ISUPDATED", "更新");

define("_WFS_CANCEL","取消");
define("_WFS_TOP","最");
define("_WFS_YES","Yes");
define("_WFS_NO","No");
define("_WFS_SAVE", "保存");
define("_WFS_SUBMIT","提交");
define("_WFS_SUBMITBROKEN", "提交中断");
define("_WFS_PRINTERFRIENDLY","适于打印页");
define("_WFS_NOTIFYPUBLISH","发表时邮件通知");
define("_WFS_NOSTORY","对不起，本文未存放于站点。");
define("_WFS_URL","URL：");
define("_WFS_RETURN2INDEX","返回主索引");
define("_WFS_BACK2CAT","返回类别");
define("_WFS_BACK2","返回");
define("_WFS_PART","部分：");
define("_WFS_TELLAFRIEND","转告朋友");
define("_WFS_PUBLISHED","最近文章");
define("_WFS_TITLE","标题");
define("_WFS_HOMEPAGEC", "主页：");
define("_WFS_CATEGORY","类别");
define("_WFS_ARTICLES","文章");
define("_WFS_AUTHER","作者："); 
define("_WFS_VIEWS","阅读："); 
define("_WFS_TIMES","次数"); 
define("_WFS_DATE","日期：");
define("_WFS_NUMVOTES","投票：");
define("_WFS_FILESIZE","文件大小：");
define("_WFS_VERSION","版本：");
define("_WFS_FILES","文件：");
define("_WFS_TOPICC","类别：");
define("_WFS_ARTICLE","文章");
define("_WFS_AUTH","作者");
define("_WFS_LASTUPDATE","更新");
define("_WFS_EDITDISCUSSINFORUM", "对本文增加'论坛讨论'？");
define("_WFS_BROKENREPORT", "报告中断资源");
define("_WFS_BEFORESUBMIT", "再提交一个中断资源前，请检查您报告的断链的文件的实际来源并且确认站点没有关闭。");
define("_WFS_SUBMITDATE", "发布");
define("_MD_REPORTBROKEN", "报告");
define("_WFS_NOFILE","本文没有附件。");
define("_WFS_CATEGORYDESC","描述");
define("_WFS_FILEID","文件ID：");
define("_WFS_FILEREALNAME","存储名：");
define("_WFS_ARTICLEID","文章ID：");
define("_WFS_OTHERARTICLES","其它文章");
define("_WFS_PAGES","页面");
define("_WFS_RELATEDARTS", "相关文章");
define("_WFS_RELATEDNEWS", "相关新闻");
define("_WFS_INFORUMS", "再论坛中讨论%s");
define("_WFS_UPLOAD","上传");
define("_WFS_SUMMARY","概要");
define("_WFS_VOTEAPPRE","期待您的投票。");
define("_WFS_THANKYOU","谢谢您花时间在%s投票"); 
define("_WFS_VOTEONCE","请不要对同一资源投两次票。");
define("_WFS_RATINGSCALE","分值是1 - 10，1最差10最好。");
define("_WFS_BEOBJECTIVE","请保持客观公正，如果所有的投票都是非１即10，那么比分就没有实际价值了。");
define("_WFS_DONOTVOTE","不要给自己投票。");
define("_WFS_RATEIT","打分！");
define("_WFS_NORATING","未选择分数。");
define("_WFS_ONLYREGISTEREDUSERS","只有注册用户能报告下载断链！");
define("_WFS_THANKSFORHELP","感谢您协助维护文章的完整性。");
define("_WFS_THANKSFORINFO","信息此信息。我们将很快处理您的请求。");
define("_WFS_THANKS","感谢您的提交。");
define("_WFS_THANKS_APPROVE","感谢您的提交。站长将很快处理。");
define("_WFS_ALREADYREPORTED","您已经提交过一份此资源的中断报告。");
define("_WFS_CANTVOTEOWN","您不能对你提交的资源投票。<br>所有投票被记录和分析。");
define("_WFS_RANK","排行");
define("_WFS_HITS","点击"); 
define("_WFS_HITS2","按点击率列出文章"); 
define("_WFS_RATING","得分");
define("_WFS_RATING2","按得分列出文章");
define("_WFS_AUTH2","按作者列出文章");
define("_WFS_VOTE","投票");
define("_WFS_TOP10","%s Top 10"); 
define("_WFS_FORSECURITY","出于安全考虑，您的姓名和IP地址将被临时记录。");
define("_WFS_NUMBYTES","%s 字节");
define("_WFS_DOWNLOADS","下载for ");
define("_WFS_FILETYPE","文件类型：");
define("_WFS_GROUPPROMPT","允许访问以下组：");
define("_WFS_REPORTBROKEN","报告中断文件");
define("_WFS_POSTNEWARTICLE","提交文章");
define("_WFS_POPULAR","最受欢迎");
define("_WFS_RATEFILE","打分");
define("_WFS_COMMENT","评论Comments:");
define("_WFS_RATED","得分：");
define("_WFS_SUBMIT1","提交");
define("_WFS_VOTES","投票：");
define("_WFS_SORTBY1","排序：");
define("_WFS_TITLE1","标题：");
define("_WFS_DATE1","日期");
define("_WFS_POPULARITYLTOM","受欢迎度（从低到高）");
define("_WFS_POPULARITYMTOL","受欢迎度（从高到低）");
define("_WFS_ARTICLEIDLTOM","文章ID（1到9）");
define("_WFS_ARTICLEIDMTOL","文章ID（9到1）");
define("_WFS_TITLEZTOA","标题（Z到A）");
define("_WFS_TITLEATOZ","标题（Z到A）");
define("_WFS_DATEOLD","日期（先发表在前）");
define("_WFS_DATENEW","日期（新发表在前）");
define("_WFS_RATINGLTOH","得分（从低到高）");
define("_WFS_RATINGHTOL","得分（从高到低）");
define("_WFS_SUBMITLTOH","提交（先提交在前）");
define("_WFS_SUBMITHTOL","提交（新提交在前）");
define("_WFS_WEIGHT","权重");
define("_WFS_ARTICLEID1","文章ID");
define("_WFS_POPULARITY1","受欢迎度");
define("_WFS_CURSORTBY1","文章当前排序：");
define("_WFS_RATING1","得分");
define("_WFS_HTMLPAGE","HTML文件</b>（这会跳过文本编辑器）");
define("_WFS_INTFILEAT","到 %s阅读此文");
define("_WFS_INTFILEFOUND","这里是我在%s读到得一篇文章");
define("_WFS_DESCRIPTION","文件描述");
define("_WFS_ARTICLELINK","文章URL链接");
define("_WFS_MISCSETTINGS","其它文章设置");

define("_WFS_PUBLISHEDHOME","发表：");
define("_WFS_ARTSIZE","文章大小：");
define("_WFS_FILEPERMISSION","文件权限：");
define("_WFS_DOWNLOADED","下载：");
define("_WFS_DOWNLOADSIZE","下载大小：");
define("_WFS_LASTACCESS","上次访问时间：");
define("_WFS_LASTUPDATED","上次修改于：");
define("_WFS_ERRORCHECK","文件校验：");
define("_WFS_NOPERM","您无权向本站提交文章！");
define("_WFS_SELECTSUBSECTION","选择类别");
define("_WFS_READMORE","阅读全文....");
define("_WFS_LISTARTICLES","列出所有文章");

//Attached Files
define("_WFS_FEATUREDARTS", "特色：");
define("_WFS_SECTIONLISTIN", "类别列表：");
define("_WFS_CATNOTEXIST", "此类别不存在！");
define("_WFS_CATNOPERM", "您无权访问此类别！");
//Submission
define("_WFS_EDITSECTION", "创建于类别：");
define("_WFS_CREATEARTICLE", "创建新文章");
define("_WFS_EDITNEWARTTITLE","新文章标题");
define("_WFS_MOVETOART", "移到新文章：（空：不改变）");
define("_WFS_IN", "显示于类别：");
define("_WFS_EDITSECTION2", "移到类别：");
define('_WFS_EDITARTICLETITLE', '文章标题：');
define("_WFS_EDITSUMMARY", "文章概要：");
define("_WFS_OTHEROPTIONS", "文章选项：");
define("_WFS_EDITSUBTITLE","文章子标题：");
define("_WFS_EDITLINKURL", "链接文章：<div style='padding-top: 8px;'><span style='font-weight: normal;'>在文章列表中显示一个到其它站点/页面的链接。</span></div>");
define("_WFS_EDITLINKURLADD", "URL地址：<br />");
define("_WFS_EDITLINKURLNAME", "URL名：<br />");
define("_WFS_EDITMAINTEXT", "编辑文章正文：");
define("_WFS_EDITDISCODES", "禁用XOOPS Codes");
define("_WFS_EDITDISAMILEY", "禁用Smilie Icons");
define("_WFS_EDITDISHTML", " 禁用HTML标签");
define("_WFS_MODIFYARTICLE", "修改文章：");
define("_WFS_NODETAILSRECORDED", "没有明细记录");
define("_WFS_CREATEDBY", "原作者：");
define("_WFS_LASTEDITBY", "最近编辑于：");
define("_WFS_CREATEDON", "创建于：");
define("_WFS_EDITEDON", "编辑于：");
define("_WFS_MOVETO", "移到类别：");
define("_WFS_MODIFY", "修改");
define("_WFS_DELETE", "删除");

//Files
define("_WFS_FILES_CREATE","创建下载");
define("_WFS_FILES_UPLOAD","上传文件：");
define("_WFS_FILES_TITLE", "下载标题：");
define("_WFS_FILES_DESCRIPT","下载描述：");
define("_WFS_FILES_SEARCHTEXT","下载搜索文本：");
define("_WFS_FILES_ATTACHED","文章下载：");
define("_WFS_FILES_DELETE_SELECTED","删除选定下载：");
//define("_WFS_FILESHOWNAME","Displayed/Psuedo Name:");

//constants added by frankblack
define("_WFS_REPBROKDOWN","报告中断下载");
define("_WFS_URLFORSTORY","本文的URL是：");
define("_WFS_THISCOMESFROM","本文来自%s");

define("_WFS_WEBMASTERACKNOW", "获取中断报告：");
define("_WFS_WEBMASTERCONFIRM", "中断报告确认：");
define("_WFS_RESOURCEID", "资源id#: ");
define("_WFS_REPORTER", "原报告人：");
define("_WFS_DATEREPORTED", "报告日期：");
define("_WFS_RESOURCEREPORTED", "报告中断的资源");
define("_WFS_THANKSFORREPORTING", "感谢您费心报告中断资源，不过我们已了解这一情况并在修正处理中。");
define("_WFS_THISFILEDOESNOTEXIST", "错误：文件不存在！");
define("_WFS_NEWSARCHIVES","文章归档");
define("_WFS_ACTIONS","操作");
define("_WFS_THEREAREINTOTAL","总共有 %s 文章");
define("_WFS_SENDSTORY","发送此文给朋友");
define("_WFS_INTARTICLE","%s的值得一读的文章");
define("_WFS_INTARTFOUND","这是我在%s看到的一篇值得一读的文章");
define("_WFS_COPYRIGHT","copyright");
define("_WFS_ERROR","保存到数据库时出错");
define("_WFS_NOTIFYSBJCT","我站点的文章"); // Notification mail subject
define("_WFS_NOTIFYMSG","嗨！网站有一个新网站提交。"); // Notification mail message
define("_WFS_VISIT","访问站点：");
define("_WFS_RELATEDLINKS","相关链接");
//define("_AM_WFS_NOTPUBLISHED", "未发布");
define("_WFS_SPONSER", "赞助");
define("_WFS_UPDATE1","欢迎使用WF-Sections升级脚本");
define("_WFS_UPDATE2","本脚本将从0.61以上版升级WF-Sections。");
define("_WFS_UPDATE3","在升级Wf-Sections前，确保您：");
define("_WFS_UPDATE4","往服务器上上传了所有WF-Sections安装文件包！");
define("_WFS_UPDATE5","创建一个数据库备份。很重要！！");
define("_WFS_UPDATE6","按下按钮开始升级过程。"); 
define("_WFS_UPDATE7","跳过改变表");
define("_WFS_UPDATE8","，数据库中没有此字段。");
define("_WFS_UPDATE9","跳过！创建表");
define("_WFS_UPDATE10","，它已存在。"); 
define("_WFS_UPDATE11","数据库");
define("_WFS_UPDATE12","创建。");
define("_WFS_UPDATE13","数据库修改 - ");
define("_WFS_UPDATE14","删除"); 
define("_WFS_UPDATE15","字段不存在无需删除。");
define("_WFS_UPDATE16","最近。");
define("_WFS_UPDATE17","创建并插入字段"); 
define("_WFS_UPDATE18","跳过！表");
define("_WFS_UPDATE19","不存在不需要删除。");
define("_WFS_UPDATE20"," 找到并删除");
define("_WFS_UPDATE21","修改。");
define("_WFS_UPDATE22","您的数据库有更新。 <br />有问题吗？ 请联系 <br><h4><a href='http://www.wf-projects.com'>WF-Sections website</a></h4>的支持团队</span></p>");
define("_WFS_UPDATE23","完成更新");  

define("_WFS_ROOT_CATEGORY","根类别");
define("_WFS_NO_FORUM","未选择论坛");
define("_WFS_CHECKIN_FAILED","Check in失败");
define("_WFS_SHOWARTAMOUNT","当前文章：%s - %s 总计文章：%s");
?>
