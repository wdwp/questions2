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

$summarytemplatename = '';
if (isset($params['summarytemplate'])) {
  $summarytemplatename = $params['summarytemplate'];
}
$categories = '';
if (isset($params['category']) && $params['category'] != '') {
  $categories = str_replace("'", '_', $params['category']);
}
$pagelimit = 20;
if (isset($params['pagelimit']) && $params['pagelimit'] != '') {
  $pagelimit = (int)$params['pagelimit'];
}
$pagenumber = 1;
if (isset($params['pagenumber']) && $params['pagenumber'] != '') {
  $pagenumber = (int)$params['pagenumber'];
}
$startelement = ($pagenumber - 1) * $pagelimit;
$filter = '1';
if (isset($params['nofilter'])) {
  $filter = '';
}
// handle detailpage parameter
$detailpage = '';
if (isset($params['detailpage'])) {
  $manager = &$gCms->GetHierarchyManager();
  $node = &$manager->sureGetNodeByAlias($params['detailpage']);
  if (isset($node)) {
    $content = &$node->GetContent();
    if (isset($content)) {
      $detailpage = $content->Id();
    }
  } else {
    $node = &$manager->sureGetNodeById($params['detailpage']);
    if (isset($node)) {
      $detailpage = $params['detailpage'];
    }
  }
}

//$query1 .= " ORDER BY mq.created DESC LIMIT $startelement,$pagelimit";
$sortby = 'created_desc';
if (isset($params['sortby'])) {
  $sortby = trim($params['sortby']);
}
switch ($sortby) {
  case 'author_asc':
    $orderby = "mq.author ASC";
    break;
  case 'author_desc':
    $orderby = "mq.author DESC";
    break;
  case 'answered_asc':
    $orderby = "mq.answered_date ASC";
    break;
  case 'answered_desc':
    $orderby = "mq.answered_date DESC";
    break;
  case 'answered_by_asc':
    $orderby = "mq.answered_by ASC";
    break;
  case 'answered_by_desc':
    $orderby = "mq.answered_by ASC";
    break;
  case 'approved_asc':
    $orderby = "mq.approved_date ASC";
    break;
  case 'approved_desc':
    $orderby = "mq.approved_date ASC";
    break;
  case 'approved_by_asc':
    $orderby = "mq.approved_by ASC";
    break;
  case 'approved_by_desc':
    $orderby = "mq.approved_by ASC";
    break;
  case 'category_asc':
    $orderby = "mqc.name ASC";
    break;
  case 'category_desc':
    $orderby = "mqc.name DESC";
    break;
  case 'created_asc':
    $orderby = "mq.created ASC";
    break;
  case 'created_desc':
    $orderby = "mq.created DESC";
    break;
  default:
    // invalid sortby param
    // but we're just gonna echo a hidden warning, and continue on
    echo "<!-- warning: sortby parameter was incorrect in module tag ($sortby is invalid) -->";
    $orderby = "mq.created DESC";
    break;
}


// Display the filter form
if ($filter != '') {
  $smarty->assign('label_filter', $this->Lang('prompt_filter'));
  $smarty->assign(
    'formstart',
    $this->CreateFrontendFormStart($id, $returnid, 'default', 'post', '', 'true', '', $params)
  );
  $smarty->assign('prompt_keywords', $this->Lang('prompt_keywords'));
  $smarty->assign(
    'input_keywords',
    $this->CreateInputText(
      $id,
      'input_keywords',
      isset($params['input_keywords']) ? $params['input_keywords'] : '',
      30
    )
  );
  $smarty->assign('prompt_author', $this->Lang('prompt_author'));
  $smarty->assign(
    'input_author',
    $this->CreateInputText(
      $id,
      'input_author',
      (isset($params['input_author']) ? $params['input_author'] : ''),
      30
    )
  );
  $smarty->assign('prompt_answered_by', $this->Lang('prompt_answered_by'));
  $smarty->assign(
    'input_answered_by',
    $this->CreateInputText(
      $id,
      'input_answered_by',
      (isset($params['input_answered_by']) ? $params['input_answered_by'] : ''),
      30
    )
  );
  $smarty->assign(
    'submit',
    $this->CreateInputSubmit($id, 'filtersubmit', $this->Lang('apply'))
  );
  $smarty->assign('formend', $this->CreateFormEnd());
}

$filter_keywords = '';
if (isset($params['input_keywords'])) {
  $filter_keywords = $params['input_keywords'];
}
$author = '';
if (isset($params['input_author'])) {
  $author = str_replace("'", '_', trim($params['input_author']));
}
$answered_by = '';
if (isset($params['input_answered_by'])) {
  $answered_by = $params['input_answered_by'];
}
$answered_required = true;
if (isset($params['no_answer_required'])) {
  $answered_required = false;
}

// Display the summary mode.
$db = &$this->GetDb();
$where1 = array();
$where2 = array();
$query1 = "SELECT mq.*, mqc.name, mqc.long_name
            FROM " . QUESTIONS_TABLE . " mq
            LEFT OUTER JOIN " . QUESTIONS_CATEGORIES_TABLE . " mqc
              ON mqc.id = mq.category_id";
$query2 = "SELECT count(mq.id) as num
            FROM " . QUESTIONS_TABLE . " mq
            LEFT OUTER JOIN " . QUESTIONS_CATEGORIES_TABLE . " mqc
              ON mqc.id = mq.category_id";
if ($answered_required == true) {
  $where1[] = 'mq.answered_date IS NOT NULL';
  $where1[] = 'mq.approved_date IS NOT NULL';
  $where2[] = 'mq.answered_date IS NOT NULL';
  $where2[] = 'mq.approved_date IS NOT NULL';
}

