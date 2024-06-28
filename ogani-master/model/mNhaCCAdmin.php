<?php
    include_once("connect.php");

    class MNhaCC {
        function selectAllNCC() {
            $p = new ConnectDB();
            // $con;
            if ($p->connect_DB($con)) {
                $str = "SELECT * FROM nhacungcap";
                $tbl = mysqli_query($con, $str); // Use mysqli_query with the connection parameter
                $p->closeDB($con);
                return $tbl;
            } else {
                return false;
            }
        }

    }
?>