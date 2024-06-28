<?php
    include_once("Model/mChiTietHoaDon_NVBH.php");
    class CCTHoaDon{
        function getAllCTHoaDon(){
            $p = new MCTHoaDon();
            $tbl = $p -> selectAllCTHoaDon();
            return $tbl;
        }

        function getAllCTHoaDonBySearch($search){
            $p = new MCTHoaDon();
            $tbl = $p -> selectAllCTHoaDonBySearch($search);
            return $tbl;
        }

        
    }
?>