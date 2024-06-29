<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    $p = new controlPhieuNhapKho();
    $tblEdit = $p->getPhieuNhapKhoToEdit($_REQUEST["MaPhieuNhapKho"]);

    if (mysqli_num_rows($tblEdit) > 0) {
        while ($r = mysqli_fetch_assoc($tblEdit)) {
            $NgayLapPhieuNhapKho = $r["NgayLapPhieuNhapKho"];
            $TrangThaiPhieuNhapKho = $r["TrangThaiPhieuNhapKho"];
            $MaNhanVien = $r["MaNhanVien"];
            $MaSanPham = $r["MaSanPham"];

        }
    }

    if (isset($_REQUEST["btnEditPNK"])) {
            $MaPhieuNhapKho = $_REQUEST["MaPhieuNhapKho"];
            $NgayLapPhieuNhapKho = $_REQUEST["NLPNK"];
            $TrangThaiPhieuNhapKho = $_REQUEST["TTPNK"];
            $MaNhanVien = $_REQUEST["MNV"];
            $MaSanPham = $_REQUEST["MSP"];

        $result = $p->editPhieuNhapKho($MaPhieuNhapKho, $NgayLapPhieuNhapKho, $TrangThaiPhieuNhapKho, $MaNhanVien, $MaSanPham);

        if ($result == 1) {
            echo "<script>alert('Edit Phiếu Nhập Kho successfully!')</script>";
            echo header("refresh: 0; url = 'indexQLKH.php?phieu-nhap-kho'");
        } else{
            echo "<script>alert('Edit Phiếu Nhập Kho unsuccessfully!')</script>";
        }
    }
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Ngày lập phiếu nhập kho</label>
                <input type="date" name="NLPNK" class="form-control" value="<?php echo $NgayLapPhieuNhapKho ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Trạng thái phiếu nhập kho</label>
                <input type="text" name="TTPNK" class="form-control" value="<?php echo $TrangThaiPhieuNhapKho ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Mã nhân viên kho</label>
                <input type="text" name="MNV" class="form-control" value="<?php echo $MaNhanVien ?>" required>
            </div>
            <div class="form-group col-md-5">
                <label>Mã sản phẩm</label>
                <input type="text" name="MSP" class="form-control" value="<?php echo $MaSanPham ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <input type="hidden" value="">
                <button type="reset" class="btnCus3 btnCus">Reset</button>
                <button type="submit" name='btnEditPNK' class="btnCus3 btnCus">Update</button>
            </div>
        </div>

    </form>
</body>

</html>