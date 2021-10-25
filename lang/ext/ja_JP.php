<?php
$lang['help_no_answer_required'] = 'Allow display of unanswered and unapproved messages in summary mode';
$lang['help_nocaptcha'] = 'If the Captcha module is installed, the question submit form will automatically use it for security purposes.  This can be disabled by supplying the \'nocaptcha\' parameter in the tag <em>(only applies to the form mode)</em>';
$lang['error_invalidcaptcha'] = 'The security text supplied is incorrect';
$lang['prompt_captcha'] = 'For security purposes, please enter the text displayed in this image.';
$lang['title_form_template'] = 'Add/Edit Form Template';
$lang['title_summary_template'] = 'Add/Edit Summary Template';
$lang['title_detail_template'] = 'Add/Edit Detail Template';
$lang['prompt_allcategories'] = 'All Categories';
$lang['anonymous'] = 'Anonymous';
$lang['prompt_prev'] = '前';
$lang['prompt_next'] = '次';
$lang['help_category'] = 'The category(ies) used for display.  In detail mode, this parameter is ignored.  In summary mode, this may be a comma separated list of categories to indicate which categories to display.  In form mode, this parameter indicates what category new questions should be placed in';
$lang['help_detailpage'] = 'This parameter is used in summarymode to indicate that a new page (possibly using a different template) is to be used to display the detail results';
$lang['help_detailtemplate'] = 'The name of the template to be used when displaying a question in detail mode.  This template must exist in the detail template list in the admin section';
$lang['help_formtemplate'] = 'The name of the template to be used when displaying the question submit form.  The template specified in this paramter must exist in the form template list in the admin section';
$lang['help_summarytemplate'] = 'The name of the template to be used when displaying one or more questions in summary mode.  This template must exist in the summary template list in the admin section';
$lang['help_mode'] = 'One of \'summary\',\'form\',or \'detailed\'.  If no mode is specified, summary is assumed';
$lang['help_nofilter'] = 'A flag, only used in summary mode, that would indicate that the filtering form should be removed';
$lang['help_pagelimit'] = 'The number of records to show in a page in summary mode';
$lang['help_sortby'] = 'A parameter indicating how records should be sorted in summary mode.  Possible values are:
<ul>
  <li>author_asc:<br/>Sort by author in ascending order</li>
  <li>author_desc:<br/>Sort by author in descending order</li>
  <li>answered_asc:<br/>Sort by answered date in ascending order</li>
  <li>answered_desc:<br/>Sort by answered date in descending order</li>
  <li>answered_by_asc:<br/>Sort by answering person in ascending order</li>
  <li>answered_by_desc:<br/>Sort by answering person in descending order</li>
  <li>approved_asc:<br/>Sort by approved date in ascending order</li>
  <li>approved_desc:<br/>Sort by approved date in descending order</li>
  <li>approved_by_asc:<br/>Sort by approving person in ascending order</li>
  <li>approved_by_desc:<br/>Sort by approving person in descending order</li>
  <li>category_asc:<br/>Sort by category name in ascending order</li>
  <li>category_desc:<br/>Sort by category name in descending order</li>
  <li>created_asc:<br/>Sort by created date in ascending order</li>
  <li>created_desc:<br/>Sort by created date in descending order</li>
