<?php
#-------------------------------------------------------------------------
# Module: Skeleton - a pedantic "starting point" module
# Version: 1.3, SjG
# Method: Uninstall
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
    wrapped in the Uninstall() method in the module body.
*/

$db =& $gCms->GetDb();

// remove the database table
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( QUESTIONS_TABLE );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( QUESTIONS_CATEGORIES_TABLE );
$dict->ExecuteSQLArray($sqlarray);

// remove the sequence
$db->DropSequence( QUESTIONS_SEQUENCE );
$db->DropSequence( QUESTIONS_CATEGORIES_SEQUENCE );

// remove the permissions
$this->RemovePermission(QUESTIONS_PERM);
$this->RemovePermission(QUESTIONS_CANANSWERQUESTIONS);
$this->RemovePermission(QUESTIONS_CANAPPROVEQUESTIONS);
		
// remove the preference
$this->RemovePreference();
		
// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

?>