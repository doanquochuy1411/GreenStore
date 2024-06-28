<?php
    session_start();
    if (isset($_REQUEST['logout'])){
        session_unset(); // Xóa tất cả các biến trong session
        session_destroy(); // Hủy session
        header('location: index.php');
        exit();
    }
    // if (isset($_REQUEST['submitAddToCart'])){
    //     if (!$_SESSION['login']){
    //         header('location: ./view/login.php');
    //     } else {
    //         // thêm vào giỏ hàng
    //     }
    // }
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="./css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="./css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="./css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="./css/slicknav.min.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="stylesheet" type="text/css" href="./css/main_long.css">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> hello@colorlib.com</li>
                                <li>Miễn phí vận chuyển cho đơn hàng từ 100.000đ</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                            </div>
                            <div class="header__top__right__auth">
                                <?php
                                    if (isset($_SESSION['MaKhachHang'])) {
                                        include('./model/connect.php');
                                        $p = new ConnectDB();
                                        $conn = $p -> connect_DB($con);
                                        $tenTaiKhoan = $_SESSION['MaKhachHang'];
                                        $name = mysqli_query($conn, "SELECT * FROM `khachhang` WHERE `MaKhachHang`= $tenTaiKhoan");
                                        $kq = mysqli_fetch_array($name);
                                        echo '<div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            '.$kq["HoTen"].'
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="orderManage.php">Quản lý đơn hàng</a>
                                                    <a class="dropdown-item" href="capnhatttcn.php">Cập nhật thông tin</a>
                                                    <a class="dropdown-item" href="doimatkhau.php">Đổi mật khẩu</a>
                                                    <a class="dropdown-item" href="vDetailProduct.php?logout">Đăng xuất</a>
                                                </div>
                                            </div>';
                                } else {
                                    echo '<a href="view/login.php"><i class="fa fa-user"></i>Đăng nhập<a>';
                                }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="index.php"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <li><a href="index.php">Trang chủ</a></li>
                            <li><a href="shop-grid.php">Sản phẩm</a></li>
                            <li><a href="contact.php">Liên hệ</a></li>
                            <li><a href="blog.php">Blog</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <!-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> -->
                            <li><a href="cart.php"><i class="fa fa-shopping-bag"></i> <span>
                                        <?php 
                                    if(isset($_SESSION['MaKhachHang'])) {
                                        include('view/vCart.php');
                                        $cart = new VCart();
                                        $total = $cart->countCart();
                                        echo $total;
                                    } else {
                                        echo '0';
                                }?>
                                    </span></a></li>
                        </ul>
                        <div class="header__cart__price">item: <span>
                                <?php 
                                if(isset($_SESSION['MaKhachHang'])) {
                                    $total = $cart->cartTotal();
                                    echo $total;
                                } else {
                                    echo '0đ';
                                }?>
                            </span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>

    <?php
        // include_once('./layout/headerweb.php');
        include_once("./controller/cDetailsProduct.php");
        $p = new CDetailsProduct();
        $p->handleAddToCart()
    ?>


    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>SẢN PHẨM</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">

                        <?php
                        include_once("./view/vDetailsProduct.php");
                        $p = new vDetailsProduct();
                        $p->viewAllProducts();
                        ?>
                        <div class="col-lg-6 col-md-6">
                            <div class="product__details__text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Footer Begin -->
    <?php
        include('footer.php');
    ?>
    <!-- Footer End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/pagination.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>