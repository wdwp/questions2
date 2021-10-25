{$startform}
{if isset($question_id) }
<div class="pageoverflow">
    <p class="pagetext">{$prompt_id}:</p>
    <p class="pageinput">{$question_id}</p>
</div>
{/if}
<div class="pageoverflow">
    <p class="pagetext">{$prompt_category}:</p>
    <p class="pageinput">{$input_category}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_author}:</p>
    <p class="pageinput">{$input_author}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_question}:</p>
    <p class="pageinput">{$input_question}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_answer}:</p>
    <p class="pageinput">{$input_answer}</p>
</div>
{if isset($prompt_approved)}
<div class="pageoverflow">
    <p class="pagetext">{$prompt_approved}:</p>
    <p class="pageinput">{$input_approved}</p>
</div>
{/if}
<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden}{$submit}{$cancel}</p>
</div>
{$endform}
