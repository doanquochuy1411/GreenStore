<?php
include_once("connect.php");

class MDetailsProduct
{
    function addToCart($quantity, $idProduct, $idCustommer)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "INSERT INTO `giohang` (`MaGioHang`, `SoLuong`, `MaKhachHang`, `MaSanPham`) VALUES (NULL, '" . $quantity . "', '$idCustommer', '" . $idProduct . "');";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function updateProductInCart($quantity, $idProduct, $idCustommer)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "UPDATE `giohang` SET `SoLuong`= '$quantity' WHERE `MaKhachHang`= '$idCustommer' AND `MaSanPham`= $idProduct;";
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

    function checkProductsAlreadyInCart($idProduct, $idCustommer)
    {
        $p = new ConnectDB();
        $con = null;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM `giohang` WHERE MaKhachHang = $idCustommer AND MaSanPham = $idProduct;";
            $result = mysqli_query($con, $str);
            $p->closeDB($con);
            return $result;
        } else {
            return false;
        }
    }
    
}
