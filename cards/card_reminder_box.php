
<li class="pin standard_card always_second reminders_list_card">
	<div>
		<div>
			<div>
				<p class="card_heading">
					<span class="card_heading_text">Reminders</span>
					<!-- Replace with Total Number of Reminders for that user variable and delete this comment <span><?php /* echo $total_reminders */ ?></span> -->
					<span class="intime_total fl_ri"><?=$total_reminders;?></span>
				</p>
				<ul class="reminders_list">
					<?php
						if ($content_target_src=='stream')
							$max_reminder_count=4;
						else if ($content_target_src=='manage_reminders')
							$max_reminder_count = $total_reminders;
						if($max_reminder_count==0)
						{
							$max_reminder_count=1;
							$reminder_name='Add Something';
						}
						foreach ($result['reminders'] as $reminder) 
						{
							$reminder_id = $reminder['reminder_id'];
							$reminder_name = $reminder['reminder_name'];
							$reminder_time = $reminder['remind_time'];
							$content_id = $reminder['content_id'];
							$content_type = 'reminder';
							//$uid;
							$note_options_req='yes';
							include 'single_reminder_item.php';
							if ($content_target_src=='stream' and $total_reminders>4)
							{
								$view_all_target='/manage_reminders';
								include_once 'view_all_target.php';	
							}
						}
					?>
				</ul>
			</div>
		</div>
	</div>
</li>