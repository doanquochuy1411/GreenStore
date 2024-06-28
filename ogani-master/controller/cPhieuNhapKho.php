<?php

include_once("Model/mPhieuNhapKho.php");
class controlPhieuNhapKho{

    function getAllPhieuNhapKho()
    {
        $p = new modelPhieuNhapKho(); 
        $tbl = $p->SelectAllPhieuNhapKho(); //trả về table
        return $tbl;
    }

    function getDeletePhieuNhapKho($MaPhieuNhapKho){
        $p = new modelPhieuNhapKho();
        $tbl = $p -> selectDelPhieuNhapKho($MaPhieuNhapKho);
        return $tbl;
    }
    function getAllPhieuNhapKhoBySearch($search){
        $p = new modelPhieuNhapKho();
        $tbl = $p -> selectAllPhieuNhapKhoBySearch($search);
        return $tbl;
    }
    function getPhieuNhapKhoToEdit($MaPhieuNhapKho){
        $p = new modelPhieuNhapKho();
        $tbl = $p -> selectPhieuNhapKhoToEdit($MaPhieuNhapKho);
        return $tbl;
    }

    function editPhieuNhapKho($MaPhieuNhapKho,$NgayLapPhieuNhapKho,$TrangThaiPhieuNhapKho,$MaNhanVien,$MaSanPham){
        $p = new modelPhieuNhapKho();
        $res = $p -> updatePhieuNhapKho($MaPhieuNhapKho,$NgayLapPhieuNhapKho,$TrangThaiPhieuNhapKho,$MaNhanVien,$MaSanPham);
        if($res){
            return 1; //update thành công
        }else{
            return 0; //update không thành công
        }
    }
    function addPhieuNhapKho($NgayLapPhieuNhapKho,$TrangThaiPhieuNhapKho,$MaNhanVien,$MaSanPham){
        $p = new modelPhieuNhapKho();
        $res = $p -> insertPhieuNhapKho($NgayLapPhieuNhapKho,$TrangThaiPhieuNhapKho,$MaNhanVien,$MaSanPham);
        if($res){
            return 1; //insert thành công
        }else{
            return 0; //insert không thành công
            }
    }

}