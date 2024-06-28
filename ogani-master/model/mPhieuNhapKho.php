<?php
    include_once("connect3.php");
    class modelPhieuNhapKho{
        function selectAllPhieuNhapKho(){
            // $con;
            $p = new KetNoiDB();
            if ($p ->moketnoi($con)) {
                $query="SELECT pnk.MaPhieuNhapKho, pnk.TrangThaiPhieuNhapKho, pnk.PhieuShow, pnk.NgayLapPhieuNhapKho, nvk.MaNhanVien, nvk.HoTen, sp.MaSanPham, sp.TenSanPham, sp.SoLuongTon, sp.ThuongHieu, sp.LoaiSanPham, lsp.TenLoai, ncc.TenNhaCungCap
                FROM phieunhapkho pnk
                INNER JOIN nhanvien nvk ON nvk.MaNhanVien = pnk.MaNhanVien 
                INNER JOIN sanpham sp ON sp.MaSanPham = pnk.MaSanPham
                INNER JOIN loaisanpham lsp ON lsp.MaLoai = sp.LoaiSanPham
                INNER JOIN nhacungcap ncc ON ncc.MaNhaCungCap = sp.MaSanPham";
                $tbl=mysqli_query($con,$query);
                $p->dongketnoi($con);
                return $tbl;
            } else {
                return false;
            }
        }
        
        function selectAllPhieuNhapKhoBySearch($search){
            // $con;
            $p=new KetNoiDB();
            if ($p->moKetNoi($con)) {
                $string = "SELECT pnk.MaPhieuNhapKho, pnk.TrangThaiPhieuNhapKho, pnk.PhieuShow, pnk.NgayLapPhieuNhapKho, nvk.MaNhanVien, nvk.HoTen, sp.MaSanPham, sp.TenSanPham, sp.SoLuongTon, sp.ThuongHieu, sp.LoaiSanPham, lsp.TenLoai, ncc.TenNhaCungCap
                FROM phieunhapkho pnk
                INNER JOIN nhanvien nvk ON nvk.MaNhanVien = pnk.MaNhanVien
                INNER JOIN sanpham sp ON sp.MaSanPham = pnk.MaSanPham
                INNER JOIN loaisanpham lsp ON lsp.MaLoai = sp.LoaiSanPham
                INNER JOIN nhacungcap ncc ON ncc.MaNhaCungCap = sp.MaSanPham
                where TrangThaiPhieuNhapKho like N'%".$search."%' order by MaPhieuNhapKho Desc";
                $table=mysqli_query($con,$string);
                $p->dongketnoi($con);
                return $table;
            } else {
                return false;
            }
            
        }
        function selectPhieuNhapKhoToEdit($MaPhieuNhapKho){
            $p = new KetNoiDB();
            // $con;
            if($p -> moKetNoi($con)){
                $string = "SELECT * FROM phieunhapkho WHERE MaPhieuNhapKho = '$MaPhieuNhapKho' LIMIT 1 ;";
                $tbl = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
        function selectDelPhieuNhapKho($MaPhieuNhapKho){
            // $con;
            $p = new KetNoiDB();
            if($p -> moKetNoi($con)){
                $string = "UPDATE `mypham`.`phieunhapkho` SET `PhieuShow` = '0' WHERE `phieunhapkho`.`MaPhieuNhapKho` =$MaPhieuNhapKho LIMIT 1 ;";
                $result = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $result;
            }else{
                return false; //ket noi that bai
            }
        }
        function  updatePhieuNhapKho($MaPhieuNhapKho,$NgayLapPhieuNhapKho,$TrangThaiPhieuNhapKho,$MaNhanVien,$MaSanPham){
            $p = new KetNoiDB();
            $con;
            if($p -> moKetNoi($con)){
                $string = "UPDATE  `mypham`.`phieunhapkho` SET `NgayLapPhieuNhapKho` = '$NgayLapPhieuNhapKho', `TrangThaiPhieuNhapKho` = '$TrangThaiPhieuNhapKho', 
                `MaNhanVien` = '$MaNhanVien', `MaSanPham` = '$MaSanPham'
                 WHERE `MaPhieuNhapKho` = '$MaPhieuNhapKho';
                ";
                $tbl = mysqli_query($con,$string);
                $p -> dongKetNoi($con);
                return $tbl;
            }else{
                return false;
            }
        }
    


        function insertPhieuNhapKho($NgayLapPhieuNhapKho,$TrangThaiPhieuNhapKho,$MaNhanVien,$MaSanPham)
        {
            $con;
            $p = new KetNoiDB();
            if($p -> moKetNoi($con)){
                $string ="INSERT INTO `mypham`.`phieunhapkho` (
                    `NgayLapPhieuNhapKho` ,
                    `TrangThaiPhieuNhapKho` ,
                    `MaNhanVien` ,
                    `MaSanPham` ,
                    `PhieuShow`
                    )
                    VALUES (
                    '$NgayLapPhieuNhapKho', '$TrangThaiPhieuNhapKho', '$MaNhanVien','$MaSanPham', '1'
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
