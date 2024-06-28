<?php
    include_once("connect.php");

    class MCTHoaDon {
        function selectAllCTHoaDon() {
            $p = new ConnectDB();
            // $con;
            if ($p->connect_DB($conn)) {
                $str = "SELECT 
                hd.MaHoaDon, 
                hd.TongTien, 
                hd.NgayLap, 
                hd.HoTen, 
                hd.SoDienThoai, 
                cthd.MaChiTietHoaDon, 
                cthd.SoLuong, 
                sp.TenSanPham
            FROM 
                hoadon hd
            JOIN 
                chitiethoadon cthd ON hd.MaHoaDon = cthd.MaHoaDon
            JOIN 
                sanpham sp ON cthd.MaSanPham = sp.MaSanPham;";
                $tbl = mysqli_query($conn,$str); // Use mysqli_query with the connection parameter
                $p->closeDB($conn);
                return $tbl;
            } else {
                return false;
            }
        }

        function selectAllCTHoaDonBySearch($search){
            $p = new ConnectDB();
            // $con;
            if($p -> connect_DB($conn)){
                //$str = "SELECT * FROM chitiethoadon WHERE MaHoaDon like N'%$search%'";
                $str = "SELECT 
                hd.MaHoaDon, 
                hd.TongTien, 
                hd.NgayLap, 
                hd.HoTen, 
                hd.SoDienThoai, 
                cthd.MaChiTietHoaDon, 
                cthd.SoLuong, 
                sp.TenSanPham
            FROM 
                hoadon hd
            JOIN 
                chitiethoadon cthd ON hd.MaHoaDon = cthd.MaHoaDon
            JOIN 
                sanpham sp ON cthd.MaSanPham = sp.MaSanPham
            WHERE
                hd.MaHoaDon
             like N'%$search%'";
                $tbl = mysqli_query($conn,$str);
                $p -> closeDB($conn);
                return $tbl;
            }else{
                return false;
            }
        }

       
    }
?>