<?php
#-------------------------------------------------------------------------
# Fork of Module: Questions - a simple Questions & Answer module
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

// This module is derived from CGExtensions
$cgextensions = cms_join_path(
  $gCms->config['root_path'],
  'modules',
  'CGExtensions',
  'CGExtensions.module.php'
);
if (!is_readable($cgextensions)) {
  echo '<h1><font color="red">ERROR: The CGExtensions module could not be found.</font></h1>';
  return;
}
require_once($cgextensions);


require_once(dirname(__FILE__) . '/defines.php');

##########################################################

class Questions2 extends CGExtensions
{

  /*---------------------------------------------------------
   GetName()
   ---------------------------------------------------------*/
  function GetName()
  {
    return 'Questions2';
  }

  /*---------------------------------------------------------
   GetFriendlyName()
   ---------------------------------------------------------*/
  function GetFriendlyName()
  {
    return $this->Lang('friendlyname');
  }


  /*---------------------------------------------------------
   GetVersion()
   ---------------------------------------------------------*/
  function GetVersion()
  {
    return '1.0';
  }


  /*---------------------------------------------------------
   GetHelp()
   ---------------------------------------------------------*/
  function GetHelp()
  {
    return $this->Lang('help');
  }


  /*---------------------------------------------------------
   GetAuthor()
   ---------------------------------------------------------*/
  function GetAuthor()
  {
    return 'calguy1000';
  }


  /*---------------------------------------------------------
   GetAuthorEmail()
   ---------------------------------------------------------*/
  function GetAuthorEmail()
  {
    return 'calguy1000@hotmail.com';
  }


  /*---------------------------------------------------------
   GetChangeLog()
   ---------------------------------------------------------*/
  function GetChangeLog()
  {
    return $this->Lang('changelog');
  }

  /*---------------------------------------------------------
   IsPluginModule()
   ---------------------------------------------------------*/
  function IsPluginModule()
  {
    return true;
  }


  /*---------------------------------------------------------
   HasAdmin()
   ---------------------------------------------------------*/
  function HasAdmin()
  {
    return true;
  }


  /*---------------------------------------------------------
   GetAdminSection()
   ---------------------------------------------------------*/
  function GetAdminSection()
  {
    return 'content';
  }


  /*---------------------------------------------------------
   GetAdminDescription()
   ---------------------------------------------------------*/
  function GetAdminDescription()
  {
    return $this->Lang('moddescription');
  }


  /*---------------------------------------------------------
   VisibleToAdminUser()
   ---------------------------------------------------------*/
  function VisibleToAdminUser()
  {
    return $this->CheckPermission(QUESTIONS_PERM) ||
      $this->CheckPermission(QUESTIONS_CANANSWERQUESTIONS) ||
      $this->CheckPermission(QUESTIONS_CANAPPROVEQUESTIONS) ||
      $this->CheckPermission('Modify Site Preferences') ||
      $this->CheckPermission('Modify Templates');
  }


  /*---------------------------------------------------------
   GetDependencies()
   ---------------------------------------------------------*/
  function GetDependencies()
  {
    return array('CGExtensions' => '1.13');
  }


  /*---------------------------------------------------------
   MinimumCMSVersion()
   ---------------------------------------------------------*/
  function MinimumCMSVersion()
  {
    return "1.4.1";
  }


  /*---------------------------------------------------------
   SetParameters()
   ---------------------------------------------------------*/
  function SetParameters()
  {
    $this->RegisterModulePlugin();
    $this->RestrictUnknownParams();

    $this->CreateParameter('nocaptcha', NULL, $this->Lang('help_nocaptcha'));
    $this->CreateParameter('category', 'category', $this->Lang('help_category'));
    $this->CreateParameter('detailpage', 'pagealias', $this->Lang('help_detailpage'));
    $this->CreateParameter(
      'detailtemplate',
      $this->Lang('info_admin_selected'),
      $this->Lang('help_detailtemplate')
    );
    $this->CreateParameter(
      'formtemplate',
      $this->Lang('info_admin_selected'),
      $this->Lang('help_formtemplate')
    );
    $this->CreateParameter('mode', 'summary', $this->Lang('help_mode'));
    $this->CreateParameter('nofilter', 'yes', $this->Lang('help_nofilter'));
    $this->CreateParameter('pagelimit', '20', $this->Lang('help_pagelimit'));
    $this->CreateParameter('sortby', 'created_desc', $this->Lang('help_sortby'));
    $this->CreateParameter(
      'summarytemplate',
      $this->Lang('info_admin_selected'),
      $this->Lang('help_summarytemplate')
    );
    $this->CreateParameter('quid', '', $this->Lang('help_qid'));
    $this->CreateParameter('no_answer_required', '', $this->Lang('help_no_answer_required'));


    $this->SetParameterType('nocaptcha', CLEAN_STRING);
    $this->SetParameterType('category', CLEAN_STRING);
    $this->SetParameterType('detailpage', CLEAN_STRING);
    $this->SetParameterType('detailtemplate', CLEAN_STRING);
    $this->SetParameterType('formtemplate', CLEAN_STRING);
    $this->SetParameterType('mode', CLEAN_STRING);
    $this->SetParameterType('nofilter', CLEAN_STRING);
    $this->SetParameterType('pagelimit', CLEAN_INT);
    $this->SetParameterType('sortby', CLEAN_STRING);
    $this->SetParameterType('summarytemplate', CLEAN_STRING);
    $this->SetParameterType('quid', CLEAN_INT);
    $this->SetParameterType('no_answer_required', CLEAN_STRING);
    $this->SetParameterType('input_author', CLEAN_STRING);
    $this->SetParameterType('error', CLEAN_STRING);
    $this->SetParameterType('input_question', CLEAN_STRING);
    $this->SetParameterType('message', CLEAN_STRING);
  }


