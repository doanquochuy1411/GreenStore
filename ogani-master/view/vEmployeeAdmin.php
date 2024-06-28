<?php
include_once("controller/cEmployeeAdmin.php");
class VEmployee
{
    function viewAllEmployees()
    {
        $p = new CEmployeeAdmin();
        $tbl = $p->getAllEmployees();
        showEmployee($tbl);
    }

    function viewAllEmployeeBySearch($search)
    {

        $p = new CEmployeeAdmin();
        if (isset($_REQUEST['txtSearchNV'])) {
            $tbl = $p->getAllEmployeeBySearch($search);
        }
        showEmployee($tbl);
    }

    function showFormDelEmployee()
    {
        $p = new CEmployeeAdmin();
        if (isset($_REQUEST["btnEmpAct"])) {
            if ($_REQUEST["btnEmpAct"] == "delete") {
                $result = $p->getDelEmployee($_REQUEST["MaNhanVien"]);
                echo "<script>alert('Xoá nhân viên thành công!')</script>";
                header("refresh:0; url='indexAdmin.php?nhan-vien'");
                return $result;
            }
        }
    }

    function showFormEditEmployee()
    {
        $p = new CEmployeeAdmin();
        if (isset($_REQUEST["btnEmpAct"])) {
            if ($_REQUEST["btnEmpAct"] == "edit") {
                include("editEmployeeAdmin.php");
                // return $result;
            }
        }
    }
}

function showEmployee($tbl)
{
    echo '
        <div id="san-pham" class="container tab-pane active"><br>
        <div class="row timKiem-them">
            <div class="timKiem input-group mb-3 col-md-5">
                <form action="indexAdmin.php" method="get">
                         <input type="text" name="txtSearchNV" size="18" placeholder = "Tìm kiếm" value = "';
    if (isset($_REQUEST["txtSearchNV"])) echo $_REQUEST["txtSearchNV"];
    echo '" >
                         <input type="submit" name="btnSearchNV" class="btnCus btnCus5" value="Tìm"> 
                </form>
            </div>

            <div class="timKiem col-md-4">
                <h2>QUẢN LÝ NHÂN VIÊN</h2>
            </div>
            <div class="timKiem themNhanVien col-md-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalThemNV">
                    Thêm nhân viên
                </button>
            </div>
        </div>
        </div>
        ';
    if ($tbl) {
        if (mysqli_num_rows($tbl) > 0) {
            echo "<table class='prod_tbl'> <tr>";
            echo '
                    <table class="table table-bordered table-hover" id="myTable">
                    <thead class="table-secondary">
                        <tr class="ex">
                            <th width="auto">Mã NV</th>
                            <th width="auto">Tên NV</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Loại NV</th>
                            <th class="tinh-nang">Tính Năng</th>
                        </tr>
                    </thead>
                    ';
            while ($row = mysqli_fetch_assoc($tbl)) {
                if ($row["trangThai"] == 1) {
                    echo "<tr >";
                    echo "<td>NV" . $row["MaNhanVien"] . "</td>";
                    echo "<td>" . $row["HoTen"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["SoDienThoai"] . "</td>";
                    echo "<td>" . $row["DiaChi"] . "</td>";
                    echo "<td>";
                    if ($row["LoaiNhanVien"] == 2) {
                        echo "NV Kho";
                    } else {
                        echo "NV Bán Hàng";
                        echo "</td>";
                    }
                    echo "<td style = 'display: flex; justify-content: center;'>
                            <form action='#' method='get'>
                                <input type='hidden' name='MaNhanVien' value='" . $row["MaNhanVien"] . "'>
                                <button class='btnCus btn2 edit' type='submit' value='edit' name= 'btnEmpAct'>
                                    <i class='fa fa-pencil' aria-hidden='true'></i>
                                </button>
                            </form>
                            <form action='#' method='get'onsubmit='return confirmDelete();'>
                                <input type='hidden' name='MaNhanVien' value='" . $row["MaNhanVien"] . "'>
                                
                                <button class='btnCus btn2 delete' type='submit' value='delete' name= 'btnEmpAct'>
                                    <i class='fa fa-trash-o' aria-hidden='true'></i>
                                </button>
                            </form>
                                </td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "Không tìm thấy nhân viên!";
            header("refresh: 5; url='indexAdmin.php?nhan-vien'");
        }
    }
}
