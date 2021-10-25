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

$questiontypes = array(
  $this->Lang('all_questions') => 'ALL',
  $this->Lang('answered_questions') => 'ANSWERED',
  $this->Lang('unanswered_questions') => 'UNANSWERED',
  $this->Lang('approved_questions') => 'APPROVED',
  $this->Lang('unapproved_questions') => 'UNAPPROVED'
);

$themeObject = \cms_utils::get_theme_object();

$db = &$this->GetDb();
$q = "SELECT * FROM " . QUESTIONS_CATEGORIES_TABLE . " ORDER BY long_name ASC";
$dbresult = $db->Execute($q);
$categories = array($this->Lang('prompt_allcategories') => '');
while ($dbresult && $row = $dbresult->FetchRow()) {
  $categories[$row['long_name']] = $row['long_name'];
}

if (isset($params['applyfilter'])) {
  if (isset($params['input_questiontype'])) {
    $this->SetPreference(
      QUESTIONS_FILTER_QUESTIONTYPES,
      $params['input_questiontype']
    );
  } else {
    $this->RemovePreference(QUESTIONS_FILTER_QUESTIONTYPES);
  }

  if (isset($params['input_subject_keywords'])) {
    $this->SetPreference(
      QUESTIONS_FILTER_SUBJECT_KEYWORDS,
      trim($params['input_subject_keywords'])
    );
  } else {
    $this->RemovePreference(QUESTIONS_FILTER_SUBJECT_KEYWORDS);
  }

  if (isset($params['input_category'])) {
    $this->SetPreference(
      QUESTIONS_FILTER_CATEGORY,
      $params['input_category']
    );
  } else {
    $this->RemovePreference(QUESTIONS_FILTER_CATEGORY);
  }

  if (isset($params['input_showchildcategories'])) {
    $this->SetPreference(
      QUESTIONS_FILTER_SHOWCHILDCATEGORIES,
      $params['input_showchildcategories']
    );
  } else {
    $this->RemovePreference(QUESTIONS_FILTER_SHOWCHILDCATEGORIES);
  }

  if (
    isset($params['input_pagelimit']) &&
    is_numeric($params['input_pagelimit'])
  ) {
    $this->SetPreference(
      QUESTIONS_FILTER_PAGELIMIT,
      $params['input_pagelimit']
    );
  } else {
    $this->RemovePreference(QUESTIONS_FILTER_PAGELIMIT);
  }
}

$smarty = &$this->smarty;

$selectedtype = $this->GetPreference(QUESTIONS_FILTER_QUESTIONTYPES, 'ALL');
$smarty->assign('selectedtype', $selectedtype);
$subject_keywords = trim($this->GetPreference(QUESTIONS_FILTER_SUBJECT_KEYWORDS));
$smarty->assign('subject_keywords', $subject_keywords);
$category = $this->GetPreference(QUESTIONS_FILTER_CATEGORY);
$smarty->assign('category', $category);
$showchildcategories = $this->GetPreference(QUESTIONS_FILTER_SHOWCHILDCATEGORIES);
$smarty->assign('showchildcategories', $showchildcategories);
$pagelimit = $this->GetPreference(QUESTIONS_FILTER_PAGELIMIT, 25);
$smarty->assign('pagelimit', $pagelimit);

// figure out what page we're on.
$pagenumber = 1;
if (isset($params['pagenumber'])) {
  $pagenumber = $params['pagenumber'];
}
$startelement = ($pagenumber - 1) * $pagelimit;


$smarty->assign('formstart', $this->CreateFormStart($id, 'defaultadmin'));
$smarty->assign('formend', $this->CreateFormEnd());
$smarty->assign(
  'legend_filter_settings',
  $this->Lang('legend_filter_settings')
);
$smarty->assign(
  'apply',
  $this->CreateInputSubmit($id, 'applyfilter', $this->Lang('apply'))
);


