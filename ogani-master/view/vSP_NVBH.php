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

    function showProduct($tbl){
        if($tbl){
            if(mysqli_num_rows($tbl) >0){
                $dem=0;
                echo '
                <div id="san-pham" class="container tab-pane active"><br>
                <div class="row timKiem-them">
                    <div class="timKiem input-group mb-3 col-md-5">
                        <form action="indexNVBH.php" method="get">
                                 <input type="text" name="txtSearchSP" size="18" placeholder = "Search" value = "';
                                 if(isset($_REQUEST["txtSearchSP"])) echo $_REQUEST["txtSearchSP"];
                                 echo '" >
                                 <input type="submit" name="btnSearchSP" class="btnCus" value="Search"> 
                        </form>
                    </div>

                    <div class="timKiem col-md-6">
                        <h2>DANH SÁCH SẢN PHẨM</h2>
                    </div>
                    
                    
                </div>
                </div>
                ';
                echo "<table class='prod_tbl'> <tr>";
                    echo'
                    <table class="table table-bordered table-hover " id="myTable">
                    <thead class="table-secondary">
                        <tr class="ex">
                            <th width="auto">Mã sản phẩm</th>
                            <th width="auto">Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Mô tả</th>
                            <th>Giá bán</th>
                            
                            <th>Thương hiệu</th>
                            <th>Hình ảnh</th>
                            <th>Hạn sử dụng</th>
                            <th>Loại sản phẩm</th>
                            
                            
                        </tr>
                    </thead>
                    ';
                    while($row = mysqli_fetch_assoc($tbl)){
                        if($row["trangThai"] == 1){
                            echo "<tr >";
                            echo "<td>".$row["MaSanPham"]."</td>";
                            echo "<td>".$row["TenSanPham"]."</td>";
                            echo "<td>".$row["SoLuongTon"]."</td>";
                            echo "<td>".$row["MoTa"]."</td>";
                            echo "<td>".number_format($row["GiaBan"], 0,".", ".")."VNĐ</td>";
                         
                            echo "<td>".$row["ThuongHieu"]."</td>";
                            echo "<td>"."<img src='img2/".$row["HinhAnh"]."' alt='".$row["HinhAnh"]."' width= '150px' height= '100px'>"."</td>";
                            echo "<td>".date("d/m/Y", strtotime($row["HanSuDung"]))."</td>";
                            echo "<td>".$row["LoaiSanPham"]."</td>";
                          
                            
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
        }else{
            echo"Không tìm thấy sản phẩm!";
            echo header("refresh: 1; url='indexNVBH.php?san-pham'");
        }
    }
    }

?>