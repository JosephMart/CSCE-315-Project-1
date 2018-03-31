/*****************************************
** File:    Main.js
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   JS Functions for the project
**
**
***********************************************/

//-------------------------------------------------------
// Name: LoadGraph
// PreCondition:  dbData is data from server to graph
//                formatDate is a function to format date
// PostCondition: Draws Google Bar Chart
//---------------------------------------------------------
function LoadGraph(dbData, formatDate) {
    var graphData = [['Date Times', 'Entering', 'Exiting']];
    var row = {};
    

    for (var i = 0; i < dbData.length; i++) {
        row = dbData[i];
        graphData.push([formatDate(row.date), parseInt(row.goingIn, 10), parseInt(row.goingOut, 10)]);
    }
    // Get Current range dates
    var startDate = graphData[1][0];
    var endDate = graphData[graphData.length - 1][0];

    function drawChart() {
        var chartDiv = document.getElementById('chart_div');
        var data = google.visualization.arrayToDataTable(graphData);
    
        var materialOptions = {
            width: 900,
            chart: {
                title: 'Rec Center Counts',
                subtitle: endDate + ' - ' + startDate
            },
              bars: 'vertical',
              vAxis: {format: 'decimal'},
              height: 400,
              colors: ['#50191F', '#eed5ae']
        };
    
        function drawMaterialChart() {
            var materialChart = new google.charts.Bar(chartDiv);
            materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
        }
    
        drawMaterialChart();
    };

    // Google Charts setup
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);
}