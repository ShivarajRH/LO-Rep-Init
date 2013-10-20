
<li class="pin standard_card always_third expenses_list_card">
	<div>
		<div>
			<div class="expenses_details">
				<p class="card_heading">
					<span class="card_heading_text">Expenses</span>
					
					<!-- Replace with Time Filter Expense Total variable and delete this comment <p><?php /* echo $time_filter_expense_total */ ?></p> -->
					<span class="intime_total fl_ri">180 900</span>
				</p>
				<?php include_once 'time_filter.php'; ?>
				<ul class="expenses_list">
					
					<!-- PHP for loop for filter list and related expenses  -->
					<?php include_once ' expenses_list_single_filter '; ?>
				</ul>
			</div>
		</div>
	</div>
</li>