<ul class="expenses_list">
	<?php
	$max_expenses_count = $total_records_count; 
	if($max_expenses_count==0)
	{
		$max_expenses_count=1;
		$expense_name='Add Something';
	}
	for ($expense_item_count=1;$expense_item_count<=$max_expenses_count;$expense_item_count++)
	{
			$expense_name;
			$expense_amount;
			$content_id;
			$content_type;
			$uid;
			$note_options_req='yes';
			include_once 'single_expense_item.php ';
	}
	?>
</ul>