<?php
include_once("Model/mDetailsProduct.php");
class CDetailsProduct
{

    function handleAddToCart()
    {

        if (isset($_REQUEST["submitAddToCart"])) {

            if (!isset($_SESSION['MaKhachHang'])) {
                echo '<script>
                window.location.href = "view/login.php";
                </script>';
                exit();
            }

            $quantity = $_REQUEST["quantity"];
            $idProduct = $_REQUEST["idProduct"];
            $idCustommer = getIdCustommer();

            // kiểm tra sản phẩm đã tổn tại trong giỏ hàng chưa, nếu có trả về số lượng sản phẩm
            $resultCheckProductsAlreadyInCart = checkProductsAlreadyInCart2($idProduct, $idCustommer);

            // kiểm tra số lượng sản phầm, nếu không đủ trả về số lượng còn trong kho
            $resultCheckQuantityProduct = checkQuantityProduct($quantity +  $resultCheckProductsAlreadyInCart, $idProduct);



            if ($quantity > 0) {
                if ($resultCheckQuantityProduct) {

                    // nếu sản phẩm đã tồn tại thì cập nhật sản phẩm trong giỏ hàng
                    if ($resultCheckProductsAlreadyInCart) {

                        // cộng số lượng thêm mới và số lượng đã có trong giỏ hàng
                        $quantity +=  $resultCheckProductsAlreadyInCart;
                        $responAddToCart = updateProductInCart($quantity, $idProduct, $idCustommer);
                    } else {
                        $responAddToCart = addToCart($quantity, $idProduct, $idCustommer);
                    }


                    if ($responAddToCart) {
                        echo "<script> alert('thêm sản phầm vào giỏ hàng thành công') </script>";
                    } else {
                        echo "<script> alert('thêm sản phầm vào giỏ hàng thất bại') </script>";
                    }
                } else {
                    echo "<script>alert('số lượng sản phẩm tồn kho không đủ')</script>";
                }
            } else {
                echo "<script>alert('số lượng sản phẩm phải lớn hơn 0')</script>";
            }
        }

        if (isset($_REQUEST["orderNow"])) {

            if (!isset($_SESSION['MaKhachHang'])) {
                echo '<script>
                window.location.href = "view/login.php";
                </script>';
                exit();
            }
            
            $quantity = $_REQUEST["quantity"];
            $idProduct = $_REQUEST["idProduct"];

            // kiểm tra sản phẩm đã tổn tại trong giỏ hàng chưa, nếu có trả về số lượng sản phẩm
            $resultCheckProductsAlreadyInCart =  checkQuantityProduct($quantity, $idProduct);

            if ($resultCheckProductsAlreadyInCart) {
                echo '<form id="redirectForm" method="post" action="payment.php">
                <input type="hidden" name="orderNow">
                <input type="hidden" name="quantity" value=' . $_REQUEST["quantity"] . '>
                <input type="hidden" name="idProduct" value=' . $_REQUEST["idProduct"] . '>
              </form>
              <script>
                document.getElementById("redirectForm").submit();
              </script>';
            }else{
                echo ' <script>
                alert("so luong san pham khong du");
                window.location.href = "xemsanpham.php?MaSanPham='.$_REQUEST["idProduct"].'";
              </script>';
            }

            exit();
        }
    }
}

function addToCart($quantity, $idProduct, $idCustommer)
{
    $p = new MDetailsProduct();

    $tbl = $p->addToCart($quantity, $idProduct, $idCustommer);
    return $tbl;
};

function updateProductInCart($quantity, $idProduct, $idCustommer)
{
    $p = new MDetailsProduct();
    $tbl = $p->updateProductInCart($quantity, $idProduct, $idCustommer);
    return $tbl;
};

function getIdCustommer()
{
    if (isset($_SESSION['MaKhachHang'])) {
        return $_SESSION['MaKhachHang'];
    } else {
        header('PTUD_N10_DEMO/view/dangnhap.php');
    }
}

function checkQuantityProduct2($quantity, $idProduct)
{
    $m = new MDetailsProduct();
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

function checkProductsAlreadyInCart2($idProduct, $idCustommer)
{
    $m = new MDetailsProduct();
    $resultProductsInStock = $m->checkProductsAlreadyInCart($idProduct, $idCustommer);
    $row = mysqli_fetch_assoc($resultProductsInStock);

    // nếu sản phẩm đã tồn tài trong giỏ hàng
    if ($row) {
        return $row['SoLuong'];
    } else {
        return 0;
    }
}