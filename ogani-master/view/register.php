<?php
$hoTenDefault = '';
$soDienThoaiDefault = '';
$emailDefault = '';
$passDefault = '';
if ((isset($_POST['submit'])) && ($_POST['submit'])) {
    $hoten = addslashes($_REQUEST["name"]);
    $sodienthoai = addslashes($_REQUEST["phone"]);
    $email = addslashes($_REQUEST["email"]);
    $matkhau = addslashes($_REQUEST["pass"]);
    $patternname = '/^[a-zA-ZÀ-Ỹà-ỹ]+(?: [a-zA-ZÀ-Ỹà-ỹ]+)?$/';
    $diachi = '';
    $role = 1;
    $pattern = '/^[0-9]{10}$/';
    $checkpass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    $hashedPassword = password_hash($matkhau, PASSWORD_DEFAULT);
    if (empty($hoten) || empty($sodienthoai) || empty($email) || empty($matkhau)) {
        $txt = "Bạn cần nhập đầy đủ thông tin";
    }else if (preg_match($patternname, $hoten)) {
        $txt = "Họ tên không hợp lệ";
    } else if (!preg_match($pattern, $sodienthoai)) {
        $txt = "Số điện thoại không hợp lệ";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $txt = "Email không hợp lệ";
    } else if ((!preg_match($checkpass, $matkhau))) {
        $txt = "Mật khẩu ít nhất có 8 ký tự trong đó ít nhất một ký tự đặc biệt như @$!%*?&, ký tự chữ thường, hoa từ 'a' đến 'z' và số từ 0 - 9";
    } else {
        include_once("../Controller/ckhachhang.php");
        $p = new controlProduct();
        $re = $p->ktradky($email);
        $ra = $p->ktradkysdt($sodienthoai);
        if ($re == 0) {
            $txt = "Email đã tồn tại";
        } else if ($ra == 0) {
            $txt = "Số điện thoại đã tồn tại";
        } else {
            $kq = $p->UpdateProds1($hoten, $sodienthoai, $diachi, $hashedPassword, $email, $role);
            if ($kq == 1) {
                echo "<script> alert('Đăng ký thành công')</script>";
                echo header("refresh: 0; url='login.php'");
            } else {
                $txt = "Lỗi đăng ký";
            }
        }
    }
    $hoTenDefault = $hoten;
    $soDienThoaiDefault = $sodienthoai;
    $emailDefault = $email;
    $passDefault = $matkhau;

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main_long.css">
    <title>Đăng ký tài khoản</title>
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background: #7fad39">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../img/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title">
                        Đăng ký tài khoản
                    </span>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="name" value="<?php echo $hoTenDefault; ?>"
                            placeholder="Họ tên">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="phone" value="<?php echo $soDienThoaiDefault; ?>"
                            placeholder="Số điện thoại">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="email" value="<?php echo $emailDefault; ?>"
                            placeholder="Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 ">
                        <input class="input100" type="password" name="pass" value="<?php echo $passDefault; ?>"
                            placeholder="Mật khẩu">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset($txt) && ($txt != "")) {
                        echo "<div style='color: red; text-align: center;'>$txt</div>";
                    }
                    ?>

                    <div class="container-login100-form-btn">
                        <input style="background: #7fad39" type="submit" class="login100-form-btn" name="submit"
                            value="Đăng ký">
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="../policy.php">
                            Bằng việc đăng ký, bạn đã đồng ý về Điều khoản dịch vụ & Chính sách bảo mật
                        </a>
                    </div>
                    <div class="text-center p-t-12">
                        <a class="txt2" href="login.php">
                            Bạn đã có tài khoản? Đăng nhập tại đây
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="../vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../vendor/select2/select2.min.js"></script>
<script src="../vendor/tilt/tilt.jquery.min.js"></script>
<script>
$('.js-tilt').tilt({
    scale: 1.1
})
</script>
<script src="../js/mainn.js"></script>

</body>

</html>