$smarty->assign('prompt_category', $this->Lang('prompt_category'));
$smarty->assign(
  'input_category',
  $this->CreateInputDropdown($id, 'input_category', $categories, -1, $category)
);
$smarty->assign('prompt_showchildcategories', $this->Lang('prompt_filter_showchildcategories'));
$smarty->assign(
  'input_showchildcategories',
  $this->CreateInputCheckbox(
    $id,
    'input_showchildcategories',
    'yes',
    $showchildcategories
  )
);

$smarty->assign('prompt_questiontype', $this->Lang('prompt_filter_questiontype'));
$smarty->assign(
  'input_questiontype',
  $this->CreateInputDropdown($id, 'input_questiontype', $questiontypes, -1, $selectedtype)
);
$smarty->assign('prompt_subject_keywords', $this->Lang('prompt_filter_subject_keywords'));
$smarty->assign(
  'input_subject_keywords',
  $this->CreateInputText($id, 'input_subject_keywords', $subject_keywords, 40, 80)
);
$smarty->assign('prompt_pagelimit', $this->Lang('prompt_filter_pagelimit'));
$smarty->assign(
  'input_pagelimit',
  $this->CreateInputText($id, 'input_pagelimit', $pagelimit, 5)
);

// the add link
$parms = array(QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_QUESTIONSTAB);
$this->smarty->assign('addlink', $this->CreateLink($id, 'admin_addquestion', $returnid, $themeObject->DisplayImage('icons/system/newobject.gif', $this->Lang('prompt_addquestion'), '', '', 'systemicon'), $parms, '', false, false, '') . ' ' . $this->CreateLink($id, 'admin_addquestion', $returnid, $this->Lang('prompt_addquestion'), $parms, '', false, false, 'class="pageoptions"'));

// Now the labels for the table headers
$smarty->assign('prompt_id', $this->Lang('prompt_id'));
$smarty->assign('prompt_author', $this->Lang('prompt_author'));
$smarty->assign('prompt_question', $this->Lang('prompt_question'));
$smarty->assign('prompt_created', $this->Lang('prompt_created'));
$smarty->assign('prompt_answered', $this->Lang('prompt_answered_s'));
$smarty->assign('prompt_approved', $this->Lang('prompt_approved_s'));
// todo also have an approved, and answered column, as well as edit and delete

//
// and now the query 
//
$where = array();
$parms = array();
$query1 = "SELECT q.*, qc.long_name
            FROM " . QUESTIONS_TABLE . " q LEFT OUTER JOIN " . QUESTIONS_CATEGORIES_TABLE . " qc
              ON q.category_id = qc.id";
$query2 = "SELECT count(q.id) AS num
            FROM " . QUESTIONS_TABLE . " q LEFT OUTER JOIN " . QUESTIONS_CATEGORIES_TABLE . " qc
              ON q.category_id = qc.id";

if ($category != '') {
  $where[] = "qc.long_name LIKE ?";
  if ($showchildcategories) {
    $parms[] = $category . '%';
  } else {
    $parms[] = $category;
  }
}

switch ($selectedtype) {
  case 'ALL':
    break;
  case 'ANSWERED':
    $where[] = 'answered_date IS NOT NULL';
    break;
  case 'UNANSWERED':
    $where[] = 'answered_date IS NULL';
    break;
  case 'APPROVED':
    $where[] = 'approved_date IS NOT NULL';
    break;
  case 'UNAPPROVED':
    $where[] = 'approved_date IS NULL';
    break;
}
if (strlen($subject_keywords) > 0) {
  $words = explode(" ", trim($subject_keywords));
  $str = '(';
  for ($i = 0; $i < count($words); $i++) {
    $str .= "q.question LIKE '%" . $words[$i] . "%'";
    if ($i < count($words) - 1) {
      $str .= ' OR ';
    }
  }
  $str .= ')';
  $where[] = $str;
}
if (count($where) >= 1) {
  $query1 .= ' WHERE ';
  $query2 .= ' WHERE ';
}
for ($i = 0; $i < count($where); $i++) {
  $query1 .= $where[$i] . ' ';
  $query2 .= $where[$i] . ' ';
  if ($i < count($where) - 1) {
    $query1 .= ' AND ';
    $query2 .= ' AND ';
  }
}
$query1 .= " LIMIT $startelement,$pagelimit";

