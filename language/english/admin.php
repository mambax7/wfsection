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
define( "_AM_WFS_SAVE", "Save" );
define( "_AM_WFS_SAVECHANGE", "Save Changes" );
define( "_AM_WFS_ADD", "Add" );
define( "_AM_WFS_EDIT", "Edit" );
define( "_AM_WFS_MODIFY", "Modify" );
define( "_AM_WFS_DELETE", "Delete" );
define( "_AM_WFS_CANCEL", "Cancel" );
define( "_AM_WFS_ACTION", "Action" );
define( "_AM_WFS_COPY1", "Clone" );
define( "_AM_WFS_NOARTICLEFOUND", "NOTICE: There are no Documents that match this criteria" );
define( "_AM_WFS_DISABLEHTML", " Disable HTML Tags" );
define( "_AM_WFS_DISABLESMILEY", " Disable Smilie Icons" );
define( "_AM_WFS_DISABLEXCODE", " Disable XOOPS Codes" );
define( "_AM_WFS_DISABLEIMAGES", " Disable Images" );
define( "_AM_WFS_DISABLEBREAK", " Use XOOPS linebreak conversion?" );
define( "_AM_WFS_STRIPHTML", " Strip HTML Tags" );
define( "_AM_WFS_CLEANHTML", " Strip unwanted MS Word tags" );
define( "_AM_WFS_NORIGHTS", "You do not have sufficient rights to access this area" );

/**
 * Database defines
 */
define( "_AD_DBERROR", "There is an error while saving information to the database: <br /><br />Please report this to <a href=\"http://www.wf-projects.com\" target=\"_blank\">WF-Sections support site</a><br /><br />Copy and paste the error below to ensure we can quickly help you." );
define( '_AM_WFS_WFSECTIONCONFIG', 'Configuration Updated' );
define( '_AM_WFS_WFPATHCONFIG', 'Path Configuration Updated' );
define( '_AM_WFS_WFTEMPLATESCONFIG', 'Templates have been Updated' );
define( "_AM_WFS_DBUPDATED", "Database Updated Successfully!" );
/**
 * Lang defines for breadcrumb system
 */
define( '_AM_WFS_BREADC1', 'Preferences' );
define( '_AM_WFS_BREADC2', 'Main Index' );
define( '_AM_WFS_BREADC3', 'Permissions' );
define( '_AM_WFS_BREADC4', 'Blocks' );
define( '_AM_WFS_BREADC5', 'Paths' );
define( '_AM_WFS_BREADC6', 'Templates' );
define( "_AM_WFS_BREADC7", "Go to module" );
define( "_AM_WFS_BREADC8", "Help" );
define( "_AM_WFS_BREADC9", "About" );
/**
 * Lang defines for menu system
 */
define( '_AM_WFS_ADMENU1', 'Page Management' );
define( '_AM_WFS_ADMENU2', 'Section Management' );
define( '_AM_WFS_ADMENU3', 'Create Document' );
define( '_AM_WFS_ADMENU4', 'Weight Management' );
define( '_AM_WFS_ADMENU5', 'Document Restore' );
define( '_AM_WFS_ADMENU6', 'Document Downloads' );
define( '_AM_WFS_ADMENU7', 'Related Documents' );
define( '_AM_WFS_ADMENU8', 'Related Links' );
define( '_AM_WFS_ADMENU9', 'Document Spotlight' );
define( "_AM_WFS_ADMENUA", "Mimetypes Management" );
define( '_AM_WFS_ADMENUB', 'Import Document' );
define( '_AM_WFS_ADMENUC', 'Vote Information' );
define( "_AM_WFS_ADMENUD", "Comments" );
define( "_AM_WFS_ADMENUE", "Server Stats" );
define( "_AM_WFS_ADMENUF", "Upload Images" );
/**
 * Summary information
 */
define( "_AM_WFS_SUMMARYINFO1", "Summary Information" );
define( "_AM_WFS_SUMMARYINFO2", "Sections" );
define( "_AM_WFS_SUMMARYINFO3", "Published" );
define( '_AM_WFS_SUMMARYINFO4', 'Submitted' );
define( '_AM_WFS_SUMMARYINFO5', 'Modified' );
define( '_AM_WFS_SUMMARYINFO6', 'Broken' );
define( "_AM_WFS_SUMMARYINFO7", "Documents In Edit Mode" );
/**
 * allarticles document management
 */
define( "_AM_WFS_ARTICLEMANAGEMENT", "Document Management" );
define( "_AM_WFS_DOC_SELECTION", "Document Selection" );
define( "_AM_WFS_LIST", "<b>List</b> " );
define( "_AM_WFS_LISTINCAT", " <b>In Section</b> " );
/**
 * List article types
 */
define( "_AM_WFS_ALLARTICLES", "All Documents" );
define( "_AM_WFS_PUBLARTICLES", "Published Documents" );
define( "_AM_WFS_SUBLARTICLES", "Submitted Documents" );
define( "_AM_WFS_ONLINARTICLES", "Online Documents" );
define( "_AM_WFS_OFFLIARTICLES", "Offline Documents" );
define( "_AM_WFS_EXPIREDARTICLES", "Expired Documents" );
define( "_AM_WFS_AUTOEXPIREARTICLES", "Auto Expire Documents" );
define( "_AM_WFS_AUTOARTICLES", "Auto Publish Documents" );
define( "_AM_WFS_NOSHOWARTICLES", "Non Index Documents" );
define( "_AM_WFS_HTMLFILES", "HTML File Documents" );
/**
 * menu lang defines
 */
define( "_AM_WFS_ALLTXTHEAD", "Document Management" );
define( "_AM_WFS_ALLTXT", "<div>With <b>Document Management</b> you can edit, delete or rename any Document. This mode will show every Document within the database." );
define( "_AM_WFS_PUBLISHEDTXTHEAD", "Published Documents" );
define( "_AM_WFS_PUBLISHEDTXT", "<div><b>Document Published Management</b> will show all Documents that have been published (Approved by Webmaster).<br /><br />These are all the Documents that will be shown in section listing of the WF-Sections index page (including all those controlled by groupaccess)." ); //added
define( "_AM_WFS_SUBMITTEDTXTHEAD", "Submitted Documents" );
define( "_AM_WFS_SUBMITTEDTXT", "<div><b>Document Submission management</b> will show all Documents submitted by your website users and allow you to moderate them.<br /><br />To approve an Document, click on <b>Edit</b> link, then highlight the <b>Approve</b> checkbox and the save the Document. The submitted Document will then be published." ); //added
define( "_AM_WFS_ONLINETXTHEAD", "Online Documents" );
define( "_AM_WFS_ONLINETXT", "<div><b>Document Online Management</b> will show all Documents which status has been set to 'online'.<br /><br />To change the status of an Document, click on the <b>Edit</b> link and highlight the <b>online</b> checkbox off/on." ); //added
define( "_AM_WFS_OFFLINETXTHEAD", "Offline Documents" );
define( "_AM_WFS_OFFLINETXT", "<div><b>Document Offline Management</b> will show all Documents which status has been set to <b>offline</b>.<br /><br />To change the status of an Document, click on the <b>Edit</b> link and highlight the <b>online</b> checkbox off/on." ); //added
define( "_AM_WFS_EXPIREDTXTHEAD", "Expired Document" );
define( "_AM_WFS_EXPIREDTXT", "<div><b>Document Expired Management</b> will show all Documents that have expired.<br /><br />You can easily reset the expire date by clicking on <b>Edit</b> link and by changing the <b>Set the date/time of expiration</b> setting." ); //added
define( "_AM_WFS_AUTOEXPIRETXTHEAD", "Auto Expire Documents" );
define( "_AM_WFS_AUTOEXPIRETXT", "<div><b>Document Auto Expired Management</b> will show all Documents that have been set to expire on a certain date.<br /><br />You can reset the expire date by clicking on <b>Edit</b> link and changing the <b>Set the date/time of expiration</b> setting." ); //added
define( "_AM_WFS_AUTOTXTHEAD", "Auto Documents" );
define( "_AM_WFS_AUTOTXT", "<div><b>Document Auto Publish Management</b> will show all Documents that have been set to publish at a future date.<br /><br />This setting can be changed by clicking on the <b>edit</b> link and changing the 'Set the date/time of publish' setting." ); //added
define( "_AM_WFS_NOSHOWTXTHEAD", "Non Index Documents" );
define( "_AM_WFS_NOSHOWTXT", "<div><b>Non Index Document</b> Theses are a special type of Documents, unlike your normal Documents these will not show up in Document index pages and will not be seen that way.&nbsp;&nbsp; Instead, these Documents will only be shown in the 'WF-Sections Menu' block.<br /><br />Using this option with 'Connect Selected HTML file to this Document', `No WF-Sections Frame` and 'Non Index Document' (Options on the edit Document page) you can show just what you want. &nbsp;&nbsp;An example of this would be a `privacy notice` page etc.<br /><br />All other options control these types of Documents also. i.e. published, expired, online/offline." ); //added
define( "_AM_WFS_HTMLFILESTXTHEAD", "HTML Documents" );
define( "_AM_WFS_HTMLFILESTXT", "HTML File Documents.  This will display all Documents that have HTML files that have been 'connected' or attached to an Document." ); //added
/**
 * Article listing defines
 */
define( "_AM_WFS_STORYID", "ID" );
define( "_AM_WFS_TITLE", "Title" );
define( "_AM_WFS_POSTER", "Author" );
define( "_AM_WFS_VERSION", "Version" );
define( "_AM_WFS_SECTION", "Section" );
define( "_AM_WFS_STATUS", "Status" );
define( "_AM_WFS_WEIGHT", "Weight" );

