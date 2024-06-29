<?php
include_once("connect.php");

class MHoaDon {
    function selectAllHoaDon() {
        $p = new ConnectDB();
        $con = $p->connect_DB($con);

        if ($con) {
            // $stmt = $con->prepare("SELECT * FROM hoadon");
            // $stmt->execute();
            // $result = $stmt->get_result();
            // $data = $result->fetch_all(MYSQLI_ASSOC);
            // if (count($data) > 0){
            //     $p -> closeDB($con);
            //     // print_r($data);
            //     return $data;
            // }
            // return 0;
            // $p->closeDB($con);
            // return $data;

            $str = "SELECT * FROM hoadon";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function selectHoaDonBySearch($search) {
        $p = new ConnectDB();
        $con = $p->connect_DB($con);
        $search = addslashes($search);

        if ($con) {
            $stmt = $con->prepare("SELECT * FROM hoadon WHERE MaHoaDon LIKE ?");
            $stmt->execute(["%{$search}%"]);
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            if (count($data) > 0){
                $p -> closeDB($con);
                // print_r($data);
                return $data;
            }
            return 0;
            // $str = "SELECT * FROM hoadon where MaHoaDon like '%$search%'";
            // $tbl = mysqli_query($con, $str);
            // $p->closeDB($con);
            // return $tbl;
        } else {
            return false;
        }
    }

    function addOrder($ngayLap, $tongTien) {
        $p = new ConnectDB();
        $con = $p->connect_DB($con);

        if ($con) {
            $stmt = $con->prepare("INSERT INTO hoadon (NgayLap, TongTien) VALUES (?, ?)");
            $stmt->bind_param("ss", $ngayLap, $tongTien);

            if ($stmt->execute()) {
                $maHoaDon = mysqli_insert_id($con);
                //$tt = $tongTien;
                // Lấy ngày giờ hiện tại
                //$ngayLapChiTietHoaDon = date("Y-m-d");

                $stmt->close(); // Đóng statement sau khi sử dụng
                // Đóng kết nối ở đây, sau khi đã sử dụng $maHoaDon
                $p->closeDB($con);

                // Tạo một đối tượng của class MChiTietHoaDon và gọi hàm addOrderDetails
                //$chiTietHoaDon = new MChiTietHoaDon();
                //$chiTietHoaDon->addOrderDetails($maHoaDon, $ngayLapChiTietHoaDon, $tt, 'maSanPham', 'soLuong', 'diaChiGiaoHang', 'hoTen', 'soDienThoai', 'email');

                return $maHoaDon;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error connecting to the database.";
        }

        return false;
    }


    ////
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





class MChiTietHoaDon {
    function addOrderDetails($maHoaDon, $ngayLapChiTietHoaDon, $tt, $maSanPham, $soLuong, $diaChiGiaoHang, $hoTen, $soDienThoai, $email) {
        $p = new ConnectDB();
        $con = $p->connect_DB($con);

        if ($con) {
            $stmt = $con->prepare("INSERT INTO chitiethoadon (MaHoaDon, NgayLapChiTietHoaDon, TongTien, MaSanPham, SoLuong, DiaChiGiaoHang, HoTen, SoDienThoai, Email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdiissss", $maHoaDon, $ngayLapChiTietHoaDon, $tt, $maSanPham, $soLuong, $diaChiGiaoHang, $hoTen, $soDienThoai, $email);

            if ($stmt->execute()) {
                $stmt->close();
                $p->closeDB($con);
                return true;
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error connecting to the database.";
        }

        return false;
    }
}

    

?>