<?php
#-------------------------------------------------------------------------
# Module: Skeleton - a pedantic "starting point" module
# Version: 1.3, SjG
# Method: Install
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------

/*
    For separated methods, you'll always want to start with the following
    line which check to make sure that method was called from the module
    API, and that everything's safe to continue:
*/ 
if (!isset($gCms)) exit;


/* After this, the code is identical to the code that would otherwise be
    wrapped in the Install() method in the module body.
*/

$db =& $gCms->GetDb();

// mysql-specific, but ignored by other database
$taboptarray = array('mysql' => 'TYPE=MyISAM');

$dict = NewDataDictionary($db);

// table schema description
$flds = "id I KEY,
         category_id I,
         created ".CMS_ADODB_DT." NOT NULL,
         author  C(80),
         question TEXT,
         answer TEXT,
         answered_by C(80),
         answered_date ".CMS_ADODB_DT.",
         approved_by C(80),
         approved_date ".CMS_ADODB_DT;

// create it. This should do error checking, but I'm a lazy sod.
$sqlarray = $dict->CreateTableSQL(QUESTIONS_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// create a sequence
$db->CreateSequence(QUESTIONS_SEQUENCE);


$flds = "id I KEY,
         parent I,
         name C(80),
         long_name X,
         hierarchy C(255)";
// create it. This should do error checking, but I'm a lazy sod.
$sqlarray = $dict->CreateTableSQL(QUESTIONS_CATEGORIES_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
// create a sequence
$db->CreateSequence(QUESTIONS_CATEGORIES_SEQUENCE);

// create a permission
$this->CreatePermission(QUESTIONS_PERM, QUESTIONS_PERM);
$this->CreatePermission(QUESTIONS_CANANSWERQUESTIONS,QUESTIONS_CANANSWERQUESTIONS);
$this->CreatePermission(QUESTIONS_CANAPPROVEQUESTIONS,QUESTIONS_CANAPPROVEQUESTIONS);

// create a preference
//$this->SetPreference("sing_loudly", true);


$fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
  'templates'.DIRECTORY_SEPARATOR.'orig_summary_template.tpl';
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetPreference(QUESTIONS_PREFDFLTSUMMARY_TEMPLATE,$template);
    $this->SetTemplate('summarySample',$template);
    $this->SetPreference(QUESTIONS_PREFSTDSUMMARY_TEMPLATE,'Sample');
  }

$fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
  'templates'.DIRECTORY_SEPARATOR.'orig_detail_template.tpl';
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetPreference(QUESTIONS_PREFDFLTDETAIL_TEMPLATE,$template);
    $this->SetTemplate('detailSample',$template);
    $this->SetPreference(QUESTIONS_PREFSTDDETAIL_TEMPLATE,'Sample');
  }

$fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
  'templates'.DIRECTORY_SEPARATOR.'orig_form_template.tpl';
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetPreference(QUESTIONS_PREFDFLTFORM_TEMPLATE,$template);
    $this->SetTemplate('formSample',$template);
    $this->SetPreference(QUESTIONS_PREFSTDFORM_TEMPLATE,'Sample');
  }

$fn = dirname(__FILE__).DIRECTORY_SEPARATOR.
  'templates'.DIRECTORY_SEPARATOR.'orig_email_template.tpl';
if( file_exists( $fn ) )
  {
    $template = @file_get_contents($fn);
    $this->SetTemplate(QUESTIONS_PREF_EMAILTEMPLATE,$template);
  }

//add a sample category
$newid = $db->GenID(QUESTIONS_CATEGORIES_SEQUENCE);
$q = 'INSERT INTO '.QUESTIONS_CATEGORIES_TABLE.' (id,parent,name) VALUES (?,-1,?)';
$db->Execute( $q, array( $newid, $this->Lang('category_general') ) );
$this->UpdateHierarchyPositions();


// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));

?>