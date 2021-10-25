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

if( isset($params['cancel']) ) 
  {
    $this->RedirectToTab($id,$params[QUESTIONS_PARAM_ACTIVETAB]);
  }

$category = $this->GetPreference(QUESTIONS_PREF_DEFAULTCATEGORY,'');
if( isset( $params['parent'] ) )
  {
    $category = $params['parent'];
  }
$author = $this->GetUsername();
if( isset( $params['input_author'] ) )
  {
    $author = $params['input_author'];
  }
if( $author == '' )
  {
    $author = $this->Lang('anonymous');
  }
$question = '';
if( isset( $params['input_question'] ) )
  {
    $question = $params['input_question'];
  }
$answer = '';
if( isset( $params['input_answer'] ) )
  {
    $answer = $params['input_answer'];
  }
$approved = '';
if( isset( $params['input_approved'] ) )
  {
    $approved = $params['input_approved'];
  }

if( isset( $params['submit']) )
  {
    if( $category == '' || $question == '' )
      {
	 $this->SetError($this->Lang('error_insufficientparams'));
     $this->RedirectToTab($id,'','','admin_addquestion');

	return;
      }
    else
      {
	$db =& $this->GetDb();
	$now = trim($db->DbTimeStamp(time()),"'");
	$flds = array('id','category_id','created','author','question');
	$newid = $db->GenId(QUESTIONS_SEQUENCE);
	$parms = array($newid,$category,$now,$author,$question);
	$qmarks = array("?","?","?","?","?");
	if( $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) &&
	    $answer != '' )
	  {
	    $flds[] = 'answer';    $parms[] = $answer; $qmarks[] = "?";
	    $flds[] = 'answered_by'; $parms[] = $this->GetUsername(); $qmarks[] = "?";
	    $flds[] = 'answered_date'; $parms[] = $now; $qmarks[] = "?";
	  }
	if( $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS) &&
	    $approved != '')
	  {
	    $flds[] = 'approved_by'; $parms[] = $this->GetUsername(); $qmarks[] = "?";
	    $flds[] = 'approved_date'; $parms[] = $now; $qmarks[] = "?";
	  }
	$fmtstr = 'INSERT INTO '.QUESTIONS_TABLE.' (%s) VALUES (%s)';
	$fldtxt = implode(',',$flds);
	$qtxt = implode(",",$qmarks);
	$q = sprintf($fmtstr,$fldtxt,$qtxt);
	$dbresult = $db->Execute( $q, $parms );
	$this->SetPreference(QUESTIONS_PREF_DEFAULTCATEGORY,$category);
	
	$search = $this->GetModuleInstance('Search');
  if ($search) {
    $str = $author . ' ' . $question;
    if ($answer != '') {
      $str .= ' ' . $answer;
    }
    $str = trim(preg_replace('/\r?\n/', '', strip_tags($str)));

    $search->AddWords($this->GetName(), $newid, 'question', $str);
  }

	$this->SetMessage($this->Lang('info_questionadded'));
	$this->RedirectToTab($id);
      }
  }

$smarty =& $this->smarty;
$smarty->assign('startform',$this->CreateFormStart($id,'admin_addquestion',$returnid));
$smarty->assign('endform',$this->CreateFormEnd());
$smarty->assign('submit',$this->CreateInputSubmit($id,'submit',$this->Lang('submit')));
$smarty->assign('cancel',$this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
$smarty->assign('hidden',$this->CreateInputHidden($id,QUESTIONS_PARAM_ACTIVETAB,
						  $params[QUESTIONS_PARAM_ACTIVETAB]));
$smarty->assign('prompt_category',$this->Lang('prompt_category'));
$smarty->assign('prompt_question',$this->Lang('prompt_question'));
$smarty->assign('prompt_answer',$this->Lang('prompt_answer'));
$smarty->assign('prompt_author',$this->Lang('prompt_author'));
if( $this->CheckPermission(QUESTIONS_PERM) )
  {
    $smarty->assign('input_category',
		    $this->CreateParentDropdown( $id, -1, $category, false )); 
	$smarty->assign('input_question',
		    $this->CreateTextArea($this->GetPreference('hide_on_admin_question_wysiwyg',0),$id,$question,'input_question'));
    $smarty->assign('input_author',
		    $this->CreateInputText($id,'input_author',$author,40,80));
  }
else
  {
    $smarty->assign('input_category',$category);
    $smarty->assign('input_question',$question);
    $smarty->assign('input_author',$question);
  }
if( $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) )
  {
    $smarty->assign('input_answer',
		    $this->CreateTextArea(true,$id,$answer,'input_answer'));
  }
else
  {
    $smarty->assign('input_answer',$answer);
  }
if( $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS) )
  {
    $smarty->assign('prompt_approved',$this->Lang('prompt_approved'));
    $smarty->assign('input_approved',$this->CreateInputCheckbox($id,'input_approved','yes',
								$approved));
  }

echo $this->ProcessTemplate('admin_addquestion.tpl');
// EOF
