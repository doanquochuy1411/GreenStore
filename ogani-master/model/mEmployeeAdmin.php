<?php
include_once("connect.php");

class MEmployeeAdmin
{
    function selectAllEmployees()
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM nhanvien";
            $tbl = mysqli_query($con, $str); // Use mysqli_query with the connection parameter
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function selectAllEmployeeBySearch($search)
    {
        $p = new ConnectDB();
        // $con;
        $ma = SUBSTR($search, 2);
        $loai = substr($search, 0, 2);
        if ($loai !== 'NV') {
            $tbl = 0;
            $maNV = "";
        } else {
            $maNV = intval($ma);
        }

        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM nhanvien WHERE HoTen like N'%$search%' or MaNhanVien = '$maNV' or SoDienThoai like N'%$search%' or Email like N'%$search%'";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function selectDelEmployee($MaNhanVien)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "UPDATE nhanvien SET trangThai = '0' WHERE MaNhanVien = '$MaNhanVien' LIMIT 1 ;";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }


    function selectEmployeeToEdit($MaNhanVien)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM nhanvien WHERE MaNhanVien = '$MaNhanVien' LIMIT 1 ;";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function updateEmployee($MaNhanVien, $hoten, $matkhau, $email, $sdt, $diachi, $loainv)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "
                UPDATE `nhanvien` SET `HoTen` = '$hoten', `MatKhau` = '$matkhau',
                 `Email` = '$email', `SoDienThoai` = '$sdt', `DiaChi` = '$diachi', `LoaiNhanVien` ='$loainv' 
                 WHERE `nhanvien`.`MaNhanVien` = '$MaNhanVien';
                ";
            // echo"<script>alert('$str')</script>";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function insertEmployee($hoten, $matkhau, $email, $sdt, $diachi, $loainv)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "
                INSERT INTO `nhanvien` (
                    `HoTen`, 
                    `MatKhau`, 
                    `Email`, 
                    `SoDienThoai`, 
                    `DiaChi`, 
                    `LoaiNhanVien`, 
                    `trangThai`) 
                    VALUES ('$hoten', '$matkhau', '$email', '$sdt', '$diachi', '$loainv', '1');
                ";
            echo "<script>alert('$str')</script>";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }
}
