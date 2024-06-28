<?php
include_once("controller/cDetailsOrder.php");
class VDetailsOrder
{
    function viewAllOrder()
    {
        $p = new CDetailsOrder();
        $tbl = $p->getAllOrder();
        showProduct4($tbl);
    }

    function cartTotal()
    {
        $p = new CCart();
        $tbl = $p->getAllProduct();
        $total = 0;
        if ($tbl) {
            if (mysqli_num_rows($tbl) > 0) {
                while ($row = mysqli_fetch_assoc($tbl)) {
                    $total += $row['GiaBan'] * $row['SoLuong'];
                }
            }
        } else {
            echo "Vui lòng nhập dữ liệu!";
        }

        echo number_format($total, 0, ',', '.');
        echo "đ";
    }
}


function showProduct4($tbl)
{
    if ($tbl) {
        if (mysqli_num_rows($tbl) > 0) {
            $temp = "";
            while ($row = mysqli_fetch_assoc($tbl)) {

                // loại bỏ trùng mã hoá đơn

                echo '
                    <tr>
                        <form action="detailsOrder.php" method="get">
                            <td class="shoping__cart__item">
                            <img src="img2/' . $row['HinhAnh'] . '" style="width: 100px" alt="">
                                <h5>' . $row['TenSanPham'] . '</h5>
                            </td>
                            <td class="shoping__cart__price">
                            <p>' . $row['SoLuong'] . '</p>
                            </td>
                            
                            <td class="shoping__cart__quantity">
                                <div class="quantity">
                                ' . $row['TongTien'] . 'đ
                                </div>
                            </td>
                            <td class="shoping__cart__item">
                                <input type="hidden" name="maSanPham" value="' . $row['MaSanPham'] . '">
                                <!-- Button trigger modal đánh giá sản phẩm -->
                                <button onclick="handleBtnComment(\'' . $row['TenSanPham'] . '\',\'' . $row['MaSanPham'] . '\' )" type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#exampleModal">
                                Đánh giá sản phẩm
                            </button>
                            <button onclick="handleBtnReturn(\'' . $row['TenSanPham'] . '\',\'' . $row['MaChiTietHoaDon']  . '\',\'' . $row['SoLuong']  . '\' )" type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal2">
                            Trả hàng
                        </button>
                            </td>
                        </form>
                    </tr>
                    ';
            }
        }
    } else {
        echo "Vui lòng nhập dữ liệu!";
    }
}