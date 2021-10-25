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

if (!isset($params['catid']))
  {
    $params[QUESTIONS_PARAM_ERRORS] = $this->Lang('error_insufficientparams');
    $this->RedirectToTab($id,$params[QUESTIONS_PARAM_ACTIVETAB],$params);
  }
$catid = $params['catid'];

// Get the category details
$query = 'SELECT * FROM '.QUESTIONS_CATEGORIES_TABLE.' WHERE id = ?';
$row = $db->GetRow( $query, array( $catid ) );

//Reset all categories using this parent to have no parent (-1)
$query = 'UPDATE '.QUESTIONS_CATEGORIES_TABLE.' SET parent=? WHERE parent=?';
$db->Execute($query, array(-1, $catid));

//Now remove the category
$query = "DELETE FROM ".QUESTIONS_CATEGORIES_TABLE." WHERE id = ?";
$db->Execute($query, array($catid));

//And remove it from any articles
// $query = "DELETE FROM module_news_article_categories WHERE news_category_id = ?";
// $db->Execute($query, array($catid));

$this->UpdateHierarchyPositions(); 
//$this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
$this->SetMessage($this->Lang('info_categoryadeleted'));
	 $this->RedirectToTab($id);


// EOF
?>