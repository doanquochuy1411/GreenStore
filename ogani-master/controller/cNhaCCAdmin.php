<?php
    include_once("Model/mNhaCCAdmin.php");
    class CNhaCCAdmin{
        function getAllNCC(){
            $p = new MNhaCC();
            $tbl = $p -> selectAllNCC();
            return $tbl;
        }
    }
?>