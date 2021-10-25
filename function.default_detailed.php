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

if( !isset( $params['qid'] ) )
  {
    echo $this->Lang('error_insufficientparams').": qid";
    return;
  }
$qid = $params['qid'];

$detailtemplatename = '';
if( isset( $params['detailtemplate'] ) )
  {
    $detailtemplatename = $params['detailtemplate'];
  }

$categories = '';
if( isset($params['category']) && $params['category'] != '' )
  {
    $categories = $params['category'];
  }

////
// Prepare and Execute the query
////

$db =& $this->GetDb();
$query = "SELECT mq.*, mqc.name FROM ".QUESTIONS_TABLE." mq
            LEFT OUTER JOIN ".QUESTIONS_CATEGORIES_TABLE." mqc
              ON mqc.id = mq.category_id 
           WHERE mq.id = ?";
$row =& $db->GetRow($query, array($qid) );
$row['created'] = $db->UnixTimeStamp($row['created']);
$row['answered_date'] = $db->UnixTimeStamp($row['answered_date']);
$row['approved_date'] = $db->UnixTimeStamp($row['approved_date']);
$row['return_link'] = $this->CreateReturnLink($id,
					     isset($params['origid'])?$params['origid']:$returnid,
					     $this->Lang('prompt_return'));

// Get the data for the prev link
$query = "SELECT mq.*, mqc.name, mqc.long_name
            FROM ".QUESTIONS_TABLE." mq
            LEFT OUTER JOIN ".QUESTIONS_CATEGORIES_TABLE." mqc
              ON mqc.id = mq.category_id
           WHERE mq.answered_date IS NOT NULL 
             AND mq.approved_date IS NOT NULL";
if( $categories != '' )
  {
    $cat2 = explode(",",str_replace("'",'_',$categories));
    $cat3 = implode("','",$cat2);
    $query .= ' AND mqc.name IN (\''; 
    $query .= $cat3;
    $query .= '\')';
  }
$prevsuffix .= ' AND mq.id < ? ORDER BY mq.id DESC LIMIT 1';
$nextsuffix .= ' AND mq.id > ? ORDER BY mq.id ASC LIMIT 1';
$previd = '';
$nextid = '';
{
  $parms = array( $qid );
  $prevresult = $db->GetRow( $query.$prevsuffix, $parms );
  $previd = $prevresult['id'];
  $nextresult = $db->GetRow( $query.$nextsuffix, $parms );
  $nextid = $nextresult['id'];
}

//// 
// Prepare Smarty
////
$smarty =& $this->smarty;
$record = new stdClass;
foreach( $row as $key => $value )
{
  $record->$key = $value;
}
$smarty->assign('record', $record);
$smarty->assign('label_author',$this->Lang('prompt_author'));
$smarty->assign('label_question',$this->Lang('prompt_question'));
$smarty->assign('label_created',$this->Lang('prompt_created'));
$smarty->assign('label_id',$this->Lang('prompt_id'));
$smarty->assign('label_answer',$this->Lang('prompt_answer'));
$smarty->assign('label_answered_by',$this->Lang('prompt_answered_by'));
$smarty->assign('label_answered_date',$this->Lang('prompt_answered_date'));
$smarty->assign('label_approved_by',$this->Lang('prompt_approved_by'));
$smarty->assign('label_approved_date',$this->Lang('prompt_approved_date'));
$smarty->assign('label_category',$this->Lang('prompt_category'));
$smarty->assign('label_return_link',$this->Lang('prompt_return_link'));
$smarty->assign('label_prev_link',$this->Lang('prompt_prev'));
$smarty->assign('label_next_link',$this->Lang('prompt_next'));
if( $previd != '' )
  {
    $parms = $params;
    $parms['qid'] = $previd;
    $smarty->assign('url_prev',$this->CreateFrontendLink($id,$returnid,'default','',$parms,'',true));
    $smarty->assign('link_prev',$this->CreateFrontendLink($id,$returnid,'default',$this->Lang('prompt_prev'),$parms));
  }
if( $nextid != '' )
  {
    $parms = $params;
    $parms['qid'] = $nextid;
    $smarty->assign('url_next',$this->CreateFrontendLink($id,$returnid,'default','',$parms,'',true));
    $smarty->assign('link_next',$this->CreateFrontendLink($id,$returnid,'default',$this->Lang('prompt_next'),$parms));
  }

////
// Process The Template
////
if( $detailtemplatename == '' )
  {
    $detailtemplatename = 'detail'.$this->GetPreference(QUESTIONS_PREFSTDDETAIL_TEMPLATE);
  }

echo $this->ProcessTemplateFromDatabase($detailtemplatename);


// EOF
?>