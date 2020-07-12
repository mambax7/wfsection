<?php
// $Id: wfsindex.php,v 1.4 2004/08/13 12:46:08 phppp Exp $
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

class WfsIndex
{
    var $db;
    var $indid;
    var $table;
    var $pagename = "";
    var $indeximage = "blank.png";
    var $indexheading = "";
    var $indexheader = "";
    var $indexfooter = "";
    var $nohtml = 0;
    var $nosmileys = 0;
    var $noxcodes = 0;
    var $noimages = 0;
    var $nobreaks = 1;
    var $indexheaderalign = "left";
    var $indexfooteralign = "left";
    var $isdefault = 0;

    function WfsIndex($indid = 0)
    {
        $this->db = &Database::getInstance();
        $this->table = $this->db->prefix(WFS_INDEXPAGE);
        if (is_array($indid))
        {
            $this->makeIndex($indid);
        }elseif ($indid != 0)
        {
            $this->loadIndex($indid);
        }
        else
        {
            $this->indid = $indid ;
        }
    }

    function loadIndex($indid)
    {
        $sql = sprintf("SELECT * FROM " . $this->table . " WHERE indid=" . $indid . "");
        $error = "Error while creating wfsection pages: <br /><br />" . $sql;
        if (!$result = $this->db->query($sql))
        {
            trigger_error($error, E_USER_ERROR);
        }

        $array = $this->db->fetchArray($this->db->query($sql));
        $this->makeIndex($array);
    }

    function makeIndex($array)
    {
        foreach($array as $key => $value)
        {
            $this->$key = $value;
        }
    }

    /**
     * Code to setup and clean items before saving to database
     */
    function setPagename($value)
    {
        $this->pagename = (isset($value) && !empty($value)) ? xoops_trim($value) : AM_NOTITLESET ;
    }
    function setIndexheading($value)
    {
        $this->indexheading = (isset($value) && !empty($value)) ? xoops_trim($value) : AM_NOTITLESET ;
    }
    function setIndeximage($value)
    {
        $this->indeximage = (!empty($value) && $value != 'blank.png') ? xoops_trim($value) : '';
    }
    function setIndexheader($value, $strip = 0)
    {
        $this->indexheader = $value;
        if ($strip)
        {
            $this->indexheader = &wfs_strip_tags($this->indexheader);
        }
    }
    function setIndexfooter($value, $strip = 0)
    {
        $this->indexfooter = $value;
        if ($strip)
        {
            $this->indexfooter = &wfs_strip_tags($this->indexfooter);
        }
    }
    function setIndexheaderalign($value)
    {
        $this->indexheaderalign = (!empty($value)) ? xoops_trim($value) : "left" ;
    }
    function setIndexfooteralign($value)
    {
        $this->indexfooteralign = (!empty($value)) ? xoops_trim($value) : "left" ;
    }

    function setIsdefault($value)
    {
        $this->isdefault = (isset($value) && $value == 1) ? 1 : 0 ;
    }

    function setHtml($value = 0)
    {
        $this->nohtml = (isset($value) && $value == 1) ? 1 : 0;
    }
    function setSmileys($value = 0)
    {
        $this->nosmileys = (isset($value) && $value == 1) ? 1 : 0;
    }
    function setXcodes($value = 0)
    {
        $this->noxcodes = (isset($value) && $value == 1) ? 1 : 0;
    }
    function setBreaks($value = 1)
    {
        $this->nobreaks = (isset($value) && $value == 1) ? 1 : 0;
    }
    function setImages($value = 0)
    {
        $this->noimages = (isset($value) && $value == 1) ? 1 : 0;
    }

