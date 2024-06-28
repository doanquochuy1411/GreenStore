<?php
include_once("connect.php");
class ChartModel
{
    function selectRevenueDataNgay($start_date, $end_date)
    {
        $p = new ConnectDB();
        if ($p->connect_DB($con)) {
            $str = "SELECT NgayLap, SUM(TongTien) AS DoanhThu
                FROM hoadon
                WHERE NgayLap BETWEEN '$start_date' AND '$end_date'
                GROUP BY NgayLap
                ORDER BY NgayLap";
            $result = mysqli_query($con, $str);

            // Kiểm tra và chuyển dữ liệu thành mảng
            $data = array('labels' => array(), 'values' => array());

            if ($result){

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data['labels'][] = $row['NgayLap'];
                        $data['values'][] = $row['DoanhThu'];
                    }
                }
            }else{
                echo"<h4 style='text-align: center; color: #e70f47'>Không có dữ liệu.</h4>";
            }

            // Use mysqli_query with the connection parameter
            $p->closeDB($con);

            // Trả về mảng thay vì echo
            return $data;
        } else {
            return false;
        }
    }


    function selectRevenueDataThang($start_month, $end_month)
    {
        $p = new ConnectDB();
        $p->connect_DB($con);

        if ($con) {
            $str = "SELECT DATE_FORMAT(NgayLap, '%m') AS Thang, SUM(TongTien) AS DoanhThu
                FROM hoadon
                WHERE DATE_FORMAT(NgayLap, '%m') BETWEEN '$start_month' AND '$end_month'
                GROUP BY DATE_FORMAT(NgayLap, '%m')
                ORDER BY DATE_FORMAT(NgayLap, '%m')";

            $result = mysqli_query($con, $str);
                // Kiểm tra và chuyển dữ liệu thành mảng
                $data = array('labels' => array(), 'values' => array());

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data['labels'][] = $row['Thang'];
                        $data['values'][] = $row['DoanhThu'];
                    }
                }

                // Đóng kết nối
                $p->closeDB($con);

                // Trả về mảng thay vì echo
                return $data;
        } else {
            return false;
        }
    }

    function selectRevenueDataNam($start_year, $end_year)
    {
        $p = new ConnectDB();
        $p->connect_DB($con);

        if ($con) {
            $str = "SELECT DATE_FORMAT(NgayLap, '%Y') AS Nam, SUM(TongTien) AS DoanhThu
                FROM hoadon
                WHERE DATE_FORMAT(NgayLap, '%Y') BETWEEN '$start_year' AND '$end_year'
                GROUP BY DATE_FORMAT(NgayLap, '%Y')
                ORDER BY DATE_FORMAT(NgayLap, '%Y')";

            $result = mysqli_query($con, $str);
                // Kiểm tra và chuyển dữ liệu thành mảng
                $data = array('labels' => array(), 'values' => array());

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data['labels'][] = $row['Nam'];
                        $data['values'][] = $row['DoanhThu'];
                    }
                }

                // Đóng kết nối
                $p->closeDB($con);

                // Trả về mảng thay vì echo
                return $data;
        } else {
            return false;
        }
    }
    
}
