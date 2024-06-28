<?php
    include_once("../model/user.php");
    class ControlProduct{

        function capnhatmatkhau1($email, $newPassword){
            $p=new modelProduct();
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