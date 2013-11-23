<li>
	<p class="expenses_timeframe">
		<!-- Replace with Filter Name variable and delete this comment <p><?php /* echo $filter_name */ ?></p> -->
		<span class="expenses_timeframe_name">October</span>
		
		<!-- Replace with Filter Expense Total variable and delete this comment <p><?php /* echo $filter_expense_total */ ?></p> -->
		<span class="expenses_timeframe_total fl_ri">1031.36</span>
	</p>
	
	<ul>
		<!-- PHP For loop for expense list in timeframe -->
		<?php include_once 'single_expense_list_card.php'; ?>
	</ul>
</li>