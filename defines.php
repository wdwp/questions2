<?php
define('QUESTIONS_TABLE',cms_db_prefix().'module_questions_questions');
define('QUESTIONS_SEQUENCE',cms_db_prefix().'module_questions_questions_seq');
define('QUESTIONS_CATEGORIES_TABLE',cms_db_prefix().'module_questions_categories');
define('QUESTIONS_CATEGORIES_SEQUENCE',cms_db_prefix().'module_questions_categories_seq');
define('QUESTIONS_PERM','Manage Questions');
define('QUESTIONS_PARAM_ACTIVETAB','active_tab');
define('QUESTIONS_PARAM_ERRORS','errors');
define('QUESTIONS_ACTION_DEFADMIN','defaultadmin');
define('QUESTIONS_PREF_EMAILFLAG','email_on_new_question');

define('QUESTIONS_PREF_HIDEWYSIWYG','hide_on_admin_question_wysiwyg');
define('QUESTIONS_PREF_FRONT_HIDEWYSIWYG','hide_on_front_question_wysiwyg');

define('QUESTIONS_PREF_EMAILADDR','emailaddr');
define('QUESTIONS_PREF_EMAILTEMPLATE','emailtemplate');
define('QUESTIONS_PREFSTAB','preferences');
define('QUESTIONS_QUESTIONSTAB','questions');
define('QUESTIONS_CATEGORIESTAB','categories');
define('QUESTIONS_FORMTEMPLATE_TAB','formtemplate');
define('QUESTIONS_SUMMARYTEMPLATE_TAB','summarytemplate');
define('QUESTIONS_DETAILTEMPLATE_TAB','detailtemplate');
define('QUESTIONS_PREFDFLTFORM_TEMPLATE','default_form_template');
define('QUESTIONS_PREFDFLTSUMMARY_TEMPLATE','default_summary_template');
define('QUESTIONS_PREFDFLTDETAIL_TEMPLATE','default_detail_template');
define('QUESTIONS_FILTER_QUESTIONTYPES','filter_questiontypes');
define('QUESTIONS_FILTER_SUBJECT_KEYWORDS','filter_subjecttext');
define('QUESTIONS_FILTER_CATEGORY','filter_category');
define('QUESTIONS_FILTER_SHOWCHILDCATEGORIES','filter_showchildcategories');
define('QUESTIONS_FILTER_PAGELIMIT','filter_pagelimit');
define('QUESTIONS_CANANSWERQUESTIONS','Can Answer Questions');
define('QUESTIONS_CANAPPROVEQUESTIONS','Can Approve Questions');
define('QUESTIONS_PREFSTDFORM_TEMPLATE','standard_form_template');
define('QUESTIONS_PREFSTDSUMMARY_TEMPLATE','standard_summary_template');
define('QUESTIONS_PREFSTDDETAIL_TEMPLATE','standard_detail_template');
define('QUESTIONS_PREF_DEFAULTCATEGORY','default_category');
?>