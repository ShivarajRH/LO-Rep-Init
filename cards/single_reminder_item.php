<li class="list_single_reminder">
	<span class="single_reminder_name"><?php echo $reminder_name ?></span>
	<span class="single_reminder_time fl_ri"><?php echo $reminder_time ?></span>
	<?php 
		if($note_options_req=='yes')
			include_once 'note_options.php'; 
	?>
</li>