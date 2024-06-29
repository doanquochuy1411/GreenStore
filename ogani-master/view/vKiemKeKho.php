<?php
    include_once("controller/cKiemKeKho.php");
    class VPhieuKiemTraKho{
        function viewAllPhieuKiemTraKho(){
            $p = new controlPhieuKiemTraKho();
            $tbl = $p -> getAllPhieuKiemTraKho();
            showPhieuKiemTraKho($tbl);
        }
        function viewAllPhieuKiemTraKhoBySearch($search){
            $p = new controlPhieuKiemTraKho();
            // if(isset($_REQUEST['txtSearchPKTK'])){
            $tbl = $p -> getAllPhieuKiemTraKhoBySearch($search);
            // }
            showPhieuKiemTraKho($tbl);
        }
        function showFormEditPhieuKiemTraKho(){
            $p = new controlPhieuKiemTraKho();
            if(isset($_REQUEST["btnSubmitActionPhieuKiemTraKho"])){
                if($_REQUEST["btnSubmitActionPhieuKiemTraKho"] == "edit"){
                    include("editPhieuKiemTraKho.php");
                    // return $result;
                }
            }
        }
        function showFormDelPhieuKiemTraKho(){
            $p = new controlPhieuKiemTraKho();
                if(isset($_REQUEST["btnSubmitActionPhieuKiemTraKho"])){
                    if ($_REQUEST["btnSubmitActionPhieuKiemTraKho"] == "delete"){
                        $result = $p -> getDeletePhieuKiemTraKho($_REQUEST["MaPhieuKiemTraKho"]);
                        echo header("refresh:0; url='indexQLKH.php?kiem-ke-kho'");
                        return $result;
                    }
                }
        }
    }
        function showPhieuKiemTraKho($tbl){
            if($tbl){
                if(mysqli_num_rows($tbl) >0){
                    $dem=0;
                    echo '
                    <div id="kiem-ke-kho" class="container tab-pane active"><br>
                    <div class="row timKiem-them">
                        <div class="timKiem input-group mb-3 col-md-5">
                            <form action="indexQLKH.php" method="get">
                                     <input type="text" name="txtSearchPKTK" size="18" placeholder = "Trạng thái" value = "';
                                     if(isset($_REQUEST["txtSearchPKTK"])) echo $_REQUEST["txtSearchPKTK"];
                                     echo '" >
                                     <input type="submit" name="btnSearchPKTK" class="btnCus btnCus5" value="Tìm"> 
                            </form>
                        </div>
    
                        <div class="timKiem col-md-4">
                            <h2>PHIẾU KIỂM TRA KHO</h2>
                        </div>
                        <div class="timKiem themPKTK col-md-3">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ModalPKTK">
                                Thêm phiếu kiểm tra kho
                            </button>
                        </div>
                    </div>
                    </div>
                    ';
                    echo "<table class='pktk_tbl'> <tr>";
                        echo'
                        <table class="table table-bordered table-hover " id="myTable">
                        <thead class="table-secondary">
                                <tr class="ex">
                                <th width="auto">Mã</th>
                                <th width="auto">Ngày kiểm tra</th>
                                <th>Tình trạng</th>
                                <th>Nhân viên kiểm tra</th>
                                <th>Sản phẩm</th>
                                <th>Tồn</th>
                                <th>Giá nhập</th>
                                <th>Thương Hiệu</th>
                                <th>HSD</th>    
                                <th>Loại</th>
                                <th>Tính Năng</th>
                            </tr>
                        </thead>
                        ';
                        while($row = mysqli_fetch_assoc($tbl)){
                            if($row["PhieuShow"] == 1){
                                echo "<tr >";
                                echo "<td>". $row['MaPhieuKiemTraKho'] ."</td>";
                                echo "<td>". $row['NgayKiemTra'] ."</td>"; 
                                echo "<td>". $row['TrangThaiKiemTra'] ."</td>";
                                echo "<td>". $row['HoTen'] ."</td>";
                                echo "<td>". $row['TenSanPham'] ."</td>";
                                echo "<td>". $row['SoLuongTon'] ."</td>";
                                echo "<td>". $row['GiaNhap'] ."</td>";
                                echo "<td>". $row['ThuongHieu'] ."</td>";
                                echo "<td>". $row['HanSuDung'] ."</td>";
                                echo "<td>". $row['LoaiSanPham'] ."</td>";
                                echo "<td>
                                        <form action='#' method='get'>
                                        <input type='hidden' name='MaPhieuKiemTraKho' value='" . $row["MaPhieuKiemTraKho"] . "'>
                                        <button class='btnCus btn2 edit' type='submit' value='edit' name= 'btnSubmitActionPhieuKiemTraKho'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                    <form action='#' method='get' onsubmit='return confirmDelete();'>
                                        <input type='hidden' name='MaPhieuKiemTraKho' value='" . $row["MaPhieuKiemTraKho"] . "'>
                                        
                                        <button class='btnCus btn2 delete' type='submit' value='delete' name= 'btnSubmitActionPhieuKiemTraKho'>
                                            <i class='fa fa-trash-o' aria-hidden='true'></i>
                                        </button>
                                        <input type='hidden' name='_token' value='".$_SESSION['_token']."'></input>

                                        </form>
                                    </td>";
                                echo "</tr>";
                            }
                        }
                        echo "</table>";
            }else{
                echo"Không tìm thấy phiếu kiểm tra kho!";
                echo header("refresh: 5; url='indexQLKH.php?kiem-ke-kho'");
            }
        }
        } 
    ?>