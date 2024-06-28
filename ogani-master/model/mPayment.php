<?php
session_start();
ob_start();
include_once("connect.php");

class MPay
{
    function getAllProduct()
    {
        $maKhachHang =  $_SESSION['MaKhachHang'];
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "SELECT sp.TenSanPham, sp.GiaBan, gh.SoLuong, sp.MaSanPham FROM giohang gh JOIN sanpham sp ON gh.MaSanPham = sp.MaSanPham WHERE gh.MaKhachHang = '$maKhachHang';";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function getNamePriceProduct($maSanPham)
    {
       
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "SELECT `GiaBan`,`TenSanPham` FROM `sanpham` WHERE MaSanPham = $maSanPham";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function createOrder($tongTienDonHang, $maKhachHang, $DiaChi, $HoTen, $SoDienThoai, $Email)
    {
        $p = new ConnectDB();
        $con = null;

        if ($p->connect_DB($con)) {

            // $str_hoadon2 = "INSERT INTO hoadon (TongTien, NgayLap) VALUES ('$tongTienDonHang', NOW())";
            // $str_hoadon = "INSERT INTO `hoadon` 
            // (`MaHoaDon`, `TongTien`, `NgayLap`, `MaKhachHang`, `DiaChiGiaoHang`, `HoTen`, `SoDienThoai`, `Email`) 
            // VALUES (NULL, $tongTienDonHang, NOW(), $maKhachHang, '$DiaChi', '$HoTen', $SoDienThoai, '$Email');";
            // mysqli_query($con, $str_hoadon);
            $str_hoadon = "INSERT INTO `hoadon` (`MaHoaDon`, `TongTien`, `NgayLap`, `MaKhachHang`, `DiaChiGiaoHang`, `HoTen`, `SoDienThoai`, `Email`) 
               VALUES (NULL, ?, NOW(), ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($con, $str_hoadon);
            mysqli_stmt_bind_param($stmt, 'dsssss', $tongTienDonHang, $maKhachHang, $DiaChi, $HoTen, $SoDienThoai, $Email);
            
            mysqli_stmt_execute($stmt);

            $str_maHoaDon = "SELECT `MaHoaDon` FROM `hoadon` ORDER BY `MaHoaDon` DESC LIMIT 1;";
            $id_maHoaDon = mysqli_query($con, $str_maHoaDon);
            $p->closeDB($con);
            return $id_maHoaDon;
        } else {
            return false;
        }
    }

    function createDetailsOrder($tongTien, $maSanPham, $soLuong, $MaHoaDon)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {

            $sql_detailsOrder = "INSERT INTO `chitiethoadon` (`MaChiTietHoaDon`, `TongTien`, `MaSanPham`, `MaHoaDon`, `SoLuong`) 
            VALUES (NULL, '$tongTien', ' $maSanPham', '$MaHoaDon', '$soLuong');";
            $result_DetailsOrder = mysqli_query($con, $sql_detailsOrder);
            $p->closeDB($con);
          
            return $result_DetailsOrder;
        } else {
            return false;
        }
    }

    function updateProductsStock($maSanPham, $soLuong)
    {
        $p = new ConnectDB();
        $con = null;

        if ($p->connect_DB($con)) {
            $sql_updateProductsStock = "UPDATE `sanpham` SET `SoLuongTon` = $soLuong WHERE `sanpham`.`MaSanPham` = $maSanPham;";
            $result_updateProductsStock = mysqli_query($con, $sql_updateProductsStock);

            return $result_updateProductsStock;
        } else {
            return false;
        }
    }

    function getInfoUsers()
    {
        $p = new ConnectDB();
        $con = null;

        $maKhachHang =  $_SESSION['MaKhachHang'];
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM `khachhang` WHERE MaKhachHang = '$maKhachHang'";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function getQuantityProductsInStock($idProduct)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "SELECT SoLuongTon FROM `sanpham` WHERE MaSanPham = $idProduct;";
            $result = mysqli_query($con, $str);
            $p->closeDB($con);
            return $result;
        } else {
            return false;
        }
    }

    function deleteProductInCart($maKhachHang, $maSanPham)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "DELETE FROM `giohang` WHERE MaKhachHang = $maKhachHang AND MaSanPham = $maSanPham;";
            $result = mysqli_query($con, $str);
            $p->closeDB($con);
            return $result;
        } else {
            return false;
        }
    }
}