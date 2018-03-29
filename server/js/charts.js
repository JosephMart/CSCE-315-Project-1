function drawMonthView() {
    var chartDiv = document.getElementById('chart_div');
    var data = google.visualization.arrayToDataTable(graph_data);

    var materialOptions = {
        width: 900,
        chart: {
            title: 'Rec Center Counts',
            subtitle: start_date + ' - ' + end_date
        },
        series: {
            0: { axis: 'Entering' },
            1: { axis: 'Exiting' }
        },
        axes: {
            y: {
                distance: {label: 'Number of People'}, // Left y-axis.
                brightness: {side: 'right', label: 'Date Time'} // Right y-axis.
            }
        }
    };

    function drawMaterialChart() {
        var materialChart = new google.charts.Bar(chartDiv);
        materialChart.draw(data, google.charts.Bar.convertOptions(materialOptions));
    }

    drawMaterialChart();
};