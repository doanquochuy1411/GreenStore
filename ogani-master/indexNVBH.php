<?php
session_start();
ob_start();

$_SESSION['MaNhanVien'];
$conn = mysqli_connect("localhost","root","","raucu");
// chuyển quyền truy cập admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
} else {
    $_SESSION['role'] = 'nvbh';
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header('location: ./admin');
    exit();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Web Của Tôi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styleNVBH.css">
    <link rel="stylesheet" href="./css/styleAdmin.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <!--<div class="container">-->

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
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['don-hang']) ? "active" : ""; ?>"
                    href="indexNVBH.php?don-hang">ĐƠN
                    HÀNG</a>
            </li>
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['san-pham']) ? "active" : ""; ?>"
                    href="indexNVBH.php?san-pham">SẢN
                    PHẨM</a>
            </li>
            <li class="nav-item menu">
                <a class="nav-link <?php echo isset($_REQUEST['hoa-don']) ? "active" : ""; ?>"
                    href="indexNVBH.php?hoa-don">CHI
                    TIẾT HÓA ĐƠN</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link active" href="indexNVBH.php">TRANG NHÂN VIÊN</a>
            </li>
            <li class="nav-item">

                <a class="nav-link" href="indexNVBH.php?san-pham">SẢN PHẨM</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="indexNVBH.php?hoa-don">CHI TIẾT HÓA ĐƠN</a>
            </li> -->
        </ul>


        <?php
        if (!isset($_SESSION['MaNhanVien'])) {
            header('location: /admin');
            exit();
        }
        include_once("view/vSP_NVBH.php");
        $c = new VProduct();

        include_once("Secured/checkInput.php");
        $v = new secured();

        //include_once('View/vChiTietHoaDon_NVBH.php');
        //$c = new VCTHoaDon();
        
        if (isset($_REQUEST['san-pham'])) {
            $c->viewAllProducts();
        } elseif (isset($_REQUEST['hoa-don'])) {
            include_once('View/vChiTietHoaDon_NVBH.php');
            $c = new VCTHoaDon();
            $c->viewAllCTHoaDon();
            //} elseif(isset($_REQUEST['dele'])) {
            //    include_once('Controller/cQLHoaDon.php');
            //    $p = new cHoaDon;
            //    $p ->xoaChiTietDonHang($_REQUEST['dele']);
        } elseif (isset($_REQUEST['btnSearchHD'])) {
            include_once('View/vChiTietHoaDon_NVBH.php');
            $c = new VCTHoaDon();
            $search = $v -> test_input($_REQUEST['txtSearchHD']);
            $c->viewAllCTHoaDonBySearch($search);
        } elseif (isset($_REQUEST['btnSearchSP'])) {
            $search = $v -> test_input($_REQUEST['txtSearchSP']);
            $c->viewAllProductBySearch($search);
        } else {
            include_once('View/vOverNv_NVBH.php');
        }
        ?>

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

</body>
<script src="./js/mainAdmin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>
<script>
function confirmDelete() {
    return confirm("Bạn có chắc chắn muốn xóa không?");
}
</script>
<script src="./js/mainAdmin.js"></script>
<script>
var tenSPinPut = document.getElementById("tenSP").value;
var moTainPut = document.getElementById("moTa").value;
var tenSP = DOMPurify.sanitize(tenSPinPut);
var moTa = DOMPurify.sanitize(moTainPut);
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>

</html>