<?php
session_start();
ob_start();
include ('view/vProduct.php');
$p = new VProduct();
$login = false;
$url = 'index.php';
$conn = mysqli_connect("localhost", "root", "", "raucu");
if (!$conn) {
    die ("Kết nối không thành công: " . mysqli_connect_error());
}
if (isset ($_SESSION['MaKhachHang']) || !empty ($_SESSION['MaKhachHang'])) {
    $login = true;
    $url = 'userIndex.php';
}

if (isset ($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Xóa tất cả các biến trong session
    session_destroy(); // Hủy session
    header('location: userIndex.php'); 
    exit();
}

  

?>
<!-- Header Section Begin -->
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
                            if (isset ($_SESSION['MaKhachHang'])) {
                                $tenTaiKhoan = $_SESSION['MaKhachHang'];
                                $name = mysqli_query($conn, "SELECT * FROM `khachhang` WHERE `MaKhachHang`= $tenTaiKhoan");
                                $kq = mysqli_fetch_array($name);
                                echo '<div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        ' . $kq["HoTen"] . '
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="orderManage.php">Quản lý đơn hàng</a>
                                                    <a class="dropdown-item" href="capnhatttcn.php">Cập nhật thông tin</a>
                                                    <a class="dropdown-item" href="doimatkhau.php">Đổi mật khẩu</a>
                                                    <a class="dropdown-item" href="?action=logout">Đăng xuất</a>
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
                    <a href="./index.php"><img src="img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>

                        <?php
                        if (isset ($_SESSION['MaKhachHang'])) {
                            echo ' <li><a href="userIndex.php">Trang chủ</a></li>';
                        } else {
                            echo '<li><a href="index.php">Trang Chủ</a></li>';
                        }
                        ?>
                        <li><a href="./shop-grid.php">Sản Phẩm</a></li>
                        <li><a href="./contact.php">Liên hệ</a></li>
                        <li><a href="./blog.php">Blog</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <!-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> -->
                        <li><a href="cart.php"><i class="fa fa-shopping-bag"></i> <span>
                                    <?php 
                                    if($login) {
                                        include('./view/vCart.php');
                                        $cart = new VCart();
                                        $total = $cart->countCart();
                                        echo $total;
                                    } else {
                                        echo '0';
                                }?>
                                </span></a></li>
                    </ul>
                    <div class="header__cart__price">Tổng tiền: <span>
                            <?php 
                                if($login) {
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
<!-- Header Section End -->

<!-- Hero Section Begin -->
<section class="hero <?php if (!$indexPage)
    echo 'hero-normal' ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>Nhóm hoa quả</span>
                    </div>
                    <?php
$p->viewProductType();
?>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form method="get" action="#">
                            <input type="text" name='search' placeholder="Bạn đang tìm gì ?">
                            <button type="submit" name="btn-search" class="site-btn">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>031-8888-899</h5>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
                <?php
                if ($indexPage) {
                    echo ' <div class="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                        <div class="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <a href="#" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>';
                }
                ;
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->