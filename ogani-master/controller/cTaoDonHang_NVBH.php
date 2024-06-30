<?php
include_once("Model/mTaoDonHang_NVBH.php");
include_one("Secured/checkInput.php");

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


    function handlePay()
    {
        if (isset($_REQUEST['btnAddOrder']) && isset($_POST['_token']) && ($_POST['_token'] === $_SESSION['_token'])) {
            $HoTen = $v -> test_input($_REQUEST['customer-name']); // 
            $SoDienThoai = $v -> test_input($_REQUEST['customer-phone']); // 
            $Email = $v -> test_input($_REQUEST['customer-email']); // 
            $DiaChi = $v -> test_input($_REQUEST['customer-diachi']); //
            $maNhanVien = $_SESSION['MaNhanVien']; // cho tạm là 1 sau này nhân viên sẽ là online 
            $tongTienDonHang = $v -> test_input($_REQUEST["tongtien"]); // 
            $tongTien = $v -> test_input($_REQUEST['tongtien']); // mảng 
            $maSanPham = $v -> test_input($_REQUEST['selected-products']); // mảng 
            $soLuong = $v -> test_input($_REQUEST['selected-quantity']); // mảng 
            $idOrder = false;

            $checkQuantityInStock = true; //
            $checkQuantity = true; //

            foreach ($maSanPham as $index => $item) {
                // kiểm tra số lượng tồn kho có đáp ứng được không
                $resultProductsInStock =  checkQuantityProduct($soLuong[$index], $maSanPham[$index]);
                if (!$resultProductsInStock) {
                    echo "<script> alert('số lượng của sản phẩm: $maSanPham[$index] trong kho không đủ') </script>";
                    $checkQuantityInStock = false;
                }

                if($soLuong[$index] <= 0){
                    $checkQuantity = false;
                }
            };



            if ($checkQuantity) {
                if ($checkQuantityInStock) {
                    // tạo hoá đơn 
                    $idOrder = createOrder($tongTienDonHang, $maNhanVien, $DiaChi, $HoTen, $SoDienThoai, $Email);
                    foreach ($maSanPham as $index => $item) {
                        // nếu các thành phần kiểm tra đều đáp ứng đủ số lượng thì vào điều kiện này


                        // nếu đã tạo đơn hàng thành công thì tạo chi tiết hoá đơn
                        if ($idOrder) {
                            echo "<script>alert('ma hoa don $idOrder')</script>";

                            $result_createDetailsOrder = createDetailsOrder(
                                $tongTien[$index],
                                $maSanPham[$index],
                                $soLuong[$index],
                                $idOrder
                            );

                            // nếu thêm sản phẩm vào chi tiết sản phẩm thành công thì trừ đi số lượng đã thêm vào chi tiết
                            if ($result_createDetailsOrder) {
                                $quantityProductsInStock = getQuantityProduct($maSanPham[$index]);
                                updateProductsStock($maSanPham[$index], $quantityProductsInStock - $soLuong[$index]);

                                echo "<script> alert('Tạo đơn hàng thành công')</script>";
                                echo header("refresh: 0; url = './TaoDonHangNVBH.php'");
                            }
                        }
                    }
                } else {
                    echo "<script>alert('số lượng sản phẩm trong kho không đủ')</script>";
                }
            } else {
                echo "<script>alert('số lượng sản phẩm phải lớn hơn 0')</script>";
            }
        }
    }
}

function checkQuantityProduct($quantity, $idProduct)
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

function createOrder($tongTienDonHang, $maNhanVien, $DiaChi, $HoTen, $SoDienThoai, $Email)
{
    $m = new MPay();
    $result = $m->createOrder($tongTienDonHang, $maNhanVien, $DiaChi, $HoTen, $SoDienThoai, $Email);
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