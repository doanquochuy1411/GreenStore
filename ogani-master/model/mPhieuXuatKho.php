<?php
    include_once("connect3.php");
    class modelPhieuXuatKho{
        function selectAllPhieuXuatKho(){
            // $con;
            $p = new KetNoiDB();
            if ($p ->moketnoi($con)) {
                $query="SELECT pxk.MaPhieuXuatKho, pxk.TrangThaiPhieuXuatKho, pxk.PhieuShow, 
                pxk.NgayLapPhieuXuatKho, nvk.MaNhanVien, nvk.HoTen,
                sp.MaSanPham, sp.TenSanPham, sp.SoLuongTon, sp.ThuongHieu, sp.LoaiSanPham
                FROM phieuxuatkho pxk
                INNER JOIN nhanvien nvk ON nvk.MaNhanVien = pxk.MaNhanVien
                INNER JOIN sanpham sp ON sp.MaSanPham = pxk.MaSanPham
                ";
                $tbl=mysqli_query($con,$query);
                $p->dongketnoi($con);
                return $tbl;
            } else {
                return false;
            }
        }
        function selectAllPhieuXuatKhoBySearch($search){
            // $con;
            $p=new KetNoiDB();
            if ($p->moKetNoi($con)) {
                $string = "SELECT pxk.MaPhieuXuatKho, pxk.TrangThaiPhieuXuatKho, pxk.PhieuShow, 
                pxk.NgayLapPhieuXuatKho, nvk.MaNhanVien, nvk.HoTen,
                sp.MaSanPham, sp.TenSanPham, sp.SoLuongTon, sp.ThuongHieu, sp.LoaiSanPham
                FROM phieuxuatkho pxk
                INNER JOIN nhanvien nvk ON nvk.MaNhanVien = pxk.MaNhanVien
                INNER JOIN sanpham sp ON sp.MaSanPham = pxk.MaSanPham
                where TrangThaiPhieuXuatKho like N'%".$search."%' order by MaPhieuXuatKho Desc";
                $table=mysqli_query($con,$string);
                $p->dongketnoi($con);
                return $table;
            } else {
                return false;
            }
            
        }
        
        function selectPhieuXuatKhoToEdit($MaPhieuXuatKho){
            $p = new KetNoiDB();
            // $con;
            if($p -> moKetNoi($con)){
                $string = "SELECT * FROM phieuxuatkho WHERE MaPhieuXuatKho = '$MaPhieuXuatKho' LIMIT 1 ;";
                $tbl = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        function  updatePhieuXuatKho($MaPhieuXuatKho,$NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham){
            $p = new KetNoiDB();
            $con;
            if($p -> moKetNoi($con)){
                $string = "UPDATE  `mypham`.`phieuxuatkho` SET `NgayLapPhieuXuatKho` = '$NgayLapPhieuXuatKho', `TrangThaiPhieuXuatKho` = '$TrangThaiPhieuXuatKho', 
                `MaNhanVien` = '$MaNhanVien', `MaSanPham` = '$MaSanPham'
                 WHERE `MaPhieuXuatKho` = '$MaPhieuXuatKho';
                ";
                $tbl = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
    

        function selectDelPhieuXuatKho($MaPhieuXuatKho){
            // $con;
            $p = new KetNoiDB();
            if($p -> moKetNoi($con)){
                $string = "UPDATE `mypham`.`phieuxuatkho` SET `PhieuShow` = '0' WHERE `phieuxuatkho`.`MaPhieuXuatKho` =$MaPhieuXuatKho LIMIT 1 ;";
                $result = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $result;
            }else{
                return false; //ket noi that bai
            }
        }
        function insertPhieuXuatKho($NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham)
        {
            // $con;
            $p = new KetNoiDB();
            if($p -> moKetNoi($con)){
                $string = "INSERT INTO `mypham`.`phieuxuatkho` (
                    `NgayLapPhieuXuatKho` ,
                    `TrangThaiPhieuXuatKho` ,
                    `MaNhanVien` ,
                    `MaSanPham` ,
                    `PhieuShow`
                    )
                    VALUES (
                    '$NgayLapPhieuXuatKho', '$TrangThaiPhieuXuatKho','$MaNhanVien','$MaSanPham', '1'
                    );";
                $result = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $result;
            }else{
                return false; //ket noi that bai
            }
        }
    }
?>