<?php
    include_once("controller/cPhieuNhapKho.php");
    class VPhieuNhapKho{
        function viewAllPhieuNhapKho(){
            $p = new controlPhieuNhapKho();
            $tbl = $p -> getAllPhieuNhapKho();
            showPhieuNhapKho($tbl);
        }
        function viewAllPhieuNhapKhoBySearch($search){
            $p = new controlPhieuNhapKho();
            if(isset($_REQUEST['txtSearchPNK'])){
                $tbl = $p -> getAllPhieuNhapKhoBySearch($search);
            }
            showPhieuNhapKho($tbl);
        }
        function showFormEditPhieuNhapKho(){
            $p = new controlPhieuNhapKho();
            if(isset($_REQUEST["btnSubmitActionPhieuNhapKho"])){
                if($_REQUEST["btnSubmitActionPhieuNhapKho"] == "edit"){
                    include("editPhieuNhapKho.php");
                    // return $result;
                }
            }
        }
        function showFormDelPhieuNhapKho(){
            $p = new controlPhieuNhapKho();
                if(isset($_REQUEST["btnSubmitActionPhieuNhapKho"])){
                    if ($_REQUEST["btnSubmitActionPhieuNhapKho"] == "delete"){
                        $result = $p -> getDeletePhieuNhapKho($_REQUEST["MaPhieuNhapKho"]);
                        echo header("refresh:0; url='indexQLKH.php?phieu-nhap-kho'");
                        return $result;
                    }
                }
        }
    }
        function showPhieuNhapKho($tbl){
            if($tbl){
                if(mysqli_num_rows($tbl) >0){
                    $dem=0;
                    echo '
                    <div id="phieu-nhap-kho" class="container tab-pane active"><br>
                    <div class="row timKiem-them">
                        <div class="timKiem input-group mb-3 col-md-5">
                            <form action="indexQLKH.php" method="get">
                                     <input type="text" name="txtSearchPNK" size="18" placeholder = "Trạng thái" value = "';
                                     if(isset($_REQUEST["txtSearchPNK"])) echo $_REQUEST["txtSearchPNK"];
                                     echo '" >
                                     <input type="submit" name="btnSearchPNK" class="btnCus btnCus5" value="Tìm"> 
                            </form>
                        </div>
    
                        <div class="timKiem col-md-4">
                            <h2>PHIẾU NHẬP KHO</h2>
                        </div>
                        <div class="timKiem themPNK col-md-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalPNK">
                                Thêm phiếu nhập kho
                            </button>
                        </div>
                    </div>
                    </div>
                    ';
                    echo "<table class='pnk_tbl'> <tr>";
                        echo'
                        <table class="table table-bordered table-hover " id="myTable">
                        <thead class="table-secondary">
                                <tr class="ex">
                                <th width="auto">Mã</th>
                                <th width="auto">Trạng Thái</th>
                                <th>Ngày Lập Phiếu Nhập Kho</th>
                                <th>Nhân Viên tiếp nhận</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Số lượng tồn</th>
                                <th>Thương hiệu</th>
                                <th>Loại sản phẩm</th>
                                <th>Tên Nhà Cung Cấp</th>
                                <th>Tính Năng</th>
                            </tr>
                        </thead>
                        ';
                        while($row = mysqli_fetch_assoc($tbl)){
                            if($row["PhieuShow"] == 1){
                                echo "<tr >";
                                    echo "<td>"."MP". $row['MaPhieuNhapKho'] ."</td>";
                                    echo "<td>". $row['TrangThaiPhieuNhapKho'] ."</td>";
                                    echo "<td>". $row['NgayLapPhieuNhapKho'] ."</td>"; 
                                    echo "<td>". $row['HoTen'] ."</td>";   
                                    echo "<td>". $row['TenSanPham'] ."</td>";
                                    echo "<td>". $row['SoLuongTon'] ."</td>";
                                    echo "<td>". $row['ThuongHieu'] ."</td>";
                                    echo "<td>"."L". $row['LoaiSanPham'] ."</td>";
                                    echo "<td>". $row['TenNhaCungCap'] ."</td>";
                                echo "<td>
                                        <form action='#' method='get'>
                                        <input type='hidden' name='MaPhieuNhapKho' value='" . $row["MaPhieuNhapKho"] . "'>
                                        <button class='btnCus btn2 edit' type='submit' value='edit' name= 'btnSubmitActionPhieuNhapKho'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                    <form action='#' method='get'onsubmit='return confirmDelete();'>
                                        <input type='hidden' name='MaPhieuNhapKho' value='" . $row["MaPhieuNhapKho"] . "'>
                                        
                                        <button class='btnCus btn2 delete' type='submit' value='delete' name= 'btnSubmitActionPhieuNhapKho'>
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
                echo header("refresh: 5; url='indexQLKH.php?phieu-nhap-kho'");
            }
        }
        }
    ?>