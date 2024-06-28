<?php
    include_once("Model/mLoaiSP.php");
    class CLoaiSPAdmin{
        function getAllLoaiSP(){
            $p = new MLoaiSP();
            $tbl = $p -> selectAllLoaiSP();
            return $tbl;
        }
    }
?>