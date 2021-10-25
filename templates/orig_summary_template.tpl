<!-- Start Questions Summary Template -->
{* the get_template_vars smarty plugin, and print_r can be very useful here
   i.e: to see the fields that can be displayed, try {$itmes|print_r} *}
{if isset($formstart)}
<fieldset>
<legend>{$label_filter}</legend>
{$formstart}
{$prompt_keywords}&nbsp;{$input_keywords}<br/>
{$prompt_author}&nbsp;{$input_author}<br/>
{$prompt_answered_by}&nbsp;{$input_answered_by}<br/>
{$submit}
{$formend}
</fieldset>
{/if}
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
{foreach from=$items item=entry}
<table width="90%" cellspacing="1">
  <tr>
    <td>{$label_author}:&nbsp;{$entry->author}</td>
    <td>{$entry->created|date_format}</td>
  </tr>
  <tr>
    <td colspan="2">{$entry->question}</td>
  </tr>
</table>
{/foreach}
<!-- End Questions Summary Template -->
