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

$smarty = &$this->smarty;

$smarty->assign(
  'categorytext',
  $this->Lang('prompt_categories')
);
$smarty->assign(
  'addlink',
  $this->CreateLink(
    $id,
    'addcategory',
    $returnid,
    $this->Lang('prompt_addcategory'),
    array(QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_CATEGORIESTAB)
  )
);

$rowclass = 'row1';
$query = "SELECT * FROM " . QUESTIONS_CATEGORIES_TABLE . " ORDER BY hierarchy";
$dbresult = &$db->Execute($query);
$entryarray = array();
while (!$dbresult->EOF) {
  $onerow = new stdClass();

  $depth = count(explode('\.', $dbresult->fields['hierarchy']));
  $onerow->id = $dbresult->fields['id'];
  $onerow->name = str_repeat('&nbsp;', $depth - 1) . $this->CreateLink(
    $id,
    'editcategory',
    $returnid,
    $dbresult->fields['name'],
    array(
      'catid' => $dbresult->fields['id'],
      QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_CATEGORIESTAB
    )
  );
  $onerow->editlink = $this->CreateLink(
    $id,
    'editcategory',
    $returnid,
    $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),
    array('catid' => $dbresult->fields['id'])
  );
  $onerow->deletelink = $this->CreateLink(
    $id,
    'deletecategory',
    $returnid,
    $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'),
    array(
      'catid' => $dbresult->fields['id'],
      QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_CATEGORIESTAB
    ),
    $this->Lang('areyousure')
  );
  $onerow->rowclass = $rowclass;

  $entryarray[] = $onerow;
  ($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
  $dbresult->MoveNext();
}
$this->smarty->assign_by_ref('items', $entryarray);
$this->smarty->assign('itemcount', count($entryarray));

echo $this->ProcessTemplate('categorylist.tpl');

// EOF
