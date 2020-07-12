<?php
// $Id: wfstree.php,v 1.4 2004/08/13 12:46:08 phppp Exp $
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
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";

class WfsTree extends XoopsTree
{
    var $table; //table with parent-child structure
    var $id; //name of unique id for records in table $table
    var $pid; // name of parent id used in table $table
    var $order; //specifies the order of query results
    var $title; // name of a field in table $table which will be used when  selection box and paths are generated
    var $db;

    function WfsTree($table_name, $id_name, $pid_name, $status = 1, $published = 0)
    {
        $this->db = &Database::getInstance();
        $this->table = $table_name;
        $this->id = $id_name;
        $this->pid = $pid_name;
		$this->status = $status;
		$this->published = $published;
    }

    function makeMyRootedSelBox($title, $order = "", $root = 0, $recurse = false, $preset_id = 0, $showroot = 0, $sel_name = "", $onchange = "", $size = 1, $multipule = "")
    {
		$myts = &MyTextSanitizer::getInstance();
        global $xoopsUser, $xoopsModule, $myts;

        $catid = array();

        $admincheck = true;
        if (isset($preset_id))
        {
            if (is_array($preset_id))
            {
                foreach ($preset_id as $v)
                {
                    $this->_value[] = $v;
                }
            }
            else
            {
                $this->_value[] = $preset_id;
            }
        }

        if (empty($sel_name)) $sel_name = $this->id;

        $selectbox = "<select size = '" . $size . "' name='" . $sel_name . "[]' id='" . $sel_name . "[]'";
        if ($multipule)
        {
            $selectbox .= "  multiple='multiple'";
        }

        if ($onchange != "") $selectbox .= ' onchange="' . $onchange . '"';
        $selectbox .= ">\n";

        if ($root == 0)
        {
            $roottitle = _WFS_ROOT_CATEGORY;
            $rootaccess = 1;
        }
        else
        {
			$rootquery = "SELECT title, groupid FROM {$this->table} WHERE {$this->id}=$root";
            if ($this->published == 1)
            {
				$rootquery .= " AND published > 0";
            } else {
				$rootquery .= " AND status = $this->status";
			}
			
			$rootres = $this->db->query("SELECT title, groupid FROM {$this->table} WHERE {$this->id}=$root");
			if ($this->published == 1)
            {
				$rootres .= " AND published != 0";
            } else {
				$rootres .= " AND status = $this->status";
			}		
			
			if (list($roottitle, $rootaccess) = $this->db->fetchRow($rootres))
            {
                $rootaccess = wfs_checkAccess($rootaccess);
            }
            else
            {
                $rootaccess = 0;
            }
        }

        if ($rootaccess)
        {
            if ($showroot)
            {
                $selectbox .= "<option value='$root'>$roottitle</option>\n";
            }

            $sql = "SELECT {$this->id}, $title, groupid FROM {$this->table} WHERE {$this->pid}= $root ";
		
			if ($this->published == 1)
            {
				$sql .= " AND published != 0";
            } else {
				$sql .= " AND status = $this->status";
			}
            if ($order != "")
            {
                $sql .= " ORDER BY $order";
            }
            $result = $this->db->query($sql);

            while (list($catid, $name, $groupid) = $this->db->fetchRow($result))
            {
                if (wfs_checkAccess($groupid))
                {
                    $sel = ($catid == $preset_id) ? " selected='selected'" : "";
                    if (($root != 0) && $showroot)
                    {
                        $name = "--&nbsp;$name";
                    }
                    $selectbox .= "<option value='" . htmlspecialchars($catid, ENT_QUOTES) . "'";
                    if (count($this->_value) > 0 && in_array($catid, $this->_value))
                    {
                        $selectbox .= " selected='selected'";
                    }
                    $selectbox .= ">$name</option>\n"; 
                    // Show sub dirs
                    if ($recurse)
                    {
                        $arr = $this->getChildTreeArray($catid, $order);
                        foreach ($arr as $option)
                        {
                			if (!wfs_checkAccess($option['groupid'])) continue;
                            $option['prefix'] = str_replace(".", "--", $option['prefix']);
                            $catpath = $option['prefix'] . "&nbsp;" . $option[$title] ;
                            if (($root != 0) && $showroot)
                            {
                                $catpath = "--$catpath";
                            }
                            $sel = ($option[$this->id] == $preset_id) ? " selected='selected'" : "";
                            $selectbox .= "<option value='{$option[$this->id]}'";
                            if (count($this->_value) > 0 && in_array($option[$this->id], $this->_value))
                            {
                                $selectbox .= " selected='selected'";
                            }
                            $selectbox .= ">$catpath</option>\n";
                        }
                    }
                }
            }
        }
        $selectbox .= "</select>\n";
        return $selectbox;
    }

    function makeMyWFSSelBox($title, $order = "", $preset_id = 0, $none = 0, $sel_name = "", $onchange = "", $size = 1, $multipule = "")
    {
        return $this->makeMyRootedSelBox($title, $order, 0, true, $preset_id, $none, $sel_name, $onchange, 1, 0);
    }

}

?>