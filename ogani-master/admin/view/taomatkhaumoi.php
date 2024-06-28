<?php
    session_start();
    ob_start();
    include "../../Model/connectdb.php";
    include "../../Model/user.php";
    $mkdef = '';
if((isset($_POST['submit'])) && ($_POST['submit'])){
            $matkhau=$_REQUEST["pass"];
            $otp = $_SESSION['email'];
        if(empty($matkhau)){
            $txt = "Bạn cần nhập mã xác minh";
        }
        else if($matkhau != $otp){
            $txt = "Mã xác minh không đúng";
        }
        else{
            header('location: taomkm.php');
        } 
        $mkdef = $matkhau;  
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
 
    <title>Quên mật khẩu</title>
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="../../img/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="post" >
                    <span class="login100-form-title1">
                        Mã xác minh
                    </span>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="pass" value="<?php echo $mkdef; ?>" placeholder="Nhập mã xác minh">
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
                        <input type="submit" name="submit" value="Tiếp" class="login100-form-btn">

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