    /**
     * WfsIndex::store()
     *
     * Store information into database
     *
     * @return
     */
    function store()
    {
        global $myts;

        $id = intval($this->indid);
        $pagename = $myts->censorString($this->pagename);
        $indexheading = $myts->censorString($this->indexheading);
        $indexheader = $myts->censorString($this->indexheader);
        $indexfooter = $myts->censorString($this->indexfooter);

        //if (get_magic_quotes_gpc()) // if get_magic_quotes_gpc enabled, module.textsanitizer::addSlashes will skip
        //{
         //$indeximage = addSlashes($this->indeximage);
         //$pagename = addSlashes($pagename);
         //$indexheading = addSlashes($indexheading);
         //$indexheader = addSlashes($indexheader);
         //$indexfooter = addSlashes($indexfooter);
        //}else {
         $indeximage = $this->indeximage;
         $pagename = $pagename;
         $indexheading = $indexheading;
         $indexheader = $indexheader;
         $indexfooter = $indexfooter;
        //}

        $indexheaderalign = $this->indexheaderalign;
        $indexfooteralign = $this->indexfooteralign;

        $nosmileys = intval($this->nosmileys);
        $nohtml = intval($this->nohtml);
        $noxcodes = intval($this->noxcodes);
        $images = intval($this->noimages);
        $noimages = intval($this->noimages);
        $isdefault = intval($this->isdefault);

        if (empty($id))
        {
            $id = $this->db->genId($this->table . "_id_seq");
            $sql = sprintf("INSERT INTO " . $this->table . " (indid, pagename, indeximage, indexheading, indexheader, indexfooter, nohtml, nosmileys, noxcodes, noimages, nobreaks, indexheaderalign, indexfooteralign,  isdefault ) VALUES (" . $id . ", '" . $pagename . "', '" . $indeximage . "', '" . $indexheading . "', '" . $indexheader . "', '" . $indexfooter . "', '" . $indexheaderalign . "', '" . $indexfooteralign . "', " . $nohtml . ", " . $nosmileys . ", " . $this->noxcodes . ", " . $this->noimages . ", " . $this->nobreaks . ", 0)");
            $error = "Error while creating wfsection pages: <br /><br />" . $sql;
        }
        else
        {
            $sql = sprintf("UPDATE " . $this->table . " set pagename = '" . $pagename . "', indexheading='" . $indexheading . "', indexheader='" . $indexheader . "', indexfooter='" . $indexfooter . "', indeximage='" . $indeximage . "', indexheaderalign='" . $indexheaderalign . "', indexfooteralign='" . $indexfooteralign . "', nohtml = " . $nohtml . ", nosmileys = " . $this->nosmileys . ", noxcodes = " . $this->noxcodes . ", noimages=" . $this->noimages . ", nobreaks=" . $this->nobreaks . " , nobreaks=" . $this->nobreaks . " WHERE indid=" . $id . "");
            $error = "Error while updating wfsection pages: <br /><br />" . $sql;
        }
        if (!$result = $this->db->query($sql))
        {
            trigger_error($error, E_USER_ERROR);
        }
        return true;
    }

    function delete()
    {
        global $xoopsDB, $xoopsConfig;

        $sql = "DELETE FROM " . $this->table . " WHERE indid=" . $this->indid . "";
        if (!$result = $this->db->query($sql))
        {
            trigger_error("Could not delete wfsections page item from database", E_USER_ERROR);
        }
    }

    function getAllPages($limit = 0, $start = 0, $asobject = true)
    {
        global $xoopsDB, $xoopsConfig, $orderby;

        $db = &Database::getInstance();
        $myts = &MyTextSanitizer::getInstance();
        $ret = array();

        $sql = "SELECT * FROM " . $db->prefix(WFS_INDEXPAGE) . " ORDER BY indid";
        $result = $db->query($sql, $limit, $start);
        while ($myrow = $db->fetchArray($result))
        {
            if ($asobject)
            {
                $ret[] = new WfsIndex($myrow);
            }
            else
            {
                $ret[$myrow['indid']] = $myts->makeTboxData4Show($myrow['pagename']);
            }
        }
        return $ret;
    }

    /**
     * Code to display items from database
     */
    function indid()
    {
        return $this->indid;
    }

