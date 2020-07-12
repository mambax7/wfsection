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
define("_MI_WFS_BNAME","WF-Section Recent");
define("_MI_WFS_BNAME_MENU","WF-Section Menu");
define("_MI_WFS_TOPICS","WF-Section Topics");
define("_MI_WFS_BNAME3","WF-Section Big Article");
define("_MI_WFS_BNAME4","WF-Section Top");
define("_MI_WFS_BNAME5","WF-Section Recent");
define("_MI_WFS_BNAME6","WF-Section downloads");
define("_MI_WFS_BNAME7","WF-Section Author Info");
define("_MI_WFS_BNAME8","WF-Section Spotlight");
define('_MI_WFS_BNAME9','WF-Section Random Articles');
define("_MI_WFS_BNAME_ARTMENU","WF-Section Article Links");

// Sub menus in main menu block
define("_MI_WFS_SUBMIT","Submit Article");
define("_MI_WFS_POPULAR","Popular");
define("_MI_WFS_RATEFILE","Rated");
define("_MI_WFS_ARCHIVE","Archives");
/*
// Names of admin menu items
define("_MI_WFS_ADMENU1","Path Management");
define("_MI_WFS_ADMENU2","Index Page Management");
define("_MI_WFS_ADMENU3","Section Management");
define("_MI_WFS_ADMENU4","Article Management");
define("_MI_WFS_ADMENU5","-- Create New Article");
define("_MI_WFS_ADMENU6","File Management");
define("_MI_WFS_ADMENU7","List Broken downloads");
define("_MI_WFS_ADMENU8","List Submitted Articles");
define("_MI_WFS_ADMENU9","Weight Management");
define("_MI_WFS_ADMENU10","Article Downloads");
define("_MI_WFS_ADMENU11","Path Management");
// Names of menu items

//Default
*/
define("_MI_WFS_ADMENU1","Main Index");
define("_MI_WFS_ADMENU2","Create Document");
define("_MI_WFS_ADMENU3","Page Management");
define("_MI_WFS_ADMENU4","Section Management");
define("_MI_WFS_ADMENU5","Weight Management");
define("_MI_WFS_ADMENU6","Document Downloads");
define("_MI_WFS_ADMENU7","Related Documents");
define("_MI_WFS_ADMENU8","Related Links");
define("_MI_WFS_ADMENU9","List submitted articles");
define("_MI_WFS_ADMENU10","List broken downloads");
//define("_MI_WFS_ADMENU11","Path Management");
define("_MI_WFS_ARTICLEINDEXMENU", "Article Index Config:");

