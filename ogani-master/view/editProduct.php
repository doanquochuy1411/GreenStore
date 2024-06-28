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
    // include_one("Controller/acProduct.php");
    $p = new CProduct();
    $tblEdit = $p->getProductToEdit($_REQUEST["MaSanPham"]);

    if (mysqli_num_rows($tblEdit) > 0) {
        while ($r = mysqli_fetch_assoc($tblEdit)) {
            $maSP = $r["MaSanPham"];
            $tenSP = $r["TenSanPham"];
            $slt = $r["SoLuongTon"];
            $moTa = $r["MoTa"];
            $giaBan = $r["GiaBan"];
            $giaNhap = $r["GiaNhap"];
            $thuongHieu = $r["ThuongHieu"];
            $tenAnh = $r["HinhAnh"];   
            $hsd = $r["HanSuDung"];
            $loaiSP = $r["LoaiSanPham"];
            $nhaCC = $r["NhaCungCap"];
        }
    }

    if (isset($_REQUEST["btnEditSP"])) {
        $ma = $p ->test_input($_REQUEST["maSP"]);
        $ten = $p ->test_input($_REQUEST["tenSP"]);
        $slt = $p ->test_input($_REQUEST["slt"]);
        $moTa = $p ->test_input($_REQUEST["mota"]);
        $giaBan = $p ->test_input($_REQUEST["giaBan"]);
        $giaNhap = $p ->test_input($_REQUEST["giaNhap"]);
        $thuongHieu = $p ->test_input($_REQUEST["thuongHieu"]);
        $tenAnh = $_FILES["tenAnh"];
        $hsd = $_REQUEST["HSD"];
        $loaiSP = $p ->test_input($_REQUEST["loaiSP"]);
        $nhaCC = $_REQUEST["nhaCC"];

        $result = $p->editProduct($ma, $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $tenAnh, $hsd, $loaiSP, $nhaCC);

        if ($result == 1) {
            echo "<script>alert('Edit product successfully!')</script>";
            echo header("refresh: 0; url = 'indexQLKH.php?san-pham'");
        } elseif ($result == 0) {
            echo "<script>alert('Edit product unsuccessfully!')</script>";
        } elseif ($result == -1) {
            echo "<script>alert('This file is not image format!')</script>";
        } elseif ($result == -2) {
            echo "<script>alert('This file is too lagre to upload!')</script>";
        } else
            echo "<script>alert('Can not upload file!')</script>";
    }
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Mã sản phẩm</label>
                <input type="text" name="maSP" class="form-control" value="<?php echo $maSP ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Tên sản phẩm</label>
                <input type="text" name="tenSP" class="form-control" value="<?php echo $tenSP ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Số lượng tồn</label>
                <input type="number" name="slt" class="form-control" value="<?php echo $slt ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Mô tả</label>
                <textarea name="mota" id="" class="form-control" cols="30" rows="4"><?php echo $moTa ?></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Giá bán</label>
                <input type="number" name="giaBan" class="form-control" value="<?php echo $giaBan ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Giá nhập</label>
                <input type="number" name="giaNhap" class="form-control" value="<?php echo $giaNhap ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Thương hiệu</label>
                <input type="text" name="thuongHieu" class="form-control" value="<?php echo $thuongHieu ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label>Hình ảnh</label>
                <img src="image/<?php echo $tenAnh ?>" alt="" width="100px">
                <input type="file" name="tenAnh" class="form-control">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label>Hạn sử dụng</label>
                <input type="date" name="HSD" class="form-control" value="<?php echo $hsd ?>" required>
            </div>
            <div class="form-group col-md-7">
                <label for="">Loại sản phẩm</label>
                <input type="text" name="LSP" class="form-control" value="<?php echo $hsd ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Nhà cung cấp</label>
                <?php
                include_once("Controller/cNhaCC.php");
                $ce = new CNhaCC();
                $tbl = $ce->getAllNCC();

                if(mysqli_num_rows($tbl)>0){
                    echo '<select name="nhaCC" class="form-control">';
                    while ($r = mysqli_fetch_assoc($tbl)){
                        if($nhaCC == $r["NhaCungCap"]){
                            echo '<option selected value="'.$r["MaNhaCungCap"].'">'.$r["TenNhaCungCap"].'</option>';
                        }else{
                            echo '<option value="'.$r["MaNhaCungCap"].'">'.$r["TenNhaCungCap"].'</option>';
                        }
                    }
                    echo '</select>';
                }
                ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <input type="hidden" value="">
                <button type="reset" class="btnCus3 btnCus">Reset</button>
                <button type="submit" name='btnEditSP' class="btnCus3 btnCus">Update</button>
            </div>
        </div>

    </form>
</body>

</html>