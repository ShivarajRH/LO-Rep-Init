<li class="single_expense">
	<span class=""><?php echo $expense_name ?></span>
	<span class="fl_ri"><?php echo $expense_amount ?></span>
	<?php
		if($note_options_req=='yes')
		{
			include_once ' note_options.php '; 
		}
	?>
</li>