<?php
include_once("connect.php");

class MCustomer
{
    function selectAllCustomers()
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM khachhang";
            $tbl = mysqli_query($con, $str); // Use mysqli_query with the connection parameter
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function selectAllCustomerBySearch($search)
    {
        $p = new ConnectDB();
        // $con;
        $ma = SUBSTR($search, 2);
        $loai = substr($search, 0, 2);
        if ($loai !== 'KH') {
            $tbl = 0;
            $maKH = "";
        } else {
            $maKH = intval($ma);
        }
        if ($p->connect_DB($con)) {
            // $str = "SELECT * FROM khachhang WHERE SoDienThoai like N'%$search%' or MaKhachHang = '$maKH' or HoTen like N'%$search%'";
            // $tbl = mysqli_query($con, $str);
            // Truy vấn chuẩn bị với prepared statement
            $str = "SELECT * FROM khachhang WHERE SoDienThoai LIKE ? OR MaKhachHang = ? OR HoTen LIKE ?";
            $stmt = mysqli_prepare($con, $str);

            // Gán giá trị cho các tham số
            $search = "%$search%"; // Thêm dấu % cho việc tìm kiếm theo mẫu (wildcard search)
            mysqli_stmt_bind_param($stmt, 'sis', $search, $maKH, $search);

            // Thực thi truy vấn
            mysqli_stmt_execute($stmt);
            $tbl = mysqli_stmt_get_result($stmt);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function selectDelCustomer($MaKhachHang)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "UPDATE khachhang SET trangThai = '0' WHERE MaKhachHang = '$MaKhachHang' LIMIT 1 ;";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }
}