</ul>
';
$lang['help_qid'] = 'In detailed mode, the id of the questin to be displayed.  Normally, this will not need to be used, as the summary link will provide it when the \'More\' link is clicked.  However it can be used to display a specific question in detail mode';
$lang['info_questionadded'] = 'Question successfully added';
$lang['info_admin_selected'] = 'The default value for this parameter is selected by the administrator';
$lang['legend_email_settings'] = 'メール設定';
$lang['legend_default_templates'] = 'デフォルトテンプレート';
$lang['legend_filter_settings'] = 'Filter Settings';
$lang['prompt_filter'] = 'フィルタ';
$lang['prompt_keywords'] = 'キーワード';
$lang['prompt_page'] = 'ページ';
$lang['prompt_of'] = 'Of';
$lang['prompt_filter_pagelimit'] = 'Page Limit';
$lang['prompt_categories'] = 'Categories';
$lang['prompt_category'] = 'カテゴリ';
$lang['prompt_addcategory'] = 'カテゴリ追加';
$lang['prompt_default_form_template'] = 'デフォルトフォームテンプレート';
$lang['prompt_default_summary_template'] = 'デフォルトサマリテンプレート';
$lang['prompt_default_detail_template'] = 'デフォルト詳細テンプレート';
$lang['prompt_emailtemplate'] = 'デフォルトメッセージテンプレート';
$lang['prompt_email_on_new_question'] = 'Send an email when a question is submitted';
$lang['prompt_emailaddr'] = 'Email Address for Notifications';
$lang['prompt_newtemplate'] = 'テンプレートの作成';
$lang['prompt_name'] = '名';
$lang['prompt_templatename'] = 'テンプレート名';
$lang['prompt_template'] = 'Template Content';
$lang['prompt_parent'] = 'Parent';
$lang['prompt_filter_questiontype'] = 'Question Type';
$lang['prompt_filter_subject_keywords'] = 'Subject Keywords';
$lang['prompt_filter_showchildcategories'] = 'Show Child Categories';
$lang['prompt_id'] = 'ID';
$lang['prompt_author'] = 'Author';
$lang['prompt_question'] = 'Question';
$lang['prompt_created'] = '作成しました。';
$lang['prompt_addquestion'] = 'Add New Question';
$lang['prompt_answer'] = '回答';
$lang['prompt_answered_by'] = 'Answered By';
$lang['prompt_answered_date'] = 'Answered On';
$lang['prompt_approved_by'] = 'Approved By';
$lang['prompt_approved'] = 'Approved for display on front end';
$lang['prompt_approved_date'] = 'Approved On';
$lang['prompt_return'] = 'Return';
$lang['prompt_return_link'] = 'Return Link';
$lang['prompt_more'] = 'もっと';
$lang['prompt_answered_s'] = 'Answered';
$lang['prompt_approved_s'] = 'Approved';
$lang['prompt_default'] = 'デフォルト';
$lang['prompt_email_subject'] = 'A new question has been posted';
$lang['title_formtemplate_tab'] = 'Form Templates';
$lang['title_summarytemplate_tab'] = 'Summary Templates';
$lang['title_detailtemplate_tab'] = 'Detail Templates';
$lang['title_categories_tab'] = 'Categories';
$lang['title_questions_tab'] = 'Questions';
$lang['title_preferences_tab'] = 'Preferences';
$lang['error_noanswer'] = 'Cannot approve a question with no answer';
$lang['error_invalidquestionid'] = 'The question id specified is invalid';
$lang['error_dberror'] = 'データベースエラー: %s';
$lang['error_missingauthor'] = 'Your name or email address is required';
$lang['error_missingquestion'] = 'I think you made a mistake.  Are you asking a question?';
$lang['error_insufficientparams'] = 'Insufficient parameters';
$lang['error_invalidmode'] = 'Invalid mode parameter';
$lang['error_invalidparam'] = 'A parameter entered on the tag is invalid';
$lang['error_invalidcategory'] = 'The category \'%s\' could not be found';
$lang['submit_question'] = 'Submit Question';
$lang['all_questions'] = 'All Questions';
$lang['answered_questions'] = 'Answered Questions';
$lang['unanswered_questions'] = 'Unanswered Questions';
$lang['approved_questions'] = 'Approved Questions';
$lang['unapproved_questions'] = 'Unapproved Questions';
$lang['category_general'] = 'General';
$lang['resettodefaults'] = 'Reset To Defaults';
$lang['submit'] = 'Submit';
$lang['cancel'] = 'Cancel';
$lang['delete'] = 'Delete';
$lang['edit'] = 'Edit';
$lang['apply'] = 'Apply';
$lang['areyousure'] = 'Are you sure?';
$lang['error'] = 'Error!';
$lang['friendlyname'] = 'Questions and Answers';
$lang['postinstall'] = 'The Questions module is now installed.  <strong>Please Note</strong> that if the Captcha module is found, then the submit question form will automatically have Captcha support.  It is recommended that you install this module ASAP.';
$lang['postuninstall'] = 'The questions module is now uninstalled.  The questions previously entered are lost';
$lang['really_uninstall'] = 'Are you really sure you want to uninstall this module? All data will be lost!';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['prefsupdated'] = 'Module preferences updated.';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['moddescription'] = 'A Simple questions and answer module';
$lang['changelog'] = '<ul>
<li>Version 1.0.1. November, 2008 - Now depend on CGExtensions 1.2</li>
<li>Version 1.0. April, 2007 - Initial Release (after many betas)</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module provides a basic question and answer ability to your website.  You can either use it as a FAQ module, or you can use it to allow frontend users to submit questions to an administrator for answering and later tisplay.</p>
<h3>How Do I Use It?</h3>
To use this module you will need one, or more module calls in your template, or in one or more of your pages.  The first module call, like \'{cms_module module=Questions mode=form}\'; will display a form that allows any user to submit questions.  Another tag, something like \'{cms_module module=Questions}\'; will display a list of previously answered and approved questions.  You may also need to provide further parameters to each of the calls, see the \'Parameters\' section for more information.
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit the CMS Made simple website, and the development forge at: <a href="http://www.cmsmadesimple.org">cmsmadesimple.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright © 2007, Robert Campbell <a href="mailto:calguy1000@hotmail.com"><calguy1000@hotmail.com></a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>
';
$lang['utma'] = '156861353.1193756969.1199698276.1213318721.1213322938.6';
$lang['utmz'] = '156861353.1213322938.6.4.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/|utmcmd=referral';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>