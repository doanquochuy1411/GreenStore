<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "raucu";
$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}
// Thiết lập bảng mã kết nối
mysqli_set_charset($conn, 'utf8');
session_start();
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['MaKhachHang']) || empty($_SESSION['MaKhachHang'])) {
    // Nếu chưa đăng nhập, chuyển hướng về trang login.php
    header('location: login.php');
    exit();
}
if ((isset($_REQUEST['submit'])) && ($_REQUEST['submit'])) {
    include('./Secured/checkInput.php');
    $s = new secured();
    $pattern = '/^[0-9]{10}$/';
    $HoTen = $s -> test_input($_REQUEST['HoTen']);
    $SoDienThoai = $_REQUEST['SoDienThoai'];
    $DiaChi = $s -> test_input($_REQUEST['DiaChi']);
    $Email = $s -> test_input($_REQUEST['Email']);
    $patternname = '/^[a-zA-ZÀ-Ỹà-ỹ]+(?: [a-zA-ZÀ-Ỹà-ỹ]+)?$/';
    $patternadd = '/^[a-zA-Z0-9,.#\- ]+$/';
    if (empty($HoTen) || empty($SoDienThoai) || empty($Email)) {
        $txt = "Bạn cần nhập đầy đủ thông tin";
    } else if (preg_match($patternname, $HoTen)) {
        $txt = "Họ tên không hợp lệ";
    } else if (!preg_match($pattern, $SoDienThoai)) {
        $txt = "Số điện thoại không hợp lệ";
    } else if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $txt = "Email không hợp lệ";
    } else if (preg_match($patternadd, $DiaChi)) {
        $txt = "Địa chỉ không hợp lệ";
    } else {
        $SoDienThoaiSession = $_SESSION['MaKhachHang'];
        $query = "SELECT Email,SoDienThoai FROM khachhang WHERE MaKhachHang = '$SoDienThoaiSession'";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $emailss = $row['Email'];
            $sdtss = $row['SoDienThoai'];
            // print_r('SDT form: '. $SoDienThoai);
            // print_r('SDT sessison: '. $sdtss);
            // if ($SoDienThoai !== $sdtss){
            //     echo "khac";
            // } else {
            //     echo "Giong";
            // }
        }

        // $query1 = "SELECT SoDienThoai FROM khachhang WHERE MaKhachHang = '$SoDienThoaiSession'";
        // $result1 = $conn->query($query1);
        // if ($result1->num_rows > 0) {
        //     $row = $result1->fetch_assoc();
        //     $sdtss = $row['SoDienThoai'];
        // }
        //echo "<script> alert('$emailss.$sdtss')</script>";

        if ($_POST['Email'] != $emailss) {
            include_once("./Controller/ckhachhang.php");
            $p = new controlProduct();
            $re = $p->ktradky($Email);
            if ($re == 0) {
                $txt = "Email đã tồn tại";
            }
            else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Xử lý dữ liệu khi form được gửi đi 
                $SoDienThoaiSession = $_SESSION['MaKhachHang'];
                // Cập nhật thông tin cá nhân trong cơ sở dữ liệu
                $query = "UPDATE khachhang SET HoTen='$HoTen', SoDienThoai='$SoDienThoai', DiaChi='$DiaChi', Email='$Email' WHERE MaKhachHang='$SoDienThoaiSession'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo "<script> alert('Cập nhật thông tin thành công')</script>";
                    echo header("refresh: 0; url='#'");
                } else {
                    echo "<script> alert('Lỗi cập nhật thông tin')</script>";
                }
            }
        } else if ($SoDienThoai !== $sdtss) {
            include_once("./Controller/ckhachhang.php");
            $p = new controlProduct();
            $ra = $p->ktradkysdt($SoDienThoai);
            if ($ra == 0) {
                $txt = "Số điện thoại đã tồn tại";
            } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Xử lý dữ liệu khi form được gửi đi 
                // $SoDienThoaiSession = $_SESSION['MaKhachHang'];
                // Cập nhật thông tin cá nhân trong cơ sở dữ liệu
                // $query = "UPDATE khachhang SET HoTen='$HoTen', SoDienThoai='$SoDienThoai', DiaChi='$DiaChi', Email='$Email' WHERE MaKhachHang='$SoDienThoaiSession'";
                // $result = mysqli_query($conn, $query);
                $query = "UPDATE khachhang SET HoTen=?, SoDienThoai=?, DiaChi=?, Email=? WHERE MaKhachHang=?";
                $stmt = mysqli_prepare($conn, $query);
                // print_r("So dien thoai: ". $SoDienThoai);
                echo "<script>alert('so dien thoai: ".$SoDienThoai." ')</script>";
                mysqli_stmt_bind_param($stmt, "sissi", $HoTen, $SoDienThoai, $DiaChi, $Email, $SoDienThoaiSession);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_affected_rows($stmt); // Đếm số hàng bị ảnh hưởng bởi câu lệnh UPDATE
                mysqli_stmt_close($stmt);
                if ($result > 0) {
                    echo "<script> alert('Cập nhật thông tin thành công')</script>";
                    echo header("refresh: 0; url='#'");
                } else {
                    echo "<script> alert('Lỗi cập nhật thông tin')</script>";

                }
            }
        } else {
            $SoDienThoaiSession = $_SESSION['MaKhachHang'];
            // Cập nhật thông tin cá nhân trong cơ sở dữ liệu
            // $query = "UPDATE khachhang SET HoTen='$HoTen', SoDienThoai='$SoDienThoai', DiaChi='$DiaChi', Email='$Email' WHERE MaKhachHang='$SoDienThoaiSession'";
            // $result = mysqli_query($conn, $query);
            $query = "UPDATE khachhang SET HoTen=?, SoDienThoai=?, DiaChi=?, Email=? WHERE MaKhachHang=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sissi", $HoTen, $SoDienThoai, $DiaChi, $Email, $SoDienThoaiSession);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_affected_rows($stmt); // Đếm số hàng bị ảnh hưởng bởi câu lệnh UPDATE
            mysqli_stmt_close($stmt);

            if ($result > 0) {
                echo "<script> alert('Cập nhật thông tin thành công')</script>";
                echo header("refresh: 0; url='#'");
            } else {
                // echo "Lỗi cập nhật thông tin: " . mysqli_error($conn);
                echo "<script> alert('Lỗi cập nhật thông tin')</script>";
            }
        }
    }
}
// Lấy thông tin khách hàng từ cơ sở dữ liệu
$SoDienThoai = $_SESSION['MaKhachHang'];
// print('So dien thoai: ').$SoDienThoai;
$query = "SELECT * FROM khachhang WHERE MaKhachHang = '$SoDienThoai'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

// include_once("model/connectdb.php");
$conn1 = mysqli_connect("localhost", "root", "", "raucu");
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Xóa tất cả các biến trong session
    session_destroy(); // Hủy session
    header('location: ../index.php'); // Chuyển hướng về trang login.php
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
    <!-- Header Section Begin -->
    <?php
        include('view/supplementHeader.php');
    ?>
    <!-- Header Section End -->

    <div class="limiter">
        <div class="container-login100" style="background: #7fad39;">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="./img/logo.png" alt="IMG">
                </div>

                <form action="#" class="login100-form validate-form" method="post">
                    <span class="login100-form-title">
                        Cập nhập thông tin
                    </span>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="HoTen" value="<?php echo $row['HoTen']; ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="SoDienThoai"
                            value="<?php echo $row['SoDienThoai']; ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 ">
                        <input class="input100" type="text" name="DiaChi" value="<?php echo $row['DiaChi']; ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-address-book-o" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 ">
                        <input class="input100" type="email" name="Email" value="<?php echo $row['Email']; ?>">
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
                    <div class="container-login100-form-btn">
                        <input style="background: #7fad39" type="submit" class="login100-form-btn" name="submit"
                            value="Cập nhật">
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- Footer Section Begin -->
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