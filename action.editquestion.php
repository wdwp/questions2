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
$smarty = &$this->smarty;

// Check permissions
if (!($this->CheckPermission(QUESTIONS_PERM) ||
  $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) ||
  $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS))) {
  echo $this->ShowErrors($this->Lang('accessdenied'));
  return;
}
if (isset($params['cancel'])) {
  $this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
}

if (!isset($params['question_id'])) {
  $params[QUESTIONS_PARAM_ERRORS] = $this->Lang('error_insufficientparams');
  $this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
}
$question_id = $params['question_id'];

// Load the default settings from the database
$db = &$this->GetDb();
$query = "SELECT * FROM " . QUESTIONS_TABLE . " where id = ?";
$row = $db->GetRow($query, array($question_id));
if (!$row) {
  $params[QUESTIONS_PARAM_ERRORS] = $this->Lang('error_dberror', $this->Lang('error_invalidquestioid'));
  $this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
}

// Override whatever we found in the database
// with whatever is in params.
$author = $row['author'];
if (isset($params['input_author'])) {
  $author = $params['input_author'];
}
$question = $row['question'];
if (isset($params['input_question'])) {
  $question = $params['input_question'];
}
$answer = $row['answer'];
if (isset($params['input_answer'])) {
  $answer = $params['input_answer'];
}
$approved = '';
if (isset($params['submit'])) {
  if (isset($params['input_approved'])) {
    $approved = $params['input_approved'];
  }
  if (isset($params['parent'])) {
    $category = $params['parent'];
  }
} else {
  $approved = ($row['approved_date'] != '') ? 'yes' : '';
  $category = $row['category_id'];
}

if (isset($params['submit'])) {
  if ($this->CheckPermission(QUESTIONS_PERM)) {
    if ($category == '' || $author == '' || $question == '') {
      echo $this->ShowErrors($this->Lang('error_insufficientparams'));
    }
  }
  if (
    $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) ||
    $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS)
  ) {
    if ($approved == 'yes' && $answer == '') {
      echo $this->ShowErrors($this->Lang('error_noanswer'));
    }
  }

  $db = &$this->GetDb();
  $now = trim($db->DbTimeStamp(time()), "'");
  $flds = array();
  $parms = array();
  if ($this->CheckPermission(QUESTIONS_PERM)) {
    $flds[] = 'category_id';
    $parms[] = $category;
    $flds[] = 'author';
    $parms[] = $author;
    $flds[] = 'question';
    $parms[] = $question;
  }
  if ($this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS)) {
    $flds[] = 'answer';
    $parms[] = $answer;
    $qmarks[] = "?";
    if ($answer != '') {
      $flds[] = 'answered_by';
      $parms[] = $this->GetUsername();
      $qmarks[] = "?";
      $flds[] = 'answered_date';
      $parms[] = $now;
      $qmarks[] = "?";
    } else {
      $flds[] = 'answered_by';
      $parms[] = NULL;
      $qmarks[] = "?";
      $flds[] = 'answered_date';
      $parms[] = NULL;
      $qmarks[] = "?";
    }
  }
  if ($this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS)) {
    if ($approved == 'yes' && $answer != '') {
      $flds[] = 'approved_by';
      $parms[] = $this->GetUsername();
      $qmarks[] = "?";
      $flds[] = 'approved_date';
      $parms[] = $now;
      $qmarks[] = "?";
    } else {
      $flds[] = 'approved_by';
      $parms[] = NULL;
      $qmarks = "?";
      $flds[] = 'approved_date';
      $parms[] = NULL;
      $qmarks = "?";
    }
  }
  $query = 'UPDATE ' . QUESTIONS_TABLE . ' SET ';
  for ($i = 0; $i < count($flds); $i++) {
    $query .= $flds[$i] . " = ?";
    if ($i < count($flds) - 1) {
      $query .= ",";
    }
    $query .= " ";
  }
  $query .= "WHERE id = ?";
  $parms[] = $question_id;
  $dbresult = $db->Execute($query, $parms);

  $search = $this->GetModuleInstance('Search');
  if ($search) {
    $str = $author . ' ' . $question;
    if ($answer != '') {
      $str .= ' ' . $answer;
    }
    $str = trim(preg_replace('/\r?\n/', '', strip_tags($str)));

    $search->AddWords($this->GetName(), $question_id, 'question', $str);
  }
  $this->SetMessage($this->Lang('info_questionedited'));
  $this->RedirectToTab($id, $params[QUESTIONS_PARAM_ACTIVETAB]);
}

$smarty->assign('startform', $this->CreateFormStart(
  $id,
  'editquestion',
  $returnid,
  'post',
  '',
  false,
  '',
  $params
));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', $this->Lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', $this->Lang('cancel')));
$smarty->assign('hidden', $this->CreateInputHidden(
  $id,
  QUESTIONS_PARAM_ACTIVETAB,
  $params[QUESTIONS_PARAM_ACTIVETAB]
));
$smarty->assign('prompt_category', $this->Lang('prompt_category'));
$smarty->assign('prompt_question', $this->Lang('prompt_question'));
$smarty->assign('prompt_answer', $this->Lang('prompt_answer'));
$smarty->assign('prompt_author', $this->Lang('prompt_author'));
$smarty->assign('prompt_id', $this->Lang('prompt_id'));
$smarty->assign('question_id', $question_id);
if ($this->CheckPermission(QUESTIONS_PERM)) {
  $smarty->assign(
    'input_category',
    $this->CreateParentDropdown($id, -1, $category, false)
  );
  $smarty->assign(
    'input_question',
    $this->CreateTextArea(true, $id, $question, 'input_question')
  );
  $smarty->assign(
    'input_author',
    $this->CreateInputText($id, 'input_author', $author, 40, 80)
  );
} else {
  // Have to lookup the category name
  $q = "SELECT name FROM " . QUESTIONS_CATEGORIES_TABLE . " WHERE id = ?";
  $row = $db->GetRow($q, array($category));
  $smarty->assign('input_category', $row['name']);
  $smarty->assign('input_question', $question);
  $smarty->assign('input_author', $author);
}
if ($this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS)) {
  $smarty->assign(
    'input_answer',
    $this->CreateTextArea(true, $id, $answer, 'input_answer')
  );
} else {
  $smarty->assign('input_answer', $answer);
}
if ($this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS)) {
  $smarty->assign('prompt_approved', $this->Lang('prompt_approved'));
  $smarty->assign('input_approved', $this->CreateInputCheckbox(
    $id,
    'input_approved',
    'yes',
    $approved
  ));
}

echo $this->ProcessTemplate('admin_addquestion.tpl');
// EOF
