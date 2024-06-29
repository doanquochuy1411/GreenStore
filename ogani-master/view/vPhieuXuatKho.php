<?php
    include_once("controller/cPhieuXuatKho.php");
    class VPhieuXuatKho{
        function viewAllPhieuXuatKho(){
            $p = new controlPhieuXuatKho();
            $tbl = $p -> getAllPhieuXuatKho();
            showPhieuXuatKho($tbl);
        }
        function viewAllPhieuXuatKhoBySearch($search){
            $p = new controlPhieuXuatKho();
            if(isset($_REQUEST['txtSearchPXK'])){
                $tbl = $p -> getAllPhieuXuatKhoBySearch($search);
            }
            showPhieuXuatKho($tbl);
        }
        function showFormEditPhieuXuatKho(){
            $p = new controlPhieuXuatKho();
            if(isset($_REQUEST["btnSubmitActionPhieuXuatKho"])){
                if($_REQUEST["btnSubmitActionPhieuXuatKho"] == "edit"){
                    include("editPhieuXuatKho.php");
                    // return $result;
                }
            }
        }
        function showFormDelPhieuXuatKho(){
            $p = new controlPhieuXuatKho();
                if(isset($_REQUEST["btnSubmitActionPhieuXuatKho"])){
                    if ($_REQUEST["btnSubmitActionPhieuXuatKho"] == "delete"){
                        $result = $p -> getDeletePhieuXuatKho($_REQUEST["MaPhieuXuatKho"]);
                        echo header("refresh:0; url='indexQLKH.php?phieu-xuat-kho'");
                        return $result;
                    }
                }
        }
    }
        function showPhieuXuatKho($tbl){
            if($tbl){
                if(mysqli_num_rows($tbl) >0){
                    $dem=0;
                    echo '
                    <div id="phieu-xuat-kho" class="container tab-pane active"><br>
                    <div class="row timKiem-them">
                        <div class="timKiem input-group mb-3 col-md-5">
                            <form action="indexQLKH.php" method="get">
                                     <input type="text" name="txtSearchPXK" size="18" placeholder = "Trạng thái" value = "';
                                     if(isset($_REQUEST["txtSearchPXK"])) echo $_REQUEST["txtSearchPXK"];
                                     echo '" >
                                     <input type="submit" name="btnSearchPXK" class="btnCus btnCus5" value="Tìm"> 
                            </form>
                        </div>
    
                        <div class="timKiem col-md-4">
                            <h2>PHIẾU XUẤT KHO</h2>
                        </div>
                        <div class="timKiem themPXK col-md-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalPXK">
                                Thêm phiếu xuất kho
                            </button>
                        </div>
                    </div>
                    </div>
                    ';
                    echo "<table class='pxk_tbl'> <tr>";
                        echo'
                        <table class="table table-bordered table-hover " id="myTable">
                        <thead class="table-secondary">
                                <tr class="ex">
                                <th width="auto">Mã</th>
                                <th width="auto">Trạng Thái</th>
                                <th>Ngày Lập Phiếu Xuất Kho</th>
                                <th>Nhân viên xử lý</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Số lượng</th>
                                <th>Thương hiệu</th>
                                <th>Loại sản phẩm</th>
                                <th>Tính Năng</th>
                            </tr>
                        </thead>
                        ';
                        while($row = mysqli_fetch_assoc($tbl)){
                            if($row["PhieuShow"] == 1){
                                echo "<tr >";
                                    echo "<td>"."MP". $row['MaPhieuXuatKho'] ."</td>";
                                    echo "<td>". $row['TrangThaiPhieuXuatKho'] ."</td>";
                                    echo "<td>". $row['NgayLapPhieuXuatKho'] ."</td>"; 
                                    echo "<td>". $row['HoTen'] ."</td>";  
                                    echo "<td>". $row['TenSanPham'] ."</td>";
                                    echo "<td>". $row['SoLuongTon'] ."</td>";
                                    echo "<td>". $row['ThuongHieu'] ."</td>";
                                    echo "<td>"."L". $row['LoaiSanPham'] ."</td>";
                                echo "<td>
                                        <form action='#' method='get'>
                                        <input type='hidden' name='MaPhieuXuatKho' value='" . $row["MaPhieuXuatKho"] . "'>
                                        <button class='btnCus btn2 edit' type='submit' value='edit' name= 'btnSubmitActionPhieuXuatKho'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                    <form action='#' method='get'onsubmit='return confirmDelete();'>
                                        <input type='hidden' name='MaPhieuXuatKho' value='" . $row["MaPhieuXuatKho"] . "'>
                                        
                                        <button class='btnCus btn2 delete' type='submit' value='delete' name= 'btnSubmitActionPhieuXuatKho'>
                                            <i class='fa fa-trash-o' aria-hidden='true'></i>
                                        </button>
                                        </form>
                                    </td>";
                                echo "</tr>";
                            }
                        }
                        echo "</table>";
            }else{
                echo"Không tìm thấy phiếu nhập kho!";
                echo header("refresh: 5; url='indexQLKH.php?phieu-xuat-kho'");
            }
        }
        }
    
    ?>