    function pagename($format = "S")
    {
        global $myts;

        switch ($format)
        {
            case "S":
                $pagename = $myts->htmlSpecialChars($this->pagename);
                break;
            case "E":
                $pagename = $myts->htmlSpecialChars($this->pagename);
                break;
        }
        return $pagename;
    }

    function indexheading($format = "S")
    {
        global $myts;
		$indexheading = (get_magic_quotes_gpc()) ? stripslashes($this->indexheading) :  $this->indexheading;
		switch ($format)
        {
            case "S":
                $indexheading = $myts->htmlSpecialChars($indexheading);
                break;
            case "E":
                $indexheading = $myts->htmlSpecialChars($indexheading);
                break;
        }
        return $indexheading;
    }

    function indeximage($format = "S")
    {
        global $myts;
		$indeximage = (get_magic_quotes_gpc()) ? stripslashes($this->indeximage) :  $this->indeximage;
        switch ($format)
        {
            case "S":
                $indeximage = "blank.png";
                if ($this->imagecheck($this->indeximage))
                {
                    if (!empty($this->indeximage) || $this->indeximage != "blank.png")
                    {
                        $indeximage = $myts->htmlSpecialChars($this->indeximage);
                    }
                }
                break;
            case "E":
                $indeximage = "blank.png";
                $indeximage = $myts->htmlSpecialChars($this->indeximage);
                break;
        }
        return $indeximage;
    }

    function indexheader($format = "S")
    {
        if (empty($this->indexheader)) return "";

        global $myts;
        switch ($format)
        {
            case "S":

                $html = ($this->nohtml == 1) ? 0 : 1;
                $smiley = ($this->nosmileys == 1) ? 0 : 1;
                $xcodes = ($this->noxcodes == 1) ? 0 : 1;
                $images = ($this->noimages == 1) ? 0 : 1;
                $breaks = ($this->nobreaks == 1) ? 1 : 0;
                if ($this->noimages == 0) $this->indexheader = preg_replace("/<img[^>]+>/i", "", $this->indexheader);

                $catdescription = $myts->displayTarea($this->indexheader, $html, $smiley, $xcodes, $images, $breaks);
                break;
            case "E":
                $catdescription = $myts->htmlSpecialChars($this->indexheader);
                break;
        }
        $catdescription = stripslashes($catdescription);
		return $catdescription;
    }

    function indexfooter($format = "S")
    {
        global $myts;

        switch ($format)
        {
            case "S":
                $html = ($this->nohtml == 1) ? 0 : 1;
                $smiley = ($this->nosmileys == 1) ? 0 : 1;
                $xcodes = ($this->noxcodes == 1) ? 0 : 1;
                $images = ($this->noimages == 1) ? 0 : 1;
                $breaks = ($this->nobreaks == 1) ? 1 : 0;

                if ($this->noimages == 0) $this->indexfooter = preg_replace("/<img[^>]+>/i", "", $this->indexfooter);
                $catfooter = $myts->displayTarea($this->indexfooter, $html, $smiley, $xcodes, $images, $breaks);
                break;
            case "E":
                $catfooter = $myts->htmlSpecialChars($this->indexfooter);
                break;
        }
        $catfooter = (get_magic_quotes_gpc()) ? stripslashes($catfooter) :  $catfooter;
        return $catfooter;
    }

    function indexheaderalign()
    {
        return $this->indexheaderalign;
    }

    function indexfooteralign()
    {
        return $this->indexfooteralign;
    }

    /**
     * HTML stuff
     */
    function imageheader()
    {
        global $xoopsDB, $xoopsModule, $wfsPathConfig;
        $image = wfs_displayimage($this->indeximage, "modules/" . WFSECTION . "/index.php", $wfsPathConfig["logopath"], $this->indexheading);
        return $image;
    }

    function imagecheck($image)
    {
        global $wfsPathConfig;

        $image = XOOPS_ROOT_PATH . "/" . $wfsPathConfig["logopath"] . "/" . $image;
        $ifexisits = file_exists($image) ? TRUE : FALSE;
        return $ifexisits;
    }
}

?>