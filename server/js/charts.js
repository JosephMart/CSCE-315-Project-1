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