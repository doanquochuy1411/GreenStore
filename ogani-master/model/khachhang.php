<?php
include_once("connect.php");

class modelProduct{
    
    function dangky($hoten,$sodienthoai, $diachi, $matkhau,$email, $role){
        $con;
        $p= new ConnectDB();
        if($p->connect_DB($con)){
            $string = "INSERT INTO khachhang(HoTen,SoDienThoai, DiaChi, MatKhau, Email, trangThai) 
            VALUES('$hoten','$sodienthoai', '$diachi ', '$matkhau', '$email', '$role')";
            $kq = mysqli_query($con,$string);
            $p->closeDB($con);
            return $kq;
        }else{
            return false;
        }
    }

    function checkdangky($email){
        $con;
        $p= new ConnectDB();
        if($p->connect_DB($con)){
            $query = "SELECT * FROM khachhang WHERE Email = '$email'";
            $result = mysqli_query($con, $query);
            $p->closeDB($con);
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
        if($p->connect_DB($con)){
            $query = "SELECT * FROM khachhang WHERE SoDienThoai = '$sdt'";
            $result = mysqli_query($con, $query);
            $p->closeDB($con);
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
        $p = new ConnectDB();
        $con = $p->connect_DB($conn);
        if ($con) {
            // $query = "SELECT * FROM khachhang WHERE MaKhachHang = $ma";
            // $result = mysqli_query($con, $query);
            $query = "SELECT MatKhau FROM khachhang WHERE MaKhachHang = ?";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "i", $ma);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)){
                    // print_r('check pass: '.password_verify($inputPassword, $row['MatKhau']));
                    if (password_verify($inputPassword, $row['MatKhau'])){
                        mysqli_stmt_close($stmt);
                        return true;
                    }
                }
            }
        } 
        mysqli_stmt_close($stmt);
        return false;
    }

    function changePassword($oldPassword, $newPassword,$ma) {
        $con;
        $p= new ConnectDB();
        if($p->connect_DB($con)){
            $string = "UPDATE khachhang SET MatKhau = '$newPassword' WHERE MaKhachHang ='$ma'";
            $kq = mysqli_query($con,$string);
            $p->closeDB($con);
            return $kq;
        }else{
            return false;
        }
    }

    function changePassword1($email, $newPassword) {
        $con;
        $p= new ConnectDB();
        if($p->connect_DB($con)){
            //$hashedPassword = md5($newPassword);
            $string = "UPDATE khachhang SET MatKhau = '$newPassword', locked = 0 WHERE MaKhachHang = $email";
            $kq = mysqli_query($con,$string);
            $p->closeDB($con);
            return $kq;
        }else{
            return false;
        }
    }
    
}
?>