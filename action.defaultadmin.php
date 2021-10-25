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

$active_tab = -1;
if( isset($params[QUESTIONS_PARAM_ACTIVETAB]))
  {
    $active_tab = $params[QUESTIONS_PARAM_ACTIVETAB];
  }

if( isset($params[QUESTIONS_PARAM_ERRORS]) )
  {
    echo $this->ShowErrors($params[QUESTIONS_PARAM_ERRORS]);
  }

echo $this->StartTabHeaders();
if( $this->CheckPermission(QUESTIONS_PERM) ||
    $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) ||
    $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS) )
  {
    echo $this->SetTabHeader(QUESTIONS_QUESTIONSTAB,
			     $this->Lang('title_questions_tab'));
  }

if( $this->CheckPermission(QUESTIONS_PERM) )
  {
    echo $this->SetTabHeader(QUESTIONS_CATEGORIESTAB,
			     $this->Lang('title_categories_tab'));
  }
if( $this->CheckPermission('Modify Templates') )
  {
    echo $this->SetTabHeader(QUESTIONS_FORMTEMPLATE_TAB,
			     $this->Lang('title_formtemplate_tab'));
    echo $this->SetTabHeader(QUESTIONS_SUMMARYTEMPLATE_TAB,
			     $this->Lang('title_summarytemplate_tab'));
    echo $this->SetTabHeader(QUESTIONS_DETAILTEMPLATE_TAB,
			     $this->Lang('title_detailtemplate_tab'));
  }
if( $this->CheckPermission('Modify Site Preferences') )
  {
    echo $this->SetTabHeader(QUESTIONS_PREFSTAB,
			     $this->Lang('title_preferences_tab'));
  }
echo $this->EndTabHeaders();

echo $this->StartTabContent();
if( $this->CheckPermission(QUESTIONS_PERM) ||
    $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) ||
    $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS) )
  {
    echo $this->StartTab(QUESTIONS_QUESTIONSTAB);
    include(dirname(__FILE__).'/function.admin_questionstab.php');
    echo $this->EndTab();
  }
if( $this->CheckPermission(QUESTIONS_PERM) )
  {
    echo $this->StartTab(QUESTIONS_CATEGORIESTAB);
    include(dirname(__FILE__).'/function.admin_categoriestab.php');
    echo $this->EndTab();
  }
if( $this->CheckPermission('Modify Templates') )
  {
    echo $this->StartTab(QUESTIONS_FORMTEMPLATE_TAB);
    include(dirname(__FILE__).'/function.admin_formtemplatetab.php');
    echo $this->EndTab();
    echo $this->StartTab(QUESTIONS_SUMMARYTEMPLATE_TAB);
    include(dirname(__FILE__).'/function.admin_summarytemplatetab.php');
    echo $this->EndTab();
    echo $this->StartTab(QUESTIONS_DETAILTEMPLATE_TAB);
    include(dirname(__FILE__).'/function.admin_detailtemplatetab.php');
    echo $this->EndTab();
  }
if( $this->CheckPermission('Modify Site Preferences') )
  {
    echo $this->StartTab(QUESTIONS_PREFSTAB);
    include(dirname(__FILE__).'/function.admin_prefstab.php');
    echo $this->EndTab();
  }
echo $this->EndTabContent();

// EOF
?>