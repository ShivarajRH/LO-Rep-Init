<?php
/*echo "{
  cols: [{id: 'A', label: 'NEW A', type: 'string'},
         {id: 'B', label: 'B-label', type: 'number'},
         {id: 'C', label: 'C-label', type: 'date'}
        ],
  rows: [{c:[{v: 'a'}, {v: 1.0, f: 'One'}, {v: new Date(2008, 1, 28, 0, 31, 26), f: '2/28/08 12:31 AM'}]},
         {c:[{v: 'b'}, {v: 2.0, f: 'Two'}, {v: new Date(2008, 2, 30, 0, 31, 26), f: '3/30/08 12:31 AM'}]},
         {c:[{v: 'c'}, {v: 3.0, f: 'Three'}, {v: new Date(2008, 3, 30, 0, 31, 26), f: '4/30/08 12:31 AM'}]}
        ]
}";
*/
//die();
$metatitle='LyfeOn - Your Stuff !';
    $metadescription='LyfeOn - Access your notes, reminders and expenses and manage them across devices.';
    $metaabstract='LyfeOn - your notes, reminders and expenses';
    $metasubject='LyfeOn - your notes, reminders and expenses';
    $metapagename='LyfeOn - your notes, reminders and expenses';
    $metasubtitle='LyfeOn - Manage your stuff';

    $metacopyright= "$ fname" . " " . "$ lname";
    
include 'paths.php'; 
include("head.php");
?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script type="text/javascript">
        
        
        
        // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      
      function drawChart() {

            
             $.post(site_url+"api/search/?action_object=list_content&uid=104775511952184246952&content_type=expense",{},function(rdata) {
              
                    // Create the data table.
                    var data = new google.visualization.DataTable();
              
                    if(rdata != undefined)
                    {
//                        console.log(rdata.expenses);
                        
//                        data.addColumn('string', 'contid');
//                        data.addColumn('string', 'visible');
//                        data.addColumn('string', 'amount');
//                        data.addColumn('string', 'Month');
                        var dat_arr=[];
                        
                            data.addColumn('string', 'title');
                            data.addColumn('number', 'amount');
                            
                        $.each(rdata.expenses,function(i,row) {
                                
                                    var array_push = [ row.expense_title,parseInt(row.expense_amount)];
//                                    dat_arr.push(array_push);
                                    
                                    
                                    data.addRows([array_push]);
                                  
                                
                        });
//                            console.log(dat_arr);
                            
                            // Set chart options
                            var options = {'title':'My expenses',
                                           'width':400,
                                           'height':300};
                            //BarChart
                            // Instantiate and draw our chart, passing in some options.
                            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                            chart.draw(data, options);
                            
//                          [row.expense_id,row.expense_title]
//                          ,row.expense_amount,row.month
                            
                    }
                    else {
                            
                            data.addColumn('string', 'title');
                            data.addColumn('number', 'contid');
                            
                            data.addRows([
                              ['Mushrooms', 3],
                              ['Onions', 1],
                              ['Olives', 1],
                              ['Zucchini', 1],
                              ['Pepperoni', 2]
                            ]);

                    }
                    
             },'json');
            
      }
        
        
        
        
        
    /*
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {*/
        
//        https://chart.googleapis.com/chart?cht=p3&chs=250x100&chd=t:60,40&chl=Hello|World

      /*var jsonData = $.ajax({
          url: "http://localhost:13080/api/search/?action_object=user_profile&uid=104775511952184246952",
          dataType:"json",
          async: false
          }).responseText;
          console.log(jsonData);*/
          
          /*
          $.post(site_url+"api/search/?action_object=list_content&uid=104775511952184246952&content_type=expense",{},function(rdata) {
              
              
            if(rdata.expense_total != undefined) {
                var cols_arr = month_arr=title_arr= [];
                var rows_arr = [];
                
                    $.each(rdata.expenses,function(i,row) {
                            month_arr.push(row.month);
                            title_arr.push(row.expense_title);
                            
                            console.log(row.expense_id);
                            console.log(row.content_id);
                            console.log(row.expense_title);
                            console.log(row.expense_amount);
                            console.log(row.month);
                            
                    });
                    
                    cols_arr.push({
                        month:month_arr
                    });
                    rows_arr.push({
                        title:title_arr
                    });
                    
                    console.log(cols_arr);
                    console.log(rows_arr);
                    //return false;
                
                    var resp_json={cols: cols_arr,rows:rows_arr};//{cols: [{id: 'A', label: 'NEW A', type: 'string'}, {id: 'B', label: 'B-label', type: 'number'}, {id: 'C', label: 'C-label', type: 'date'} ], rows: [{c:[{v: 'a'}, {v: 1.0, f: 'One'}, {v: new Date(2008, 1, 28, 0, 31, 26), f: '2/28/08 12:31 AM'}]}, {c:[{v: 'b'}, {v: 2.0, f: 'Two'}, {v: new Date(2008, 2, 30, 0, 31, 26), f: '3/30/08 12:31 AM'}]}, {c:[{v: 'c'}, {v: 3.0, f: 'Three'}, {v: new Date(2008, 3, 30, 0, 31, 26), f: '4/30/08 12:31 AM'}]} ] };
                    //var resp = (object)resp_json;
                    loadGraphData(resp_json);
            }
            else {
                console.log("\n"+rdata.response);
                
                var resp_json={
                                cols: 
                                [   {id: 'A', label: 'NEW A', type: 'string'}
//                                    ,{id: 'B', label: 'B-label', type: 'number'} 
//                                    ,{id: 'C', label: 'C-label', type: 'date'} 
                                ]
                                ,rows: 
                                [
                                    {c:[{v: 'a',f:"hi"}, {v: 1, f: 'One'}, {v: 'v1', f: 'f1'}]}
//                                    ,{c:[{v: 'b'}, {v: 2, f: 'Two'}, {v: "v2", f: 'f2'}]} 
//                                    ,{c:[{v: 'c'}, {v: 3, f: 'Three'},{v: 'v3',f: 'f3'}]} 
                                ]
                            };
                    //var resp = (object)resp_json;
                    loadGraphData(resp_json);
                    
            }
        },"json").fail(fail);*/
        /*
         var resp_json={
                cols: 
                [  {label: 'NEW A'}
//                [   {id: 'A', label: 'NEW A', type: 'string'}
//                                    ,{id: 'B', label: 'B-label', type: 'number'} 
//                                    ,{id: 'C', label: 'C-label', type: 'date'} 
                ]
                ,rows: 
                [
                    {c:'My First V'}
//                    {c:[{v: 'a',f:"hi"}, {v: 1, f: 'One'}, {v: 'v1', f: 'f1'}]}
//                                    ,{c:[{v: 'b'}, {v: 2, f: 'Two'}, {v: "v2", f: 'f2'}]} 
//                                    ,{c:[{v: 'c'}, {v: 3, f: 'Three'},{v: 'v3',f: 'f3'}]} 
                ]
            };
            
            //var resp = (object)resp_json;
            loadGraphData(resp_json);
          
    }
    
    function loadGraphData(jsonData) {
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      
      
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 400, height: 240});
    }
    
    function fail(rdata){
        console.log(rdata.responseText);
    }*/
    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <h2>Charts</h2>
    <div id="chart_div"></div>
  </body>
</html>