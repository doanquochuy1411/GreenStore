<?php

include_once("Model/mPhieuXuatKho.php");
class controlPhieuXuatKho{

    function getAllPhieuXuatKho()
    {
        $p = new modelPhieuXuatKho(); 
        $tbl = $p->SelectAllPhieuXuatKho(); //trả về table
        return $tbl;
    }

    
    function getDeletePhieuXuatKho($MaPhieuXuatKho){
        $p = new modelPhieuXuatKho();
        $tbl = $p -> selectDelPhieuXuatKho($MaPhieuXuatKho);
        return $tbl;
    }
    function getAllPhieuXuatKhoBySearch($search){
        $p = new modelPhieuXuatKho();
        $tbl = $p -> selectAllPhieuXuatKhoBySearch($search);
        return $tbl;
    }
    function getPhieuXuatKhoToEdit($MaPhieuXuatKho){
        $p = new modelPhieuXuatKho();
        $tbl = $p -> selectPhieuXuatKhoToEdit($MaPhieuXuatKho);
        return $tbl;
    }
    function editPhieuXuatKho($MaPhieuXuatKho,$NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham){
        $p = new modelPhieuXuatKho();
        $res = $p -> updatePhieuXuatKho($MaPhieuXuatKho,$NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham);
        if($res){
            return 1; //update thành công
        }else{
            return 0; //update không thành công
        }
    }

    function addPhieuXuatKho($NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham){
        $p = new modelPhieuXuatKho();
        $res = $p -> insertPhieuXuatKho($NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham);
        if($res){
            return 1; //insert thành công
        }else{
            return 0; //insert không thành công
            }
    }
   
}