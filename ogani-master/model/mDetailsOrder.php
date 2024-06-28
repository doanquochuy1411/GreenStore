<?php
include_once("connect.php");

class MDetailsOrder
{
    function getAllDetailsOrder($maHoaDon)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "SELECT *
            FROM chitiethoadon
            INNER JOIN hoadon ON chitiethoadon.MaHoaDon = hoadon.MaHoaDon
            INNER JOIN sanpham ON chitiethoadon.MaSanPham = sanpham.MaSanPham
            WHERE chitiethoadon.MaHoaDon = $maHoaDon";

            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }



    function createComment($maKhachHang,  $maSanPham,  $noidung, $sao, $hinhAnh)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            // $str = "INSERT INTO `noidungdanhgia` (`MaDanhGia`, `MaSanPham`, `ThoiGianDanhGia`, `NoiDungDanhGia`, `HinhAnh`, `SoSao`, `MaKhachHang`) 
            // VALUES (NULL, '$maSanPham', NOW(), '$noidung','$hinhAnh','$sao', '$maKhachHang');";

            // $tbl = mysqli_query($con, $str);
            // $p->closeDB($con);
            // return true;
            $str = "INSERT INTO `noidungdanhgia` (`MaDanhGia`, `MaSanPham`, `ThoiGianDanhGia`, `NoiDungDanhGia`, `HinhAnh`, `SoSao`, `MaKhachHang`) 
            VALUES (NULL,?, NOW(), ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $str);
            mysqli_stmt_bind_param($stmt, "issii", $maSanPham, $noidung, $hinhAnh, $sao, $maKhachHang);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $p->closeDB($con);
            return true;
        } else {
            return false;
        }
    }

    function createReturn($maChiTietHoaDon,  $soLuong,  $noidung, $hinhAnh)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            // $str = "INSERT INTO `phieutrahang` (`MaPhieuTraHang`, `MaChiTietDonHang`, `ThoiGianTraHang`, `SoLuong`, `LyDoTraHang`, `HinhAnh`) 
            // VALUES (NULL, '$maChiTietHoaDon', NOW(), '$soLuong', '$noidung', '$hinhAnh');";

            // $tbl = mysqli_query($con, $str);
            // $p->closeDB($con);
            // return true;
            $str = "INSERT INTO `phieutrahang` (`MaPhieuTraHang`, `MaChiTietDonHang`, `ThoiGianTraHang`, `SoLuong`, `LyDoTraHang`, `HinhAnh`)
            VALUES (NULL,?, NOW(), ?, ?, ?)";
            $stmt = mysqli_prepare($con, $str);
            mysqli_stmt_bind_param($stmt, "iiss", $maChiTietHoaDon, $soLuong, $noidung, $hinhAnh);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $p->closeDB($con);
            return true;
        } else {
            return false;
        }
    }
}