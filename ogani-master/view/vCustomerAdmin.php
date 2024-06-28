<?php
include_once("controller/cCustomerAdmin.php");
class VCustomer
{
    function viewAllCustomers()
    {
        $p = new CCustomer();
        $tbl = $p->getAllCustomers();
        showCustomer($tbl);
    }

    function viewAllCustomerBySearch($search)
    {
        $p = new CCustomer();
        if (isset($_REQUEST['txtSearchKH'])) {
            $tbl = $p->getAllCustomerBySearch($search);
        }
        showCustomer($tbl);
    }

    function showFormDelCustomer()
    {
        $p = new CCustomer();
        if (isset($_REQUEST["btnCusAct"])) {
            if ($_REQUEST["btnCusAct"] == "delete") {
                $result = $p->getDelCustomer($_REQUEST["MaKhachHang"]);
                echo "<script>alert('Xoá khách hàng thành công!')</script>";
                header("refresh:0; url='indexAdmin.php?khach-hang'");
                return $result;
            }
        }
    }
}

function showCustomer($tbl)
{
    if ($tbl) {
        if (mysqli_num_rows($tbl) > 0) {
            echo '
                <div id="khach-hang" class="container tab-pane active"><br>
                <div class="row timKiem-them">
                <div class="timKiem input-group mb-3 col-md-5">
                    <form action="#" method="get">
                             <input type="text" name="txtSearchKH" size="18" placeholder = "Tên khách hàng" value = "';
            if (isset($_REQUEST["txtSearchKH"])) echo $_REQUEST["txtSearchKH"];
            echo '" >
                             <input type="submit" name="btnSearchKH" class="btnCus btnCus5" value="Tìm"> 
                    </form>
                </div>

                <div class="timKiem col-md-4">
                    <h2>QUẢN LÝ KHÁCH HÀNG</h2>
                </div>
                <div class="timKiem themNhanVien col-md-3">
                </div>
            </div>
            </div>
                ';
            $dem = 0;
            echo "<table class='prod_tbl'> <tr>";
            echo '
                    <table class="table table-bordered table-hover " id="myTable">
                    <thead class="table-secondary">
                        <tr class="ex">
                            <th width="auto">Mã KH</th>
                            <th width="auto">Tên KH</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Email</th>
                            <th class="tinh-nang">Tính Năng</th>
                        </tr>
                    </thead>
                    ';
            while ($row = mysqli_fetch_assoc($tbl)) {
                if ($row["trangThai"] == 1) {
                    echo "<tr >";
                    echo "<td>KH" . $row["MaKhachHang"] . "</td>";
                    echo "<td>" . $row["HoTen"] . "</td>";
                    echo "<td>" . $row["SoDienThoai"] . "</td>";
                    echo "<td>" . $row["DiaChi"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td style = 'display: flex; justify-content: center;'>
                                    <form action='#' method='get' onsubmit='return confirmDelete();'>
                                        <input type='hidden' name='MaKhachHang' value='" . $row["MaKhachHang"] . "'>
                                        <button class='btnCus btn2 delete' type='submit' value='delete' name= 'btnCusAct'>
                                            <i class='fa fa-trash-o' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                </td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "Không tìm thấy khách hàng!";
            echo header("refresh: 5; url='indexAdmin.php?khach-hang'");
        }
    }
}