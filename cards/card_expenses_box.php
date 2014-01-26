
<li class="pin standard_card always_third expenses_list_card">
	<div>
		<div>
			<div class="expenses_details">
				<?php include_once 'time_filter.php'; ?>
				</br>
				<p class="card_heading">
					<span class="card_heading_text">Expenses</span>
					<span class="intime_total fl_ri" id="expense_total"><?php//$expenses_filter_total;?></span>
				</p>
                                <div id="chart_div2"></div>
                                <?php 
					if($content_target_src == 'manage_expenses')
					{
						include 'expenses_list.php';
					}
					elseif($content_target_src == 'stream')
					{
						$view_all_target = $site_url.'manage_expenses';
						include_once 'view_all_target.php';
					}
				?>
                                <span class="expenses_view_all"></span>
			</div>
		</div>
	</div>
</li>
<script>
    
    $('.time_filter:first').trigger('click');

    var isexecuted=0;
    function plotgraph(interval) {
            $("body").data('interval',interval);
            if(isexecuted == 1) {
                processChartData();
            }
            //print(interval+"...1");
            // Load the Visualization API and the piechart package.
            google.load('visualization', '1.0', {'packages':['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.setOnLoadCallback(processChartData);
            return false;
    }

    // Instantiates the pie chart, passes in the data and draws it.
    function processChartData() {
        isexecuted=1;
        var interval = $("body").data('interval');
        var postData={action:"time_filter",uid:'<?php echo $uid;?>',content_type:"expense",interval:interval};
        //print(interval+"...2");
        $.post(site_url+"includes/api_process/",postData,function(resp){
//                console.log(resp.expenses); //return false;
                // Create and populate the data table.
                /*var data = google.visualization.arrayToDataTable([
                  ['Year', 'Austria', 'Bulgaria', 'Denmark', 'Greece'],
                  ['2003',  1336060,    400361,    1001582,   997974],
                  ['2004',  1538156,    366849,    1119450,   941795]
                ]);*/

                if(resp.status == "success") 
                {
                    var array_push = [];
                    // Create the data table.
                    //var data = new google.visualization.DataTable();
                    //data.addColumn('string', 'Title');data.addColumn('number', 'Amount');
                    var ttl_expense = 0;
                    array_push.push(["Title","Amount"]);
                    $.each(resp.expenses,function(i,row) {
                            ttl_expense += parseFloat(row.expense_amount);
                            array_push.push([ row.title,parseInt(row.expense_amount)]);
                            //data.addRows([array_push]);
                    });

                    $("#expense_total").html(ttl_expense);
                    drawChart(array_push);
                    //$(".expenses_list_container").html(get_expense_list(resp.expenses));
                }
                else {
                        document.getElementById('chart_div').innerHTML = "<div>"+resp+"</div>";
                }
         },'json');
    }
    function drawChart(array_push) {
        
        var data = new google.visualization.arrayToDataTable(array_push);
        // Instantiate and draw our chart, passing in some options.//BarChart,PieChart,LineChart
        var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));

        // Set chart options
        var options = { title:'Expenses Chart'
                        ,width:300
                        ,height:300
                        ,hAxis:{title:"Intervals"}
                        ,vAxis:{title:"Amount"} };
        chart.draw(data, options);
    }
</script>