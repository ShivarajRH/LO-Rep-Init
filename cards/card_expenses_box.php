
<li class="pin standard_card always_third expenses_list_card">
	<div>
		<div>
			<div class="expenses_details">
				<?php 
					include_once 'time_filter.php'; 
					//$filter_from;
					//$filter_to;
				?>
				</br>
				<p class="card_heading">
					<span class="card_heading_text">Expenses</span>
					<span class="intime_total fl_ri" id="expense_total"><?php//$expenses_filter_total;?></span>
				</p>
				<?php 
					/*if($content_target_src == 'manage_expenses')
					{
						include 'expenses_list.php';
					}
					else if($content_target_src == 'stream')
					{
						$view_all_target = $site_url.'manage_expenses';
						include_once 'view_all_target.php';
					}*/
				?>
                                <span class="expenses_view_all"></span>
			</div>
		</div>
	</div>
</li>