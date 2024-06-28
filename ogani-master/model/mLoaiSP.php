<?php
    include_once("connect3.php");

    class MLoaiSP {
        function selectAllLoaiSP() {
            $p = new KetNoiDB();
            // $con;
            if ($p->moKetNoi($con)) {
                $str = "SELECT * FROM loaisanpham";
                $tbl = mysqli_query($con,$str); // Use mysqli_query with the connection parameter
                $p->dongKetNoi($con);
                return $tbl;
            } else {
                return false;
            }
        }

    }
?>