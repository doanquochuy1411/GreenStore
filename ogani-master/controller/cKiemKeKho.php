<?php

include_once("Model/mKiemKeKho.php");
class controlPhieuKiemTraKho{

    function getAllPhieuKiemTraKho()
    {
        $p = new modelPhieuKiemTraKho(); 
        $tbl = $p->SelectAllPhieuKiemTraKho(); //trả về table
        return $tbl;
    }
    function getDeletePhieuKiemTraKho($MaPhieuKiemTraKho){
        $p = new modelPhieuKiemTraKho();
        $tbl = $p -> selectDelPhieuKiemTraKho($MaPhieuKiemTraKho);
        return $tbl;
    }
    function getAllPhieuKiemTraKhoBySearch($search){
        $p = new modelPhieuKiemTraKho();
        $tbl = $p -> selectAllPhieuKiemTraKhoBySearch($search);
        return $tbl;
    }

    function getPhieuKiemTraKhoToEdit($MaPhieuKiemTraKho){
        $p = new modelPhieuKiemTraKho();
        $tbl = $p -> selectPhieuKiemTraKhoToEdit($MaPhieuKiemTraKho);
        return $tbl;
    }

    function editPhieuKiemTraKho($MaPhieuKiemTraKho, $NgayKiemTra, $TrangThaiKiemTra, $MaNhanVien, $MaSanPham){
        $p = new modelPhieuKiemTraKho();
        $res = $p -> updatePhieuKiemTraKho($MaPhieuKiemTraKho, $NgayKiemTra, $TrangThaiKiemTra, $MaNhanVien, $MaSanPham);
        if($res){
            return 1; //update thành công
        }else{
            return 0; //update không thành công
        }
    }
    function addPhieuKiemTraKho($NgayKiemTra,$TrangThaiKiemTra,$MaNhanVien,$MaSanPham){
        $p = new modelPhieuKiemTraKho();
        $res = $p -> insertPhieuKiemTraKho($NgayKiemTra,$TrangThaiKiemTra,$MaNhanVien,$MaSanPham);
        if($res){
            return 1; //insert thành công
        }else{
            return 0; //insert không thành công
            }
    }



}