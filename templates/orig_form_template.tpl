<!-- Start Questions Form Template -->
{if isset($error)}<strong><font color="red">{$error}</font></strong>{/if}
{if isset($message)}<strong><font color="blue">{$message}</font></strong>{/if}
{$formstart}
<table>
<tr><td>{$prompt_author}</td><td>{$input_author}</td>
<tr><td>{$prompt_question}</td><td>{$input_question}</td>
{if isset($image_captcha)}
<tr><td>{$prompt_captcha}</td><td>{$image_captcha}</td>
<tr><td>&nbsp;</td><td>{$input_captcha}</td>
{/if}
<tr><td>&nbsp;</td><td>{$submit}</td>
</table>
{$formend}
<!-- End Questions Form Template -->
