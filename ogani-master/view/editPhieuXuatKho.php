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
    $p = new controlPhieuXuatKho();
    $tblEdit = $p->getPhieuXuatKhoToEdit($_REQUEST["MaPhieuXuatKho"]);

    if (mysqli_num_rows($tblEdit) > 0) {
        while ($r = mysqli_fetch_assoc($tblEdit)) {
            $NgayLapPhieuXuatKho = $r["NgayLapPhieuXuatKho"];
            $TrangThaiPhieuXuatKho = $r["TrangThaiPhieuXuatKho"];
            $MaNhanVien = $r["MaNhanVien"];
            $MaSanPham = $r["MaSanPham"];

        }
    }

    if (isset($_REQUEST["btnEditPXK"])) {
            $MaPhieuXuatKho = $_REQUEST["MaPhieuXuatKho"];
            $NgayLapPhieuXuatKho = $_REQUEST["NLPXK"];
            $TrangThaiPhieuXuatKho = $_REQUEST["TTPXK"];
            $MaNhanVien = $_REQUEST["MNV"];
            $MaSanPham = $_REQUEST["MSP"];

            $result = $p->editPhieuXuatKho($MaPhieuXuatKho,$NgayLapPhieuXuatKho,$TrangThaiPhieuXuatKho,$MaNhanVien,$MaSanPham);

        if ($result == 1) {
            echo "<script>alert('Edit Phiếu Xuất Kho successfully!')</script>";
            echo header("refresh: 0; url = 'indexQLKH.php?phieu-xuat-kho'");
        } else{
            echo "<script>alert('Edit Phiếu Xuất Kho unsuccessfully!')</script>";
        }
    }
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Ngày lập Xuất Kho</label>
                <input type="date" name="NLPXK" class="form-control" value="<?php echo $NgayLapPhieuXuatKho ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Trạng thái Xuất kho</label>
                <input type="text" name="TTPXK" class="form-control" value="<?php echo $TrangThaiPhieuXuatKho ?>" required>
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
                <button type="submit" name='btnEditPXK' class="btnCus3 btnCus">Update</button>
            </div>
        </div>

    </form>
</body>

</html>