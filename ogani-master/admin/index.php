<?php
session_start();
ob_start();

include_once ("../model/connectdb.php");
include "../Model/user.php";

function checkuser($user, $pass)
{
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM nhanvien WHERE SoDienThoai = ?");
    $stmt->execute([$user]);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    if ($kq) {
        $verify = password_verify($pass, $kq[0]['MatKhau']);
        if ($verify) {
            return $kq[0]['MaNhanVien'];
        }
    }
    return 0;
}

function checkuserRole($user, $pass)
{
    $conn = connectdb();
    $stmt = $conn->prepare("SELECT * FROM nhanvien WHERE SoDienThoai = ?");
    $stmt->execute([$user]);
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $kq = $stmt->fetchAll();
    if ($kq) {
        $verify = password_verify($pass, $kq[0]['MatKhau']);
        if ($verify) {
            return $kq[0]['LoaiNhanVien'];
        }
    }
    return 0;
}

$hoTenDefault = '';
$soDienThoaiDefault = '';
if (isset ($_POST['submit']) && $_POST['submit']) {
    $user = addslashes($_POST['user']);
    $pass = addslashes($_POST['pass']);
    $hoTenDefault = $user;
    $soDienThoaiDefault = $pass;
    $role = checkuser($user, $pass); // return idUser
    $roleUser = checkuserRole($user, $pass); // return role User

    if (empty ($pass) || empty ($user)) {
        $txt = "Bạn cần nhập đủ thông tin";
    } elseif ($role) {
        // Lưu MaKhachHang vào session
        $_SESSION['MaNhanVien'] = $role; // ID user
        $_SESSION['SoDienThoai'] = $user;
        $_SESSION['LoaiNhanVien'] = $roleUser; // Role user
        // Tao token
        $_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(16));
        //$_SESSION['MatKhau'] = $pass;
        if($roleUser==1) {
            header('location: ../indexAdmin.php');
        }else if($roleUser==3) {
            header('location: ../indexQLKH.php');
        }else if($roleUser==2) {
            header('location: ../indexNVBH.php');
        }
        // Chuyển hướng đến trang abc.php
        // header('location: ../indexAdmin.php');
        exit();
    } else {
        $txt = "Số điện thoại hoặc mật khẩu không tồn tại";
    }
    $hoTenDefault = $user;
    $soDienThoaiDefault = $pass;
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
    <title>Đăng nhập</title>
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../img/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title">
                        Đăng nhập
                    </span>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="user" value="<?php echo $hoTenDefault; ?>"
                            placeholder="Số điện thoại">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 ">
                        <input class="input100" type="password" name="pass" value="<?php echo $soDienThoaiDefault; ?>"
                            placeholder="Mật khẩu">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset ($txt) && ($txt != "")) {
                        echo "<div style='color: red; text-align: center;'>$txt</div>";
                    }
                    ?>
                    <div class="container-login100-form-btn">
                        <input type="submit" class="login100-form-btn" name="submit" value="Đăng nhập">
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="view/quenmatkhau.php">
                            Quên mật khẩu
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

</html>