<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "raucu";
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}
session_start();
if (!isset($_SESSION['MaKhachHang']) || empty($_SESSION['MaKhachHang'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang login.php
    header('location: dangnhap.php');
    exit();
}
$mkc = '';
$mkdefa = '';
$remkdefa = '';
if((isset($_POST['submit'])) && ($_POST['submit'])){
            // include_once("./Secured/checkInput.php");
            $oldPassword=addslashes($_REQUEST["oldpass"]);
            $newPassword=addslashes($_REQUEST["newpass"]);
            $mlnkm=addslashes($_REQUEST["renewpass"]);
            $checkpass = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
            $mkh = $_SESSION['MaKhachHang'];
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            include_once("./Controller/ckhachhang.php");
            $p = new controlProduct();
            $re = $p->isPasswordCorrect1($oldPassword, $mkh);
        if(empty($oldPassword) || empty($newPassword)  ||empty($mlnkm)){
            $txt = "Bạn cần nhập đủ thông tin";
        }else if($newPassword != $mlnkm){
            $txt = "Mật khẩu nhập lại không trùng khớp";
        }
        else if((!preg_match($checkpass, $newPassword))){
            $txt = "Mật khẩu ít nhất có 8 ký tự trong đó ít nhất một ký tự đặc biệt như @$!%*?&, ký tự chữ thường, hoa từ 'a' đến 'z' và số từ 0 - 9";
        }else if($re==0){
            $txt = "Mật khẩu cũ không đúng";
        }
        else{
            include_once("./Controller/ckhachhang.php");
            $p =  new controlProduct();
            $kq = $p->capnhatmatkhau($oldPassword, $hashedPassword,$mkh);
                if($kq==1){
                    echo "<script> alert('Đổi mật khẩu thành công')</script>";
                    echo header("refresh: 0; url='#'");
                }
                else{
                    $txt = "Lỗi";
                }     
        }
        
        $mkc = $oldPassword;
        $mkdefa = $newPassword;
        $remkdefa = $mlnkm;  
     }

     $conn1 = mysqli_connect("localhost","root","","raucu");
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Xóa tất cả các biến trong session
    session_destroy(); // Hủy session
    header('location: ./index.php'); // Chuyển hướng về trang login.php
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">


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
    <?php
        include('view/supplementHeader.php');
    ?>
    <div class="limiter">
        <div class="container-login100" style="background: #7fad39;">
            <div class=" wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="./img/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title">
                        Đổi mật khẩu
                    </span>

                    <div class="wrap-input100 ">
                        <input class="input100" type="password" name="oldpass" value="<?php echo $mkc; ?>"
                            placeholder="Nhập mật khẩu cũ">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 ">
                        <input class="input100" type="password" name="newpass" value="<?php echo $mkdefa; ?>"
                            placeholder="Nhập mật khẩu mới">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 ">
                        <input class="input100" type="password" name="renewpass" value="<?php echo $remkdefa; ?>"
                            placeholder="Nhập lại mật khẩu">
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
                        <input style="background: #7fad39;" type="submit" name="submit" value="Đổi mật khẩu"
                            class="login100-form-btn">

                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Begin -->
        <!-- Footer -->
        <?php
        include('./footer.php');
    ?>

</body>
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

</html>