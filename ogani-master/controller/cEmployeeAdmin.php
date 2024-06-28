<?php
    include_once("Model/mEmployeeAdmin.php");
    class CEmployeeAdmin{
        function getAllEmployees(){
            $p = new MEmployeeAdmin();
            $tbl = $p -> selectAllEmployees();
            return $tbl;
        }

        function getAllEmployeeBySearch($search){
            $p = new MEmployeeAdmin();
            $tbl = $p -> selectAllEmployeeBySearch($search);
            return $tbl;
        }

        function getDelEmployee($MaNhanVien){
            $p = new MEmployeeAdmin();
            $tbl = $p -> selectDelEmployee($MaNhanVien);
            return $tbl;
        }

        function addEmployee($hoten,  $matkhau, $email, $sdt, $diachi, $loainv){
            $p = new MEmployeeAdmin();
            $res = $p -> insertEmployee($hoten, $matkhau, $email, $sdt, $diachi, $loainv);
            if($res){
                return 1; //insert thành công
            }else{
                return 0; //insert không thành công
            }
        }

        function getEmployeeToEdit($MaNhanVien){
            $p = new MEmployeeAdmin();
            $tbl = $p -> selectEmployeeToEdit($MaNhanVien);
            return $tbl;
        }

        function editEmployee( $MaNhanVien, $hoten, $matkhau, $email, $sdt, $diachi, $loainv){
            $p = new MEmployeeAdmin();
            $res = $p -> updateEmployee( $MaNhanVien, $hoten, $matkhau, $email, $sdt, $diachi, $loainv);
            if($res){
                return 1; //update thành công
            }else{
                return 0; //update không thành công
            }
        }
    }
?>