  /*---------------------------------------------------------
   InstallPostMessage()
   ---------------------------------------------------------*/
  function InstallPostMessage()
  {
    return $this->Lang('postinstall');
  }


  /*---------------------------------------------------------
   UninstallPostMessage()
   ---------------------------------------------------------*/
  function UninstallPostMessage()
  {
    return $this->Lang('postuninstall');
  }


  /*---------------------------------------------------------
   UninstallPreMessage()
   ---------------------------------------------------------*/
  function UninstallPreMessage()
  {
    return $this->Lang('really_uninstall');
  }


  function UpdateHierarchyPositions()
  {
    $db = &$this->GetDb();

    $query = "SELECT id FROM " . QUESTIONS_CATEGORIES_TABLE;
    $dbresult = $db->Execute($query);
    while ($dbresult && $row = $dbresult->FetchRow()) {
      $current_hierarchy_position = "";
      $current_long_name = "";
      $content_id = $row['id'];
      $current_parent_id = $row['id'];
      $count = 0;

      while ($current_parent_id > -1) {
        $query = "SELECT id, name, parent FROM " . QUESTIONS_CATEGORIES_TABLE . " WHERE id = ?";
        $row2 = $db->GetRow($query, array($current_parent_id));
        if ($row2) {
          $current_hierarchy_position = str_pad($row2['id'], 5, '0', STR_PAD_LEFT) . "." . $current_hierarchy_position;
          $current_long_name = $row2['name'] . ' | ' . $current_long_name;
          $current_parent_id = $row2['parent'];
          $count++;
        } else {
          $current_parent_id = 0;
        }
      }

      if (strlen($current_hierarchy_position) > 0) {
        $current_hierarchy_position = substr($current_hierarchy_position, 0, strlen($current_hierarchy_position) - 1);
      }

      if (strlen($current_long_name) > 0) {
        $current_long_name = substr($current_long_name, 0, strlen($current_long_name) - 3);
      }

      $query = "UPDATE " . QUESTIONS_CATEGORIES_TABLE . " SET hierarchy = ?, long_name = ? WHERE id = ?";
      $db->Execute($query, array($current_hierarchy_position, $current_long_name, $content_id));
    }
  }


  function CreateParentDropdown($id, $catid = -1, $selectedvalue = -1, $none = true)
  {
    $db = &$this->GetDb();

    $longname = '';

    $items = array();
    if ($none == true) {
      $items['(None)'] = '-1';
    }

    $query = "SELECT hierarchy, long_name FROM " . QUESTIONS_CATEGORIES_TABLE . " WHERE id = ?";
    $dbresult = $db->Execute($query, array($catid));
    while ($dbresult && $row = $dbresult->FetchRow()) {
      $longname = $row['hierarchy'] . '%';
    }

    $query = "SELECT id, name, hierarchy, long_name FROM " . QUESTIONS_CATEGORIES_TABLE . " WHERE hierarchy not like ? ORDER by hierarchy";
    $dbresult = $db->Execute($query, array($longname));
    while ($dbresult && $row = $dbresult->FetchRow()) {
      $items[$row['long_name']] = $row['id'];
    }

    return $this->CreateInputDropdown($id, 'parent', $items, -1, $selectedvalue);
  }


  function GetUsername()
  {
    global $gCms;
    $userops = UserOperations::get_instance();
    $oneuser = $userops->LoadUserByID(get_userid());
    if ($oneuser) {
      return $oneuser->username;
    }
    return '';
  }


  function SearchResult($returnid, $articleid, $attr = '')
  {
    if ($attr == 'question') {
      $db = &$this->GetDb();
      $q = "SELECT * FROM " . QUESTIONS_TABLE . " WHERE id = ?";
      $dbresult = &$db->Execute($q, array($articleid));
      if ($dbresult) {
        $row = $dbresult->FetchRow();

        $result = array();
        $result[0] = $this->GetFriendlyName();
        $result[1] = $row['question'];
        $result[2] = $this->CreateLink(
          $articleid,
          'default',
          $returnid,
          $row['question'],
          array(
            'mode' => 'detailed',
            'qid' => $articleid
          ),
          '',
          true
        );
        return $result;
      }
    }
  }

  function SearchReindex(&$module)
  {
    $db = &$this->GetDb();
    $q = "SELECT * FROM " . QUESTIONS_TABLE . " ORDER BY created";
    $result = &$db->Execute($q);
    while ($result && !$result->EOF) {
      if ($result->fields['approved_date'] != NULL) {
        $str = $result->fields['created'] . ' ' . $result->fields['author'] . ' ' . $result->fields['question'];
        if ($result->fields['answer'] != '') {
          $str .= ' ' . $result->fields['answer'];
          $str .= ' ' . $result->fields['answered_by'];
        }
        $module->AddWords(
          $this->GetName(),
          $result->fields['id'],
          'question',
          $str
        );
      }
      $result->MoveNext();
    }
  }
} // class
