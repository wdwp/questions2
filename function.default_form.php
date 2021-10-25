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

$formtemplatename = '';
if( isset( $params['formtemplate'] ) )
  {
    $formtemplatename = $params['formtemplate'];
  }
$categories = '';
if( isset($params['category']) && $params['category'] != '' )
  {
    $categories = $params['category'];
  }


////
// Begin Form
////

// do a little magic here, and try to get the logged in users name
// from the frontend users module, if it's available.
$author = '';
$feusers = $this->GetModuleInstance('FrontEndUsers');
if( $feusers )
  {
    $userid = $feusers->LoggedInId();
    if( $userid !== false )
      {
	$author = $feusers->GetUserName($userid);
      }
  }

$smarty =& $this->smarty;
$params['origaction'] = 'default';
$params['action'] = 'default_formsubmit';
$smarty->assign('formstart',
		$this->CreateFrontendFormStart($id,$returnid,'default_formsubmit','post','',true,'', $params));
$smarty->assign('prompt_author',$this->Lang('prompt_author'));
$smarty->assign('input_author',
		$this->CreateInputText($id,'input_author',$author,40));
$smarty->assign('prompt_question',$this->Lang('prompt_question'));
$smarty->assign('input_question',
		$this->CreateTextArea($this->GetPreference('hide_on_front_question_wysiwyg',0),$id,'','input_question'));
$smarty->assign('submit',
		$this->CreateInputSubmit($id,'questionsubmit',$this->Lang('submit_question')));
$smarty->assign('formend',$this->CreateFormEnd());
if( isset($params['error']) )
  {
    $smarty->assign('error',$params['error']);
  }
if( isset($params['message']) )
  {
    $smarty->assign('message',$params['message']);
  }

$captcha =& $this->GetModuleInstance('Captcha');
if( is_object($captcha) && !isset($params['nocaptcha']) )
  {
    $smarty->assign('prompt_captcha',
		    $this->Lang('prompt_captcha'));
    $smarty->assign('image_captcha',
		    $captcha->getCaptcha());
    $smarty->assign('input_captcha',
		    $this->createInputText($id,'input_captcha','',40));
  }
////
// End Form
////

if( $formtemplatename == '' )
  {
    $formtemplatename = 'form'.$this->GetPreference(QUESTIONS_PREFSTDFORM_TEMPLATE);
  }

echo $this->ProcessTemplateFromDatabase($formtemplatename);

// EOF
?>