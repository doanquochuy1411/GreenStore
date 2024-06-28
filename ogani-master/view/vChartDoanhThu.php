<?php
include_once "controller/cChart.php";
class ViewChart
{

    function showRevenueChartNgay($start_date, $end_date)
    {
        $p = new ChartController();
        $data = $p->getRevenueChartNgay($start_date, $end_date);
        echo "
    
        <h2>Biểu đồ Doanh thu</h2>
        <canvas id='revenueChart' width='200' height='100'></canvas>
    
        <script>
            var revenueData =" . json_encode($data) . ";
            
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: revenueData.labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: revenueData.values,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        ";
    }

    function showRevenueChartThang($start_month, $end_month)
    {
        $p = new ChartController();
        $data = $p->getRevenueChartThang($start_month, $end_month);
        echo "
    
        <h2>Biểu đồ Doanh thu</h2>
        <canvas id='revenueChart' width='200' height='100'></canvas>
    
        <script>
            var revenueData =" . json_encode($data) . ";
            
            var ctx = document.getElementById('revenueChart').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: revenueData.labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: revenueData.values,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        ";
    }


    function showRevenueChartNam($start_date, $end_date)
    {
        $p = new ChartController();
        $data = $p->getRevenueChartNam($start_date, $end_date);
        echo "

   <h2>Biểu đồ Doanh thu</h2>
   <canvas id='revenueChart' width='200' height='100'></canvas>

   <script>
       var revenueData =" . json_encode($data) . ";
       
       var ctx = document.getElementById('revenueChart').getContext('2d');
       var revenueChart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: revenueData.labels,
               datasets: [{
                   label: 'Doanh thu',
                   data: revenueData.values,
                   backgroundColor: 'rgba(75, 192, 192, 0.2)',
                   borderColor: 'rgba(75, 192, 192, 1)',
                   borderWidth: 1
               }]
           },
           options: {
               scales: {
                   y: {
                       beginAtZero: true
                   }
               }
           }
       });
   </script>
   ";
    }
}
