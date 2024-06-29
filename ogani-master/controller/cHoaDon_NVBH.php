<?php
    include_once("Model/mHoaDon_NVBH.php");

    class cHoaDon{
        function getAllHoaDon(){
            $p = new mHoaDon();
            $tbl = $p -> selectAllHoaDon();
            return $tbl;
        }

        function getHoaDonBySearch($search){
            $p = new mHoaDon();
            $tbl = $p -> selectHoaDonBySearch($search);
            return $tbl;
        }
    
        //function addOrder($ngayLap, $tongTien) {
        function addOrder($ngayLap, $tongTien, $ngayLapChiTietHoaDon, $maSanPham, $soLuong, $diaChiGiaoHang, $hoTen, $soDienThoai, $email) {
        $p = new MHoaDon();
        $result = $p -> addOrder($ngayLap, $tongTien);
        

        if ($result) {
            $pChiTietHoaDon = new MChiTietHoaDon();
            $resultChiTiet = $pChiTietHoaDon->addOrderDetails($result, $ngayLapChiTietHoaDon, $tongTien, $maSanPham, $soLuong, $diaChiGiaoHang, $hoTen, $soDienThoai, $email);
            
            return $resultChiTiet;
        

        return false;


        ///
        function getAllProductBySearch($search){
            $p = new MProduct();
            $tbl = $p -> selectAllProductBySearch($search);
            return $tbl;
        }

    }

}
    
    }

?>