//author name
define("_MI_WFS_NAMEDISPLAY","Author's Name:");
define("_MI_WFS_DISPLAYNAMEDSC", "Select how to display the author's name.");
define("_MI_WFS_DISPLAYNAME1", "Username");
define("_MI_WFS_DISPLAYNAME2", "Real Name");
define("_MI_WFS_DISPLAYNAME3", "Do not display author");
//Authour Atavar
define("_MI_WFS_SHOWATAV", "Authors Atavar:");
define("_MI_WFS_SHOWATAVDSC", "Select how to display the author's Atavar in Document.");
define("_MI_WFS_DISPLAYATAV1", "Authors own Atavar");
define("_MI_WFS_DISPLAYATAV2", "Display Section Image");
define("_MI_WFS_DISPLAYATAV3", "Display no image");
//email address
define("_MI_WFS_USEREMAILDISPLAY","Author's Email Address:");
define("_MI_WFS_DISPLAYUSEREMAILDSC", "Select how to display the author's email address.");
define("_MI_WFS_DISPLAYEMAIL1", "Display");
define("_MI_WFS_DISPLAYEMAIL2", "Display and Protect");
define("_MI_WFS_DISPLAYEMAIL3", "Do Not Display");
//displayInfo document listing
define("_MI_WFS_DISPLAYINFOLIST","Display Document Listing Info:");
define("_MI_WFS_DISPLAYINFOLISTDSC", "<div>Information that will be displayed in document listing.</div><div style='padding-top: 8px;'>NB: Vote information will only be displayed if 'User Votes' is enabled</div>");
//displayInfo document
define("_MI_WFS_DISPLAYINFO","Display Document Info:");
define("_MI_WFS_DISPLAYINFODSC", "<div>Information that will be displayed in the document info box.</div><div style='padding-top: 8px;'>NB: Vote information will only be displayed if 'User Votes' is enabled</div>");
//display info lang defines
define("_MI_WFS_DISPLAYINFO1", "Document Comment Count");
define("_MI_WFS_DISPLAYINFO2", "Document File Count");
define("_MI_WFS_DISPLAYINFO3", "Document Rated Count");
define("_MI_WFS_DISPLAYINFO4", "Document Vote Count");
define("_MI_WFS_DISPLAYINFO5", "Document Published Date");
define("_MI_WFS_DISPLAYINFO6", "Document Read Count");
define("_MI_WFS_DISPLAYINFO7", "Document Size");
define("_MI_WFS_DISPLAYINFO8", "Document ID");
define("_MI_WFS_DISPLAYINFO9", "Document Version");
//Copyright Notice
define("_MI_WFS_ADDCOPYRIGHT", "Copyright Notice:");
define("_MI_WFS_ADDCOPYRIGHTDSC", "Select to display a copyright notice on document page.");
//Allow User Votes
define("_MI_WFS_SHOWVOTESINART", "Enable User Votes:");
define("_MI_WFS_SHOWVOTESINARTDSC", "<div>Select to allow user document voting.</div><div style='padding-top: 8px;'>Vote information will not be displayed if this option is not enabled.</div>");
//Display Icons
define("_MI_WFS_ICONDISPLAY","Document Popular and New:");
define("_MI_WFS_DISPLAYICONDSC", "Select how to display the popular and new icons in document listing.");
define("_MI_WFS_DISPLAYICON1", "Display As Icons");
define("_MI_WFS_DISPLAYICON2", "Display As Text");
define("_MI_WFS_DISPLAYICON3", "Do Not Display");
//Amount od days new and popular
define("_MI_WFS_DAYSNEW","Document Days New:");
define("_MI_WFS_DAYSNEWDSC","The number of days a document status will be considered as new.");
define("_MI_WFS_DAYSUPDATED","Document Days Updated:");
define("_MI_WFS_DAYSUPDATEDDSC","The amount of days a document status will be considered as updated.");
define("_MI_WFS_POPULARS","Document Popular Count:");
define("_MI_WFS_POPULARSDSC","The number of hits before a document status will be considered as popular.");
//Title lenght
define("_MI_WFS_SHORTMENLEN", "MainMenu Title Length:");
define("_MI_WFS_SHORTMENLENDSC", "Enter title length of items added to the mainmenu. <div style='padding-top: 8px;'>Keep original length: 0  Default: 19 </div>");
define("_MI_WFS_SHORTCATLEN", "Section Title Length:");
define("_MI_WFS_SHORTCATLENDSC", "Enter title length of Section items. <div style='padding-top: 8px;'>Keep original length: 0  Default: 19 </div>");
define("_MI_WFS_SHORTARTLEN", "Document Title Length:");
define("_MI_WFS_SHORTARTLENDSC", "Enter title length of Document items. <div style='padding-top: 8px;'>Keep original length: 0  Default: 19 </div>");
//Images
define("_MI_WFS_SHOWCATPIC", "Display Section Images?");
define("_MI_WFS_SHOWCATPICDSC", "Global: If set as 'off' no Section images will be displayed.");
define("_MI_WFS_DEF_IMAGE", "Default Document Image:");
define("_MI_WFS_DEF_IMAGEDSC", "Image to be used if document has no image selected.<div style='padding-top: 8px;'>Image must be upload to WF-Section image folder.</div>");
define("_MI_WFS_DIS_DEF_IMAGE", "Display Default Document Image?");
define("_MI_WFS_DIS_DEF_IMAGEDSC", "Select how to display default document image.");
define("_MI_WFS_DISPLAYDIMAGE1", "Document listing only");
define("_MI_WFS_DISPLAYDIMAGE2", "Document only");
define("_MI_WFS_DISPLAYDIMAGE3", "Document listing and Document");
define("_MI_WFS_DISPLAYDIMAGE4", "Do not display");
//Thumbs nails
define("_MI_WFS_USETHUMBS", "Use Thumb Nails:");
define("_MI_WFS_USETHUMBSDSC", "Supported file types: JPG, GIF, PNG.<br /><br />WF-Section will use thumb nails for images. Set to \'No\' to use orginal image if the server does not support this option.");
define("_MI_WFS_QUALITY", "Thumb Nail Quality: ");
define("_MI_WFS_QUALITYDSC", "Quality Lowest: 0 Highest: 100");
define("_MI_WFS_IMGUPDATE", "Update Thumbnails?");
define("_MI_WFS_IMGUPDATEDSC", "If selected Thumbnail images will be updated at each page render, otherwise the first thumbnail image will be used regardless. <br /><br />");
define("_MI_WFS_KEEPASPECT", "Keep Image Aspect Ratio?");
define("_MI_WFS_KEEPASPECTDSC", "");
//Sections and document listings and navigation
//define("_MI_WFS_SHOWEMPTYSEC", "Empty Sections:");
//define("_MI_WFS_SHOWEMPTYSECDSC", "Set to display empty sections in main section index.");
define("_MI_WFS_SHOWSUBMENU", "Display Sub-Sections:");
define("_MI_WFS_SHOWSUBMENUDSC", "Set to display sub-sections in main section index.");
//artlistings and description
define("_MI_WFS_SHOWARTLISTINGS", "Section Document Listing:");
define("_MI_WFS_SHOWARTLISTINGSDSC", "Set method of displaying Section description and documents listing in main section index.");
define("_MI_WFS_SHOWARTLISTING1", "Description Only");
define("_MI_WFS_SHOWARTLISTING2", "Document Listing Only");
define("_MI_WFS_SHOWARTLISTING3", "Display Both");
define("_MI_WFS_SHOWARTLISTING4", "Display None");
define("_MI_WFS_SHOWARTLISTAMOUNT", "Section Index Document Count:");
define("_MI_WFS_SHOWARTLISTAMOUNTDSC", "The amount of documents to display in main section index. <div style='padding-top: 8px;'>NB: Documents will only be displayed if 'Section document listing' is enabled.</div>");
define("_MI_WFS_ARTICLESAPAGE", "Document Index Listing Count");
define("_MI_WFS_ARTICLESAPAGEDSC", "Number of documents to display in document listing.");
define("_MI_WFS_LASTART", "Admin Index Document Count:");
define("_MI_WFS_LASTARTDSC", "Number of new documents to display in module admin area.");
define("_MI_WFS_SHOWORDERBOX", "Document Order Box:");
define("_MI_WFS_SHOWORDERBOXDSC", "Allow users to change document order with xoops orderbox.");
define("_MI_WFS_PATHTYPE", "Navigation Box:");
define("_MI_WFS_PATHTYPEDSC", "Select the type of navigation for document index listing.");
define("_MI_WFS_SECTIONSORT", "Default Section Order:");
define("_MI_WFS_SECTIONSORTDSC", "Select the default order for the Section index listings.");
define("_MI_WFS_ARTICLESSORT", "Default Document Order:");
define("_MI_WFS_ARTICLESSORTDSC", "Select the default order for the document index listings.");
define("_MI_WFS_TITLE", "Title");
define("_MI_WFS_RATING", "Rating");
define("_MI_WFS_WEIGHT", "Weight");
define("_MI_WFS_POPULARITY", "Popularity");
define("_MI_WFS_SUBMITTED2", "Submission Date");
define("_MI_WFS_SELECTBOX", "Select box");
define("_MI_WFS_SELECTSUBS", "Select box with sub-sections");
define("_MI_WFS_LINKEDPATH", "Linked path");
define("_MI_WFS_LINKSANDSELECT", "Links and select box");
define("_MI_WFS_NONE", "None");
define("_MI_WFS_AUTOWEIGHT", "Auto Weight: ");
define("_MI_WFS_AUTOWEIGHTDSC", "Use Auto weight for Section and Documents on save.");
define("_MI_WFS_AUTOSUMMARY", "Auto Summary: (Global)");
define("_MI_WFS_AUTOSUMMARYDSC", "Use Auto summary for Documents. Only applies to documents with no summary.");
define("_MI_WFS_NAMESUMTYPE", "Auto Summary Type:");
define("_MI_WFS_NAMESUMTYPEDSC", "Select the method type of auto summary.<div style='padding-top: 8px;'><b>Word Count:</b> This method will count to the amount of words choosen in the auto summary feature and end at the nearest paragraph.</div>
<div style='padding-top: 8px;'><b>letter count:</b> This method will count the amount of letters (chars) entered in the auto summary feature and end there.</div>");
define("_MI_WFS_NAMESUMTYPE1", "Auto by Word count");
define("_MI_WFS_NAMESUMTYPE2", "Auto by letter count");
define("_MI_WFS_NAMESUMAMOUNT", "Auto Summary Amount:");
define("_MI_WFS_NAMESUMAMOUNTDSC", "<div style='padding-top: 8px;'>Word Count Default: <b>50</b></div>
<div style='padding-top: 8px;'>letter count default: <b>250</b></div>");
define("_MI_WFS_WIKI", "Wiki:");
define("_MI_WFS_WIKIDSC", "Set to allow wiki in document.");
define("_MI_WFS_PHPCODING", "PHP Coding:");
define("_MI_WFS_PHPCODINGDSC", "Set to display PHP coding within document.<div style='padding-top: 8px;'>Wrap text with [php][/php] tags to display as code.</div>");
define("_MI_WFS_VERSIONINC", "Document Version Increment: ");
define("_MI_WFS_VERSIONINCDSC", "The document version will be incremented by this number on save.");
define("_MI_WFS_USERESTORE", "Document Restore:");
define("_MI_WFS_USERESTOREDSC", "This feature will allow backups of modified documents to be restored at a later stage. <br /><br />Using this feature <b>will</b> increase the size of the MySQL database dramatically and older restore points should be removed at regular perodic intervals.");
define("_MI_WFS_DEFAULTTIME", "Timestamp:");
define("_MI_WFS_DEFAULTTIMEDSC", "Default Timestamp for WF-Section:");
//submission document and files
define("_MI_WFS_GROUPSUBMITART", "Document Submission:");
define("_MI_WFS_GROUPSUBMITARTDSC", "Select groups that can submit new documents.");
define("_MI_WFS_ANONPOST", "Anonymous Document Submission?");
define("_MI_WFS_ANONPOSTDSC", "Select to allow anonymous users to post new documents.");
define("_MI_WFS_AUTOAPPROVE", "Auto Approve Submitted Documents:");
define("_MI_WFS_AUTOAPPROVEDSC", "Select to approve submitted documents without moderation.");
define("_MI_WFS_NOTIFYSUBMIT", "Webmaster Submission Email:");
define("_MI_WFS_NOTIFYSUBMITDSC", "Send email to Webmaster upon document submission.");
define("_MI_WFS_WYSIWYG", "Spaw WYSIWYG Editor: (Admin Side)");
define("_MI_WFS_WYSIWYGDSC", "Select to allow admin to use Spaw editor instead of Xoops default editor when submiting documents.");
define("_MI_WFS_USERWYSIWYG", "Spaw WYSIWYG Editor: (User Side)");
define("_MI_WFS_USERWYSIWYGDSC", "Select to allow users to use Spaw editor instead of Xoops default editor when submiting documents?");
define("_MI_WFS_GROUPUSERWYSIWYG", "Select user groups who have access to Spaw editor:");
define("_MI_WFS_USEHTMLAREA", "HTMLtextarea Footers:");
define("_MI_WFS_USEHTMLAREADSC", "Select to use XoopsFormDhtmlTextArea instead of XoopsFormTextArea in Page Management and Section Management.<div style='padding-top: 8px;'>Set to 'No' if you find that your browser crashes when using this option.</div>");
//uploads
define("_MI_WFS_SUBMITFILES", "File Submission:");
define("_MI_WFS_SUBMITFILESDSC", "Select groups that can submit new files.");
define("_MI_WFS_ALLOWEDMIMETYPES", "Allowed Admin Mimetypes:");
define("_MI_WFS_ALLOWEDMIMETYPESDSC", "Select the mimetypes that admin can upload.");
define("_MI_WFS_ALLOWEDUSERMIME", "Allowed User Mimetypes:");
define("_MI_WFS_ALLOWEDUSERMIMEDSC", "Select the mimetypes that users can upload");
define("_MI_WFS_ADMINMIMECHECK", "No admin check on upload Mimetypes:");
define("_MI_WFS_NOUPLOADFILESIZE", "No Admin upload file size check:");
define("_MI_WFS_NOUPIMGSIZE", "No Admin upload file width/height check:");
define("_MI_WFS_UPLOADFILESIZE", "MAX Filesize Upload (KB) 1048576 = 1 Meg");
define("_MI_WFS_IMGHEIGHT", "MAX upload Image Height");
define("_MI_WFS_IMGWIDTH", "MAX Upload Image Width");
define("_MI_WFS_FILEMODE", "CHMOD Files:");
define("_MI_WFS_FILEPREFIX", "Add Prefix:");
define("_MI_WFS_ADDEXT", "File Extension:");
define("_MI_WFS_BANNEDCHARS", "Filename Filter Type:");
define("_MI_WFS_BANNEDCHARSDSC", "Used when uploading file.");
define("_MI_WFS_STRIPCHARS", "Strip characters in Filenames:");
define("_MI_WFS_STRICT","Strict (only alphabets and numbers)");
define("_MI_WFS_MEDIUM","Medium");
define("_MI_WFS_LIGHT","Light (recommended for multi-byte chars)");
define("_MI_WFS_STRIPSPACES", "Strip Spaces from Filename:");
define("_MI_WFS_CHECKSESSION","Checkin Session Time");
define("_MI_WFS_CHECKSESSIONDSC","Session time duration for checkin [minutes, 0 for non-check]");
define("_MI_WFS_BY","Dev by");
define('_MI_WFS_AUTHOR_INFO', "Developer Information");
define('_MI_WFS_AUTHOR_NAME', "Developer");
define('_MI_WFS_AUTHOR_DEVTEAM', "Development Team");
define('_MI_WFS_AUTHOR_WEBSITE', "Developer website");
define('_MI_WFS_AUTHOR_EMAIL', "Developer email");
define('_MI_WFS_AUTHOR_CREDITS', "Credits");
define('_MI_WFS_MODULE_INFO', "Module Development Information");
define('_MI_WFS_MODULE_STATUS', "Development Status");
define('_MI_WFS_MODULE_DEMO', "Demo Site");
define('_MI_WFS_MODULE_SUPPORT', "Official support site");
define('_MI_WFS_MODULE_BUG', "Report a bug for this module");
define('_MI_WFS_MODULE_FEATURE', "Suggest a new feature for this module");
define('_MI_WFS_MODULE_DISCLAIMER', "Disclaimer");
define('_MI_WFS_AUTHOR_WORD', "The Author's Word");
define('_MI_WFS_RELEASE', "Release Date: ");
define('_MI_WFS_MODULE_MAILLIST', "WF-Section Mailing Lists");
define('_MI_WFS_MODULE_MAILANNOUNCEMENTS', "Announcements Mailing List");
define('_MI_WFS_MODULE_MAILBUGS', "Bug Mailing List");
define('_MI_WFS_MODULE_MAILFEATURES', "Features Mailing List");
define('_MI_WFS_MODULE_MAILANNOUNCEMENTSDSC', "Get the latest announcements from Zarili.com.");
define('_MI_WFS_MODULE_MAILBUGSDSC', "Bug Tracking and submission mailing list");
define('_MI_WFS_MODULE_MAILFEATURESDSC', "Request New Features mailing list.");
define('_MI_WFS_WARNINGTEXT', "THE SOFTWARE IS PROVIDED BY ZARILIA CMS \"AS IS\" AND \"WITH ALL FAULTS.\" ZARILIA CMS MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND CONCERNING THE QUALITY, SAFETY OR SUITABILITY OF THE SOFTWARE, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, OR NON-INFRINGEMENT. FURTHER, ABLEMEDIA MAKES NO REPRESENTATIONS OR WARRANTIES AS TO THE TRUTH, ACCURACY OR COMPLETENESS OF ANY STATEMENTS, INFORMATION OR MATERIALS CONCERNING THE SOFTWARE THAT IS CONTAINED IN WF-SECTIONS WEBSITE. IN NO EVENT WILL ABLEMEDIA BE LIABLE FOR ANY INDIRECT, PUNITIVE, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES HOWEVER THEY MAY ARISE AND EVEN IF WF-SECTIONS HAS BEEN PREVIOUSLY ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.");
define('_MI_WFS_AUTHOR_CREDITSTEXT',"I would like to thank the following people for their help and support during the development phase of this module:<br /><br />
tom, mking, paco1969, mharoun, Talis, m0nty, steenlnielsen, Clubby, Geronimo, bd_csmc, herko, LANG, Stewdio, tedsmith, veggieryan, carnuke, MadFish.
<br /><br />Personally I would like to thank those guys from Xoops China Community, like JFYuan (AKA lab) for helping bug mining and language translation.
");
define('_MI_WFS_AUTHOR_BUGFIXES', "Bug Fix History");

define('_MI_WFS_SELECTFORUM', "Select Forum:");
define('_MI_WFS_SELECTFORUMDSC', "Select the forum you have installed and will be used by WF-Sections.");
define('_MI_WFS_DISPLAYFORUM1', "Newbb (all)");
define('_MI_WFS_DISPLAYFORUM2', "IPB Forum");
//define('_MI_WFS_DISPLAYFORUM3', "NewBB");

define("_MI_WFS_USERAMOUNT","User Amount Display:");
define("_MI_WFS_USERAMOUNTDSC", "Change this option if your server as problems displaying large amount of users at once.<br /><br />");

?>