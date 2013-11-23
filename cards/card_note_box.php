
<li class="pin single_note_card">
	<img src="<?php echo $note_image ?>" /> 
	<p><?php echo $note_text ?></p>
	<?php
		if($note_options_req=='yes') 
			include_once 'note_options.php'; 
	?>
</li>