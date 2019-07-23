$(document).ready(function () {
    let id = $_GET('id');
    let url = window.location.pathname+ "/../chart_data.php?id=" + id;
    $.ajax({
        url: url,
        type: "GET",
        success: function (data) {
            var debit = [];
            var date = [];

            for (var i in data) {
                debit.push(data[i].debit);
                date.push(data[i].date);
            }
            var chartdata = {
                labels: date,
                datasets: [
                    {
                        label: "Debit",
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: "rgba(59, 89, 152, 0.75)",
                        borderColor: "rgba(59, 89, 152, 1)",
                        pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
                        pointHoverBorderColor: "rgba(59, 89, 152, 1)",
                        data: debit
                    }
                ]
            };

            var ctx = $("#mycanvas");

            var LineGraph = new Chart(ctx, {
                type: 'line',
                data: chartdata
            });
        },
        error: function (data) {

        }
    });

    function $_GET(param: string) {
        var vars : any= {};
        window.location.href.replace(location.hash, '').replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function (m , key, value) : any { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );

        if (param) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }
});