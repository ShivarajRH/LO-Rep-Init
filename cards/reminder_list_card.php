
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
					
					<!-- PHP For loop for reminder list -->
					<?php include_once 'single_reminder_list_card.php'; ?>
				</ul>
			</div>
		</div>
	</div>
</li>