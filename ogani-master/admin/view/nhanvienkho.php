<?php
session_start();
ob_start();

if (!isset($_SESSION['LoaiNhanVien']) || empty($_SESSION['LoaiNhanVien'])) {
    header('location: ../login.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy(); 
    header('location: ../login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang ABC</title>
</head>

<body>
    <a href="?action=logout">Đăng xuất</a>
</body>

</html>