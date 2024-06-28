<?php
    include_once("Model/mCustomerAdmin.php");
    class CCustomer{
        function getAllCustomers(){
            $p = new MCustomer();
            $tbl = $p -> selectAllCustomers();
            return $tbl;
        }

        function getAllCustomerBySearch($search){
            $p = new MCustomer();
            $tbl = $p -> selectAllCustomerBySearch($search);
            return $tbl;
        }

        function getDelCustomer($MaKhachHang){
            $p = new MCustomer();
            $tbl = $p -> selectDelCustomer($MaKhachHang);
            return $tbl;
        }
    }
?>