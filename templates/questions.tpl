<fieldset>
<legend>{$legend_filter_settings}</legend>
{$formstart}
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_category}:</p>
		<p class="pageinput">{$input_category}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_showchildcategories}:</p>
		<p class="pageinput">{$input_showchildcategories}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_questiontype}:</p>
		<p class="pageinput">{$input_questiontype}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_subject_keywords}:</p>
		<p class="pageinput">{$input_subject_keywords}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_pagelimit}:</p>
		<p class="pageinput">{$input_pagelimit}</p>
	</div>
	<div class="pageoverflow">
	   <p class="pagetext">&nbsp;</p>
	   <p class="pageinput">{$apply}</p>
	</div>	
{$formend}
</fieldset>

{if $itemcount > 0}
<div class="pageoptions">
	<p class="pageoptions">{$addlink}</p>
</div>
{if $pagecount > 1}
  <p>
{if $pagenumber > 1}
{$firstpage}&nbsp;{$prevpage}&nbsp;
{/if}
{$pagenumber}&nbsp;{$oftext}&nbsp;{$pagecount}
{if $pagenumber < $pagecount}
&nbsp;{$nextpage}&nbsp;{$lastpage}
{/if}
</p>
{/if}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
	                <th>{$prompt_id}</th>
	                <th width="60%">{$prompt_question}</th>
                        <th>{$prompt_author}</th>
                        <th>{$prompt_created}</th>
			<th>{$prompt_answered}</th>
			<th>{$prompt_approved}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}" onmouseover="this.className='{$entry->rowclass}hover';" onmouseout="this.className='{$entry->rowclass}';">
			<td>{$entry->id}</td>
			<td>{$entry->question}</td>
			<td>{$entry->author}</td>
			<td>{$entry->created}</td>
			<td>{$entry->answered}</td>
			<td>{$entry->approved}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
		</tr>
	{/foreach}
	</tbody>
</table>
{/if}

<div class="pageoptions">
	<p class="pageoptions">{$addlink}</p>
</div>

