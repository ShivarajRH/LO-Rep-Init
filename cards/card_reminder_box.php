
<li class="pin standard_card always_second reminders_list_card">
	<div>
		<div>
			<div>
				<p class="card_heading">
					<span class="card_heading_text">Reminders</span>
					<!-- Replace with Total Number of Reminders for that user variable and delete this comment <span><?php /* echo $total_reminders */ ?></span> -->
					<span class="intime_total fl_ri">2</span>
				</p>
				<ul class="reminders_list">
					<?php
						if ($content_target_src==stream)
							$max_reminder_count=4;
						else if ($content_target_src==manage_reminders)
							$max_reminder_count = $total_records_count;
						if($max_reminder_count==0)
						{
							$max_reminder_count=1;
							$reminder_name='Add Something';
						}
						for ($reminder_item_count=1;$reminder_item_count<=$max_reminder_count;$reminder_item_count++)
						{
							$reminder_name;
							$reminder_time;
							$content_id;
							$content_type;
							$uid;
							$note_options_req='yes';
							include_once 'single_reminder_item.php';
							if ($content_target_src==stream & $total_records_count>4)
							{
								$view_all_target='/manage_reminders.php';
								include_once 'view_all_target.php';	
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</li>