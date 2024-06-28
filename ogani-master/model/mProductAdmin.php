<?php
include_once("connect.php");

class MProductAdmin
{
    function selectAllProducts()
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM sanpham";
            $tbl = mysqli_query($con, $str); // Use mysqli_query with the connection parameter
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }

    function selectAllProductBySearch($search)
    {
        $p = new ConnectDB();
        // $con;
        $ma = SUBSTR($search, 2);
        $loai = substr($search, 0, 2);
        if ($loai !== 'SP') {
            $tbl = 0;
            $maSP = "";
        } else {
            $maSP = intval($ma);
        }
        if ($p->connect_DB($con)) {
            // $str = "SELECT * FROM sanpham WHERE TenSanPham like N'%$search%' or MaSanPham ='$maSP' or MoTa like N'%$search%' or ThuongHieu like N'%$search%'";
            // $tbl = mysqli_query($con, $str);
            // Truy vấn chuẩn bị với prepared statement
            
            $str = "SELECT * FROM sanpham WHERE TenSanPham LIKE ? OR MaSanPham = ? OR MoTa LIKE ? OR ThuongHieu LIKE ?";
            $stmt = mysqli_prepare($con, $str);

            // Gán giá trị cho các tham số
            $search = "%$search%"; // Thêm dấu % cho việc tìm kiếm theo mẫu
            mysqli_stmt_bind_param($stmt, 'ssss', $search, $maSP, $search, $search);

            // Thực thi truy vấn
            mysqli_stmt_execute($stmt);
            $tbl = mysqli_stmt_get_result($stmt);
            $p->closeDB($con);  
            return $tbl;
        } else {
            return false;
        }
    }

    function selectDelProduct($MaSanPham)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            // $str = "UPDATE sanpham SET trangThai = '0' WHERE MaSanPham = '$MaSanPham' LIMIT 1 ;";
            // $tbl = mysqli_query($con, $str);
            // Truy vấn chuẩn bị với prepared statement
            $str = "UPDATE `sanpham` SET `trangThai` = '0' WHERE `MaSanPham` = ? LIMIT 1";
            $stmt = mysqli_prepare($con, $str);

            // Gán giá trị cho các tham số
            mysqli_stmt_bind_param($stmt, 'i', $MaSanPham);

            // Thực thi truy vấn
            if(mysqli_stmt_execute($stmt)){
                $p->closeDB($con);
                return true;
            }
        } else {
            return false;
        }
    }

    function insertProduct($tenSP, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $tenAnh, $hsd, $loaiSP, $nhaCC)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "
                INSERT INTO `sanpham` (
                    `TenSanPham`, 
                    `SoLuongTon`, 
                    `MoTa`, 
                    `GiaBan`, 
                    `GiaNhap`, 
                    `ThuongHieu`, 
                    `HinhAnh`, 
                    `HanSuDung`, 
                    `LoaiSanPham`, 
                    `NhaCungCap`, 
                    `trangThai`) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1');
                ";
            $stmt = mysqli_prepare($con, $str);

            // Gán giá trị cho các tham số
            mysqli_stmt_bind_param($stmt, 'sisiissssi', $tenSP, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $tenAnh, $hsd, $loaiSP, $nhaCC);

            // Thực thi truy vấn
            if(mysqli_stmt_execute($stmt)){
                $p->closeDB($con);
                return true;
            }
            // $tbl = mysqli_query($con, $str);
            // return $true;
        } else {
            return false;
        }
    }




    function selectProductToEdit($MaSanPham)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM sanpham WHERE MaSanPham = '$MaSanPham' LIMIT 1 ;";
            $tbl = mysqli_query($con, $str);
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }


    function updateProduct($ma, $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $nameImg, $hsd, $loaiSP, $nhaCC)
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            if ($nameImg != "") { // nếu có hình
                $str = "UPDATE `sanpham` SET 
                    `TenSanPham` = ?, 
                    `SoLuongTon` = ?,
                    `MoTa` = ?,  
                    `GiaBan` = ?, 
                    `GiaNhap` = ?, 
                    `ThuongHieu` = ?, 
                    `HinhAnh` = ?, 
                    `HanSuDung` = ?, 
                    `LoaiSanPham` = ?, 
                    `NhaCungCap` = ?, 
                    `trangThai` = '1' 
                    WHERE `MaSanPham` = ?";
                    
                    $stmt = mysqli_prepare($con, $str);
                    
                    // Gán giá trị cho các tham số
                    mysqli_stmt_bind_param($stmt, 'sisiissssii', $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $nameImg, $hsd, $loaiSP, $nhaCC, $ma);
            } else {
                $str = "UPDATE `sanpham` SET 
                `TenSanPham` = ?, 
                `SoLuongTon` = ?,
                `MoTa` = ?,  
                `GiaBan` = ?, 
                `GiaNhap` = ?, 
                `ThuongHieu` = ?,
                `HanSuDung` = ?, 
                `LoaiSanPham` = ?, 
                `NhaCungCap` = ?, 
                `trangThai` = '1' 
                WHERE `MaSanPham` = ?";
                
                $stmt = mysqli_prepare($con, $str);
                
                // Gán giá trị cho các tham số
                mysqli_stmt_bind_param($stmt, 'sisiisssii', $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $hsd, $loaiSP, $nhaCC, $ma);
            }

            // Thực thi truy vấn
            if(mysqli_stmt_execute($stmt)){
                $p->closeDB($con);
                return true;
            }
            // $tbl = mysqli_query($con, $str);
            // return $tbl;
        } else {
            return false;
        }
    }

    function getData()
    {
        $p = new ConnectDB();
        // $con;
        if ($p->connect_DB($con)) {
            $str = "SELECT * FROM sanpham";
            $tbl = mysqli_query($con, $str); // Use mysqli_query with the connection parameter
            $p->closeDB($con);
            return $tbl;
        } else {
            return false;
        }
    }
}