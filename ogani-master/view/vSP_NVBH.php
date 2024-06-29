<?php
    include_once("controller/cSP_NVBH.php");
    class VProduct{
        function viewAllProducts(){
            $p = new CProduct();
            $tbl = $p -> getAllProducts();
            showProduct($tbl);
        }

        function viewAllProductBySearch($search){
            $p = new CProduct();
            if(isset($_REQUEST['txtSearchSP'])){
                $tbl = $p -> getAllProductBySearch($search);
            }
            showProduct($tbl);
        }

        

    }

    // function showProduct($tbl){
    //     if($tbl){
    //         if(mysqli_num_rows($tbl) >0){
    //             $dem=0;
    //             echo '
    //             <div id="san-pham" class="container tab-pane active"><br>
    //             <div class="row timKiem-them">
    //                 <div class="timKiem input-group mb-3 col-md-5">
    //                     <form action="indexNVBH.php" method="get">
    //                              <input type="text" name="txtSearchSP" size="18" placeholder = "Search" value = "';
    //                              if(isset($_REQUEST["txtSearchSP"])) echo $_REQUEST["txtSearchSP"];
    //                              echo '" >
    //                              <input type="submit" name="btnSearchSP" class="btnCus" value="Search"> 
    //                     </form>
    //                 </div>

    //                 <div class="timKiem col-md-6">
    //                     <h2>DANH SÁCH SẢN PHẨM</h2>
    //                 </div>
                    
                    
    //             </div>
    //             </div>
    //             ';
    //             echo "<table class='prod_tbl'> <tr>";
    //                 echo'
    //                 <table class="table table-bordered table-hover " id="myTable">
    //                 <thead class="table-secondary">
    //                     <tr class="ex">
    //                         <th width="auto">Mã sản phẩm</th>
    //                         <th width="auto">Tên sản phẩm</th>
    //                         <th>Số lượng</th>
    //                         <th>Mô tả</th>
    //                         <th>Giá bán</th>
                            
    //                         <th>Thương hiệu</th>
    //                         <th>Hình ảnh</th>
    //                         <th>Hạn sử dụng</th>
    //                         <th>Loại sản phẩm</th>
                            
                            
    //                     </tr>
    //                 </thead>
    //                 ';
    //                 while($row = mysqli_fetch_assoc($tbl)){
    //                     if($row["trangThai"] == 1){
    //                         echo "<tr >";
    //                         echo "<td>".$row["MaSanPham"]."</td>";
    //                         echo "<td>".$row["TenSanPham"]."</td>";
    //                         echo "<td>".$row["SoLuongTon"]."</td>";
    //                         echo "<td>".$row["MoTa"]."</td>";
    //                         echo "<td>".number_format($row["GiaBan"], 0,".", ".")."VNĐ</td>";
                         
    //                         echo "<td>".$row["ThuongHieu"]."</td>";
    //                         echo "<td>"."<img src='img2/".$row["HinhAnh"]."' alt='".$row["HinhAnh"]."' width= '150px' height= '100px'>"."</td>";
    //                         echo "<td>".date("d/m/Y", strtotime($row["HanSuDung"]))."</td>";
    //                         echo "<td>".$row["LoaiSanPham"]."</td>";
                          
                            
    //                         echo "</tr>";
    //                     }
    //                 }
    //                 echo "</table>";
    //     }else{
    //         echo"Không tìm thấy sản phẩm!";
    //         echo header("refresh: 1; url='indexNVBH.php?san-pham'");
    //     }
    // }
    // }
    function showProduct($tbl)
{
    if ($tbl) {
        if (mysqli_num_rows($tbl) > 0) {
            $dem = 0;
            echo '
                <div id="san-pham" class="container tab-pane active"><br>
                <div class="row timKiem-them">
                    <div class="timKiem input-group mb-3 col-md-6">
                        <form action="#" method="get">
                                 <input type="text" name="txtSearchSP" size="18" placeholder = "Tên sản phẩm" value = "';
                                 
            if (isset($_REQUEST["txtSearchSP"])) echo $_REQUEST["txtSearchSP"];
            echo '" >
                                 <input type="submit" name="btnSearchSP" class="btnCus btnCus5" value="Tìm"> 
                        </form>
                    </div>

                    <div class="timKiem col-md-4">
                        <h2>QUẢN LÝ SẢN PHẨM</h2>
                    </div>
                    <div class="timKiem themNhanVien col-md-3">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalThemSP">
                            Thêm sản phẩm
                        </button>
                    </div>
                </div>
                </div>
                ';
            echo "<table class='prod_tbl'> <tr>";
            echo '
                    <table class="table table-bordered table-hover " id="myTable">
                    <thead class="table-secondary">
                        <tr class="ex" style="vertical-align: text-top;">
                            <th width="auto">Mã SP</th>
                            <th width="auto">Tên SP</th>
                            <th>SLT</th>
                            <th>Mô tả</th>
                            <th>Giá bán</th>
                            <th>Giá nhập</th>
                            <th>Thương hiệu</th>
                            <th>Hình ảnh</th>
                            <th>HSD</th>
                            <th>Loại SP</th>
                           
                            <th class="tinh-nang">Tính Năng</th>
                        </tr>
                    </thead>
                    ';
            while ($row = mysqli_fetch_assoc($tbl)) {
                if ($row["trangThai"] == 1) {
                    echo "<tr >";
                    echo "<td>SP" . $row["MaSanPham"] . "</td>";
                    echo "<td>" . $row["TenSanPham"] . "</td>";
                    echo "<td>" . $row["SoLuongTon"] . "</td>";
                    echo "<td>" . $row["MoTa"] . "</td>";
                    echo "<td>" . number_format($row["GiaBan"], 0, ".", ".") . "VNĐ</td>";
                    echo "<td>" . number_format($row["GiaNhap"], 0, ".", ".") . "VNĐ</td>";
                    echo "<td>" . $row["ThuongHieu"] . "</td>";
                    echo "<td>" . "<img src='img2/" . $row["HinhAnh"] . "' alt='" . $row["HinhAnh"] . "' width= '50px' height= '50px'>" . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["HanSuDung"])) . "</td>";
                    echo "<td>" . $row["LoaiSanPham"] . "</td>";
                    echo "<td style = 'display: flex; justify-content: center;  padding: 20px 0;'>
                                    <form action='indexAdmin.php?editPro=" . $row["MaSanPham"] . "' method='post'>
                                        <button class='btnCus btn2 edit' type='submit'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                    <form action='indexAdmin.php?deletePro=" . $row["MaSanPham"] . "' method='post' onsubmit='return confirmDelete();'>
                                        <button class='btnCus btn2 delete' type='submit'>
                                            <i class='fa fa-trash-o' aria-hidden='true'></i>
                                        </button>
                                        <input type='hidden' name='_token' value='".$_SESSION['_token']."'></input>
                                    </form>
                                    </td>";
                                    echo "</tr>";
}
}
echo "</table>";
} else {
echo "Không tìm thấy sản phẩm!";
echo header("refresh: 5; url='indexNVBH.php?san-pham'");
}
}
}

?>