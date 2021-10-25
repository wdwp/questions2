<?php
#-------------------------------------------------------------------------
# Module: Questions - a simple Questions & Answer module
# Version: 1.0, calguy1000 <calguy1000@hotmail.com>
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

// Check permissions
if( !$this->CheckPermission(QUESTIONS_PERM) )
  {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
  }

$this->SetCurrentTab('categories');

if( isset($params['cancel']) )
  {
    //$this->RedirectToTab($id,$params[QUESTIONS_PARAM_ACTIVETAB],$params);
	
	   $this->RedirectToTab($id);
  }

$catid = '';
if (isset($params['catid']))
  {
    $catid = $params['catid'];
  }

$parentid = '-1';
if (isset($params['parent']))
  {
    $parentid = $params['parent'];
  }

$origname = '';
if (isset($params['origname']))
  {
    $origname = $params['origname'];
  }

$name = '';
if (!isset($params['name']))
  {
    //$params[QUESTIONS_PARAM_ERRORS] = $this->Lang('error_nonamegiven');
    //$this->Redirect($id,'editcategory',$params);
	$this->SetError($this->Lang('error_nonamegiven'));
	 $this->RedirectToTab($id,'','','editcategory');
  }

$name = trim($params['name']);
if ($name == '')
  {
    //$params[QUESTIONS_PARAM_ERRORS] = $this->Lang('error_nonamegiven');
    //$this->Redirect($id,'editcategory',$params);
	$this->SetError($this->Lang('error_nonamegiven'));
	 $this->RedirectToTab($id,'','','editcategory');
  }

$query = 'UPDATE '.QUESTIONS_CATEGORIES_TABLE.' SET name = ?, parent = ? WHERE id = ?';
$db->Execute($query, array($name, $parentid, $catid));
$this->UpdateHierarchyPositions();

//$this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
$this->SetMessage($this->Lang('info_categoryaedited'));
$this->RedirectToTab($id);

// EOF
?>