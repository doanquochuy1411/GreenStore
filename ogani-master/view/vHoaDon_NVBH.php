<?php
include_once("Controller/cHoaDon_NVBH.php");

class VHoaDon {
    function viewAllHoaDon() {
        $c = new CHoaDon();
        $tbl = $c->getAllHoaDon();
        showHoaDon($tbl);
    }

    function viewHoaDonBySearch($search) {
        $c = new CHoaDon();
        $data = $c->getHoaDonBySearch($search);
        showHoaDonBySearch($data);
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

function showHoaDonBySearch($data) {
    if ($data) {
        foreach ($data as $row) {
            echo "<tr>";
            echo "<td>" . $row["MaHoaDon"] . "</td>";
            echo "<td>" . number_format($row["TongTien"], 0, ".", ".") . " VNĐ</td>";
            echo "<td>" . date("d/m/Y", strtotime($row["NgayLap"])) . "</td>";
            echo "</tr>";
        }
        // while ($row = mysqli_fetch_assoc($tbl)) {
        // }
    } else {
        echo "Không có dữ liệu hóa đơn.";
    }
}
?>