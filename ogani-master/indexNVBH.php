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
    header('location: ./admin/login.php');
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

</body>
<script src="./js/mainAdmin.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>


</html>