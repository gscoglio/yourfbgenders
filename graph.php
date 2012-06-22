<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
        
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Genders');
        data.addColumn('number', 'Amount');
        data.addRows(3);
        data.setValue(0, 0, 'Female friends');
        data.setValue(0, 1, <?php echo($params['female_count']); ?>);
        data.setValue(1, 0, 'Male friends');
        data.setValue(1, 1, <?php echo($params['male_count']); ?>);
//        data.setValue(2, 0, 'Unknown gender friends');
//        data.setValue(2, 1, <?php echo($params['unknown_friends_amount']); ?>);


        // Set chart options
        var options = {'title':"Your female and male friends",
            'colors':['pink','#bbeeff','#A8B1B8'],
            'pieSliceTextStyle':{color:'black'},
            'width':400,
            'height':250};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>