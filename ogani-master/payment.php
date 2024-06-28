<?php
ob_start();
// include_once("model/connectdb.php");
$conn = mysqli_connect("localhost", "root", "", "raucu");

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Xóa tất cả các biến trong session
    session_destroy(); // Hủy session
    header('location: index.php'); // Chuyển hướng về trang login.php
    exit();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ĐẶT HÀNG</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
    small {
        color: red;
    }

    .checkout__input input {
        color: #000;
    }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <!-- <div id="preloder">
        <div class="loader"></div>
    </div> -->
    <?php
    include_once('./controller/cPayment.php');
    include './view/vPayment.php';
    $v = new VPay();

    $pay = new CPay();
    $pay->handlePay();
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
                                                    <a class="dropdown-item" href="orderManage.php">Quản lý mua hàng</a>
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
    <!-- Header Section End -->
    <br>
    <br>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>ĐẶT HÀNG</h2>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">

            <div class="checkout__form">
                <h4>Thông tin giao hàng</h4>
                <form action="#" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">


                            <?php
                            $v->viewInfoUsers();
                            ?>

                            <div class="checkout__input__checkbox">
                                <label for="acc">
                                    Bạn đồng ý với các điều khoản của chúng tôi ?
                                    <input type="checkbox" id="acc">
                                    <span class="checkmark"></span>
                                </label> <br>
                                <small id="DieuKhoan-mess"></small>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Hoá đơn</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Tổng</span></div>
                                <ul>
                                    <?php

                                    $v->viewAllProducts();
                                    ?>
                                </ul>

                                <div class="checkout__order__total">Tổng tiền <span id="total">0</span></div>
                                <input type="hidden" name="tongTienDonHang" value="0" id="tongTienDonHang">

                                <p>Vui lòng chọn phương thức thanh toán.</p>
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        Thanh toán khi nhận hàng
                                        <input type="checkbox" id="payment">
                                        <span class="checkmark"></span> <br>
                                        <small id="PhuongThucThanhToan-mess"></small>
                                    </label>
                                </div>
                                <!-- <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Chuyển khoản
                                        <input type="checkbox" id="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div> -->
                                <button type="submit" class="site-btn" name="btnPay" onClick="return confirmPay();">
                                    thanh toán</button>
                                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <?php
        include('footer.php');
    ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
    function validateFormPay() {
        console.log('object');
        var hoTen = document.getElementById('hoTen').value;
        var SDT = document.getElementById('SDT').value;
        var Email = document.getElementById('Email').value;
        var DiaChi = document.getElementById('DiaChi').value;
        var DieuKhoan = document.getElementById('acc').checked;
        var PhuongThucThanhToan = document.getElementById('payment').checked;



        // Khởi tạo đối tượng chứa thông báo lỗi
        var errorMessages = {
            hoTen: '',
            Email: '',
            SDT: '',
            DiaChi: '',
            DieuKhoan: '',
            PhuongThucThanhToan: ''
        };

        // Kiểm tra điều kiện và lưu thông báo lỗi
        //^[a-zA-Z\s]
        if (hoTen.trim() === '' || !
            /^[A-ZÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴÈÉẸẺẼÊỀẾỆỂỄÌÍỊỈĨÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠÙÚỤỦŨƯỪỨỰỬỮỲÝỴỶỸĐ][a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]*(?:[ ][A-ZÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴÈÉẸẺẼÊỀẾỆỂỄÌÍỊỈĨÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠÙÚỤỦŨƯỪỨỰỬỮỲÝỴỶỸĐ][a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]*)*$/gm
            .test(hoTen)) {
            errorMessages.hoTen = 'Họ và tên không được để trống và phải là chữ.';
        }


        if (Email.trim() === '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(Email)) {
            errorMessages.Email = 'Email không hợp lệ.';
        }

        if (SDT.trim() === '' || !/^[0]\d{9}$/.test(SDT)) {
            errorMessages.SDT = 'Số điện thoại không hợp lệ.';
        }

        var regex = /^[A-Za-z0-9\/]+$/;
        if (regex.test(DiaChi)) {
            errorMessages.DiaChi = 'Địa chỉ không hợp lệ.';
        }
        var DiaChi = DOMPurify.sanitize(DiaChi);

        if (!DieuKhoan) {
            errorMessages.DieuKhoan = 'Bắt buộc chọn.';
        }
        if (!PhuongThucThanhToan) {
            errorMessages.PhuongThucThanhToan = 'Bắt buộc chọn phương thức.';
        }



        // Hiển thị thông báo lỗi trong thẻ <small>
        document.getElementById('hoTen-mess').innerHTML = errorMessages.hoTen;
        document.getElementById('Email-mess').innerHTML = errorMessages.Email;
        document.getElementById('SDT-mess').innerHTML = errorMessages.SDT;
        document.getElementById('DiaChi-mess').innerHTML = errorMessages.DiaChi;
        document.getElementById('DieuKhoan-mess').innerHTML = errorMessages.DieuKhoan;
        document.getElementById('PhuongThucThanhToan-mess').innerHTML = errorMessages.PhuongThucThanhToan;

        // Kiểm tra xem có thông báo lỗi nào không
        for (var field in errorMessages) {
            if (errorMessages[field] !== '') {
                return false; // Có ít nhất một lỗi, không submit form
            }
        }

        return true; // Không có lỗi, có thể submit form
    }

    function confirmPay() {
        if (validateFormPay()) {
            return confirm("Bạn có chắc chắn thanh toán đơn hàng này?");
        } else {
            alert("kiểm tra lại thông tin")
            return false
        }
    }
    var formatter = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0,
    });

    const totalItem = document.querySelector('#total')
    const tongTienDonHang = document.querySelector('#tongTienDonHang')
    const prices = document.querySelectorAll('._price')

    function renderPrice() {
        let total = 0

        for (let i = 0; i < prices.length; i++) {
            console.log(parseInt(prices[i].value, 10))
            total += parseInt(prices[i].value, 10)

        }
        totalItem.innerHTML = formatter.format(total)
        tongTienDonHang.value = total
    }
    renderPrice()
    </script>;

    <script>
    function sanitizeAddress(diachi) {
        // Sử dụng DOMPurify để làm sạch chuỗi địa chỉ
        var cleanAddress = DOMPurify.sanitize(diachi);
        return cleanAddress;
    }

    function sanitizeAndSetAddress() {
        var inputElement = document.getElementById("DiaChi");
        var sanitizedAddress = sanitizeAddress(inputElement.value);
        inputElement.value = sanitizedAddress;
    }

    // Thêm sự kiện onchange vào trường nhập liệu
    document.getElementById("DiaChi").addEventListener("change", sanitizeAndSetAddress);
    console.log(document.getElementById("DiaChi").value);
    </script>


</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.4/purify.min.js"></script>

</html>