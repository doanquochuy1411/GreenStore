<?php
// -------------------------------------------------------------------------SEND MAIL-------------------------------------------------------------------------------------
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/SMTP.php';

$con = mysqli_connect("localhost","root","","raucu") or die("Can not connect to MySQL");
mysqli_set_charset($con,"UTF8");

$emailDefault = '';
if (isset($_POST['submit'])) {
    
    $emailPhone = mysqli_real_escape_string($con, $_POST['check']);
    if(empty($emailPhone)){
        $txt = "Bạn cần nhập email";
    }
    else if (!filter_var($emailPhone, FILTER_VALIDATE_EMAIL)) {
        $txt = "Email không hợp lệ";
    }
    else if (!empty($emailPhone)) {
        $select = mysqli_query($con, "SELECT * FROM `nhanvien` where `Email` = '$emailPhone';") or die("select failed");
        if (mysqli_num_rows($select) > 0) {
            $row = mysqli_fetch_assoc($select);
            $_SESSION['employee_id_check'] = $row["MaNhanVien"];
            $otp = rand(100000, 999999);
            $_SESSION['email'] = $otp;
        
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            $mail->Username = "let942217@gmail.com";
            $mail->Password = "ikfmpkfphmcyywcf";

            $mail->SMTPSecure = 'tls';

            $mail->Port = 587;

            $mail->setFrom("let942217@gmail.com");
            $mail->addAddress($emailPhone);

            $mail->isHTML(true);

            $mail->Subject = "Verification Code";
            $mail->Body = "mã code : $otp ";
            try {
                $mail->send();
                echo "<script>
                               alert('Đã gửi mã xác thực!'); 
                               location.href = 'taomatkhaumoi.php';
                               </script>";
            } catch (Exception $e) {
                echo "<script>
                               alert(''Message could not be sent. Mailer Error: ' . $mail->ErrorInfo'); 
                               </script>";
            }
        }else {
            $txt = "Email chưa được đăng ký";
        }
    } else {
        $txt = "Bạn cần nhập email";
    }
    $emaildf = $_POST['check'];
    $emailDefault = $emaildf;
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/util.css">
    <link rel="stylesheet" type="text/css" href="../../css/main_long.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo&family=Public+Sans&family=Work+Sans&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../../img/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="post">
                    <span class="login100-form-title1">
                        Quên mật khẩu
                    </span>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="check" id="check" placeholder="Nhập email của bạn">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>
                    <?php
                    if (isset($txt) && ($txt != "")) {
                        echo "<div style='color: red; text-align: center;'>$txt</div>";
                    }
                    ?>
                    <div class="container-login100-form-btn1">
                        <input type="submit" name="submit" value="Tiếp theo" class="login100-form-btn">
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
    const userHeader = document.getElementById("user_header");
    const loginLogout = document.querySelector(".login_logout");


    userHeader.addEventListener("click", function() {
        userHeader.classList.toggle("active");
        if (userHeader.classList.contains("active")) {
            loginLogout.style.display = "block";
        } else {
            loginLogout.style.display = "none";
        }

    });
    </script>
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