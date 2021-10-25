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

if( !isset( $params['input_author']) || trim($params['input_author']) == '' )
  {
    $params['input_author'] = $this->Lang('anonymous');
//     $params['error'] = $this->Lang('error_missingauthor');
//     $this->RedirectForFrontend($id,$returnid,'default',$params);
  }
if( !isset($params['input_question']) || trim($params['input_question']) == '' )
  {
    $params['error'] = $this->Lang('error_missingquestion');
    $this->RedirectForFrontend($id,$returnid,'default',$params);
  }
if( !isset($params['category']) || trim($params['category']) == '' )
  {
    $params['error'] = $this->Lang('error_insufficientparams').' category';
    $this->RedirectForFrontend($id,$returnid,'default',$params);
  }
if( count(explode(',',$params['category'])) > 1 )
  {
    $params['error'] = $this->Lang('error_insvalidparam').' category';
    $this->RedirectForFrontend($id,$returnid,'default',$params);
  }
if( isset($params['input_captcha']) )
  {
    $captcha =& $this->GetModuleInstance('Captcha');
    if( is_object($captcha) )
      {
	$valid = $captcha->checkCaptcha($params['input_captcha']);
	if( $valid == FALSE )
	  {
	    $params['error'] = $this->Lang('error_invalidcaptcha');
	    $this->RedirectForFrontend($id,$returnid,'default',$params);
	  }
      }
  }
$author = trim($params['input_author']);
$question = trim($params['input_question']);
$category = trim($params['category']);

// We have enough information now...
// we can add the question
$db =& $this->GetDb();

// Get the category id from the category name
$q = "SELECT id FROM ".QUESTIONS_CATEGORIES_TABLE." WHERE name = ?";
$row = $db->GetRow($q,array($category));
if( $row == false || !isset($row['id']) )
  {
    $params['error'] = $this->Lang('error_invalidcategory',$category);
    $this->RedirectForFrontend($id,$returnid,'default',$params);
  }

$newid = $db->GenID(QUESTIONS_SEQUENCE);
$q = "INSERT INTO ".QUESTIONS_TABLE." (id,category_id,created,author,question)
           VALUES (?,?,?,?,?)";
$now = time();
$dbresult = $db->Execute($q,array($newid,$row['id'],trim($db->DbTimestamp($now),"'"),$author,$question));
if( !$dbresult )
  {
    $params['error'] = $this->Lang('error_dberror',$category).'&nbsp'.$db->ErrorMsg();
    $this->RedirectForFrontend($id,$returnid,'default',$params);
  }


$search = $this->GetModuleInstance('Search');
if( $search )
  {
    $str .= $now.' '.$author.' '.$question;
    $search->AddWords($this->GetName(),$newid,'question',$str);
  }

if( $this->GetPreference(QUESTIONS_PREF_EMAILFLAG) == 1 &&
    $this->GetPreference(QUESTIONS_PREF_EMAILADDR) != '' )
  { 
    $cmsmailer = $this->GetModuleInstance('CMSMailer');
    if( $cmsmailer )
      {
	$smarty =& $this->smarty;
	$smarty->assign('emailto',$this->GetPreference(QUESTIONS_PREF_EMAILADDR));
	$smarty->assign('subject',$this->Lang('prompt_email_subject'));
	$smarty->assign('msgid',$newid);
	$smarty->assign('category',$category);
	$smarty->assign('created',$now);
	$smarty->assign('author',$author);
	$smarty->assign('question',$question);
	$email_body = $this->ProcessTemplateFromDatabase(QUESTIONS_PREF_EMAILTEMPLATE);

	$cmsmailer->AddAddress($this->GetPreference(QUESTIONS_PREF_EMAILADDR));
	$cmsmailer->SetSubject($this->Lang('prompt_email_subject'));
	$cmsmailer->SetBody($email_body);
	$cmsmailer->IsHTML(false);
	$cmsmailer->SetCharSet('utf-8');
	$cmsmailer->Send();
      }
  }
    

// it all worked if we got here (hopefully)
$params['message'] = $this->Lang('info_questionadded');
$this->RedirectForFrontend($id,$returnid,'default',$params);

// EOF
?>