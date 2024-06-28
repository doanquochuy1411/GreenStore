<?php
    include_once("Model/mLoaiSPAdmin.php");
    class CLoaiSPAdmin{
        function getAllLoaiSP(){
            $p = new MLoaiSP();
            $tbl = $p -> selectAllLoaiSP();
            return $tbl;
        }
    }
?>