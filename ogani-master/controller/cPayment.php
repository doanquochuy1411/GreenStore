<?php
include_once("Model/mPayment.php");
class CPay
{
    function getAllProduct()
    {
        $p = new MPay();
        $tbl = $p->getAllProduct();
        return $tbl;
    }

    function getInfoUsers()
    {
        $p = new MPay();
        $tbl = $p->getInfoUsers();
        return $tbl;
    }

    function getNamePriceProduct($maSanPham)
    {
        $p = new MPay();
        $tbl = $p->getNamePriceProduct($maSanPham);
        return $tbl;
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function handlePay()
    {
        if (!isset($_SESSION['MaKhachHang'])) {
            // echo "";
            echo '<script>
            window.location.href = "view/dangnhap.php";
            </script>';
            exit();
        }

        if (isset($_REQUEST['btnPay'])) {
            if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])){
                die('Invalid CSRF token');
            } else {
                    $HoTen = $this->test_input($_REQUEST['HoTen']);
                    $SoDienThoai = $this->test_input($_REQUEST['SoDienThoai']);
                    $Email = $this->test_input($_REQUEST['Email']);
                    $DiaChi = $this->test_input($_REQUEST['DiaChi']);
                    $maNhanVien = '1'; // cho tạm là 1 sau này nhân viên sẽ là online 
                    $tongTienDonHang = $this->test_input($_REQUEST["tongTienDonHang"]);
                    if ($tongTienDonHang == 0){
                        echo "<script> alert('Chưa có sản phẩm!')</script>";
                    } else {
                        $maKhachHang = $_SESSION['MaKhachHang'];
                        $tongTien = $_REQUEST['TongTien']; // mảng
                        $maSanPham = $_REQUEST['MaSanPham']; // mảng 
                        $soLuong = $_REQUEST['SoLuong']; // mảng
                        $idOrder = false;
            
                        // print_r('Tong tien: '.$tongTien);
                        // print_r('Tong tien don hang: '.$tongTienDonHang);
                        $checkQuantity = true; //
                        foreach ($maSanPham as $index => $item) {
                            // kiểm tra số lượng tồn kho có đáp ứng được không
                            $resultProductsInStock =  checkQuantityProduct2($soLuong[$index], $maSanPham[$index]);
                            if (!$resultProductsInStock) {
                                echo "<script> alert('số lượng của sản phẩm: $maSanPham[$index] trong kho không đủ') </script>";
                                $checkQuantity = false;
                            }
                        };
            
                        if ($checkQuantity) {
                            // tạo hoá đơn 
                            $idOrder = createOrder($tongTienDonHang, $maKhachHang, $DiaChi, $HoTen, $SoDienThoai, $Email);
                            foreach ($maSanPham as $index => $item) {
                                // nếu các thành phần kiểm tra đều đáp ứng đủ số lượng thì vào điều kiện này
            
                                // nếu đã tạo đơn hàng thành công thì tạo chi tiết hoá đơn
                                if ($idOrder) {
            
                                    $result_createDetailsOrder = createDetailsOrder(
                                        $tongTien[$index],
                                        $maSanPham[$index],
                                        $soLuong[$index],
                                        $idOrder
                                    );
            
            
                                    if ($result_createDetailsOrder) {
            
                                        if (isset($_REQUEST['orderNow'])) {
                                        } else {
                                            // xoả sản phẩm đã thanh toán trong  giỏ hàng
                                            deleteProductInCart($maKhachHang, $maSanPham[$index]);
                                        }
                                    //     // nếu thêm sản phẩm vào chi tiết sản phẩm thành công thì trừ đi số lượng đã thêm đặt
                                        $quantityProductsInStock = getQuantityProduct($maSanPham[$index]);
                                        updateProductsStock($maSanPham[$index], $quantityProductsInStock - $soLuong[$index]);
            
            
            
                                        echo "<script> alert('thanh toán thành công')</script>";
                                        echo header("refresh: 0; url = 'cart.php'");
                                    }
                                }
                            }
                        }
                    }
            }
        }
                
        
    }
}

function checkQuantityProduct2($quantity, $idProduct)
{
    $m = new MPay();
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

function createOrder($tongTienDonHang, $maKhachHang, $DiaChi, $HoTen, $SoDienThoai, $Email)
{
    $m = new MPay();
    $result = $m->createOrder($tongTienDonHang, $maKhachHang, $DiaChi, $HoTen, $SoDienThoai, $Email);
    $row = mysqli_fetch_assoc($result);
    return $row['MaHoaDon'];
}

function createDetailsOrder($tongTien, $maSanPham, $soLuong, $MaHoaDon)
{
    $m = new MPay();
    $result = $m->createDetailsOrder($tongTien, $maSanPham, $soLuong, $MaHoaDon);

    return $result;
}

function getQuantityProduct($maSanPham)
{
    $m = new MPay();
    $result = $m->getQuantityProductsInStock($maSanPham);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['SoLuongTon'];
    } else {
        false;
    }
}

function updateProductsStock($maSanPham, $soLuong)
{
    $m = new MPay();
    $result = $m->updateProductsStock($maSanPham, $soLuong);
    if ($result) {
        return true;
    } else {
        false;
    }
}

function deleteProductInCart($maKhachHang, $maSanPham)
{
    $m = new MPay();
    $result = $m->deleteProductInCart($maKhachHang, $maSanPham);
    if ($result) {
        return true;
    } else {
        false;
    }
}