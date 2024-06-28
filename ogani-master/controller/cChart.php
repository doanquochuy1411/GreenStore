<?php
include_once 'model/mChart.php';


class ChartController
{
    function getRevenueChartNgay($start_date, $end_date){
        $p = new ChartModel();
        $data = $p -> selectRevenueDataNgay($start_date, $end_date);
        return $data;
    }

    function getRevenueChartThang($start_month, $end_month){
        $p = new ChartModel();
        $data = $p -> selectRevenueDataThang($start_month, $end_month);
        return $data;
    }

    function getRevenueChartNam($start_month, $end_month){
        $p = new ChartModel();
        $data = $p -> selectRevenueDataNam($start_month, $end_month);
        return $data;
    }
}

?>
