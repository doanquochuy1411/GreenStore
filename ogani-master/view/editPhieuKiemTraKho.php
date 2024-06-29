<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
    div#update_info {
        color: #157347;
        text-align: center;
        margin: 15px 0;
        display: flex;
        justify-content: flex-start;
        margin-left: 25%;
        align-items: center;
    }

    #update_info a>i {
        color: #157347;
        margin-right: 150px;
    }

    h4 {
        color: #157347;
        margin: 15px 0;
        margin-left: 25%;
    }

    .btnCus3.btnCus {
        border-radius: 3px;
        background-color: #157347;
        color: #fff;
        border: none;
        padding: 5px 10px;
        width: 80px;
    }

    form {
        margin-left: 25%;
    }

    .btnUpd {
        align-items: center;
        margin-left: 25%;
        margin-top: 10px;
    }

    small {
        color: red;
    }
    </style>
</head>

<body>

    <?php
    // include_one("Controller/acEmployee.php");
    $p = new controlPhieuKiemTraKho();
    $tblEdit = $p->getPhieuKiemTraKhoToEdit($_REQUEST["MaPhieuKiemTraKho"]);

    if (mysqli_num_rows($tblEdit) > 0) {
        while ($r = mysqli_fetch_assoc($tblEdit)) {
            $NgayKiemTra = $r["NgayKiemTra"];
            $TrangThaiKiemTra = $r["TrangThaiKiemTra"];
            $MaNhanVien = $r["MaNhanVien"];
            $MaSanPham = $r["MaSanPham"];

        }
    }

    if (isset($_REQUEST["btnEdit"])) {
            $MaPhieuKiemTraKho = $_REQUEST["MaPhieuKiemTraKho"];
            $NgayKiemTra = $_REQUEST["NKT"];
            $TrangThaiKiemTra = $_REQUEST["TTKT"];
            $MaNhanVien = $_REQUEST["MNV"];
            $MaSanPham = $_REQUEST["MSP"];

        $result = $p->editPhieuKiemTraKho($MaPhieuKiemTraKho, $NgayKiemTra, $TrangThaiKiemTra, $MaNhanVien, $MaSanPham);

        if ($result == 1) {
            echo "<script>alert('Edit Phiếu Kiểm Tra Kho successfully!')</script>";
            echo header("refresh: 0; url = 'indexQLKH.php?kiem-ke-kho'");
        } else{
            echo "<script>alert('Edit Phiếu Kiểm Tra Kho unsuccessfully!')</script>";
        }
    }
    ?>

    <div>
        <div id="update_info">
            <a href="./indexQLKH.php?kiem-ke-kho"><i class="fas fa-backward"></i></a>
            <h2>Cập nhật phiếu <?php echo $_REQUEST["MaPhieuKiemTraKho"]; ?></h2>
        </div>
    </div>

    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Ngày kiểm tra</label>
                <input type="date" style="width: 200px; margin-bottom: 15px" name="NKT" class="form-control"
                    value="<?php echo $NgayKiemTra ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Trạng thái kiểm tra</label>
                <input type="text" name="TTKT" style="width: 600px; margin-bottom: 15px" class="form-control"
                    value="<?php echo $TrangThaiKiemTra ?>" required>
                <small id="tenSP-mess"></small>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Mã nhân viên kho</label>
                <input type="number" name="MNV" class="form-control" value="<?php echo $MaNhanVien ?>" required>
            </div>
            <div class="form-group col-md-5">
                <label>Mã sản phẩm</label>
                <input type="number" name="MSP" class="form-control" value="<?php echo $MaSanPham ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group btnUpd">
                <input type="hidden" value="">
                <button type="reset" class="btnCus3 btnCus">Đặt lại</button>
                <button type="submit" name='btnEditSP' class="btnCus3 btnCus">Lưu</button>
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']?>"></input>
            </div>
        </div>

    </form>
</body>

</html>