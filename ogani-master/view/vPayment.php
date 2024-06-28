<?php
include_once("controller/cPayment.php");
class VPay
{
    function viewAllProducts()
    {
        $p = new CPay();
        $tbl = $p->getAllProduct();


        if (isset($_REQUEST['orderNow'])) {
            showProductOrderNow();
        } else {
            showProduct2($tbl);
        }
    }
    function viewInfoUsers()
    {
        $p = new CPay();
        $tbl = $p->getInfoUsers();
        showInfoUsers($tbl);
    }
}

function showInfoUsers($tbl)
{
    if ($tbl) {
        // Lấy dữ liệu từ hàng đầu tiên của kết quả
        $row = mysqli_fetch_assoc($tbl);

        echo '
            <div class="row">
                    <div class="col-lg-12">
                        <div class="checkout__input">
                            <p>Họ tên<span>*</span></p>
                            <input id="hoTen"  onchange="validateFormPay()" name="HoTen" type="text" value="' . $row["HoTen"] . '">
                            <small id="hoTen-mess"></small>
                        </div>
                    </div>
                </div>
                <div class="checkout__input">
                    <p>Số điện thoại<span>*</span></p>
                    <input onchange="validateFormPay()" id="SDT" name="SoDienThoai" type="tell" value="' . $row["SoDienThoai"] . '">
                    <small id="SDT-mess"></small>
                </div>
                <div class="checkout__input">
                    <p>Email<span>*</span></p>
                    <input onchange="validateFormPay()" id="Email" name="Email" type="email" value="' . $row["Email"] . '">
                    <small id="Email-mess"></small>
                </div>
                <div class="checkout__input">
                    <p>Địa chỉ<span>*</span></p>
                    <input id="DiaChi" name="DiaChi" type="text" placeholder="Street Address" class="checkout__input__add" value="' . $row["DiaChi"] . '">
                    <small id="DiaChi-mess"></small>
            </div>
        ';
    } else {
        echo "Không thể kết nối CSDL hoặc không tìm thấy thông tin người dùng.";
    }
}
function showProduct2($tbl)
{
    if ($tbl) {
        if (mysqli_num_rows($tbl) > 0) {
            while ($row = mysqli_fetch_assoc($tbl)) {
                echo '<input type="hidden" name="TongTien[]" class="_price" value=' . $row["GiaBan"] * $row["SoLuong"] . '>';
                echo '<input type="hidden" name="MaSanPham[]" value=' . $row["MaSanPham"] . '>';
                echo '<input type="hidden" name="SoLuong[]" value=' . $row["SoLuong"] . '>';

                echo '<li>' . $row["TenSanPham"] . ' <span>' . $row["GiaBan"] * $row["SoLuong"]  . '</span></li>';
            };
        }
    } else {
        echo "Vui lòng nhập dữ liệu!";
    }
}

function showProductOrderNow()
{

    echo '<input type="hidden" name="orderNow">';
    echo '<input type="hidden" name="TongTien[]" class="_price" value='.getPriceProduct($_REQUEST['idProduct']) * $_REQUEST['quantity'].'>';
    echo '<input type="hidden" name="MaSanPham[]" value=' . $_REQUEST['idProduct'] . '>';
    echo '<input type="hidden" name="SoLuong[]" value=' . $_REQUEST['quantity'] . '>';

    echo '<li>'.getNameProduct($_REQUEST['idProduct']).'<span>'.getPriceProduct($_REQUEST['idProduct']) * $_REQUEST['quantity'].'</span></li>';
}

function getPriceProduct($maSanPham)
{

    $p = new CPay();
    $tbl = $p->getNamePriceProduct($maSanPham);

    $row = mysqli_fetch_assoc($tbl);

    return $row['GiaBan'];
}

function getNameProduct($maSanPham)
{

    $p = new CPay();
    $tbl = $p->getNamePriceProduct($maSanPham);

    $row = mysqli_fetch_assoc($tbl);

    return $row['TenSanPham'];
}