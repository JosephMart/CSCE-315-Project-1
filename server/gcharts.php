<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawAxisTickColors);

        function drawAxisTickColors() {
            var data = new google.visualization.DataTable();
            data.addColumn('timeofday', 'Time of Day');
            data.addColumn('number', 'Motivation Level');

            data.addRows([
                [{v: [8, 0, 0], f: '8 am'}, 1],
                [{v: [9, 0, 0], f: '9 am'}, 2],
                [{v: [10, 0, 0], f:'10 am'}, 3],
                [{v: [11, 0, 0], f: '11 am'}, 4],
                [{v: [12, 0, 0], f: '12 pm'}, 5],
                [{v: [13, 0, 0], f: '1 pm'}, 6],
                [{v: [14, 0, 0], f: '2 pm'}, 7],
                [{v: [15, 0, 0], f: '3 pm'}, 8],
                [{v: [16, 0, 0], f: '4 pm'}, 9],
                [{v: [17, 0, 0], f: '5 pm'}, 10],
            ]);

            var options = {
                title: 'Motivation and Energy Level Throughout the Day',
                focusTarget: 'category',
                hAxis: {
                title: 'Time',
                format: 'h:mm a',
                viewWindow: {
                    min: [7, 30, 0],
                    max: [17, 30, 0]
                },
                textStyle: {
                    fontSize: 12,
                    color: '#000',
                    bold: false,
                    italic: false
                },
                titleTextStyle: {
                    fontSize: 12,
                    color: '#00',
                    bold: true,
                    italic: false
                }
                },
                vAxis: {
                title: '# of People',
                textStyle: {
                    fontSize: 12,
                    color: '#000',
                    bold: false,
                    italic: false
                },
                titleTextStyle: {
                    fontSize: 14,
                    color: '#000',
                    bold: true,
                    italic: false
                }
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
            }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
</html>