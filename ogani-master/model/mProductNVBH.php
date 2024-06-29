<?php
include_once("connect.php");

class mProduct {
    function selectAllProduct() {
        $p = new ConnectDB();
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM sanpham";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function getProductById($productId) {
        $p = new ConnectDB();
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM sanpham WHERE MaSanPham = '$productId'";
            $result = mysqli_query($con, $str);
            $row = mysqli_fetch_assoc($result);
            $p->closeDB($con);
            return $row;
        } else {
            return false;
        }
    }
    
    function getProductPrice($productId) {
        $p = new ConnectDB();
        if ($p->connect_DB($con)) {
            $str = "SELECT GiaBan FROM sanpham WHERE MaSanPham = '$productId'";
            $result = mysqli_query($con, $str);
            $row = mysqli_fetch_assoc($result);
            $p->closeDB($con);
            return $row['GiaBan'];
        } else {
            return false;
        }
    }
    
}
?>