if ($categories != '') {
  $where1[] = 'mqc.name IN (\'' . $categories . '\')';
  $where2[] = 'mqc.name IN (\'' . $categories . '\')';
}
if ($filter_keywords != '') {
  $str .= '(';
  $words = explode(' ', trim($filter_keywords));
  for ($i = 0; $i < count($words); $i++) {
    $str .= "mq.question LIKE '%" . str_replace("'", '_', $words[$i]) . "%'";
    if ($i < count($words) - 1) {
      $str .= ' OR ';
    }
  }
  $str .= ')';
  $where1[] = $str;
  $where2[] = $str;
}
if (FALSE == empty($author)) {
  $where1[] = 'mq.author LIKE \'%' . $author . '%\'';
  $where2[] = 'mq.author LIKE \'%' . $author . '%\'';
}
if (FALSE == empty($answered_by)) {
  $where1[] = 'mq.answered_by LIKE \'%' . $answered_by . '%\'';
  $where2[] = 'mq.answered_by LIKE \'%' . $answered_by . '%\'';
}
if (count($where1) > 0) {
  $str1 = implode(" AND ", $where1);
  $str2 = implode(" AND ", $where2);
  $query1 .= " WHERE $str1";
  $query2 .= " WHERE $str2";
}
$query1 .= " ORDER BY $orderby LIMIT $startelement,$pagelimit";

// Get the count
$row2 = $db->GetRow($query2);
$pagecount = (int)($row2['num'] / $pagelimit);
if (($row2['num'] % $pagelimit) != 0) $pagecount++;

// Assign some pagination variables to smarty.
// some pagination variables to smarty.
if ($pagenumber == 1) {
  $smarty->assign('prevpage', '<');
  $smarty->assign('firstpage', '<<');
} else {
  $params['pagenumber'] = $pagenumber - 1;
  $smarty->assign(
    'prevpage',
    $this->CreateFrontendLink($id, $returnid, 'default', '<', $params)
  );
  $params['pagenumber'] = 1;
  $smarty->assign(
    'firstpage',
    $this->CreateFrontendLink($id, $returnid, 'default', '<<', $params)
  );
}
if ($pagenumber >= $pagecount) {
  $smarty->assign('nextpage', '>');
  $smarty->assign('lastpage', '>>');
} else {
  $params['pagenumber'] = $pagenumber + 1;
  $smarty->assign(
    'nextpage',
    $this->CreateFrontendLink($id, $returnid, 'default', '>', $params)
  );
  $params['pagenumber'] = $pagecount;
  $smarty->assign(
    'lastpage',
    $this->CreateFrontendLink($id, $returnid, 'default', '>>', $params)
  );
}
$smarty->assign('pagenumber', $pagenumber);
$smarty->assign('pagecount', $pagecount);
$smarty->assign('oftext', $this->Lang('prompt_of'));
$smarty->assign('pagetext', $this->Lang('prompt_page'));
$smarty->assign('label_author', $this->Lang('prompt_author'));
$smarty->assign('label_question', $this->Lang('prompt_question'));
$smarty->assign('label_created', $this->Lang('prompt_created'));
$smarty->assign('label_id', $this->Lang('prompt_id'));
$smarty->assign('label_answer', $this->Lang('prompt_answer'));
$smarty->assign('label_answered_by', $this->Lang('prompt_answered_by'));
$smarty->assign('label_answered_date', $this->Lang('prompt_answered_date'));
$smarty->assign('label_approved_by', $this->Lang('prompt_approved_by'));
$smarty->assign('label_approved_date', $this->Lang('prompt_approved_date'));
$smarty->assign('label_category', $this->Lang('prompt_category'));
$smarty->assign('label_more', $this->Lang('prompt_more'));

// get the records
$dbresult = $db->Execute($query1);
$entries = array();
while ($dbresult && !$dbresult->EOF) {
  $oneentry = new stdClass;
  $fields = &$dbresult->fields;

  foreach ($fields as $key => $value) {
    $oneentry->$key = $value;
  }

  // fix a few items up
  $oneentry->created = $db->UnixTimeStamp($fields['created']);
  $oneentry->answered_date = $db->UnixTimeStamp($fields['answered_date']);
  $oneentry->approved_date = $db->UnixTimeStamp($fields['approved_date']);
  $params['mode'] = 'detailed';
  $params['qid'] = $oneentry->id;
  $thereturnid = $returnid;
  if ($detailpage != '') {
    $params['origid'] = $returnid;
    $thereturnid = $detailpage;
  }
  //     $oneentry->morelink = $this->CreateFrontendLink($id,$thereturnid,'default',
  // 					    $this->Lang('prompt_more'),
  // 					    $params);
  //     $oneentry->moreurl = $this->CreateFrontendLink($id,$thereturnid,'default',
  // 					    $this->Lang('prompt_more'),
  //  					    $params,true);
  $oneentry->morelink = $this->CreateLink(
    $id,
    'default',
    $thereturnid,
    $this->Lang('prompt_more'),
    $params,
    '',
    false,
    true,
    '',
    false,
    ''
  );
  $oneentry->moreurl = $this->CreateLink(
    $id,
    'default',
    $thereturnid,
    $this->Lang('prompt_more'),
    $params,
    '',
    true
  );
  $entries[] = $oneentry;
  $dbresult->MoveNext();
}

$smarty->assign('items', $entries);
$smarty->assign('itemcount', count($entries));

if ($summarytemplatename == '') {
  $summarytemplatename = $this->GetPreference(QUESTIONS_PREFSTDSUMMARY_TEMPLATE);
}

echo $this->ProcessTemplateFromDatabase('summary' . $summarytemplatename);
// EOF
