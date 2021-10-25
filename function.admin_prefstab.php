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

if( !$this->CheckPermission('Modify Site Preferences') )
  {
    return;
  }
$this->SetCurrentTab('preferences');
$smarty =& $this->smarty;

$questions_pref_emailflag = $this->GetPreference(QUESTIONS_PREF_EMAILFLAG,0);
if( isset( $params[QUESTIONS_PREF_EMAILFLAG] ) )
  {
    $questions_pref_emailflag = $params[QUESTIONS_PREF_EMAILFLAG];
  }
$questions_pref_emailaddr = $this->GetPreference(QUESTIONS_PREF_EMAILADDR);
if( isset( $params[QUESTIONS_PREF_EMAILADDR] ) )
  {
    $questions_pref_emailaddr = $params[QUESTIONS_PREF_EMAILADDR];
  }
$questions_pref_emailtemplate = $this->GetTemplate(QUESTIONS_PREF_EMAILTEMPLATE);

//nuno
$hide_on_admin_question_wysiwyg = isset($params[QUESTIONS_PREF_HIDEWYSIWYG])?$params[QUESTIONS_PREF_HIDEWYSIWYG]:$this->GetPreference(QUESTIONS_PREF_HIDEWYSIWYG,0);

$hide_on_front_question_wysiwyg = isset($params[QUESTIONS_PREF_FRONT_HIDEWYSIWYG])?$params[QUESTIONS_PREF_FRONT_HIDEWYSIWYG]:$this->GetPreference(QUESTIONS_PREF_FRONT_HIDEWYSIWYG,0);
//end
if( isset( $params[QUESTIONS_PREF_EMAILTEMPLATE] ) )
  {
    $questions_pref_emailtemplate = $params[QUESTIONS_PREF_EMAILTEMPLATE];
  }
$default_form_template = $this->GetPreference(QUESTIONS_PREFDFLTFORM_TEMPLATE);
if( isset( $params[QUESTIONS_PREFDFLTFORM_TEMPLATE] ) )
  {
    $default_form_template = $params[QUESTIONS_PREFDFLTFORM_TEMPLATE];
  }
$default_summary_template = $this->GetPreference(QUESTIONS_PREFDFLTSUMMARY_TEMPLATE);
if( isset( $params[QUESTIONS_PREFDFLTSUMMARY_TEMPLATE] ) )
  {
    $default_summary_template = $params[QUESTIONS_PREFDFLTSUMMARY_TEMPLATE];
  }
$default_detail_template = $this->GetPreference(QUESTIONS_PREFDFLTDETAIL_TEMPLATE);
if( isset( $params[QUESTIONS_PREFDFLTDETAIL_TEMPLATE] ) )
  {
    $default_detail_template = $params[QUESTIONS_PREFDFLTDETAIL_TEMPLATE];
  }

$smarty->assign('formstart',
		$this->CreateFormStart($id,'save_preferences',
				       $returnid,'post','',false,''
				       ));
$smarty->assign('submit',
		$this->CreateInputSubmit($id,'submit',
					 $this->Lang('submit')));
$smarty->assign('formend',
		$this->CreateFormEnd());

$smarty->assign('legend_email_settings',
		$this->Lang('legend_email_settings'));
$smarty->assign('prompt_email_on_new_question',
		$this->Lang('prompt_email_on_new_question'));
$smarty->assign('input_'.QUESTIONS_PREF_EMAILFLAG,
		$this->CreateInputCheckbox($id,QUESTIONS_PREF_EMAILFLAG,
					   1,
					   $questions_pref_emailflag));
$smarty->assign('prompt_emailaddr',
		$this->Lang('prompt_emailaddr'));
$smarty->assign('input_'.QUESTIONS_PREF_EMAILADDR,
		$this->CreateInputText($id,QUESTIONS_PREF_EMAILADDR,
				       $questions_pref_emailaddr, 40, 80));
$smarty->assign('prompt_emailtemplate',
		$this->Lang('prompt_emailtemplate'));
$smarty->assign('input_'.QUESTIONS_PREF_EMAILTEMPLATE,
		$this->CreateTextArea(true,$id,$questions_pref_emailtemplate,
				      'input_'.QUESTIONS_PREF_EMAILTEMPLATE));
$smarty->assign('reset_email_template',
		$this->CreateInputSubmit($id,'reset_email_template',
					 $this->Lang('resettodefaults')));

$smarty->assign('legend_default_templates',
		$this->Lang('legend_default_templates'));
$smarty->assign('prompt_form_template',
		$this->Lang('prompt_default_form_template'));
$smarty->assign('input_form_template',
		$this->CreateTextArea(false, $id,
				      $default_form_template,
				      QUESTIONS_PREFDFLTFORM_TEMPLATE));
$smarty->assign('reset_form_template',
		$this->CreateInputSubmit($id,'reset_form_template',
					 $this->Lang('resettodefaults')));
$smarty->assign('prompt_summary_template',
		$this->Lang('prompt_default_summary_template'));
$smarty->assign('input_summary_template',
		$this->CreateTextArea(false, $id,
				      $default_summary_template,
				      QUESTIONS_PREFDFLTSUMMARY_TEMPLATE));
$smarty->assign('reset_summary_template',
		$this->CreateInputSubmit($id,'reset_summary_template',
					 $this->Lang('resettodefaults')));
$smarty->assign('prompt_detail_template',
		$this->Lang('prompt_default_detail_template'));
$smarty->assign('input_detail_template',
		$this->CreateTextArea(false, $id,
				      $default_detail_template,
				      QUESTIONS_PREFDFLTDETAIL_TEMPLATE));
$smarty->assign('reset_detail_template',
		$this->CreateInputSubmit($id,'reset_detail_template',
					 $this->Lang('resettodefaults')));

//admin
$smarty->assign('prompt_hide_on_admin_question_wysiwyg',
		$this->Lang('hide_on_admin_question_wysiwyg'));


$smarty->assign('input_'.QUESTIONS_PREF_HIDEWYSIWYG,
		$this->CreateInputCheckbox($id,QUESTIONS_PREF_HIDEWYSIWYG,
					   1,
					   $hide_on_admin_question_wysiwyg));
//front					   
$smarty->assign('prompt_hide_on_front_question_wysiwyg',
		$this->Lang('hide_on_front_question_wysiwyg'));


$smarty->assign('input_'.QUESTIONS_PREF_FRONT_HIDEWYSIWYG,
		$this->CreateInputCheckbox($id,QUESTIONS_PREF_FRONT_HIDEWYSIWYG,
					   1,
					   $hide_on_front_question_wysiwyg));

//end

echo $this->ProcessTemplate('prefs.tpl');
// EOF
?>