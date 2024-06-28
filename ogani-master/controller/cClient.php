<?php
    include_once("../model/khachhang.php");
    class CClient{
        function UpdateProds1($hoten,$sodienthoai, $diachi, $matkhau,$email, $role){
            $p=new modelClient();
            $insert = $p->dangky($hoten,$sodienthoai, $diachi, $matkhau,$email, $role);
            if($insert==true){
                return 1;
            }
            else{
                return 0;
            }
        }

        function ktradky($email){
            $p=new modelClient();
            $insert = $p->checkdangky($email);
            if($insert==true){
                return 1;
            }
            else{
                return 0;
            }
        }
        
        function isPasswordCorrect1($inputPassword, $ma){
            $p=new modelClient();
            $insert = $p->isPasswordCorrect($inputPassword, $ma);
            if($insert==true){
                return 1;
            }
            else{
                return 0;
            }
        }
        function ktradkysdt($sdt){
            $p=new modelClient();
            $insert = $p->checkdangkysdt($sdt);
            if($insert==true){
                return 1;
            }
            else{
                return 0;
            }
        }
        
        function capnhatmatkhau($oldPassword, $newPassword,$ma){
            $p=new modelClient();
            $re = $p->changePassword($oldPassword, $newPassword,$ma);
            if($re==true){
                return 1;
            }
            else{
                return 0;
            }
        }

        function capnhatmatkhau1($email, $newPassword){
            $p=new modelClient();
            $re = $p->changePassword1($email, $newPassword);
            if($re==true){
                return 1;
            }
            else{
                return 0;
            }
        }
}
?>