<?php
session_start();
ob_start();

$_SESSION['MaNhanVien'];
$conn = mysqli_connect("localhost", "root", "", "raucu");

if (!isset($_SESSION['LoaiNhanVien']) || empty($_SESSION['LoaiNhanVien'])) {
    header('location: ./admin/login.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header('location: ./admin');
    exit();
}

// chuyển quyền truy cập admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
} else {
    $_SESSION['role'] = 'qlkh';

}



if (isset($_REQUEST['adminButton'])) {
    if ($_SESSION['role'] !== 'admin') {
        // Nếu không phải admin, chuyển hướng về trang không có quyền truy cập
        echo ('<h4 style="text-align:center; padding-top:10px; color:red">Bạn không có quyền truy cập trang này!</h4>');
        echo "<meta http-equiv='refresh' content='3;url='''>";
        exit();
    }

    if ($_SESSION['role'] === 'admin') {
        // Nếu là admin, chuyển hướng đến trang admin
        header('Location: indexAdmin.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="./css/styleAdmin.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    small {
        color: red;
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 header">
                <a class="navbar-brand" href="#"><i class="fa fa-user-circle" aria-hidden="true"></i>
                    <?php
                    if (isset($_SESSION['MaNhanVien'])) {
                        $tenTaiKhoan = $_SESSION['MaNhanVien'];
                        $name = mysqli_query($conn, "SELECT * FROM `nhanvien` WHERE `MaNhanVien`= $tenTaiKhoan");
                        $kq = mysqli_fetch_array($name);
                        echo $kq["HoTen"];
                    }
                    ?>
                </a>
                <form action="" method="post" id="formAdmin">
                    <button type="submit" name="adminButton" id="adminButton">Admin</button>
                    <a href="?action=logout" data-toggle="tooltip" data-placement="bottom" title="ĐĂNG XUẤT"><b>Đăng
                            xuất <i class="fas fa-sign-out-alt"></i></b></a>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-3 body">
        <br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['kiem-ke-kho']) ? "active" : ""; ?>"
                    href="indexQLKH.php?kiem-ke-kho">KIỂM KÊ KHO</a>
            </li>
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['san-pham']) ? "active" : ""; ?>"
                    href="indexQLKH.php?san-pham">SẢN PHẨM</a>
            </li>
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['phieu-nhap-kho']) ? "active" : ""; ?>"
                    href="indexQLKH.php?phieu-nhap-kho">PHIẾU NHẬP KHO</a>
            </li>
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['phieu-xuat-kho']) ? "active" : ""; ?>"
                    href="indexQLKH.php?phieu-xuat-kho">PHIẾU XUẤT KHO</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="indexQLKH.php?san-pham">CẬP NHẬT THÔNG TIN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="indexQLKH.php?phieu-nhap-kho">PHIẾU NHẬP KHO</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="indexQLKH.php?phieu-xuat-kho">PHIẾU XUẤT KHO</a>
            </li> -->
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <?php
            include_once("view/vKiemKeKho.php");
            $p = new VPhieuKiemTraKho();

            include_once("view/vProduct3.php");
            $c = new VProduct();

            include_once("view/vPhieuNhapKho.php");
            $d = new VPhieuNhapKho();

            include_once("view/vPhieuXuatKho.php");
            $e = new VPhieuXuatKho();

            include_once("Secured/checkInput.php");
            $v = new secured();

            if (isset($_REQUEST['kiem-ke-kho'])) {
                $p->viewAllPhieuKiemTraKho();
            } elseif (isset($_REQUEST['san-pham'])) {
                $c->viewAllProducts();
            } elseif (isset($_REQUEST['phieu-nhap-kho'])) {
                $d->viewAllPhieuNhapKho();
            } elseif (isset($_REQUEST['phieu-xuat-kho'])) {
                $e->viewAllPhieuXuatKho();
            } elseif (isset($_REQUEST['btnSearchPKTK'])) {
                $search = $v -> test_input($_REQUEST['txtSearchPKTK']);
                $p->viewAllPhieuKiemTraKhoBySearch($search);
            } elseif (isset($_REQUEST['btnSearchSP'])) {
                $search = $v -> test_input($_REQUEST['txtSearchSP']);
                $c->viewAllProductBySearch($search);
            } elseif (isset($_REQUEST['btnSearchPNK'])) {
                $search = $v -> test_input($_REQUEST['txtSearchPNK']);
                $d->viewAllPhieuNhapKhoBySearch($search);
            } elseif (isset($_REQUEST['btnSearchPXK'])) {
                $search = $v -> test_input($_REQUEST['txtSearchPXK']);
                $e->viewAllPhieuXuatKhoBySearch($search);
                // } elseif (isset($_REQUEST["btnSubmitActionPhieuKiemTraKho"])) {
                //     $p->showFormDelPhieuKiemTraKho();
                //     $p -> showFormEditPhieuKiemTraKho(); 
            } elseif (isset($_REQUEST["btnSubmitActionPhieuXuatKho"])) {
                $e->showFormDelPhieuXuatKho();
                $e->showFormEditPhieuXuatKho();
            } elseif (isset($_REQUEST["btnSubmitActionPhieuNhapKho"])) {
                $d->showFormDelPhieuNhapKho();
                $d->showFormEditPhieuNhapKho();
            } elseif (isset($_REQUEST["btnProdAct"])) {
                $c->showFormDelProduct();
                $c->showFormEditProduct();
            } elseif (isset($_REQUEST["btnSubmitActionPhieuKiemTraKho"])) {
                $p->showFormDelPhieuKiemTraKho();
                $p->showFormEditPhieuKiemTraKho();
                // $p -> showFormEditPhieuKiemTraKho();
                // }elseif(isset($_REQUEST["btnCusAct"])){
                //     $d -> showFormDelCustomer();
            } else {
                echo "welcom admin";
            }

            //thêm PKTK
            if (isset($_REQUEST["btnAddPKTK"]) && isset($_POST['_token']) && ($_POST['_token'] === $_SESSION['_token'])) {
                $NgayKiemTra = $v -> test_input($_REQUEST["NKT"]);
                $TrangThaiKiemTra = $v -> test_input($_REQUEST["TTKT"]);
                $MaNhanVien = (int)$_SESSION['MaNhanVien'];
                $MaSanPham = (int)$_REQUEST["MSPQLK"];
                $p = new controlPhieuKiemTraKho();
                $result = $p->addPhieuKiemTraKho($NgayKiemTra, $TrangThaiKiemTra, $MaNhanVien, $MaSanPham);

                if ($result == 1) {
                    echo "<script>alert('Thêm phieu kiem tra kho thành công!')</script>";
                    //echo header("refresh: 0; url = 'index.php?kiem-ke-kho'");
                } elseif ($result == 0) {
                    echo "<script>alert('Thêm phieu kiem tra kho không thành công!')</script>";
                }
            }
            //thêm sản phẩm
            if (isset($_REQUEST["btnAddProd"]) && isset($_POST['_token']) && ($_POST['_token'] === $_SESSION['_token'])) {

                $tenSP = $v -> test_input($_REQUEST["tenSP"]);
                $slt = $v -> test_input($_REQUEST["SLT"]);
                $moTa = $v -> test_input($_REQUEST["moTa"]);
                $giaBan = $v -> test_input($_REQUEST["giaBan"]);
                $giaNhap = $v -> test_input($_REQUEST["giaNhap"]);
                $thuongHieu = $v -> test_input($_REQUEST["thuongHieu"]);
                $hinhAnh = $_FILES["fileAnh"];
                $hsd = $v -> test_input($_REQUEST["HSD"]);
                $loaiSP = $v -> test_input($_REQUEST["LoaiSP"]);
                $nhaCC = $v -> test_input($_REQUEST["nhaCC"]);
                $cp = new CProduct();
                $result = $cp->addProduct($tenSP, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $hinhAnh, $hsd, $loaiSP, $nhaCC);

                if ($result == 1) {
                    echo "<script>alert('Add product successfully!')</script>";
                    // echo header("refresh: 0; url = 'index.php?san-pham'");
                } elseif ($result == 0) {
                    echo "<script>alert('Add product unsuccessfully!')</script>";
                } elseif ($result == -1) {
                    echo "<script>alert('This file is not image format!')</script>";
                } elseif ($result == -2) {
                    echo "<script>alert('This file is too lagre to upload!')</script>";
                } else {
                    echo "<script>alert('Can not upload file!')</script>";
                }
            }
            //thêm PNK
            if (isset($_REQUEST["btnAddPNK"]) && isset($_POST['_token']) && ($_POST['_token'] === $_SESSION['_token'])) {
                $NgayLapPhieuNhapKho = $v -> test_input($_REQUEST["NLPNK"]);
                $TrangThaiPhieuNhapKho = $v -> test_input($_REQUEST["TTPN"]);
                $MaNhanVien = $_SESSION['MaNhanVien'];
                $MaSanPham = $v -> test_input($_REQUEST["MSP"]);
                $dp = new controlPhieuNhapKho();
                $result = $dp->addPhieuNhapKho($NgayLapPhieuNhapKho, $TrangThaiPhieuNhapKho, $MaNhanVien, $MaSanPham);

                if ($result == 1) {
                    echo "<script>alert('Add phieu nhap kho successfully!')</script>";
                    //echo header("refresh: 0; url = 'index.php?phieu-xuat-kho'");
                } elseif ($result == 0) {
                    echo "<script>alert('Add phieu nhap kho unsuccessfully!')</script>";
                }
            }

            //thêm PXK
            if (isset($_REQUEST["btnAddPXK"]) && isset($_POST['_token']) && ($_POST['_token'] === $_SESSION['_token'])) {
                $NgayLapPhieuXuatKho = $v -> test_input($_REQUEST["NLPXK"]);
                $TrangThaiPhieuXuatKho = $v -> test_input($_REQUEST["TTPX"]);
                $MaNhanVien = $_SESSION['MaNhanVien'];
                $MaSanPham = $v -> test_input($_REQUEST["MSPX"]);
                $ep = new controlPhieuXuatKho();
                $result = $ep->addPhieuXuatKho($NgayLapPhieuXuatKho, $TrangThaiPhieuXuatKho, $MaNhanVien, $MaSanPham);

                if ($result == 1) {
                    echo "<script>alert('Add phieu xuat kho successfully!')</script>";
                    // echo header("refresh: 0; url = 'index.php?san-pham'");
                } elseif ($result == 0) {
                    echo "<script>alert('Add phieu xuat kho unsuccessfully!')</script>";
                }
            }
            ?>
        </div>

    </div>

    <!-- Modal Them phiếu kiểm tra kho -->
    <div class="modal fade" id="ModalPKTK" tabindex="-1" aria-labelledby="modalPKTKLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm phiếu kiểm tra kho</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form action="#" method="post" enctype="multipart/form-data"
                    onsubmit="return validateFormKiemTraKho();">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NKT">Ngày kiểm tra</label>
                            <input type="date" name="NKT" id="NKT" class="form-control" aria-describedby="NKT-mess"
                                value="<?php echo date('Y-m-d'); ?>">
                            <small id="NKT-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="TTKT">Trạng thái kiểm tra</label>
                            <input type="text" name="TTKT" id="TTKT" class="form-control" aria-describedby="TTKT-mess"
                                onblur="test('#TTKT', ktTTKT)">
                            <small id="TTKT-mess"></small>
                        </div>

                        <!-- <div class="form-group">
                                        <label for="MNVQLK">Mã nhân viên quản lý kho</label>
                                        <input type="text" name="MNVQLK" id="MNVQLK" class="form-control" aria-describedby="MNVQLK-mess" onblur="test('#MNVQLK', ktMNVQLK)">
                                        <small id="MNVQLK-mess"></small>
                                    </div> -->

                        <div class="form-group">
                            <label for="MSPQLK">Mã sản phẩm</label>
                            <input type="text" name="MSPQLK" id="MSPQLK" class="form-control"
                                aria-describedby="MSPQLK-mess" onblur="test('#MSPQLK', ktMSPQLK)">
                            <small id="MSPQLK-mess"></small>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" name="btnAddPKTK" class="btn btn-success">Lưu</button>
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>"></input>
                    </div>
                </form>

            </div>
        </div>

    </div>



    <!-- Model Them san pham -->
    <div class="modal fade" id="modalThemSP" tabindex="-1" aria-labelledby="modalThemSPLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">THÔNG TIN SẢN PHẨM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateFormSP();">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tên sản phẩm</label>
                            <input type="text" name="tenSP" id="tenSP" class="form-control"
                                aria-describedby="tenSP-messs">
                            <small id="tenSP-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Số lượng tồn</label>
                            <input type="number" name="SLT" id="SLT" class="form-control" aria-describedby="SLT-messs">
                            <small id="SLT-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Mô tả</label>
                            <input type="text" name="moTa" id="moTa" class="form-control" aria-describedby="moTa-messs">
                            <small id="moTa-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Giá nhập</label>
                            <input type="number" name="giaNhap" id="giaNhap" class="form-control"
                                aria-describedby="giaNhap-messs">
                            <small id="giaNhap-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Giá bán</label>
                            <input type="number" name="giaBan" id="giaBan" class="form-control"
                                aria-describedby="giaBan-messs">
                            <small id="giaBan-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Thương hiệu</label>
                            <!-- <input type="text" name="thuongHieu" id="thuongHieu" class="form-control"
                                aria-describedby="thuongHieu-messs">
                            <small id="thuongHieu-mess"></small> -->
                            <select name="thuongHieu" id="thuongHieu" class="form-control">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Hình ảnh</label>
                            <input type="file" name="fileAnh" class="form-control">
                            <small id="hinhAnh-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Hạn sử dụng</label>
                            <input type="date" name="HSD" id="HSD" class="form-control" aria-describedby="HSD-messs">
                            <small id="HSD-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="">Loại sản phẩm</label>
                            <!-- <input type="text" name="LoaiSP" id="LoaiSP" class="form-control"
                                aria-describedby="LSP-messs">
                            <small id="LSP-mess"></small> -->
                            <select name="loaiSP" id="loaiSP" class="form-control">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Nhà cung cấp</label>
                            <?php
                            include_once("Controller/cNhaCCAdmin.php");
                            $ce = new CNhaCCAdmin();
                            $tbl = $ce->getAllNCC();

                            if (mysqli_num_rows($tbl) > 0) {
                                echo '<select name="nhaCC" class="form-control">';
                                while ($r = mysqli_fetch_assoc($tbl)) {
                                    echo '<option value="' . $r["MaNhaCungCap"] . '">' . $r["TenNhaCungCap"] . '</option>';
                                }
                                echo '</select>';
                            }
                            ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" name="btnAddProd" class="btn btn-success">Lưu</button>
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Phiếu nhập kho  -->
    <div class="modal fade" id="ModalPNK" tabindex="-1" aria-labelledby="modalPNKLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm phiếu nhập kho</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateFormNhapKho();">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NLPNK">Ngày Lập Phiếu Nhập Kho</label>
                            <input type="date" name="NLPNK" id="NLPNK" class="form-control"
                                placeholder="vi du: 20/11/2023" aria-describedby="NLPNK-mess"
                                value="<?php echo date('Y-m-d'); ?>">
                            <small id="NLPNK-mess"></small>
                        </div>

                        <div class="form-group">
                            <label for="TTPN">Trạng thái phiếu nhập kho</label>
                            <input type="text" name="TTPN" id="TTPN" class="form-control"
                                placeholder="vi du: sản phẩm không hư hỏng" aria-describedby="TTPN-messs"
                                onblur="test('#TTPN', ktTTPN)">
                            <small id="TTPN-mess"></small>
                        </div>

                        <!-- <div class="form-group">
                                                <label for="MNVK">Mã nhân viên kiểm tra kho</label>
                                                <input type="text" name="MNVK" id="MNVK" class="form-control" placeholder="" aria-describedby="MNVK-messs" onblur="test('#MNVK', ktMNVK)">
                                                <small id="MNVK-mess"></small>
                                            </div> -->

                        <div class="form-group">
                            <label for="MSP">Mã Sản Phẩm</label>
                            <input type="text" name="MSP" id="MSP" class="form-control" placeholder=""
                                aria-describedby="MSP-messs" onblur="test('#MSP', ktMSP)">
                            <small id="MSP-mess"></small>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" name="btnAddPNK" class="btn btn-success">Lưu</button>
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>"></input>
                    </div>
                </form>

            </div>
        </div>

    </div>


    </div>

    <!-- Modal Phiếu xuất kho  -->
    <div class="modal fade" id="ModalPXK" tabindex="-1" aria-labelledby="modalPXKLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Thêm phiếu xuất kho</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form action="#" method="post" enctype="multipart/form-data" onsubmit="return validateFormXuatKho();">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Ngày Lập Phiếu Xuất Kho</label>
                            <input type="date" name="NLPXK" id="NLPXK" class="form-control"
                                placeholder="vi du: 20/11/2023" aria-describedby="NLPXK-mess"
                                value="<?php echo date('Y-m-d'); ?>">
                            <small id="NLPXK-mess"></small>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng Thái Phiếu Xuất Kho</label>
                            <input type="text" name="TTPX" id="TTPX" class="form-control" placeholder=""
                                aria-describedby="TTPX-messs" onblur="test('#TTPX', ktTTPX)">
                            <small id="TTPX-mess"></small>
                        </div>

                        <!-- <div class="form-group">
                                    <label for="">Mã nhân viên kiểm tra kho</label>
                                        <input type="text" name="MNVXK" id="MNVXK" class="form-control"
                                            placeholder="" aria-describedby="MNVXK-messs"
                                            onblur="test('#MNVXK', ktMNVXK)">
                                        <small id="MNVXK-mess"></small>
                                    </div> -->
                        <div class="form-group">
                            <label for="">Mã Sản Phẩm</label>
                            <input type="text" name="MSPX" id="MSPX" class="form-control" placeholder=""
                                aria-describedby="MSPX-messs" onblur="test('#MSPX', ktMSPX)">
                            <small id="MSPX-mess"></small>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                        <button type="submit" name="btnAddPXK" class="btn btn-success">Lưu</button>
                        <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>"></input>
                    </div>

            </div>
            </form>
        </div>
    </div>

    </div>


    </tbody>
    </table>
    </div>
    </div>
    <script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa không?");
    }
    </script>


    <script>
    function validateFormKiemTraKho() {
        var NKT = document.getElementById('NKT').value;
        var TTKT = document.getElementById('TTKT').value;
        // var MNVQLK = document.getElementById('MNVQLK').value;
        var MSPQLK = document.getElementById('MSPQLK').value;

        // Khởi tạo đối tượng chứa thông báo lỗi
        var errorMessages = {
            NKT: '',
            TTKT: '',
            // MNVQLK: '',
            MSPQLK: ''
        };

        // Kiểm tra điều kiện và lưu thông báo lỗi
        var currentDate = new Date().toISOString().split('T')[0];
        if (NKT <= currentDate) {
            errorMessages.NKT = 'Ngày lập phiếu kiểm tra kho phải lớn hơn ngày hiện tại.';
        }

        if (TTKT.trim() === '') {
            errorMessages.TTKT = 'Trạng thái phiếu kiểm tra kho không được để trống.';
        }

        // if (MNVQLK.trim() === '') {
        //     errorMessages.MNVQLK = 'Mã nhân viên kiểm tra kho không được để trống.';
        // }

        if (MSPQLK === undefined || MSPQLK.trim() === '') {
            errorMessages.MSPQLK = 'Mã Sản Phẩm không được để trống.';
        }

        // Hiển thị thông báo lỗi trong thẻ <small>
        document.getElementById('NKT-mess').innerHTML = errorMessages.NKT;
        document.getElementById('TTKT-mess').innerHTML = errorMessages.TTKT;
        // document.getElementById('MNVQLK-mess').innerHTML = errorMessages.MNVQLK;
        document.getElementById('MSPQLK-mess').innerHTML = errorMessages.MSPQLK;
        document.getElementById('NKT').value = currentDate;

        // Kiểm tra xem có thông báo lỗi nào không
        for (var field in errorMessages) {
            if (errorMessages[field] !== '') {
                return false; // Có ít nhất một lỗi, không submit form
            }
        }

        return true; // Không có lỗi, có thể submit form
    }



    function validateFormNhapKho() {
        var NLPNK = document.getElementById('NLPNK').value;
        var TTPN = document.getElementById('TTPN').value;
        // var MNVK = document.getElementById('MNVK').value;
        var MSP = document.getElementById('MSP').value;

        // Khởi tạo đối tượng chứa thông báo lỗi
        var errorMessages = {
            NLPNK: '',
            TTPN: '',
            // MNVK: '',
            MSP: ''
        };

        // Kiểm tra điều kiện và lưu thông báo lỗi
        var currentDate = new Date().toISOString().split('T')[0];
        if (NLPNK <= currentDate) {
            errorMessages.NLPNK = 'Ngày lập phiếu nhập kho phải lớn hơn ngày hiện tại.';
        }

        if (TTPN.trim() === '') {
            errorMessages.TTPN = 'Trạng thái phiếu nhập kho không được để trống.';
        }

        // if (MNVK.trim() === '') {
        //     errorMessages.MNVK = 'Mã nhân viên kiểm tra kho không được để trống.';
        // }

        if (MSP.trim() === '') {
            errorMessages.MSP = 'Mã Sản Phẩm không được để trống.';
        }

        // Hiển thị thông báo lỗi trong thẻ <small>
        document.getElementById('NLPNK-mess').innerHTML = errorMessages.NLPNK;
        document.getElementById('TTPN-mess').innerHTML = errorMessages.TTPN;
        // document.getElementById('MNVK-mess').innerHTML = errorMessages.MNVK;
        document.getElementById('MSP-mess').innerHTML = errorMessages.MSP;
        document.getElementById('NLPNK').value = currentDate;
        // Kiểm tra xem có thông báo lỗi nào không
        for (var field in errorMessages) {
            if (errorMessages[field] !== '') {
                return false; // Có ít nhất một lỗi, không submit form
            }
        }

        return true; // Không có lỗi, có thể submit form
    }



    function validateFormXuatKho() {
        var NLPXK = document.getElementById('NLPXK').value;
        var TTPX = document.getElementById('TTPX').value;
        // var MNVXK = document.getElementById('MNVXK').value;
        var MSPX = document.getElementById('MSPX').value;

        // Khởi tạo đối tượng chứa thông báo lỗi
        var errorMessages = {
            NLPXK: '',
            TTPX: '',
            // MNVXK: '',
            MSPX: ''
        };

        // Kiểm tra điều kiện và lưu thông báo lỗi
        var currentDate = new Date().toISOString().split('T')[0];
        if (NLPXK <= currentDate) {
            errorMessages.NLPXK = 'Ngày lập phiếu xuất kho phải lớn hơn ngày hiện tại.';
        }

        if (TTPX.trim() === '') {
            errorMessages.TTPX = 'Trạng thái phiếu xuất kho không được để trống.';
        }

        // if (MNVXK.trim() === '') {
        //     errorMessages.MNVXK = 'Mã nhân viên kiểm tra kho không được để trống.';
        // }

        if (MSPX.trim() === '') {
            errorMessages.MSPX = 'Mã Sản Phẩm không được để trống.';
        }

        // Hiển thị thông báo lỗi trong thẻ <small>
        document.getElementById('NLPXK-mess').innerHTML = errorMessages.NLPXK;
        document.getElementById('TTPX-mess').innerHTML = errorMessages.TTPX;
        // document.getElementById('MNVXK-mess').innerHTML = errorMessages.MNVXK;
        document.getElementById('MSPX-mess').innerHTML = errorMessages.MSPX;
        document.getElementById('NLPXK').value = currentDate;
        // Kiểm tra xem có thông báo lỗi nào không
        for (var field in errorMessages) {
            if (errorMessages[field] !== '') {
                return false; // Có ít nhất một lỗi, không submit form
            }
        }

        return true; // Không có lỗi, có thể submit form
    }

    function validateFormSP() {
        var tenSP = document.getElementById('tenSP').value;
        var thuongHieu = document.getElementById('thuongHieu').value;
        var SLT = document.getElementById('SLT').value;
        var giaNhap = document.getElementById('giaNhap').value;
        var giaBan = document.getElementById('giaBan').value;
        var HSD = document.getElementById('HSD').value;

        // Khởi tạo đối tượng chứa thông báo lỗi
        var errorMessages = {
            tenSP: '',
            thuongHieu: '',
            SLT: '',
            giaNhap: '',
            giaBan: '',
            HSD: ''
        };

        // Kiểm tra điều kiện và lưu thông báo lỗi
        if (tenSP.trim() === '') {
            errorMessages.tenSP = 'Tên sản phẩm không được để trống.';
        }

        if (thuongHieu.trim() === '') {
            errorMessages.thuongHieu = 'Thương hiệu không được để trống.';
        }

        if (SLT <= 0) {
            errorMessages.SLT = 'Số lượng tồn phải lớn hơn 0.';
        }

        if (giaNhap <= 0) {
            errorMessages.giaNhap = 'Giá nhập phải lớn hơn 0.';
        }

        if (giaBan <= giaNhap) {
            errorMessages.giaBan = 'Giá bán phải lớn hơn giá nhập.';
        }

        var currentDate = new Date().toISOString().split('T')[0];
        if (HSD <= currentDate) {
            errorMessages.HSD = 'Hạn sử dụng phải lớn hơn ngày hiện tại.';
        }

        // Hiển thị thông báo lỗi trong thẻ <small>
        document.getElementById('tenSP-mess').innerHTML = errorMessages.tenSP;
        document.getElementById('thuongHieu-mess').innerHTML = errorMessages.thuongHieu;
        document.getElementById('SLT-mess').innerHTML = errorMessages.SLT;
        document.getElementById('giaNhap-mess').innerHTML = errorMessages.giaNhap;
        document.getElementById('giaBan-mess').innerHTML = errorMessages.giaBan;
        document.getElementById('HSD-mess').innerHTML = errorMessages.HSD;
        document.getElementById('HSD').value = currentDate;

        // Kiểm tra xem có thông báo lỗi nào không
        for (var field in errorMessages) {
            if (errorMessages[field] !== '') {
                return false; // Có ít nhất một lỗi, không submit form
            }
        }

        return true; // Không có lỗi, có thể submit form
    }
    </script>

    <script>
    // Mảng chứa các tùy chọn cho select box
    var optionsArray = ["Nhóm rau xanh", "Nhóm hạt", "Trái cây", "Nhóm bông", "Nhóm củ"];

    // Lấy đối tượng select box từ DOM
    var selectBox = document.getElementById("loaiSP");

    // Duyệt qua mảng và thêm các option vào select box
    optionsArray.forEach(function(optionText) {
        var option = document.createElement("option");
        option.text = optionText;
        option.value = optionText; // Gán giá trị của option là nội dung của nó
        selectBox.add(option);
    });
    </script>

    <script>
    var optionsArrayThuongHieu = ["Dalatvet", "CanThofood", "HCMfood", "ChinaFood", "DakFood", "STFood", "MyFood",
        "GLFood", "HYFood", "PY", "HLFood", "HNFood", "TGFood", "FLFood"
    ];
    var selectBoxThuonghieu = document.getElementById("thuongHieu");
    optionsArrayThuongHieu.forEach(function(optionText) {
        var option = document.createElement("option");
        option.text = optionText;
        option.value = optionText; // Gán giá trị của option là nội dung của nó
        selectBoxThuonghieu.add(option);
    });
    </script>
</body>

</html>