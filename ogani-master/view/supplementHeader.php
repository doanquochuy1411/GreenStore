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
                        <li><a href="./index.php">Trang chủ</a></li>
                        <li><a href="./shop-grid.php">Sản phẩm</a></li>
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