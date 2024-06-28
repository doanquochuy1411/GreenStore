<?php
    include_once("connect.php");

    class MProduct {
        function selectAllProducts() {
            $p = new ConnectDB();
            // $con;
            if ($p->connect_DB($conn)) {
                $str = "SELECT * FROM sanpham";
                $tbl = mysqli_query($conn,$str); // Use mysqli_query with the connection parameter
                $p->closeDB($conn);
                return $tbl;
            } else {
                return false;
            }
        }

        function selectAllProductBySearch($search){
            $p = new ConnectDB();
            // $con;
            if($p -> connect_DB($conn)){
                $str = "SELECT * FROM sanpham WHERE TenSanPham like N'%$search%'";
                $tbl = mysqli_query($conn,$str);
                $p -> closeDB($conn);
                return $tbl;
            }else{
                return false;
            }
        }

       
    }
?>