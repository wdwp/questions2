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
$this->SetCurrentTab('categories');
// Check permissions
if( !$this->CheckPermission(QUESTIONS_PERM) )
  {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
  }
if( isset($params['cancel']) )
  {
    $this->RedirectToTab($id);
  }

 
$name = '';
if( isset($params['name'] ) )
  {
    $name = trim($params['name']);
  }
  
 
if ($name != '')
  {
    $catid = $db->GenID(QUESTIONS_CATEGORIES_SEQUENCE);
    $query = 'INSERT INTO '.QUESTIONS_CATEGORIES_TABLE.' (id, name, parent)  VALUES (?,?,?)';
    $db->Execute($query, array($catid, $name, $params['parent']));
    $this->UpdateHierarchyPositions();
    //$this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
	 $this->SetMessage($this->Lang('info_categoryadded'));
	 $this->RedirectToTab($id);
  }
 

#Display template
$this->smarty->assign('startform', $this->CreateFormStart($id, 'addcategory', $returnid));
$this->smarty->assign('endform', $this->CreateFormEnd());
$this->smarty->assign('nametext', $this->Lang('prompt_name'));
$this->smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 20, 255));
$this->smarty->assign('parentdropdown', $this->CreateParentDropdown($id, -1, -1));
$this->smarty->assign('hidden',
		      $this->CreateInputHidden($id, QUESTIONS_PARAM_ACTIVETAB,
					       $params[QUESTIONS_PARAM_ACTIVETAB]));

$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$this->smarty->assign('parenttext', $this->Lang('prompt_parent'));
echo $this->ProcessTemplate('editcategory.tpl');

// EOF
?>