
<!-- Start Questions Detail Template -->
<ul>
   <li>{$label_id} = {$record->id}</li>
   <li>{$label_category} = {$record->name}&nbsp;({$record->category_id})</li>
   <li>{$label_created} = {$record->created|date_format}</li>
   <li>{$label_author} = {$record->author}</li>
   <li>{$label_question} = {$record->question}</li>
   <li>{$label_answer} = {$record->answer}</li>
   <li>{$label_answered_by} = {$record->answered_by}</li>
   <li>{$label_answered_date} = {$record->answered_date|date_format}</li>
   <li>{$label_approved_by} = {$record->approved_by}</li>
   <li>{$label_approved_date} = {$record->approved_date|date_format}</li>
   <li>{$label_return_link} = {$record->return_link}</li>
</ul>
{$link_prev}&nbsp;{$link_next}
<!-- End Questions Detail Template -->
