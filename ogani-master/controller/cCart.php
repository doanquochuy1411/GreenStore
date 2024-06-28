<?php
include_once("Model/mCart.php");

if (!isset($_SESSION['MaKhachHang'])) {
    header('location: view/dangnhap.php');
    exit();
}

class CCart
{
    function getAllProduct()
    {
        $p = new MCart();
        $tbl = $p->getAllProduct();
        return $tbl;
    }

    function handleUpdateProduct()
    {
        $p = new MCart();

        if (isset($_REQUEST['btnUpdateProduct'])) {
            $soLuong = $_REQUEST['SoLuong'];
            $maGioHang = $_REQUEST['MaGioHang'];
            $idProduct = $_REQUEST['MaSanPham'];
            

            $Result_checkQuantityProduct = checkQuantityProduct($soLuong, $idProduct);

            if($soLuong > 0){
                if($Result_checkQuantityProduct){
                    $tbl = $p->updateProduct($soLuong, $maGioHang);
                    if($tbl){
                        echo "<script> alert('cập nhật số lượng thành công')</script>";    
                        return $tbl;
                    }else{
                        echo "<script> alert('cập nhật số lượng thất bại')</script>";    
                    }
                }else{
                    echo "<script> alert('Số lượng tồn kho không đủ')</script>";   
                }
            }else{
                echo "<script> alert('Số lượng phải lớn hơn 0')</script>";   
            }
        };
    }

    function handleDeleteProduct()
    {
        $p = new MCart();

        if (isset($_REQUEST['btnDeleteProduct'])) {
            $maGioHang = $_REQUEST['MaGioHang'];
            $tbl = $p->deleteProduct($maGioHang);
            return $tbl;
        };
    }
}

function checkQuantityProduct($quantity, $idProduct)
{
    $m = new MCart();
    $quantityProductsInStock = 0;
    $resultProductsInStock = $m->getQuantityProductsInStock($idProduct);
    $row = mysqli_fetch_assoc($resultProductsInStock);

    // nếu kết quả tổn tại
    if ($row) {
        $quantityProductsInStock = $row['SoLuongTon'];
    }

    // kiểm tra số lượng thêm có bé hơn hoặc bằng số lượng tổn kho
    if ($quantity <= $quantityProductsInStock) {
        return true;
    } else {
    
        return false;
    }
}