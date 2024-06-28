<?php
include_once("connect.php");

class MOrderManager
{
    function getAllOrder($maKhachHang)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "SELECT *
            FROM chitiethoadon
            INNER JOIN hoadon ON chitiethoadon.MaHoaDon = hoadon.MaHoaDon
            INNER JOIN sanpham ON chitiethoadon.MaSanPham = sanpham.MaSanPham
            WHERE hoadon.MaKhachHang = ?";
            $stmt = mysqli_prepare($con, $str);
            mysqli_stmt_bind_param($stmt, "i", $maKhachHang);
            mysqli_stmt_execute($stmt);
            $tbl = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $tbl;
        } else {
            return false;
        }
    }
}