// Now get the count
$row2 = $db->GetRow($query2, $parms);
$pagecount = (int)($row2['num'] / $pagelimit);
if (($row2['num'] % $pagelimit) != 0) $pagecount++;

// some pagination variables to smarty.
if ($pagenumber == 1) {
  $smarty->assign('prevpage', '<');
  $smarty->assign('firstpage', '<<');
} else {
  $smarty->assign(
    'prevpage',
    $this->CreateLink(
      $id,
      QUESTIONS_ACTION_DEFADMIN,
      $returnid,
      '<',
      array(
        'pagenumber' => $pagenumber - 1,
        QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_QUESTIONSTAB
      )
    )
  );
  $smarty->assign(
    'firstpage',
    $this->CreateLink(
      $id,
      QUESTIONS_ACTION_DEFADMIN,
      $returnid,
      '<<',
      array(
        'pagenumber' => 1,
        QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_QUESTIONSTAB
      )
    )
  );
}
if ($pagenumber >= $pagecount) {
  $smarty->assign('nextpage', '>');
  $smarty->assign('lastpage', '>>');
} else {
  $smarty->assign(
    'nextpage',
    $this->CreateLink(
      $id,
      QUESTIONS_ACTION_DEFADMIN,
      $returnid,
      '>',
      array(
        'pagenumber' => $pagenumber + 1,
        QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_QUESTIONSTAB
      )
    )
  );
  $smarty->assign(
    'lastpage',
    $this->CreateLink(
      $id,
      QUESTIONS_ACTION_DEFADMIN,
      $returnid,
      '>>',
      array(
        'pagenumber' => $pagecount,
        QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_QUESTIONSTAB
      )
    )
  );
}
$smarty->assign('pagenumber', $pagenumber);
$smarty->assign('pagecount', $pagecount);
$smarty->assign('oftext', $this->Lang('prompt_of'));

$falseimage1 = $themeObject->DisplayImage('icons/system/false.gif', 'not answered', '', '', 'systemicon');
$trueimage1 = $themeObject->DisplayImage('icons/system/true.gif', 'answered', '', '', 'systemicon');
$falseimage2 = $themeObject->DisplayImage('icons/system/false.gif', 'not approved', '', '', 'systemicon');
$trueimage2 = $themeObject->DisplayImage('icons/system/true.gif', 'approved', '', '', 'systemicon');

// And the results
$dbresult = $db->Execute($query1, $parms);

$entryarray = array();
$rowclass = 'row1';
while ($dbresult && $row = $dbresult->FetchRow()) {
  $onerow = new stdClass();
  $onerow->id = $row['id'];
  $onerow->author = $row['author'];
  $onerow->created = $row['created'];
  $onerow->question = $row['question'];

  $onerow->answered = $falseimage1;
  if ($row['answered_date'] != NULL) {
    $onerow->answered = $trueimage1;
  }

  $onerow->approved = $falseimage2;
  if ($row['approved_date'] != NULL) {
    $onerow->approved = $trueimage2;
  }

  $parms = array(
    'question_id' => $row['id'],
    QUESTIONS_PARAM_ACTIVETAB => QUESTIONS_QUESTIONSTAB
  );
  $onerow->editlink = $this->CreateLink(
    $id,
    'editquestion',
    $returnid,
    $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),
    $parms
  );

  if ($this->CheckPermission(QUESTIONS_PERM)) {
    $onerow->deletelink = $this->CreateLink(
      $id,
      'deletequestion',
      $returnid,
      $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'),
      $parms,
      $this->Lang('areyousure')
    );
  } else {
    $onerow->deletelink = '&nbsp;';
  }

  $onerow->rowclass = $rowclass;
  $entryarray[] = $onerow;
  ($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
}
$this->smarty->assign_by_ref('items', $entryarray);
$this->smarty->assign('itemcount', count($entryarray));

echo $this->ProcessTemplate('questions.tpl');

// EOF
