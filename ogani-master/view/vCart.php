<?php
include_once("controller/cCart.php");
class VCart
{
    function viewAllProducts()
    {
        $p = new CCart();
        $tbl = $p->getAllProduct();
        showProduct($tbl);
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

    function countCart()
    {
        $p = new CCart();
        $tbl = $p->getAllProduct();
        $count = 0;
        if ($tbl) {
            if (mysqli_num_rows($tbl) > 0) {
                while ($row = mysqli_fetch_assoc($tbl)) {
                    $count += 1;
                }
            }
        } else {
            echo "Vui lòng nhập dữ liệu!";
        }

        echo $count;
    }
}


function showProduct($tbl)
{
    if ($tbl) {
        if (mysqli_num_rows($tbl) > 0) {
            while ($row = mysqli_fetch_assoc($tbl)) {
                echo '
                <tr>
                <form action="#" method="get">
                        <input type="hidden" name="MaGioHang" value="' . $row['MaGioHang'] . '">
                        <input type="hidden" name="MaSanPham" value="' . $row['MaSanPham'] . '">
                    <td class="shoping__cart__item">
                        <img style="width: 100px; height: 100px" src="img2/' . $row['HinhAnh'] . '" alt="">
                        <h5>' . $row['TenSanPham'] . '</h5>
                    </td>
                    <td class="shoping__cart__price">
                        ' . number_format($row['GiaBan'], 0, ',', '.') . 'đ
                        <span class="_price" style="display: none;">' . $row['GiaBan'] . '</span>
                    </td>
                    <td class="shoping__cart__quantity">
                        <div class="quantity">
                            <div class="pro-qty">
                                <input type="text" class="_quantity" name="SoLuong" value="' . $row['SoLuong'] . '" onchange=renderPrice()>
                            </div>
                        </div>
                    </td>
                    <td class="shoping__cart__total">
                        ' . $row['GiaBan'] * $row['SoLuong'] . '
                        
                    </td>
                    <td class="shoping__cart__quantity">
                        <button type="submit" name="btnUpdateProduct" class="btn btn-outline-info" onClick="return confirmUpdate();">Cập nhật</button>
                        <button type="submit" name="btnDeleteProduct" class="btn btn-danger" onClick="return confirmDelete();">x</button>
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