<?php 
// $Id: wfsfiles.php,v 1.4 2004/08/13 12:46:08 phppp Exp $
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

class WfsFiles
{
    var $db;
    var $table;
    var $fileid;
    var $articleid;
    var $filerealname;
    var $fileshowname;
    var $filetext;
    var $filedescript;
    var $date;
    var $ext;
    var $mimetype;
    var $downloadname;
    var $counter;
    var $groupid;
    var $submit = 0;
    var $uid; 
    
	/*
	*  constructor
	*/ 
    function WfsFiles($fileid = -1)
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix(WFS_FILES_DB);
        $this->articleid = 0;
        $this->filerealname = "";
        $this->fileshowname = "";
        $this->filetext = "";
        $this->filedescript = "";
        $this->date = "";
        $this->ext = "";
        $this->mimetype = "";
        $this->downloadname = "";
        $this->counter = 0;
        if (is_array($fileid))
        {
            $this->makeFile($fileid);
        }elseif ($fileid != -1)
        {
            $this->getFile($fileid);
        }
    }

    function setFileRealName($filename)
    {
        $this->filerealname = $filename;
    }

    function setFileShowName($filename)
    {
        $this->fileshowname = $filename;
    }

    function setArticleid($id)
    {
        $this->articleid = $id;
    }

    function setFiletext($text)
    {
        $this->filetext = $text;
    }

    function setFiledescript($descript)
    {
        $this->filedescript = $descript;
    }

    function setMimetype($value)
    {
        $this->mimetype = $value;
    }

    function setExt($value)
    {
        $this->ext = $value;
    }

    function setDownloadname($value)
    {
        $this->downloadname = $value;
    }

    function setgroupid($value)
    {
        $this->groupid = wfs_saveAccess($value);
    }
    function setSubmit($value)
    {
        $this->submit = $value;
    }
    function setUid($value)
    {
        $this->uid = $value;
    }

    function setByUploadFile(& $uploader, $tag = "")
    {
        global $xoopsModule, $xoopsModuleConfig;

        if(is_array($tag)) $this->$tag[0] = $uploader->{"get".$tag[1]}();
        else{
	        $this->filerealname = $uploader->getSavedFileName();
	        $this->ext = $uploader->getExt();
	        $this->mimetype = $uploader->getMediaType();
	        $this->downloadname = $uploader->getMediaName();
            $this->fileshowname = $uploader->getMediaName();
	        
	        $this->setFileTextByFile();
	    }
    }

    function setFileTextByFile()
    {
        global $WfsHelperDir, $xoopsModule, $xoopsConfig;

        if (preg_match("/^\/|~[ABCDEFGHIJKLMNOPQRSTQVWXYZ]:\//", $this->filerealname))
        {
            $filename = $this->filerealname;
        }
        else
        {
            $filename = WFS_FILE_PATH . "/" . $this->filerealname;
        } 
        // helper app & character set convertor
        if (file_exists(WFS_ROOT_PATH . "/language/" . $xoopsConfig['language'] . "/convert.php"))
        {
            $langdir = WFS_ROOT_PATH . "/language/" . $xoopsConfig['language'];
        }
        else
        {
            $langdir = WFS_ROOT_PATH . "/language/english";
        }

        include_once($langdir . "/convert.php");

        switch ($this->mimetype)
        {
            case "text/plain":
                $this->filetext = join(' ', file($filename));
                $this->filetext = WfsConvert::TextPlane($this->filetext);
                break;
            case "text/html":
                $this->filetext = join(' ', file($filename));
                $this->filetext = WfsConvert::TextHtml($this->filetext);
                break;
            case "application/vnd.ms-excel":
                if (!empty($WfsHelperDir['application/vnd.ms-excel']))
                {
                    exec(WFS_ROOT_PATH . "/helper/" . $WfsHelperDir['application/vnd.ms-excel'] . "/xlhtml -te " . $filename, $ret);
                    $this->filetext = join(' ', $ret);
                    $this->filetext = WfsConvert::TextHtml($this->filetext);
                }
                break;
            case "application/pdf":
                if (!empty($WfsHelperDir['application/pdf']))
                {
                    $distfile = tempnam(WFS_FILE_PATH . "/temp/", "pdf");
                    exec(WFS_ROOT_PATH . "/helper/" . $WfsHelperDir['application/pdf'] . "/pdftotext " . "-cfg " . $langdir . "/xpdfrc " . $filename . " " . $distfile);
                    $this->filetext = join(' ', file($distfile));
                    $this->filetext = WfsConvert::stripSpaces($this->filetext);
                    unlink($distfile);
                }
                break;
            case "default":
            default:
                $this->filetext = "";
        }
    }

    function getFileShowName($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $smiley = 1;
        switch ($format)
        {
            case "S":
        		$fileshowname = ($this->fileshowname)?$this->fileshowname:$this->filerealname;
                $fileShowName = $myts->makeTboxData4Show($fileshowname, $smiley);
                break;
            case "E":
                $fileShowName = $myts->makeTboxData4Edit($this->fileshowname);
                break;
        }
        return $fileShowName;
    }

    function getFileRealName($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $smiley = 0;
        switch ($format)
        {
            case "S":
                $filerealname = $myts->makeTboxData4Show($this->filerealname, $smiley);
                break;
            case "E":
                $filerealname = $myts->makeTboxData4Edit($this->filerealname);
                break;
        }
        return $filerealname;
    }

    function getExt($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $smiley = 0;
        switch ($format)
        {
            case "S":
            	$ext = ($this->ext)?$this->ext:wfs_getFileExtension($this->filerealname);
                $fileext = $myts->makeTboxData4Show($this->ext, $smiley);
                break;
            case "E":
                $fileext = $myts->makeTboxData4Edit($this->ext);
                break;
        }
        return $fileext;
    }

    function getMimetype($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $smiley = 0;
        switch ($format)
        {
            case "S":
                $filemimetype = $myts->makeTboxData4Show($this->mimetype, $smiley);
                break;
            case "E":
                $filemimetype = $myts->makeTboxData4Edit($this->mimetype);
                break;
        }
        return $filemimetype;
    }

    function getFileText($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $smiley = 0;
        switch ($format)
        {
            case "S":
                $filetext = $myts->makeTareaData4Show($this->filetext, $smiley);
                break;
            case "E":
                $filetext = $myts->makeTareaData4Edit($this->filetext);
                break;
        }
        return $filetext;
    }

    function getFiledescript($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $html = 1;
        $smiley = 1;
        $xcodes = 1;

        switch ($format)
        {
            case "S":
                $filedescript = $myts->makeTareaData4Show($this->filedescript, $html, $smiley, $xcodes);
                break;
            case "E":

                $filedescript = $myts->makeTareaData4Edit($this->filedescript);
                break;
        }
        return $filedescript;
    }

    function getDownloadname($format = "S")
    {
        $myts = &MyTextSanitizer::getInstance();
        $smiley = 0;
        switch ($format)
        {
            case "S":
            	$downloadname = ($this->downloadname)?$this->downloadname:$this->fileid.".".$this->ext;
                $filedownname = $myts->makeTboxData4Show($downloadname, $smiley);
                break;
            case "E":
                $filedownname = $myts->makeTboxData4Edit($this->downloadname);
                break;
        }
        return $filedownname;
    }

    function getFileid()
    {
        return $this->fileid;
    }

    function getLinkedName($funcURL)
    {
        $myts = &MyTextSanitizer::getInstance();
        $linked_url = "<a href='" . $funcURL . "/download.php?fileid=" . $this->fileid . "'>" . $myts->makeTboxData4Show($this->getFileShowName()) . "</a>";
        return $linked_url;
    }

    function getArticleid()
    {
        return $this->articleid;
    }

    function getCounter()
    {
        return $this->counter;
    }

    function getSubmit()
    {
        return $this->submit;
    }

    function getAllfiles($limit = 10, $start = 0, $articleid = 0, $uid = 0, $orderby = "fileid DESC", $asobject = true)
    {
		$db = &Database::getInstance();
        $myts = &MyTextSanitizer::getInstance();

        $ret = array();
        $sql = "SELECT * FROM " . $db->prefix(WFS_FILES_DB) . " WHERE articleid > 0";
        if ($articleid > 0)
        {
            $sql .= " AND articleid=" . $articleid . " ";
        }
        if ($uid > 0)
        {
            $sql .= " AND uid=" . $uid . " ";
        }
        $sql .= " ORDER BY " . $orderby . " ";

        $result = $db->query($sql, $limit, $start);
        while ($myrow = $db->fetchArray($result))
        {
            if (!wfs_checkAccess($myrow['groupid']))
                Continue;
            if ($asobject)
            {
                $ret[] = new WfsFiles($myrow);
            }
            else
            {
                $ret[$myrow['fileid']] = $myts->makeTboxData4Show($myrow['filerealname']);
            }
        }
        return $ret;
    }

    function getfilecount($articleid = 0, $uid = 0)
    {
        $db = &Database::getInstance();
        $myts = &MyTextSanitizer::getInstance();

        $ret = array();
        $sql = "SELECT * FROM " . $db->prefix(WFS_FILES_DB) . " WHERE articleid != 0";
        if ($articleid > 0)
            $sql .= " AND articleid= $articleid ";
        if ($uid > 0)
            $sql .= " AND uid= $uid ";
        $count = 0;
		$result = $db->query($sql);
        while ($myrow = $db->fetchArray($result))
        {
            if (!wfs_checkAccess($myrow['groupid'])) Continue;
			$count++;	
        } 
 
        //$ret = $db->getRowsNum($result);
        return $count;
    } 
    // database
    function getFile($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE fileid=" . $id . " ";
        $array = $this->db->fetchArray($this->db->query($sql));
        $this->makeFile($array);
    }

    function makeFile($array)
    {
        if (!is_array($array))
        {
            return false;
        }
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }

    function store()
    {
        $myts = &MyTextSanitizer::getInstance();
        $fileRealName = $myts->makeTboxData4Save($this->filerealname);
        $fileShowName = $myts->censorString($this->fileshowname);
        $fileShowName = $myts->makeTboxData4Save($fileShowName);
        $filetext = $myts->makeTboxData4Save($this->filetext);
        $filedescript = $myts->makeTboxData4Save($this->filedescript);
        $downloadname = $myts->makeTboxData4Save($this->downloadname);
        $submit = $myts->makeTboxData4Save($this->submit);
        $groupid = wfs_saveAccess($this->groupid);
        $date = time();
        $ext = $myts->makeTboxData4Save($this->ext);
        $mimetype = $myts->makeTboxData4Save($this->mimetype);
        $counter = intval($this->counter);
        $articleid = $this->articleid;
        $uid = $this->uid;
        
        if(!$fileRealName) {
	        echo "<br />No file name";
            return false;
        }

        if (!isset($this->fileid))
        {
	        //echo "<br />articleid:$articleid";
            $newid = $this->db->genId($this->table . "_fileid_seq");
            $sql = "INSERT INTO " . $this->table . " (fileid, articleid, filerealname, fileshowname, filetext, filedescript, date, ext, mimetype, downloadname, counter, groupid, submit, uid) VALUES (" . $newid . "," . $articleid . ",'" . $fileRealName . "','" . $fileShowName . "','" . $filetext . "','" . $filedescript . "'," . $date . ",'" . $ext . "','" . $mimetype . "','" . $downloadname . "'," . $counter . ",'" . $groupid . "'," . $submit . ", " . $uid . ")";
        }
        else
        {
            $sql = "UPDATE " . $this->table . " SET 
            	articleid=" . $articleid . ",
            	filerealname='" . $fileRealName . "',
            	fileshowname='" . $fileShowName . "',
            	filetext='" . $filetext . "', 
            	filedescript='" . $filedescript . "',
            	date=" . $date . ",
            	ext='" . $ext . "',
            	mimetype='" . $mimetype . "',
            	downloadname='" . $downloadname . "', 
            	groupid='" . $groupid . "', 
            	submit=" . $submit . " ,
            	counter=" . $counter . ", 
            	uid = " . $uid . " 
            	WHERE fileid=" . $this->fileid . "";
        }
        if (!$result = $this->db->query($sql))
        {
	        echo "<br />wsfile->store() error, sql:".$sql;
            exit();
			return false;
        }
        return true;
    }

    function delete()
    {
        global $WfsHelperDir, $xoopsModule, $xoopsConfig, $xoopsModuleConfig;

        $sql = "DELETE FROM " . $this->table . " WHERE fileid=" . $this->fileid . "";
        if (!$result = $this->db->query($sql))
        {
            return false;
        }
        if (is_file(WFS_FILE_PATH . "/" . $this->filerealname)) unlink(WFS_FILE_PATH . "/" . $this->filerealname);
        return true;
    }

    function updateCounter()
    {
        $sql = "UPDATE " . $this->table . " SET counter=counter+1 WHERE fileid=" . $this->fileid . "";
        if (!$result = $this->db->queryF($sql))
        {
            return false;
        }
        return true;
    } 
    // HTML output
    function editform()
    {
        global $xoopsModule, $xoopsModuleConfig, $xoopsDB;

        include XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

        $article = new WfsArticle($this->articleid);
        $filename = $this->getFileRealName();

        xoops_cp_header();

        wfs_admin_menu(_AM_WFS_ATTACHEDFILEM);

        $file_size = (is_file(WFS_FILE_PATH . "/" . $filename)) ? wfs_myfilesize(WFS_FILE_PATH . "/" . $filename) : 0;

		echo "<h4>" . _AM_WFS_ATTACHEDFILEPREVIEW . "</h4>";
        	echo "<table width='100%' cellspacing = 1 cellpadding = '2' class = outer>";
        	echo "<tr>";
        	echo "<td colspan='3' class='head' align='left' valign ='middle'><img src=" . WFS_IMAGES_URL . "/icon/download.gif align ='absmiddle'> " . $this->getLinkedName(WFS_ROOT_URL . "/download.php?fileid=") . "</td>";
       		echo "</tr>";
        	echo "<tr >";
        	echo "<td  class='odd' align='left' colspan='3'>";
        	echo "<div align= 'top'>";
        $fdesc = ($this->filedescript)?$this->getFiledescript('S'): _AM_WFS_NODESCRIPT;
        	echo"<img src='" . WFS_IMAGES_URL . "/icon/desc.gif' border='0' alt='' align='absmiddle'/>&nbsp;<b>" . _AM_WFS_DESCRIPTION . ":</b><br>" . $fdesc . "</div><br /></td>";
        	echo "</tr>";
        echo "<tr>";

        $mimeicon = wfs_getIcon($filename);
		echo "<td colspan='2' class='even' align='left'>
			<img src='" . WFS_IMAGES_URL . "/icon/download.gif' border='0' alt='downloads' align='absmiddle'/>&nbsp;" . $this->getCounter() . "&nbsp;&nbsp;
			<img src='" . WFS_IMAGES_URL . "/icon/size.gif' border='0' align='absmiddle' alt='" . _AM_WFS_FILESIZE . "' />&nbsp;" . $file_size . "&nbsp;&nbsp;
			<img src='" . WFS_IMAGES_URL . "/icon/".$mimeicon."' border='0' align='absmiddle' alt='" . _AM_WFS_FILEMIMETYPE . "' />".$this->getMimetype()."</td>
			<td class='even' align='right' valign ='middle'><b>" . _AM_WFS_UPLOADED . "</b>" . formatTimestamp($this->date, $xoopsModuleConfig['timestamp']) . "</td>";
        echo "</tr>";
        echo "</table>";
		
        $atitle = "<a href='" . WFS_ROOT_URL . "/article.php?articleid=" . $this->articleid . "'>" . $article->title . "</a>";

        $stform = new XoopsThemeForm(_AM_WFS_FILESTATS, "op", xoops_getenv('PHP_SELF'));

        echo "<h4>" . _AM_WFS_ATTACHEDFILESTAS . "</h4>";
        $stform->addElement(new XoopsFormLabel(_AM_WFS_FILESTAT, $atitle));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_FILEID, _AM_WFS_NUMBER . $this->fileid));
        if (file_exists(realpath(WFS_FILE_PATH . "/" . $this->filerealname)))
        {
            $error = $this->filerealname . _AM_WFS_FILEEXISTS;
        }
        else
        {
            $error = "" . _AM_WFS_FILEERROR . " <b>" . $this->filerealname . "</b>" . _AM_WFS_FILEERRORPLEASECHECK . "";
        }

        $stform->addElement(new XoopsFormLabel(_AM_WFS_ERRORCHECK, $error));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_FILESHOWNAME, $this->getLinkedName(XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/download.php?fileid=")));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_FILEREALNAME, $this->getFileRealName("E")));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_DOWNLOADNAME, $this->getDownloadname("E")));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_MIMETYPE, $this->getMimetype("E")));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_EXT, $this->getExt("E")));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_FILEPERMISSION, wfs_get_perms(WFS_FILE_PATH . "/" . $this->getFileRealName("E"))));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_DOWNLOADED, $this->getCounter("E") . " times"));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_DOWNLOADSIZE, $file_size));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_LASTACCESS, wfs_lastaccess(WFS_FILE_PATH . "/" . $this->filerealname, 'E1')));
        $stform->addElement(new XoopsFormLabel(_AM_WFS_LASTUPDATED, formatTimestamp($this->date, $xoopsModuleConfig['timestamp'])));
        $stform->display();

		//        $sform = new XoopsThemeForm(_AM_WFS_MODIFYFILE, "op", xoops_getenv('PHP_SELF'));
        echo "<h4>" . _AM_WFS_ATTACHEDFILEEDIT . "</h4>";

        $sform = new XoopsThemeForm(_AM_WFS_ATTACHEDFILEEDITH, "op", xoops_getenv('PHP_SELF'));
        $sform->addElement(new XoopsFormSelectGroup(_AM_WFS_ATTACHEDFILEACCESS, 'groupid', true, wfs_getGroupIda($this->groupid), 5, true));
        $sform->addElement(new XoopsFormLabel(_AM_WFS_FILEID, _AM_WFS_NUMBER . $this->fileid));
        $sform->addElement(new XoopsFormText(_AM_WFS_FILEREALNAME, 'filerealname', 40, 40, $this->getFileRealName("E")));
        $sform->addElement(new XoopsFormText(_AM_WFS_DOWNLOADNAME, 'downloadname', 40, 40, $this->getDownloadname("E")));
        $sform->addElement(new XoopsFormText(_AM_WFS_FILESHOWNAME, 'fileshowname', 40, 80, $this->getFileShowName("E")));
        $sform->addElement(new XoopsFormLabel(_AM_WFS_ARTICLEID, $this->articleid));

        ob_start();
		$cattree = new XoopsTree($xoopsDB->prefix("wfs_article"), "articleid", 0);
        $catarray = $cattree->makeMySelBox("title", "title", $this->articleid , 1);
        $sform->addElement(new XoopsFormLabel(_AM_WFS_MOVETOART, ob_get_contents()));
        ob_end_clean();

        $sform->addElement(new XoopsFormDhtmlTextArea(_AM_WFS_FILEDESCRIPT, 'textfiledescript', $this->getFiledescript("E"), 10, 60));
        $sform->addElement(new XoopsFormTextArea(_AM_WFS_FILETEXT, 'filetext', $this->getFileText("E")));
        $sform->addElement(new XoopsFormText(_AM_WFS_EXT, 'ext', 30, 80, $this->getExt("E")));
        $sform->addElement(new XoopsFormText(_AM_WFS_MIMETYPE, 'mimetype', 40, 80, $this->getMimetype("E")));
        $sform->addElement(new XoopsFormLabel(_AM_WFS_UPDATEDATE, formatTimestamp($this->date, $xoopsModuleConfig['timestamp'])));

        $sform->addElement(new XoopsFormHidden('uid', $this->uid));
        
        $sform->addElement(new XoopsFormHidden('submit', $this->submit));
        if ($this->submit == 0)
        {
            $submit_radio = new XoopsFormRadioYN(_AM_WFS_APPROVE, 'submit', '', '' . _AM_WFS_YES . '', ' ' . _AM_WFS_NO . '');
            $sform->addElement($submit_radio);
        }
        $sform->addElement(new XoopsFormHidden('fileid', $this->fileid));

        $button_tray = new XoopsFormElementTray('', '');
        $button_tray->addElement(new XoopsFormHidden('op', 'filesave'));
        //$button_tray->addElement(new XoopsFormHidden('articleid', $this->articleid));

        $butt_save = new XoopsFormButton('', '', _AM_WFS_SAVECHANGE, 'submit');
        $butt_save->setExtra('onclick="this.form.elements.op.value=\'filesave\'"');
        $button_tray->addElement($butt_save);

        $butt_delete = new XoopsFormButton('', '', _AM_WFS_DEL, 'submit');
        $butt_delete->setExtra('onclick="this.form.elements.op.value=\'delfile\'"');
        $button_tray->addElement($butt_delete);

        $butt_cancel = new XoopsFormButton('', '', _AM_WFS_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="javascript:history.go(-1)"');
        $button_tray->addElement($butt_cancel);
        $sform->addElement($button_tray);
        $sform->display();
        unset($hidden);
        clearstatcache();
    }

    function loadPostVars()
    {
        global $_POST;
        $this->setArticleid($_POST['articleid']);
        $this->setFiledescript($_POST['textfiledescript']);
        $this->setGroupid($_POST['groupid']);
        $this->setSubmit($_POST['submit']);
        $this->setUid($_POST['uid']);

        if(isset($_POST['fileshowname'])&& $_POST['fileshowname']) $this->setFileShowName($_POST['fileshowname']);
        if(isset($_POST['filetext'])&& $_POST['filetext']) $this->setFiletext($_POST['filetext']);
        if(isset($_POST['mimetype'])&& $_POST['mimetype']) $this->setMimetype($_POST['mimetype']);
        if(isset($_POST['ext'])&& $_POST['ext']) $this->setExt($_POST['ext']);
        if(isset($_POST['downloadname'])&& $_POST['downloadname']) $this->setDownloadname($_POST['downloadname']);
    }
}

?>