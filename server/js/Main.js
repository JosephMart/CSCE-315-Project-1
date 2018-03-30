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

// https://jonlabelle.com/snippets/view/javascript/calculate-mean-median-mode-and-range-in-javascript
function mode(numbers) {
    // as result can be bimodal or multi-modal,
    // the returned result is provided as an array
    // mode of [3, 5, 4, 4, 1, 1, 2, 3] = [1, 3, 4]
    var modes = [], count = [], i, number, maxIndex = 0;
 
    for (i = 0; i < numbers.length; i += 1) {
        number = numbers[i];
        count[number] = (count[number] || 0) + 1;
        if (count[number] > maxIndex) {
            maxIndex = count[number];
        }
    }

    for (i in count)
        if (count.hasOwnProperty(i)) {
            if (count[i] === maxIndex) {
                modes.push(Number(i));
            }
        }

    return modes;
}