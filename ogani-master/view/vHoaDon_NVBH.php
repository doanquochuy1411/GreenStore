<?php
include_once("Controller/cHoaDon_NVBH.php");

class VHoaDon {
    function viewAllHoaDon() {
        $c = new CHoaDon();
        $tbl = $c->getAllHoaDon();
        showHoaDon($tbl);
    }

    
}

function showHoaDon($tbl) {
    if ($tbl) {
        while ($row = mysqli_fetch_assoc($tbl)) {
            echo "<tr>";
            echo "<td>" . $row["MaHoaDon"] . "</td>";
            echo "<td>" . number_format($row["TongTien"], 0, ".", ".") . " VNĐ</td>";
            echo "<td>" . date("d/m/Y", strtotime($row["NgayLap"])) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "Không có dữ liệu hóa đơn.";
    }
}
?>
