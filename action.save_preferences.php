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

if( isset($params[QUESTIONS_PREF_EMAILFLAG]) )
  {
    $this->SetPreference(QUESTIONS_PREF_EMAILFLAG,
			 $params[QUESTIONS_PREF_EMAILFLAG]);
			 
  }
else
  {
    $this->RemovePreference(QUESTIONS_PREF_EMAILFLAG);
  }


//admin
if( isset($params[QUESTIONS_PREF_HIDEWYSIWYG]) )
  {
    $this->SetPreference(QUESTIONS_PREF_HIDEWYSIWYG,
			 $params[QUESTIONS_PREF_HIDEWYSIWYG]);
			 
  }
else
  {
    $this->RemovePreference(QUESTIONS_PREF_HIDEWYSIWYG);
  }
   
  //front
if( isset($params[QUESTIONS_PREF_FRONT_HIDEWYSIWYG]) )
  {
    $this->SetPreference(QUESTIONS_PREF_FRONT_HIDEWYSIWYG,
			 $params[QUESTIONS_PREF_FRONT_HIDEWYSIWYG]);
			 
  }
else
  {
    $this->RemovePreference(QUESTIONS_PREF_FRONT_HIDEWYSIWYG);
  }
  //end
  

if( isset($params[QUESTIONS_PREF_EMAILADDR]) )
  {
    $this->SetPreference(QUESTIONS_PREF_EMAILADDR,
			 trim($params[QUESTIONS_PREF_EMAILADDR]));
			 
  }
else
  {
    $this->RemovePreference(QUESTIONS_PREF_EMAILADDR);
  }


if( isset( $params['reset_email_template'] ) )
  {
    $fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
      'templates'.DIRECTORY_SEPARATOR.'orig_email_template.tpl';
    if( file_exists( $fn ) )
      {
	$template = @file_get_contents($fn);
	$this->SetTemplate(QUESTIONS_PREF_EMAILTEMPLATE,$template);
      }
  }
 else if( isset( $params['input_'.QUESTIONS_PREF_EMAILTEMPLATE] ) )
   {
     $this->SetTemplate(QUESTIONS_PREF_EMAILTEMPLATE,$params['input_'.QUESTIONS_PREF_EMAILTEMPLATE]);
   }

if( isset( $params['reset_form_template'] ) )
  {
    $fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
      'templates'.DIRECTORY_SEPARATOR.'orig_form_template.tpl';
    if( file_exists( $fn ) )
      {
	$template = @file_get_contents($fn);
	$this->SetPreference(QUESTIONS_PREFDFLTFORM_TEMPLATE,$template);
	unset( $params[QUESTIONS_PREFDFLTFORM_TEMPLATE] );
      }
  }
 else if( isset( $params[QUESTIONS_PREFDFLTFORM_TEMPLATE] ) )
   {
     $this->SetPreference(QUESTIONS_PREFDFLTFORM_TEMPLATE,$params[QUESTIONS_PREFDFLTFORM_TEMPLATE]);
   }

if( isset( $params['reset_summary_template'] ) )
  {
    $fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
      'templates'.DIRECTORY_SEPARATOR.'orig_summary_template.tpl';
    if( file_exists( $fn ) )
      {
	$template = @file_get_contents($fn);
	$this->SetPreference(QUESTIONS_PREFDFLTSUMMARY_TEMPLATE,$template);
	unset( $params[QUESTIONS_PREFDFLTSUMMARY_TEMPLATE] );
      }
  }
 else if( isset( $params[QUESTIONS_PREFDFLTSUMMARY_TEMPLATE] ) )
   {
     $this->SetPreference(QUESTIONS_PREFDFLTSUMMARY_TEMPLATE,$params[QUESTIONS_PREFDFLTSUMMARY_TEMPLATE]);
   }


if( isset( $params['reset_detail_template'] ) )
  {
    $fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
      'templates'.DIRECTORY_SEPARATOR.'orig_detail_template.tpl';
    if( file_exists( $fn ) )
      {
	$template = @file_get_contents($fn);
	$this->SetPreference(QUESTIONS_PREFDFLTDETAIL_TEMPLATE,$template);
	unset( $params[QUESTIONS_PREFDFLTDETAIL_TEMPLATE] );
      }
  }
 else if( isset( $params[QUESTIONS_PREFDFLTDETAIL_TEMPLATE] ) )
   {
     $this->SetPreference(QUESTIONS_PREFDFLTDETAIL_TEMPLATE,$params[QUESTIONS_PREFDFLTDETAIL_TEMPLATE]);
   }

//$this->Redirect($id,QUESTIONS_ACTION_DEFADMIN,'',$params);
$this->SetMessage($this->Lang('info_prefedited'));
     $this->RedirectToTab($id); 

// EOF
?>