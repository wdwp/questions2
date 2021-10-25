{if isset($message)}<p>{$message}</p>{/if}
{$formstart}
<fieldset>
<legend>{$legend_email_settings}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_email_on_new_question}:</p>
		<p class="pageinput">{$input_email_on_new_question}</p>
	</div>
    
    
    <div class="pageoverflow">
		<p class="pagetext">{$prompt_hide_on_admin_question_wysiwyg}:</p>
		<p class="pageinput">{$input_hide_on_admin_question_wysiwyg}</p>
	</div>
	
	  <div class="pageoverflow">
		<p class="pagetext">{$prompt_hide_on_front_question_wysiwyg}:</p>
		<p class="pageinput">{$input_hide_on_front_question_wysiwyg}</p>
	</div>
    
    
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_emailaddr}:</p>
		<p class="pageinput">{$input_emailaddr}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_emailtemplate}:</p>
		<p class="pageinput">{$input_emailtemplate}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$reset_email_template}</p>
	</div>
</fieldset>
<fieldset>
<legend>{$legend_default_templates}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_form_template}:</p>
		<p class="pageinput">{$input_form_template}</p>
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$reset_form_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_summary_template}:</p>
		<p class="pageinput">{$input_summary_template}</p>
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$reset_summary_template}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_detail_template}:</p>
		<p class="pageinput">{$input_detail_template}</p>
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$reset_detail_template}</p>
	</div>
</fieldset>
<div class="pageoverflow">
   <p class="pagetext">&nbsp;</p>
   <p class="pageinput">{$submit}</p>
</div>
{$formend}