define( "_AM_WFS_SUBMITTED2", "Submission Date" );
define( "_AM_WFS_PUBLISHED", "Published Date" );
define( "_AM_WFS_PUBLISHEDON", "Publication Date" );
define( "_AM_WFS_SUBMITTED", "User submitted Documents" );
define( "_AM_WFS_NOTPUBLISHED", "Not published" );
define( "_AM_WFS_EXPARTS", "Expired Documents" );
define( "_AM_WFS_EXPIRED", "Auto Expire Date" );
define( "_AM_WFS_CREATED", "Created Date" );
/**
 * Blocks Management
 */
define( "_AM_WFS_BLOCKSHEADING", "Blocks Management" );
define( "_AM_WFS_BLOCKSINFO", "Blocks Information" );
define( "_AM_WFS_BLOCKSTEXT", "Blocks can be configured from the sytem=>blocks.<br />Following displays WFsection blocks. You can also edit from \"Edit\" area." );
/**
 * Path Managment
 */
define( "_AM_WFS_PATHCONFIGURATION", "Path Configuration" );
define( "_AM_WFS_PATHCONFIG", "Path and Permission Settings" );
define( "_AM_WFS_FILEPATHWARNING", "<li>Sets the path for directories used by WF-Sections.
	<li>A warning will be given if a path used is incorrect.
	<li>Leave a field empty if you wish WF-Sections to use the default path/s." );
define( "_AM_WFS_FILEPATH", "Path Configuration" );
define( "_AM_WFS_FILEUSEPATH", "Change user Path" );
define( "_AM_WFS_PATHEXIST", "Path exists!" );
define( "_AM_WFS_PATHNOTEXIST", "Path does not exist." );
define( "_AM_WFS_THUMBPATHEXIST", "Path exists!" );
define( "_AM_WFS_THUMBPATHNOTEXIST", "Path does not exist." );
define( "_AM_WFS_PATHCHECK", "<b>Path Check:</b> " );
define( "_AM_WFS_PERMISSIONS", "<b>Path Permission Check:</b>" );
define( "_AM_WFS_THUMBPATHCHECK", "<b>Thumbnail Path Check:</b> " );
define( "_AM_WFS_THUMBPERMISSIONS", "<b>Thumbnail Folder Permission Check:</b>" );
define( "_AM_WFS_RESETDEFUALTS", " Reset Path Defaults" );
define( "_AM_WFS_REVERTED", "Paths restored to their orginal settings" );
/**
 * Path Management form defines
 */
define( "_AM_WFS_CMODERROR", "Permissions incorrect: Set permission to 0777 for this path." );
define( "_AM_WFS_CMODERRORNOTCORRECTED", " and permission not corrected." );
define( "_AM_WFS_AGRAPHICPATH", "Document Image Path:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Path where images are stored for use as article logos.</span></div>" );
define( "_AM_WFS_SGRAPHICPATH", "Section Image Path:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Path where Section images are stored.</span></div>" );
define( "_AM_WFS_HTMLCPATH", "HTML Files Path:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Path where HTML files are stored.</span></div>" );
define( "_AM_WFS_LOGOPATH", "Logo Image Path:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Path where logo images are stored.</span></div>" );
define( "_AM_WFS_FILEUPLOADSPATH", "Attached Files Upload Path:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Path where attached files are uploaded and stored.</span></div>" );
define( "_AM_WFS_FILEUPLOADSTEMPPATH", "Attached Files Upload Temp Path:<div style='padding-top: 8px;'><span style='font-weight: normal;'>This path is no longer required and will be removed.</span></div>" );
define( "_AM_WFS_AVATARPATH", "Avatar Thumb folder:<div style='padding-top: 8px;'><span style='font-weight: normal;'>This folder is required for the creation of avatar thumb nails. <br />Please create this folder if the path does not exist.</span></div> " );
/**
 * Template management
 */
define( '_AM_WFS_MODIFYTEMPLATES', 'Template Management' );
define( '_AM_WFS_USINGTEMPLATES', 'Using Templates' );
define( '_AM_WFS_HOWTOUSETEMP', "<li>You can now choose which template to use for your each part WF-Sections.<br /><li><b>WARNING:</b> Wrong use could have un-desirable affects on your website, if you are unsure, then I strongly suggest you leave this area as default!" );
define( '_AM_WFS_ADDINGATEMPLATE', "<b>Adding A template</b>" );
define( '_AM_WFS_HOWTOUSETEMP2', "<li>To add a new template, copy the template file to the WF-Sections template folder as normal.<br /><li>Then you MUST update WF-Sections via <a href='../../../modules/system/admin.php?fct=modulesadmin&op=update&module=wfsection'>System Admin/Modules</a> for these changes to take affect.<br /><li>Failure to do so will result in a blank page." );
define( '_AM_WFS_DISPLAYXOOPSTEMPADMIN', 'Xoops Template Set Manager: ' );
define( '_AM_WFS_NONBLOCKS', 'Main Templates' );
define( '_AM_WFS_ISBLOCKS', 'Block Templates' );
define( '_AM_WFS_TEMPLDOWNLOADS', 'Download Template' );
define( '_AM_WFS_TEMPLARCHIVES', 'Article Archive Template' );
define( '_AM_WFS_TEMPLARTINDEX', 'Article Index Template' );
define( '_AM_WFS_TEMPLSECINDEX', 'Section Index Template' );
define( '_AM_WFS_TEMPLART', 'Article Page: With information (Default)' );
define( '_AM_WFS_TEMPLPLAINART', 'Article Page: No Frame Document' );
define( '_AM_WFS_TEMPLTOPTEN', 'Top Ten Page Template' );
define( '_AM_WFS_ARTMENUBLOCK', 'Article Menu Block' );
define( '_AM_WFS_BIGSTORYBLOCK', 'Big Article Block' );
define( '_AM_WFS_MAINMENUBLOCK', 'Main Menu Block' );
define( '_AM_WFS_NEWARTBLOCK', 'New Article Block' );
define( '_AM_WFS_NEWDOWNBLOCK', 'WF-Sections Downloads Block' );
define( '_AM_WFS_TOPARTBLOCK', 'Top Article Block' );
define( '_AM_WFS_TOPICSBLOCK', 'Sections Block' );
define( '_AM_WFS_SPOTLIGHTBLOCK', 'Spotlight Block' );
define( '_AM_WFS_NEWDOWNLOADSBLOCK', 'New Downloads Block' );
define( '_AM_WFS_AUTHORBLOCK', 'Author Info Block' );
define( "_AM_WFS_VIEW", "View" );
/**
 * Indexpage management
 */
define( '_AM_WFS_INDEXPAGE', 'Page Management' );
define( '_AM_WFS_INDEXPAGEINFO', 'Page Management Information' );
define( '_AM_WFS_INDEXPAGEINFOTXT', '<li>This area allows you to \'design\' many pages of WF-Sections.<li>You can easily change the image logo, heading, main index header and footer text to suit your own look.' );
define( '_AM_WFS_INDEXPAGELISTING', 'Page Management Listing' );

define( "_AM_WFS_PAGENAME2", "Page Name" );
define( "_AM_WFS_MODIFYPAGE", "Modify New Page" );
define( "_AM_WFS_ADDPAGE", "Add New Page" );
define( "_AM_WFS_INDEXHEADING", "Page Title:" );
define( "_AM_WFS_INDEXHEADING2", "Page Title" );
define( '_AM_WFS_INDEXPAGEEDIT', 'Edit Page' );
define( "_AM_WFS_SECTIONIMAGE", "Page Image:" );
define( "_AM_WFS_SECTIONHEAD", "Page Heading Text:" );
define( "_AM_WFS_SECTIONFOOT", "Page Footer Text:" );
define( "_AM_WFS_ALIGNMENT", "<b>Page Alignment: </b>" );
define( "_AM_WFS_ISDEFAULT", "Default" );
define( "_AM_WFS_PAGENAME", "Page Name:" );
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
// define('_AM_WFS_ADMENU12', 'WF-Sections Admin Management');
define( "_AM_WFS_MINDEX_ACTION", "Action" );
define( "_AM_WFS_MINDEX_PAGE", "<b>Page:<b> " );
// Database Lang defines
define( "_AM_WFS_RUSUREDEL", "Are you sure you want to delete this Document?" );
define( "_AM_WFS_NOTEIMGRESIZE", "Image has been resized to Height: 160 x Width: 200" );
// Section Lang Defines
define( "_AM_WFS_CATEGORY", "Section Title" );
define( "_AM_WFS_CATEGORYNAME", "Section Title:" );
define( "_AM_WFS_SECTIONPAGEDETAILS", "Section Page Details" );
define( "_AM_WFS_TEXTOPTIONS", "Text Formatting Options:" );
define( "_AM_WFS_GROUPPROMPT", "Section Access Privileges:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Select user groups who will have access to this Section.</span></div>" );
define( "_AM_WFS_IN", "Create As Sub-Section:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Leave as blank to create top level Section.</span></div>" );
define( "_AM_WFS_MOVETO", "Move To Section:" );
define( "_AM_WFS_CATEGORYWEIGHT", "Section Weight:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Determines the section display order: 0 Highest</span></div>" );
define( "_AM_WFS_CATEGORYDESC", "Section Description:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Text Only. No HTML or Xoops Codes</span></div>" );
define( "_AM_WFS_ADDMCATEGORY", "Create New Section" );
define( "_AM_WFS_CATEGORYTAKEMETO", "Click here to create a new Section." );
define( "_AM_WFS_NOCATEGORY", "ERROR - No Sections created." );
define( "_AM_WFS_MODIFYCATEGORY", "Modify Section" );
define( "_AM_WFS_MOVECATEGORY", "Move Section Documents" );
define( "_AM_WFS_MOVEDEL", "Move Documents" );
define( "_AM_WFS_EDITSECTION2", "Move to Section: Document will appear in the Section." );
define( "_AM_WFS_MOVE", "Move" );
define( "_AM_WFS_MOVEARTICLES", "Move Documents to Section" );
define( '_AM_WFS_DUPLICATECATEGORY', 'Duplicate Section' );
define( '_AM_WFS_COPY', 'Copy Section:' );
define( '_AM_WFS_TO', 'To:' );
define( '_AM_WFS_NEWCATEGORYNAME', 'New Section Title:' );
define( '_AM_WFS_DUPLICATE', 'Duplicate' );
define( '_AM_WFS_DUPLICATEWSUBS', 'Duplicate with Sub-Sections' );
define( "_AM_WFS_SECTIONCOPYARTICLES", "Also Copy Section Documents?" );
define( "_AM_WFS_ADDSECTIONTOMENU", "Add Section to Xoops Main Menu?" );
define( "_AM_WFS_SECTIONTEMPLATE", "Select Section Template:" );
define( "_AM_WFS_SHOWCATEGORYIMG", "<b>Display Section Image:&nbsp;</b>" );
define( "_AM_WFS_SECTIONIMAGEALIGN", "<b>Image alignment:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>" );
define( "_AM_WFS_SECTIONIMAGEOPTION", "Section Image Options:" );
define( "_AM_WFS_SECTIONSTATUS", "Section Status:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Set to display Section in main Section index listing. If set to offline, section will be hidden</span></div>" );
define( "_AM_WFS_CATEGORYHEAD", "Section Heading Text:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Leave as blank to create top level Section.</span></div>" );
define( "_AM_WFS_CATEGORYFOOT", "Section Footer Text:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Leave as blank to create top level Section.</span></div>" );
define( "_AM_WFS_GROUPCREATEPROMPT", "Article Creation Privileges:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Select the user groups who may create article in this Section.</span></div>" );
// Document Lang defines
define( "_AM_WFS_ADDNEWAUTH", " Select New Author" );
define( "_AM_WFS_EDITARTICLE", "Document Management Information" );
define( "_AM_WFS_MENU_LINKS", "WF-Sections Menu" );
// define("_AM_WFS_ARTICLEMANAGEMENT", "Document Management");
define( "_AM_WFS_ARTICLEPREVIEW", "Document Preview" );
define( "_AM_WFS_WAYSYWTDTTAL", "WARNING: Are you sure you want to delete this Section and ALL its Documents" );
define( "_AM_WFS_CATEGORYSMNGR", "Sections Manager" );
define( "_AM_WFS_PEARTICLES", "Create new Document" );
define( "_AM_WFS_GENERALCONF", "General Configuration" );
define( "_AM_WFS_UPDATEFAIL", "Update failed." );
define( "_AM_WFS_EDITFILE", "Edit attached file" );
define( "_AM_WFS_FILEDEL", "WARNING: Are you sure you want to delete this File?" );
define( "_AM_WFS_IMGNAME", "File Name (Blank: Same as original (uploaded) file name)" );
define( "_AM_WFS_UPLOADED", "Uploaded!" );
define( "_AM_WFS_ISNOTWRITABLE", "is not writable!" );
define( "_AM_WFS_UPLOADFAIL", "WARNING: This upload failed. Reason:" );
define( "_AM_WFS_NOTALLOWEDMIMETYPE", "Mimetype: %s <br />Extension: .%s <br />You are not permitted to upload this type of file." );
define( "_AM_WFS_FILETOOBIG", "File Size larger than permitted upload size!" );
define( "_AM_WFS_IMAGEALIGN", "Set Image alignment:" );
define( "_AM_WFS_ARTICLEPAGEMENU", "Document Page Configuration" );
define( "_AM_WFS_BLOCKMENU", "Blocks Configuration" );
define( "_AM_WFS_ADMINEDITMENU", "Document General Configuration" );
define( "_AM_WFS_ADMINCONFIGMENU", "Admin Configuration" );
define( "_AM_WFS_SELECTITEM", "Select" );
define( "_AM_WFS_SPOTLIGHT", "Spotlight This Document in Document Index?" );
define( "_AM_WFS_SPOTLIGHTMAIN", "Spotlight This Document in Main Index?" );
define( "_AM_WFS_SPOTLIGHTSPONSER", "Sponsered Document in Main Index?" );
define( "_AM_WFS_MENU", "Other Settings" );
define( "_AM_WFS_EDITMAINTEXT", "3. Text Document: (Default)<div style='padding-top: 8px;'><span style='font-weight: normal;'>Word count: %s</span></div> " );
define( "_AM_WFS_DOC_RESTORE", "Restore to Previous version of this Document" );
/**
 * all article information text
 */
define( "_AM_WFS_CMODHEADER", "File Permission Check" );
define( "_AM_WFS_FILE", "File: " );
define( "_AM_WFS_NOMAINTEXT", "ERROR: There is no Text/Html in your Document! Document cannot be empty!" );
define( "_AM_WFS_PATH", "Path: " );
define( "_AM_WFS_ARTICLEMENU", "Document Index Configuration" );
define( "_AM_WFS_APPROVE", "Approve" );
define( "_AM_WFS_MOVETOTOP", "Move this story to top" );
define( "_AM_WFS_CHANGEDATETIME", "Change the date/time for publication" );
define( "_AM_WFS_NOWSETTIME", "Publish date set for: %s" );
define( "_AM_WFS_CURRENTTIME", "Current time is: %s" );
define( "_AM_WFS_SETDATETIME", "Set the date/time for publication" );
define( "_AM_WFS_MONTHC", "Month:" );
define( "_AM_WFS_DAYC", "Day:" );
define( "_AM_WFS_YEARC", "Year:" );
define( "_AM_WFS_TIMEC", "Time:" );
define( "_AM_WFS_IMAGES", "Image Config" );
define( "_AM_WFS_BROKENDOWNLOADS", "Broken Downloads" );
define( "_AM_WFS_BROKENDOWNLOADSTEXT", "Broken Downloads Information" );
define( "_AM_WFS_NOBROKEN", "No reported broken files." );
define( "_AM_WFS_IGNORE", "Ignore" );
define( "_AM_WFS_FILEDELETED", "File Deleted." );
define( "_AM_WFS_BROKENDELETED", "Broken file report deleted." );
define( '_AM_WFS_BROKENTEXT', '<li>Ignore (Ignores the report and only deletes the <b>broken file report.</b>
<li>Edit (Edit or Modify the attached file.)
<li>Delete (Deletes <b>the reported download data</b> and <b>broken file reports</b> for the file.)' );
define( "_AM_WFS_REPORTER", "Report Sender" );
define( "_AM_WFS_FILETITLE", "Download Title " );
define( "_AM_WFS_ARTICLETITLE", "Article Title " );
define( "_AM_WFS_UPLOAD", "Upload" );
define( "_AM_WFS_VIEWHTML", "EditHTML" );
define( "_AM_WFS_VIEWWAYSIWIG", "EditWYSIWYG" );
define( "_AM_WFS_ARTICLEMANAGE", "Document Management" );
define( "_AM_WFS_WEIGHTMANAGE", "Weight Management" );
define( "_AM_WFS_UPLOADMAN", "File Management" );
define( "_AM_WFS_NOADMINRIGHTS", "Sorry, only the Webmaster can change WF-Sections configuration" );
define( "_AM_WFS_CANNOTHAVECATTHERE", "ERROR: This Section cannot be a child of itself!!" );
define( "_AM_WFS_SECTIONMANAGE", "Section Management" );
define( "_AM_WFS_FILEID", "File" );
define( "_AM_WFS_FILEICON", "Icon" );
define( "_AM_WFS_FILESTORE", "Stored As" );
define( "_AM_WFS_REALFILENAME", "Real Name" );
define( "_AM_WFS_USERFILENAME", "User Name" );
define( "_AM_WFS_FILEMIMETYPE", "File Type" );
define( "_AM_WFS_FILESIZE", "File Size" );
define( "_AM_WFS_CHANGEEXPDATETIME", "Change the date/time of expiration" );
define( "_AM_WFS_SETEXPDATETIME", "Set the date/time of expiration" );
define( "_AM_WFS_NOWSETEXPTIME", "Document Expiration date set for : %s" );
define( "_AM_WFS_ALLOWCOMENTS", "Display Xoops Comments for this Document?" );
define( "_AM_WFS_COMMENT", "Comments" );
define( "_AM_WFS_EDITSERVERFILE", "Edit Server file" );
define( "_AM_WFS_CURRENTFILENAME", "Current Filename: " );
define( "_AM_WFS_CURRENTFILESIZE", "File size: " );
define( "_AM_WFS_UPLOADFOLD", "Upload Folder: " );
define( "_AM_WFS_UPLOADPATH", "Path: " );
define( "_AM_WFS_FREEDISKSPACE", "Free diskspace:" );
define( "_AM_WFS_RENAMEFILE", "Rename file" );
define( "_AM_WFS_ARTICLEWEIGHT", "Document Weight" );
define( '_AM_WFS_MODIFYFILE', 'Modify Document File' );
define( '_AM_WFS_FILESTATS', 'Attached File Stats' );
define( '_AM_WFS_FILESTAT', 'File Stats for Document: ' );
define( '_AM_WFS_IMGESIZETOBIG', 'Image height/width larger than permitted sizes Allowed image dimensions: Height:%s x Width:%s <br />Uploading image dimensions: Height:%s x Width:%s' );
define( '_AM_WFS_CATREORDERTEXT', '<li>You can use this area to change the current section and Document weight.<br /><li>Each section and Documents are listed by their weight.<br /><li>Main Sections are in dark blue, Sub-sections are in a lighter blue and then grey.</li><br /><li>To re-order Documents, click on a Section title and a list of its Documents will be shown.</li>' );
define( '_AM_WFS_ATTACHFILEACCESS', 'Access permission will be the same as the Document.  You can change this when editing the attached file.' );
define( '_AM_WFS_WFSFILESHOW', 'Attached Files' );
define( '_AM_WFS_ATTACHEDFILE', 'Document Downloads Information' );
define( '_AM_WFS_TDISPLAYSATTACHEDFILES', '<li>All attached files will shown in order of their ID.<br /><li>You can edit or delete the files from here.' );
define( '_AM_WFS_VOTEDATA', 'Display Vote Data' );
define( '_AM_WFS_VOTEDATATEXT', '<li>Vote data will be displayed in order of their ID.' );
define( '_AM_WFS_ATTACHEDFILEM', 'Download Management' );
define( '_AM_WFS_UPOADMANAGE', 'File Management' );
define( '_AM_WFS_CAREORDER', 'Weight Management' );
define( '_AM_WFS_CAREORDER2', 'Section and Document Weight' );
define( '_AM_WFS_CAREORDER3', 'Setting Documents weight' );
define( "_AM_WFS_EDITHTMLFILE", "2. HTML Document:<div style='padding-top: 8px;'><span style='font-weight: normal;'>This document will be used as the maintext of the page.</span></div>" );
define( "_AM_WFS_DOCTITLE", " Use HTML Document Title" );
define( "_AM_WFS_DOHTMLDB", " Import to Database" );
define( "_AM_WFS_EDITCONNECTFILE", " Connect Page?" );
define( "_AM_WFS_EDITHTMLFILEEDIT", "Edit Selected HTML File?" );
define( "_AM_WFS_EDITWORDBROWSE", "Select Word Document" );
define( "_AM_WFS_EDITWORDDOCUMENT", "Edit Selected Word Document to edit:" );
define( '_AM_WFS_EDITGROUPPROMPT', "Document Access Permissions:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Select user groups who will have access to this Document.</span></div>" );
define( "_AM_WFS_EDITSECTION", "Create in Section:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Document will be created an displayed in this Section.</span></div>" );
define( "_AM_WFS_EDITWEIGHT", "Document Weight:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Determines the document display order: 0 Highest. Only has effect if Default Document Order has been set to weight.</span></div>" );
define( "_AM_WFS_EDITCAUTH", "Document Author:" );
define( "_AM_WFS_EDITCAUTH2", "Document Author:<div style='padding-top: 8px;font-weight: normal;color:red;'><br />Warning:<br />
If you changed any content of this document please save those changes before using the Navbar to change the author! <br />(Navbar is only used on sites with more than 300 users)</span></div>" );
define( "_AM_WFS_EDITLINKURL", "1. Linked Document:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Displays a link to another website/page in Document listing.</span></div>" );
define( "_AM_WFS_EDITLINKURLADD", "URL Address:<br />" );
define( "_AM_WFS_EDITLINKURLNAME", "URL Name:<br />" );
define( "_AM_WFS_EDITARTICLETITLE", "Document Title:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Name of the Document.</span></div>" );
define( "_AM_WFS_PUBLISHDATE", "Document Publish Date:" );
define( "_AM_WFS_EXPIREDATESET", " Expire date set: " );
define( "_AM_WFS_EXPIREDATE", "Document Expire Date:" );
define( "_AM_WFS_CLEARPUBLISHDATE", "<br /><br />Remove Publish date:" );
define( "_AM_WFS_CLEAREXPIREDATE", "<br /><br />Remove Expire date:" );
define( "_AM_WFS_PUBLISHDATESET", " Publish date set: " );
define( "_AM_WFS_SETDATETIMEPUBLISH", " Set the date/time of publish" );
define( "_AM_WFS_SETDATETIMEEXPIRE", " Set the date/time of expire" );
define( "_AM_WFS_SETPUBLISHDATE", "<b>Set Publish Date: </b>" );
define( "_AM_WFS_SETEXPIREDATE", "<b>Set Expire Date: </b>" );
define( "_AM_WFS_EXPIREWARNING", "<br />WARNING: Expire date set before publish date! " );
define( "_AM_WFS_EDITSUMMARY", "Document Summary:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Summary Text only.</span></div>
<div style='padding-top: 8px;'><span style='font-weight: normal;'>Displays a link to another website/page in Document listing.</span></div>
" );
define( '_AM_WFS_EDITAUTOSUMMARY', ' Use Auto Summary' );
define( '_AM_WFS_EDITREMOVEIMAGES', ' Remove images with auto summary' );
define( '_AM_WFS_EDITSUMMARYAMOUNTW', 'Auto Summary lenght: (Words)' );
define( '_AM_WFS_EDITSUMMARYAMOUNTC', 'Auto Summary lenght: (Chars)' );
define( "_AM_WFS_EDITMOVETOTOP", " Set Document status as new" );
define( "_AM_WFS_EDITAPPROVE", "Approve This Document?" );
define( "_AM_WFS_EDITALLOWCOMENTS", " Allow Comments for Document" );
define( "_AM_WFS_EDITJUSTHTML", " No WF-Sections Frame" );
define( '_AM_WFS_EDITNOSHOART', ' Non Index Document' );
define( "_AM_WFS_EDITOFFLINE", " Set Document Offline" );
define( "_AM_WFS_EDITMAINMENU", " Add Document to Xoops Mainmenu" );
define( "_AM_WFS_CHECKOUTOFARTICLE", "Checking you out of a previous Document and redirecting you" );
define( "_AM_WFS_SECTIONHASARTICLES", "WARNING: This Section is not empty. Move these Documents and delete section?" );
define( "_AM_WFS_CREATEDBY", "Orginal Author: " );
define( "_AM_WFS_LASTEDITBY", "Last Edited By: " );
define( "_AM_WFS_CREATEDON", "Created On:  " );
define( "_AM_WFS_EDITEDON", "Edited On:  " );
define( "_AM_WFS_ADDAFILETOTHISDOWNLOAD", " Add a file to this Document " );
define( "_AM_WFS_WARNINGUNSAVEDDATA", "(WARNING: All unsaved data will be lost!)" );
define( "_AM_WFS_EDITDISCUSSINFORUM", "Add 'Discuss in Forum' to Document?" );
define( "_AM_WFS_EDITDISSUMMARYBREAKS", "Disable Linebreak conversion for summary?" );
define( "_AM_WFS_NAVIGATION", "Navigation" );
define( "_AM_WFS_USECATEGORYACCESS", " Use Section Permissions for this document?" );
define( '_AM_WFS_REORDERID', 'ID' );
define( '_AM_WFS_REORDERPID', 'PID' );
define( '_AM_WFS_REORDERTITLE', 'Title' );
define( '_AM_WFS_REORDERDESCRIPT', 'Description' );
define( '_AM_WFS_REORDERWEIGHT', 'Weight' );
define( '_AM_WFS_REORDERSUMMARY', 'Summary' );
define( "_AM_WFS_EXTRADOC_TEXT", "<div style='padding-top: 8px;'><b>Page Break</b>: <span style='font-weight: normal;'>use [pagebreak] to seperate a document into smaller pages with a normal navigation.</span></div>
<div style='padding-top: 8px;'><b>PageNav Breaks</b>: <br /><span style='font-weight: normal;'>Use [title]TitleText[/title] to seperate a document into smaller pages using a title navagation system.<br />You can use [subtitle]Sub Title[/subtitle] to give each new page a Sub Title.</span></div>
" );
/**
 * Main Configuration
 */
define( "_AM_WFS_WFSECTIONMAINCONFIG", "Misc Settings and Configuration" );
define( "_AM_WFS_WFSECTIONMAINCONFIGTEXT", "<li>This area allows you to change most of WF-Sections settings and configuration.<br /><li>Please read the help documentation for further details" );
define( "_AM_WFS_SECTIONSETTINGS", "Section Management Information" );
define( "_AM_WFS_SECTIONSETTINGSTEXT", "<li>Here you can create new sections for your site, these are like 'folders' where you store your Documents.<br /><li>You can create, modify and delete your sections easily from here.<br /><li>Please read the help document for further use of the features here." );
define( "_AM_WFS_MODIFICATION", "Modification Request" );
define( "_AM_WFS_MODIFICATIONINFO", "Modification Request Information" );
define( "_AM_WFS_MODIFICATIONTEXT", "<li>This area will list all Documents that have been modified and re-submitted for approval.<br /><li>You can view, modify or approve these changes." );
/**
 * Index Page management
 */

/**
 * Copyright and Support.  Please do not remove this line as this is part of the only copyright agreement for using WF-Sections
 */
define( '_AM_WFS_VISITSUPPORT', 'Visit the WF-Sections website for information, updates and help on its usage.<br /> WF-Sections v1 Catzwolf &copy; 2003 <a href="http://www.wf-projects.com/" target="_blank">WF-Sections</a>' );
// new constants by frankblack
define( '_AM_WFS_CLEAN', 'Clean' );
define( '_AM_WFS_PREVIEW', 'Preview' );
define( '_AM_WFS_NOARTWITHINCAT', 'No Documents within this section' );
define( '_AM_WFS_RETCATREORDER', 'Return to Section re-order' );
define( '_AM_WFS_ARTREORDER', 'Documents have been re-ordered!' );
define( '_AM_WFS_CATREORDER', 'Choosen Sections have been re-ordered!' );
define( '_AM_WFS_NOFILESFOUND', 'No Files Found' );
define( '_AM_WFS_TOTALATTFILES', 'Total Downloads: ' );
define( '_AM_WFS_NOARTFOUND', 'No Documents found' );
define( '_AM_WFS_WEIGHTMUSTNUMBER', 'Weight must be a number!' );
define( '_AM_WFS_FILENAME', 'Filename' );
define( '_AM_WFS_FILETYPE', 'Type' );
define( '_AM_WFS_FILEMODIFIED', 'Modified' );
define( '_AM_WFS_FILEATTRIBUTES', 'Attributes' );
define( '_AM_WFS_FILEACTIONS', 'Actions' );
define( '_AM_WFS_ALTFOLDER', ' Folder ' );
define( '_AM_WFS_ALTCHANGEFOLDER', 'Modify' );
define( '_AM_WFS_ALTRENAMEFILE', 'Rename' );
define( '_AM_WFS_ALTEDITFILE', 'Edit' );
define( '_AM_WFS_ALTDELFILE', 'Delete' );
define( '_AM_WFS_ALTVIEWFILE', 'Show' );
define( '_AM_WFS_ALTREFRESH', 'Refresh' );
define( '_AM_WFS_FILEFILES', 'Files' );
define( '_AM_WFS_FILEDIRECTORIES', 'Directories' );
define( '_AM_WFS_FILENEWFILE', 'NewFile' );
define( '_AM_WFS_FILEMAKEDIR', 'Makedir' );
define( '_AM_WFS_FILEPARENTDIR', 'Parent Directory' );
define( '_AM_WFS_FILESAVED', 'File Saved' );
define( '_AM_WFS_FILECREATED', 'File Created' );
define( '_AM_WFS_FILENOTCREATED', 'Error: File not Created' );
define( '_AM_WFS_FILEFOLDERCREATED', 'Folder Created' );
define( '_AM_WFS_FILEFOLDERNOTCREATED', 'Error, folder not created' );
define( '_AM_WFS_FILERENAME', 'Rename' );
define( '_AM_WFS_FILERENAMEFILE', 'Rename File: ' );
define( '_AM_WFS_FILERENAMEFILEHEAD', 'Rename File' );
define( '_AM_WFS_FILECHMOD', 'CHMOD File: ' );
define( '_AM_WFS_FILECHMODHEAD', 'CHMOD File' );
define( '_AM_WFS_FILECHMODSAVE', 'CHMOD' );
define( '_AM_WFS_FILEDELETE', 'Delete' );
define( '_AM_WFS_FILEDELETEFILE', 'Delete File' );
define( '_AM_WFS_FILECANNOTDELFOLDEREMPT', 'Cannot delete, Folder not empty!' );
define( '_AM_WFS_FILENOFILEEDIT', 'No File to Edit' );
define( '_AM_WFS_ISDELETED', 'File Deleted' );
define( '_AM_WFS_FILEFOLDERDEL', 'Folder Deleted' );
define( '_AM_WFS_FILEINVALIDFILENAME', 'Invalid File name' );
define( '_AM_WFS_FILESAFEMODE1', 'Safe Mode restriction applies, not' );
define( '_AM_WFS_FILEUNKWOWN', 'Unknown error??!, Could not delete!' );
define( '_AM_WFS_FILENOTDELNOTWRITE', 'Cannot delete, is not writable!' );
define( '_AM_WFS_FILESAFEMODE2', 'safe_mode is ON (This will cause problems with Filemanager)' );
define( '_AM_WFS_FILESAFEMODE3', 'safe_mode is OFF' );
define( '_AM_WFS_FILEUPLOAD1', 'Uploads is ON' );
define( '_AM_WFS_FILEUPLOAD2', 'Uploads is OFF' );
define( '_AM_WFS_FILEUPLOAD3', 'and Max Upload size' );
define( '_AM_WFS_FILEREGISTER1', 'Register Globals is ON' );
define( '_AM_WFS_FILEREGISTER2', 'Register Globals is OFF' );
define( '_AM_WFS_FILERENAMED', 'Renamed!' );
define( '_AM_WFS_FILEALREADYEXISTS', 'already exists!' );
define( '_AM_WFS_FILESAVEAS', 'Save As: ' );
define( '_AM_WFS_FILEUPLOADEXISTSERVER', 'The file you are uploading exists on the server' );
define( '_AM_WFS_FILEMAXALLOWEDIS', 'Maximum allowed is' );
define( '_AM_WFS_FILEWIDTH', 'Width:' );
define( '_AM_WFS_FILEHEIGHT', 'Height:' );
define( '_AM_WFS_FILEIMGDIMENS', 'Uploading image dimensions:' );
define( '_AM_WFS_FILEALLOWIMGDIMENS', 'Allowed image dimensions:' );
define( '_AM_WFS_FILENONAMECHOOSEN', 'No File Selected! Please select a file to upload.' );
define( '_AM_WFS_FILEPATHNOTEXIST', 'Path does not exists:<br /> %s' );
define( '_AM_WFS_FILEPATHNOTWRITE', 'Path Not writable:<br /> %s' );
define( '_AM_WFS_FILENODIRSEL', 'No Dir selected' );
define( '_AM_WFS_FILEERRFILENOTREN', 'Unknown Error: File not renamed!' );
define( '_AM_WFS_FILECANNOT', 'Cannot' );
define( '_AM_WFS_FILEISNOTWRITABLE', 'is not writable!' );
define( '_AM_WFS_FILEFILE', 'File' );
define( '_AM_WFS_SAFEMODEAPPLY', 'Safe Mode restriction applies, not ' );
define( '_AM_WFS_UNKOWNERRORNOTDEL', 'Unknown error, not deleted!' );
define( '_AM_WFS_MIMETYPE', 'Mimetype: ' );
define( '_AM_WFS_SERVERSTATUS', 'Server status' );
define( '_AM_WFS_SAFEMODEISON', 'Safe_mode is ON (This will cause problems with Filemanger)' );
define( '_AM_WFS_SAFEMODEISOFF', 'Safe_mode is OFF' );
define( '_AM_WFS_UPLOADSON', 'Uploads is ON' );
define( '_AM_WFS_UPLOADSOFF', 'Uploads is OFF' );
define( '_AM_WFS_ANDTHEMAX', ' and Max Upload size = ' );
define( '_AM_WFS_REGISTERON', 'Register Globals is ON' );
define( '_AM_WFS_REGISTEROFF', 'Register Globals is OFF' );
define( '_AM_WFS_APPROVED', 'Approved' );
define( '_AM_WFS_ERROR_APPROVED', 'Error occurred during approval' );
// votedata
define( "_AM_WFS_DLRATINGS", "WF-Sections Document Rating (total votes: %s)" );
define( "_AM_WFS_REGUSERVOTES", "Registered User Votes (total votes: %s)" );
define( "_AM_WFS_ANONUSERVOTES", "Anonymous User Votes (total votes: %s)" );
define( "_AM_WFS_USER", "User" );
define( "_AM_WFS_IP", "IP Address" );
define( "_AM_WFS_USERAVG", "Average User Rating" );
define( "_AM_WFS_TOTALRATE", "Total Ratings" );
define( "_AM_WFS_NOREGVOTES", "No User Votes" );
define( "_AM_WFS_DATE", "Date" );
define( "_AM_WFS_ARTICLE", "Document Name" );
define( "_AM_WFS_RATING", "Rating" );
define( "_AM_WFS_VOTEDELETED", "Vote Deleted" );
// Modify Document
define( "_MD_DLCONF", "Downloads Configuration" );
define( "_MD_USERMODREQ", "User Modification Requests" );
define( "_MD_ORIGINAL", "Original" );
define( "_MD_PROPOSED", "Proposed" );
define( "_MD_OWNER", "Owner: " );
define( "_MD_NOMODREQ", "No Download Modification Request." );
define( "_MD_DESCRIPTIONC", "Description: " );
define( "_MD_FILEID", "File ID: " );
define( "_MD_FILETITLE", "Download Title: " );
define( "_MD_DLURL", "Download URL: " );
define( "_MD_DLURLUPLOAD", "Upload File: " );
define( "_MD_HOMEPAGEC", "Home Page: " );
define( "_MD_VERSIONC", "Version: " );
define( "_MD_FILESIZEC", "File Size: " );
define( "_MD_NUMBYTES", "%s bytes" );
define( "_MD_PLATFORMC", "Platform: " );
define( "_MD_EMAILC", "Email: " );
define( "_MD_CATEGORYC", "Section: " );
define( "_MD_LASTUPDATEC", "Last Update: " );
define( "_MD_APPROVE", "Approve" );
define( "_MD_IGNORE", "Ignore" );
define( "_MD_SUBMITTER", "Submitter: " );
define( "_AM_WFS_MOVETOART", "Move To Document: (Blank: No Change)" );
// Modified Documents
define( "_AM_WFS_MODIFIED", "Modified" );
define( "_AM_WFS_ORIGINAL", "Original Document" );
define( "_AM_WFS_AUTHOR", "Author:" );
define( "_AM_WFS_MAINTEXT", "Maintext:" );
define( "_AM_WFS_SUBTITLE", "Subtitle:" );
define( "_AM_WFS_SUMMARY", "Summary:" );
define( "_AM_WFS_URL", "URL:" );
define( "_AM_WFS_URLNAME", "URL Name:" );
// define("_AM_WFS_SECTION", "Section:");
define( "_AM_WFS_TITLE1", "Title:" );
define( "_AM_WFS_PUBLISHEDDATE", "Published:" );
define( "_AM_WFS_SUMITDATE", "Modified Date:" );
define( "_AM_WFS_PROPOSED", "Proposed Document" );
define( "_AM_WFS_POST", "Save" );
define( "_AM_WFS_POSTNEWARTICLE", "Edit Modified Document" );
define( "_AM_WFS_WAYSYWTDTTAL2", "Delete Modified Document?" );
define( "_AM_WFS_MODREQDELETED", "Modified Document Deleted" );
// Admin rights
define( "_AM_WFS_WFSECTIONADMINRIGHTS", "You do not have permission to access this area!" );
// Document Stats
define( "_AM_WFS_ARTICLESTATS", "Document Stats" );
define( "_AM_WFS_ARTICLESTATSFOR", "Stats For Document:" );
define( "_AM_WFS_ISLEFT", "Left" );
define( "_AM_WFS_ISCENTER", "Center" );
define( "_AM_WFS_ISRIGHT", "Right" );
define( "_AM_WFS_THISWILLREPLACELINEBREAKS", "(This will replace linebreaks with the break tag)" );
define( "_AM_WFS_CREATEARTICLE", "Creating New Document" );
define( "_AM_WFS_MODIFYARTICLE", "Modify Document : " );
define( "_AM_WFS_NODETAILSRECORDED", "No Details recorded" );
define( "_AM_WFS_ISFOLDER", "Folder" );
define( "_AM_WFS_ISCHANGEFOLDER", "Change Folder" );
define( "_AM_WFS_ISRENAMEFILE", "Rename file" );
define( "_AM_WFS_ISEDITFILE", "Edit file" );
define( "_AM_WFS_ISDOWNLOAD", "Download" );
define( "_AM_WFS_ISDELFILE", "Delete File" );
define( "_AM_WFS_ISVIEWFILE", "View File" );
define( "_AM_WFS_ISHOME", "Home" );
define( "_AM_WFS_ISREFRESH", "refresh" );
define( "_AM_WFS_ISADMINNOTICE", "Admin Notice: You need to correct this" );
define( "_AM_WFS_ISSORRYMESSAGE", "" );
define( "_AM_WFS_ISSORRYMESSAGE2", "<div><b>Sorry</b>, document <i>%s</i> is not available for editing!</div><br /><div>User %s is editing this document at the moment. Editing started at: %s </div>" );
define( "_AM_WFS_STATARTICLEID", "Articleid:" );
define( "_AM_WFS_STATTITLE", "Title:" );
define( "_AM_WFS_STATWEIGHT", "Weight:" );
define( "_AM_WFS_STATSECTION", "Under Section:" );
define( "_AM_WFS_STATAUTHOR", "Orginal Author:" );
define( "_AM_WFS_STATCREATED", "Created Date:" );
define( "_AM_WFS_STATPUBLISHED", "Published Date:" );
define( "_AM_WFS_STATPUBLISH", "Publish Date:" );
define( "_AM_WFS_STATEXPIRED", "Expire Date" );
define( "_AM_WFS_STATLASTEDITED", "On the date:" );
define( "_AM_WFS_STATLASTEDITEDBY", "Last edited By:" );
define( "_AM_WFS_STATTIMESEDITEDBYAUTHOR", "Times edited by the author:" );
define( "_AM_WFS_STATTIMESEDITEDBYLASTEDITOR", "Times edited by the last editor:" );
define( "_AM_WFS_STATTIMESEDITEDTOTAL", "Total times edited" );
define( "_AM_WFS_STATCOUNTER", "Document Read:" );
define( "_AM_WFS_STATRATING", "Document Rating:" );
define( "_AM_WFS_STATRATINGHIGH", "Highest Rating:" );
define( "_AM_WFS_STATRATINGLOW", "Lowest Rating:" );
define( "_AM_WFS_STATVOTES", "Voted times:" );
define( "_AM_WFS_STATDOWNLOADS", "Number Files Attached:" );
define( "_AM_WFS_STATCOMMENTSALLOWED", "Comments Enabled?" );
define( "_AM_WFS_STATCOMMENTS", "Total Comments:" );
define( "_AM_WFS_STATSTATUS", "Document Status:" );
define( "_AM_WFS_RELATEDART", "Related Documents Management" );

define( "_AM_WFS_RELATEDARTADMIN", "Related Documents Information" );
define( "_AM_WFS_RELATEDARTADMINTXT", "A related Document can be either WF-Sections Document or a News releated article:
<br /><li><b>Document:</b> This will take you to the document selection list.</li>
<li><b>News:</b> This will take you to the News Article selection list.</li>
" );

define( "_AM_WFS_RELATEDDOCLIST", "Related Document Selection list:
<br /><li><b>Document:</b> This will take you to the document selection list.</li>
<li><b>News:</b> This will take you to the News Article selection list.</li>
" );

define( "_AM_WFS_RELATEDNEWSLIST", "Related News Article Selection list" );
define( "_AM_WFS_RELATEDDOCUMENTLIST", "Related Document Selection list" );

define( "_AM_WFS_RELATEDNEWSLISTTXT", "
<li><b>ID:</b> ID of the listed.</li>
<li><b>Title:</b> This dispalys the title of the item in the list.</li>
<li><b>Weight:</b> This is the display order of each item. You can assign new values for each item.</li>
<li><b>Add Releted Item:</b> Checking or unchecking will add or remove an item from the related item listing.</li>
<li><b>Select All/None:</b> Quickly toggle listing items.</li>
" );

define( "_AM_WFS_RELATEDLINKLIST", "Related Links Selection list" );
define( "_AM_WFS_RELATEDLINKLISTTXT", "
<li><b>ID:</b> ID of the listed.</li>
<li><b>Title:</b> This displays the title of the item in the list.</li>
<li><b>Weight:</b> This is the display order of each item.</li>
<li><b>Add Releted Item:</b> Checking or unchecking will add or remove an item from the related item listing.</li>
<li><b>Action:</b> Peform specific tasks.</li>
" );

define( "_AM_WFS_RELATEDLINKLIST2", "Create New Releated Link" );
define( "_AM_WFS_RELATEDLINKLISTTXT2", "
<li><b>Releated Link:</b> Url Address of the link.</li>
<li><b>Related Link Name:</b> Friendly Name to display in the link listing.</li>
<li><b>Weight:</b> This is the display order of this item in the list.</li>
<li><b>Action:</b> Peform specific tasks such as edit or delete the current link.</li>
" );

define( "_AM_WFS_NO_DOCS_CREATEDYET", "No Documents have been created yet. Please create some and try again." );
define( "_AM_WFS_RELATED_DOC", "Document" );
define( "_AM_WFS_RELATED_NEWS", "News" );
define( "_AM_WFS_ADDRELATEDART", "Add Related Documents" );
define( "_AM_WFS_RELATEDITEM", "Add Releted Item" );
define( "_AM_WFS_RELATEDART_WEIGHT", "Weight" );
define( "_AM_WFS_ARTID", "ID" );
define( "_AM_WFS_SHOWALL", "Select All/None" );
define( "_AM_WFS_FAILTOSEE", "Ok? ERROR!!!! I fail to see the reason of you copying these Documents into the same Section? Do you?" );
define( "_AM_WFS_NOARTICLE", "This article does not exist" );
define( "_AM_WFS_NOARTICLESSELECTED", "No Documents Selected" );
define( "_AM_WFS_ARTICLESMOVED", "Selected Documents have been moved to new Section" );
define( "_AM_WFS_ANDMOVED", "And Move to Section:" );
define( "_AM_WFS_SELECTALLNONE", "Select All/None" );
define( "_AM_WFS_SUBMIT1", "Submitted" );
define( "_AM_WFS_VOTES", "Votes:" );
define( "_AM_WFS_SORTBY1", "Sort by:" );
define( "_AM_WFS_DATE1", "Date" );
define( "_AM_WFS_ARTICLEID1", "Document ID" );
define( "_AM_WFS_POPULARITY1", "Popularity" );
define( "_AM_WFS_CURSORTBY1", "Documents currently sorted by: " );
define( "_AM_WFS_RATING1", "Rating" );
define( "_AM_WFS_RESET", "Reset" );
define( "_AM_WFS_NOSUCHSECTION", "<b>Error</b>: No Such Section" );
define( "_AM_WFS_NOTITLESET", "No Title Set" );
define( "_AM_WFS_EDITSUBTITLE", "Document Sub Title:<div style='padding-top: 8px;'><span style='font-weight: normal;'>This text will appear in bold above the maintext in the document.</span></div>" );
define( "_AM_WFS_EDITNEWARTTITLE", "New Document" );
define( "_AM_WFS_EDITWRAPURL", "Wrap External HTML Document:" );
define( "_AM_WFS_SELECT_IMG", "Document Image:" );
define( "_AM_WFS_TOTALNUMARTS", "Total Number Documents: " );
define( "_AM_WFS_STATUSERTYPE", "Document User Type: " );
define( "_AM_WFS_DATEIN", "Editing Time Start: " );
define( "_AM_WFS_DATEOUT", "Editing Time Finished: " );
define( "_AM_WFS_DOCEDITHISTORY", "Document Edit History" );
define( "_AM_WFS_STILLEDITING", "Still Editing Document" );
define( "_AM_WFS_DOCSINEDITING", "Documents being edited" );
define( "_AM_WFS_EDITVERSION", " Increment Version On Save" );
define( "_AM_WFS_EDITVERSIONNUM", "Document Version:" );
define( "_AM_WFS_OTHEROPTIONS", "Other Options:" );
// wfs_fileshow defines
define( "_AM_WFS_ATTACHEDFILES", "Attached Files Configuration" );
define( "_AM_WFS_FILEUPLOAD", "Upload File To Document: " );
define( "_AM_WFS_ATTACHEDFILEEDITH", "Create new Upload" );
define( "_AM_WFS_ATTACHFILE", "File to Upload" );
define( "_AM_WFS_FILESHOWNAME", "File name to display" );
define( "_AM_WFS_FILEDESCRIPT", "File Description" );
define( "_AM_WFS_FILETEXT", "File Search Text" );
define( "_AM_WFS_NOT_PUBLISHED", "Not Published" );
define( "_AM_WFS_NOT_SET", "Not Set" );
define( "_AM_WFS_NOT_CHANGED", "Not Changed" );
define( "_AM_WFS_TIMES", " Times" );
define( "_AM_WFS_ONLINE", "Online" );
define( "_AM_WFS_OFFLINE", "Offline" );
define( "_AM_WFS_DISPLAYPAGES", "Display Pages: " );
define( "_AM_WFS_ARTICLERESTOREHEADING", "Document Restore Management" );
define( "_AM_WFS_ARTICLERESTOREINFO", "Document Restore Information" );
define( "_AM_WFS_ARTICLERESTORETEXT", "Restore modified documents from a backuped previous version." );
define( "_AM_WFS_RESTORE_ID", "RID" );
define( "_AM_WFS_RESTORE_DATE", "Restore Date" );
define( "_AM_WFS_RESTORE_ARTICLEID", "ArID" );
define( "_AM_WFS_RESTORE_TITLE", "Restore Title" );
define( "_AM_WFS_RESTORE_VERSION", "Version" );
define( "_AM_WFS_RESTORE_ACTION", "Action" );
define( "_AM_WFS_RESTORE_CREATED", "Created" );
define( "_AM_WFS_RESTORE_PUBLISHED", "Published" );
define( "_AM_WFS_NORESTORE", "Restore id does not exist" );
define( "_AM_WFS_NORESTORE_POINTS", "There are No Restore points for this Document" );
define( "_AM_WFS_DELETERESTORE", "Delete this restore point?" );
define( "_AM_WFS_RESTOREDELETED", "The restore point has been deleted." );
define( "_AM_WFS_ERROR_RESTOREDELETED", "Eorror occurred when deleting restore point." );
define( "_AM_WFS_FILEEXISTS", " (File Exists)" );
define( "_AM_WFS_FILEERROR", "ERROR: " );
define( "_AM_WFS_FILEERRORPLEASECHECK", " Please Check File!" );
define( "_AM_WFS_NUMBER", " NO: " );
define( "_AM_WFS_ATTACHEDARTICLE", "Files Attached To Document: " );
define( "_AM_WFS_RATINGID", "RID" );
// Uploader
define( "_AM_WFS_FILENOTFOUND", "File not found" );
define( "_AM_WFS_INVALIDFILESIZE", "Invalid file size: %s bytes" );
define( "_AM_WFS_ERRORUPLOADINGFILE", "No file has been uploaded" );
define( "_AM_WFS_INVALIDCHARCS", "Invalid chars in filename" );
define( "_AM_WFS_FAILEDUPLOADING", "Failed uploading file: " );
define( "_AM_WFS_ERRORSRETURNED", "<h4>Errors Returned While Uploading</h4>" );
define( "_AM_WFS_FILESIZEGRTMAX", "Filesize not allowed: %s (%s)<br /> Maximum allowed is: %s (%s)." );
define( "_AM_WFS_EXTNOTSAME", "File Mimetype does not match the file Extension!<br />File Mimetype: %s <br />File Extension: %s" );
// Related LINKS
define( "_AM_WFS_RELATEDLINKS", "Related Links Management" );
define( "_AM_WFS_RELATEDLINKSADMIN", "Related Link Information" );
define( "_AM_WFS_RELATEDLINKSLIST", "Related Link Listing" );
define( "_AM_WFS_ADDRELATEDLINK", "Add Related Document Link" );
define( "_AM_WFS_RELATED_URL", "Related Link" );
define( "_AM_WFS_RELATED_URLNAME", "Related Link Name" );
define( "_AM_WFS_RELATED_WEIGHT", "Weight" );
define( "_AM_WFS_ID", "ID" );
define( '_AM_WFS_NOURLFOUND', 'No Related Links' );
define( '_AM_WFS_DELETERELEATEDLINK', 'Really delete this related link?' );
define( '_AM_WFS_RELATED_DELETED', 'Related Link Deleted!' );
define( '_AM_WFS_RELATED_DBUPDATED', 'Related Link Created/Updated' );
// Reviews
define( "_AM_WFS_ADDREVIEW", "Add/Modify Review Details" );
define( "_AM_WFS_PUBLISHER", "Publisher:" );
define( "_AM_WFS_INTROTEXT", "Review Intro:" );
define( "_AM_WFS_GAMEPLAYTEXT", "Gameplay Text:" );
define( "_AM_WFS_GRAPHICSTEXT", "Graphics Text:" );
define( "_AM_WFS_MUSIC", "Music Text:" );
define( "_AM_WFS_FINALTHOUGHTS", "Final Thoughts:" );
define( "_AM_WFS_PLATFORM", "Platform:" );
define( "_AM_WFS_DEVELOPER", "Developer:" );
define( "_AM_WFS_WEBSITE", "Official Website URL:" );
define( "_AM_WFS_WEBSITEFREINDLY", "Friendly Official Website Name:" );
define( "_AM_WFS_DIFFICULTY", "Difficulty:" );
define( "_AM_WFS_RELEASED", "Date Released:" );
define( "_AM_WFS_GRADING", "Grading:" );
define( "_AM_WFS_GENRE", "Genre:" );
define( "_AM_WFS_PLAYERS", "Players:" );
define( "_AM_WFS_PLAYONLINE", "Play Online:" );
define( "_AM_WFS_ESRB", "ESRB Rating:" );
define( "_AM_WFS_LEARNINGCURVE", "Learning Curve:" );
define( "_AM_WFS_GRAPHICS", "Graphics Score:" );
define( "_AM_WFS_SOUND", "Music Score:" );
define( "_AM_WFS_GAMEPLAY", "Gameplay Score:" );
define( "_AM_WFS_CONCEPT", "Concept Design Score:" );
define( "_AM_WFS_VALUE", "Value For Money:" );
define( "_AM_WFS_TILT", "Editors Tilt:" );
define( "_AM_WFS_OVERALL", "Overall:" );
define( "_AM_WFS_CONCLUSION", "Conclusion:" );
define( "_AM_WFS_DISPLAYREVIEW", "Display this Review?" );
define( "_AM_WFS_ADD_REVIEW", "Add Review to Document" );
// Import settings
define( "_AM_WFS_IMPORT", "Bulk import document files" );
define( "_AM_WFS_IMPORTTEXT", "Bulk import HTML documents into a chosen Section:
<br /><li><b>Section Title:</b> The section title that the new imported documents will be displayed under.</li>
<li><b>Directory name or File name:</b> Directory where the HTML documents are stored.</li>" );

define( "_AM_WFS_ADD_SETTINGS", "Change Other Document Settings" );
define( "_AM_WFS_IMPORTWORD", "Import Word Document" );
define( "_AM_WFS_IMPORTWORDYES", "Com found/enabled on server. It seems you can convert word documents, but you must have word installed on your computer before you can use this feature." );
define( "_AM_WFS_IMPORTWORDNO", "Com not found/enabled on server" );
define( "_AM_WFS_CATEGORYT", "Category" );

define( "_AM_WFS_IMPORTWORDINYES", "MS Word seems to be installed on your computer and it seems you can convert a word document." );
define( "_AM_WFS_IMPORTWORDINNO", "MS Word was not found/installed on your computer." );
/**
 * Check for word
 */
define( "_AM_WFS_IMPORTWORDTXT", "Import Word Documents Check:");
define( "_AM_WFS_IMPORTCOMENABLED", "Com Enabled?");
define( "_AM_WFS_IMPORTWORDINSTALL", "MS Word Installed?");
define( "_AM_WFS_IMPORTWORDSELECT", "<b>Select Word Document:</b> Select a Word Document for uploading and importing.");
define( "_AM_WFS_WORDNOTINSTALLED", "Your server or computer does not meet the requirements to convert MS Word documents." );

define( "_AM_WFS_IMPORTPDF", "Import PDF Document" );
define( "_AM_WFS_IMPORTPDFSELECT", "<b>Select PDF Document:</b> Select a PDF Document for uploading and importing.");
define( "_AM_WFS_EDITPDFBROWSE", "Select PDF Document" );
define( "_AM_WFS_EDITPDFFILE", "2a. PDF Document:<div style='padding-top: 8px;'><span style='font-weight: normal;'>This document will be used as the maintext of the page.</span></div>" );

define( "_AM_WFS_EDITDRAFT", "Save as Draft Document?" );
define( "_AM_WFS_IMPORT_DIRNAME", "Directory name or File name" );
define( "_AM_WFS_IMPORT_HTMLPROC", "Process HTML files" );
define( "_AM_WFS_IMPORT_EXTFILTER", "External filter program name" );
define( "_AM_WFS_IMPORT_BODY", "Import body part of HTML file" );
define( "_AM_WFS_IMPORT_INDEXHTML", "Delete a link to index.html, there are in the same directory or in one upper directory." );
define( "_AM_WFS_IMPORT_LINK", "Change a link to a title = file name" );
define( "_AM_WFS_IMPORT_IMAGE", "Change a link of an image file into an image directory. " );
define( "_AM_WFS_IMPORT_ATMARK", "Change @ to &amp;#064;" );
define( "_AM_WFS_IMPORT_TEXTPROC", "Process Text files" );
define( "_AM_WFS_IMPORT_TEXTPRE", "Surround Text file by &lt;pre&gt; &lt;/pre&gt;" );
define( "_AM_WFS_IMPORT_IMAGEPROC", "Processing of Image files" );
define( "_AM_WFS_IMPORT_IMAGEDIR", "Image directory name" );
define( "_AM_WFS_IMPORT_IMAGECOPY", "Copy image files to a image directory." );
define( "_AM_WFS_IMPORT_TESTMODE", "Test mode" );
define( "_AM_WFS_IMPORT_TESTDB", "Not store in DB. Please remove a check, when you store. " );
define( "_AM_WFS_IMPORT_TESTEXEC", "Test" );
define( "_AM_WFS_IMPORT_TESTTEXT", "Text display" );
define( "_AM_WFS_IMPORT_EXPLANE", "A judgment of the kind of file is performed by the extension.<br>HTML file have extension of html or htm.<br>Text file have extension of txt.<br>Image file have extension of gif, jpg, jpeg, or png.<br>" );
define( "_AM_WFS_IMPORT_ERRDIREXI", "Directory or file does not exist" );
define( "_AM_WFS_IMPORT_ERRFILEXI", "Filter program does not exist" );
define( "_AM_WFS_IMPORT_ERRFILEXEC", "Filter program is not executable" );
define( "_AM_WFS_IMPORT_ERRNOCOPY", "No specification of image copy" );
define( "_AM_WFS_IMPORT_ERRNOIMGDIR", "No specification of image directory" );
define( "_AM_WFS_IMPORT_ERRIMGDIREXI", "Specified image directory is not directory" );
define( "_AM_WFS_IMPORT_ERRFILEEXI", "File does not exist" );
define( "_AM_WFS_ARTRESTORENOTACT", "This feature has not been activated yet." );
define( "_AM_WFS_ERRORFILEALLREADYEXISITS", "File already exists on the server." );
// define("_AM_WFS_RELATEDARTS", "Related Documents Listing");
// define("_AM_WFS_RELATEDNEWS", "Related News Listing");
define( "_AM_WFS_ATTACHEDFILESADMIN", "Edit Attached File Admin" );
define( "_AM_WFS_ATTACHEDFILEPREVIEW", "File Preview" );
define( "_AM_WFS_ATTACHEDFILESTAS", "File Stats" );
define( "_AM_WFS_ATTACHEDFILEEDIT", "File Edit" );
define( "_AM_WFS_ATTACHEDFILEACCESS", "Allow Access For:" );
// Document Spotlight
define( "_AM_WFS_DOCSPOTLIGHTHEADING", "Document Spotlight Management" );
define( "_AM_WFS_DOCSPOTLIGHTINFO", "Document Spotlight Information" );
define( "_AM_WFS_DOCSPOTLIGHTTEXT", "To set an article diplaying in the spotlight block:
<li>Spotlight Image</li>
<li>Spotlight Image max width</li>
<li>Spotlight Image max height</li>
<li>Spotlight document max length</li>
<li>Summary Text Type</li>
<li>Spotlight document: always use the last published article or choose an article</li>
" );
define( "_AM_WFS_DOCSPOTLIGHTFORM", "Spotlight Form" );
define( "_AM_WFS_DOCSPOTLIGHTDOC", "Spotlight Document:" );
define( "_AM_WFS_DOCSPOTLIGHTIMAGE", "Spotlight Preview:" );
define( "_AM_WFS_USE_LASTPUBLISHED", " Use last published article" );
define( "_AM_WFS_CURRENT_SPOT", "Current spotlight article" );
define( "_AM_WFS_OTHERWISE_CHOOSEANARTICLE", "or choose an article from following" );
define( "_AM_WFS_SPOTIT", "Check" ); // select it as spotlight document
define( "_AM_WFS_SPOTIMAGE_MAXWIDTH", "Max Spotlight Width Image:" );
define( "_AM_WFS_SPOTIMAGE_MAXHEIGHT", "Max Spotlight Height Image:" );
define( "_AM_WFS_SPOTDOCUMENT_MAXLENGTH", "Max length of Spotlight Text Area:<div style='padding-top: 8px;'><span style='font-weight: normal;'>The size of the text paragraph in words/letters. A setting of 0 will keep orginal length.</span></div>" );
define( "_AM_WFS_SPOTDOCUMENT_SUMTYPE", "Summary Text Type:" );
define( "_AM_WFS_SPOTDOCUMENT_SUBTITLE", "Document Sub Title" );
define( "_AM_WFS_SPOTDOCUMENT_SUMMARY", "Document Summary" );
define( "_AM_WFS_SPOTDOCUMENT_MAINTEXT", "Document Maintext" );
// index.php
define( "_AM_WFS_ARTICLENOTEXIST", "Error: Document doesn't Exist" );
define( "_AM_WFS_NOT_WORDDOC", "Error: This is not a MS WORD document" );
define( "_AM_WFS_NO_FORUM", "No Forum Selected" );
define( "_AM_WFS_CHECKIN_FAILED", "Document Checkin failed" );
define( "_AM_WFS_SERVERSTATS", "Server Status" );
define( "_AM_WFS_SPHPINI", "<b>Information taken from PHP ini File:</b>" );
define( "_AM_WFS_SAFEMODESTATUS", "Safe Mode Status: " );
define( "_AM_WFS_REGISTERGLOBALS", "Register Globals: " );
define( "_AM_WFS_MAGICQUOTESGPC", "Magic_quotes State For GPC : " );
define( "_AM_WFS_SERVERUPLOADSTATUS", "Server Uploads Status: " );
define( "_AM_WFS_MAXUPLOADSIZE", "Max Upload Size Permitted: " );
define( "_AM_WFS_MAXPOSTSIZE", "Max Post Size Permitted: " );
define( "_AM_WFS_SAFEMODEPROBLEMS", " (This May Cause Problems)" );
define( "_AM_WFS_GDLIBSTATUS", "GD Library Support: " );
define( "_AM_WFS_GDLIBVERSION", "GD Library Version: " );
define( "_AM_WFS_GDON", "<b>Enabled</b> (Thumbs Nails Available)" );
define( "_AM_WFS_GDOFF", "<b>Disabled</b> (No Thumb Nails Available)" );
define( "_AM_WFS_OFF", "<b>OFF</b>" );
define( "_AM_WFS_ON", "<b>ON</b>" );
define( "_AM_WFS_ZLIBCOMPRESSION", "ZLib Compression:" );
define( "_AM_WFS_MAXINPUTTIME", "Max Input Time:" );
define( "_AM_WFS_FOPENURL", "FOpen URL:" );

define( "_AM_WFS_EXT", "Extension:" );
define( "_AM_WFS_UPDATEDATE", "Last Update:" );
define( "_AM_WFS_DOWNLOADNAME", "Download Name:" );
define( "_AM_WFS_FILEREALNAME", "Stored Name:" );
define( "_AM_WFS_ARTICLEID", "Article ID:" );
define( "_AM_WFS_DESCRIPTION", "File description" );
define( "_AM_WFS_NODESCRIPT", "No description for file." );
define( "_AM_WFS_ERRORCHECK", "File Check:" );
define( "_AM_WFS_ADD_STATUS", "View Status of Document" );
define( "_AM_WFS_FILEPERMISSION", "File Permission:" );
define( "_AM_WFS_DOWNLOADED", "Downloaded times:" );
define( "_AM_WFS_DOWNLOADSIZE", "Download Size:" );
define( "_AM_WFS_LASTACCESS", "Last Access Date:" );
define( "_AM_WFS_LASTUPDATED", "Last Updated On:" );
define( "_AM_WFS_DEL", "Delete" );
// Mimetypes
define( "_AM_WFS_MMIMETYPES", "Mimetypes Management" );
define( "_AM_WFS_MIME_ID", "ID" );
define( "_AM_WFS_MIME_EXT", "EXT" );
define( "_AM_WFS_MIME_NAME", "Application Type" );
define( "_AM_WFS_MIME_ADMIN", "Admin" );
define( "_AM_WFS_MIME_USER", "User" );
// Mimetype Form
define( "_AM_WFS_MIME_CREATEF", "Create Mimetype" );
define( "_AM_WFS_MIME_MODIFYF", "Modify Mimetype" );
define( "_AM_WFS_MIME_EXTF", "File Extension:" );
define( "_AM_WFS_MIME_NAMEF", "Application Type/Name:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter application associated with this extension.</span></div>" );
define( "_AM_WFS_MIME_TYPEF", "Mimetypes:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter each mimetype associated with the file extension. Each mimetype must be seperated with a space.</span></div>" );
define( "_AM_WFS_MIME_ADMINF", "Allowed Admin Mimetype" );
define( "_AM_WFS_MIME_ADMINFINFO", "<b>Mimetypes that are available for Admin uploads:</b>" );
define( "_AM_WFS_MIME_USERF", "Allowed User Mimetype" );
define( "_AM_WFS_MIME_USERFINFO", "<b>Mimetypes that are available for User uploads:</b>" );
define( "_AM_WFS_MIME_NOMIMEINFO", "No mimetypes selected." );
define( "_AM_WFS_MIME_FINDMIMETYPE", "Find New Mimetype:" );
define( "_AM_WFS_MIME_EXTFIND", "Search File Extension:<div style='padding-top: 8px;'><span style='font-weight: normal;'>Enter file extension you wish to search.</span></div>" );
define( "_AM_WFS_MIME_INFOTEXT", "<ul><li>New mimetypes can be created, edit or deleted easily via this form.</li>
	<li>Search for a new mimetypes via an external website.</li>
	<li>View displayed mimetypes for Admin and User uploads.</li>
	<li>Change mimetype upload status.</li></ul>
	" );
// Mimetype Buttons
define( "_AM_WFS_MIME_CREATE", "Create" );
define( "_AM_WFS_MIME_CLEAR", "Reset" );
define( "_AM_WFS_MIME_CANCEL", "Cancel" );
define( "_AM_WFS_MIME_MODIFY", "Modify" );
define( "_AM_WFS_MIME_DELETE", "Delete" );
define( "_AM_WFS_MIME_FINDIT", "Get Extension!" );
// Mimetype Database
define( "_AM_WFS_MIME_DELETETHIS", "Delete Selected Mimetype?" );
define( "_AM_WFS_MIME_MIMEDELETED", "Mimetype %s has been deleted" );
define( "_AM_WFS_MIME_CREATED", "Mimetype Information Created" );
define( "_AM_WFS_MIME_MODIFIED", "Mimetype Information Modified" );

define( "_AM_WFS_GL_WEIGHTON", "<br />Global Weight On" );
define( "_AM_WFS_GL_WEIGHTOFF", "<br />Global Weight Off" );
define( "_AM_WFS_DOCUMENTTYPES", "There are three different document types to choose as your Maintext. <br />If more than one document type has been selected, then the highest priority type will be shown first. (1 = Highest)" );
define( "_AM_WFS_DOCUMENTTYPE", "<b>Document Types</b>" );
define( "_AM_WFS_BIGUESER", "ON is suggested for Big5 users" );

?>
