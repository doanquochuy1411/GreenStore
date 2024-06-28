<?php
include_once("connect.php");

class modelClient{
    
    function dangky($hoten,$sodienthoai, $diachi, $matkhau,$email, $role){
        $con;
        $p= new ConnectDB();
        if($p->ketnoiDB($con)){
            $string = "INSERT INTO khachhang(HoTen,SoDienThoai, DiaChi, MatKhau, Email, trangThai) 
            VALUES('$hoten','$sodienthoai', '$diachi ', '$matkhau', '$email', '$role')";
            $kq = mysqli_query($con,$string);
            $p->dongKetNoi($con);
            return $kq;
        }else{
            return false;
        }
    }

    function checkdangky($email){
        $con;
        $p= new ConnectDB();
        if($p->ketnoiDB($con)){
            $query = "SELECT * FROM khachhang WHERE Email = '$email'";
            $result = mysqli_query($con, $query);
            $p->dongKetNoi($con);
            if ($result && mysqli_num_rows($result) > 0) {
                return false;
            } else {
                return true;
            }
            
        }else{
            return false;
        }
    }
    function checkdangkysdt($sdt){
        $con;
        $p= new ConnectDB();
        if($p->ketnoiDB($con)){
            $query = "SELECT * FROM khachhang WHERE SoDienThoai = '$sdt'";
            $result = mysqli_query($con, $query);
            $p->dongKetNoi($con);
            if ($result && mysqli_num_rows($result) > 0) {
                return false;
            } else {
                return true;
            }
            
        }else{
            return false;
        }
    }
    function isPasswordCorrect($inputPassword, $ma) {
        $con;
        $p = new ConnectDB();
        if ($p->ketnoiDB($con)) {
            $hashedInputPassword = md5($inputPassword);
            $query = "SELECT * FROM khachhang WHERE MatKhau = '$hashedInputPassword' AND MaKhachHang = '$ma'";
            $result = mysqli_query($con, $query);
            $rowCount = mysqli_num_rows($result);
            
            $p->dongKetNoi($con);
            
            return $rowCount > 0; // Trả về true nếu có ít nhất một dòng dữ liệu khớp
        } else {
            return false;
        }
    }

    function changePassword($oldPassword, $newPassword,$ma) {
        $con;
        $p= new ConnectDB();
        if($p->ketnoiDB($con)){
            $hashedPassword = md5($oldPassword);
            $string = "UPDATE khachhang SET MatKhau = '$newPassword' WHERE MatKhau = '$hashedPassword' and MaKhachHang ='$ma'";
            $kq = mysqli_query($con,$string);
            $p->dongKetNoi($con);
            return $kq;
        }else{
            return false;
        }
    }

    function changePassword1($email, $newPassword) {
        $con;
        $p= new ConnectDB();
        if($p->ketnoiDB($con)){
            //$hashedPassword = md5($newPassword);
            $string = "UPDATE khachhang SET MatKhau = '$newPassword' WHERE MaKhachHang = $email";
            $kq = mysqli_query($con,$string);
            $p->dongKetNoi($con);
            return $kq;
        }else{
            return false;
        }
    }
    
}
?>