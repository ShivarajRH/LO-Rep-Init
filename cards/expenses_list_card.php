
<li class="pin standard_card always_third expenses_list_card">
	<div>
		<div>
			<div class="expenses_details">
				<?php include_once 'time_filter.php'; ?>
				</br>
				<p class="card_heading">
					<span class="card_heading_text">Expenses</span>
					
					<!-- Replace with Time Filter Expense Total variable and delete this comment <p><?php /* echo $time_filter_expense_total */ ?></p> -->
					<span class="intime_total fl_ri">180 900</span>
				</p>
				<p class="expenses_timeframe recent_expenses">
					<span class="expenses_timeframe_name">Recent</span>
					<a href="manage_expenses.html"><span class="expenses_timeframe_name fl_ri">View All</span></a>
				</p>
				<ul class="expenses_list">
					<?php 
//					for ()
//					{
						
					?>
						<li class="single_expense">
							<span class=""><?php $expense_name ?></span>
							<span class="fl_ri"><?php $expense_amount ?></span>
							<div>
								<?php include_once 'note_options.php'; ?>
							</div>
						</li>
					<?php 
//					}
					?>
					<!-- PHP for loop for filter list and related expenses  -->
					<?php include_once 'expenses_list_single_filter.php'; ?>
				</ul>
			</div>
		</div>
	</div>
</li>