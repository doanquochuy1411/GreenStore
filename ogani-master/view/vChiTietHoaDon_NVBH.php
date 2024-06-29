<?php
    include_once("controller/cChiTietHoaDon_NVBH.php");
    class VCTHoaDon{
        function viewAllCTHoaDon(){
            $p = new CCTHoaDon();
            $tbl = $p -> getAllCTHoaDon();
            showCTHoaDon($tbl);
        }

        function viewAllCTHoaDonBySearch($search){
            $p = new CCTHoaDon();
            if(isset($_REQUEST['txtSearchHD'])){
                $tbl = $p -> getAllCTHoaDonBySearch($search);
            }
            showCTHoaDon($tbl);
        }

        

    }

    function showCTHoaDon($tbl){
        if($tbl){
            if(mysqli_num_rows($tbl) >0){
                $dem=0;
                echo '
                <div id="hoa-don" class="container tab-pane active"><br>
                <div class="row timKiem-them">
                    <div class="timKiem input-group mb-3 col-md-5">
                        <form action="indexNVBH.php" method="get">
                                 <input type="text" name="txtSearchHD" size="18" placeholder = "Mã hóa đơn" value = "';
                                 if(isset($_REQUEST["txtSearchHD"])) echo $_REQUEST["txtSearchHD"];
                                 echo '" >
                                 <input type="submit" name="btnSearchHD" class="btnCus btnCus5" value="Tìm"> 
                        </form>
                    </div>

                    <div class="timKiem col-md-6">
                        <h2>DANH SÁCH CHI TIẾT HÓA ĐƠN</h2>
                    </div>
                    
                    
                </div>
                </div>
                ';
                echo "<table class='prod_tbl'> <tr>";
                    echo'
                    <table class="table table-bordered table-hover " id="myTable">
                    <thead class="table-secondary">
                        <tr class="ex">
                            <th width="auto">Mã hóa đơn</th>
                            <th>Tổng tiền</th>
                            <th>Ngày lập</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th width="auto">Mã chi tiết hóa đơn</th>
                            <th>Số lượng</th>
                            <th width="auto">Tên Sản phẩm</th>
                            
                            
                            
                            
                            
                        </tr>
                    </thead>
                    ';
                    while($row = mysqli_fetch_assoc($tbl)){
                        
                            echo "<tr >";
                            echo "<td>".$row["MaHoaDon"]."</td>";
                            echo "<td>".number_format($row["TongTien"], 0,".", ".")."VNĐ</td>";
                            echo "<td>".$row["NgayLap"]."</td>"; 
                            echo "<td>".$row["HoTen"]."</td>";
                            echo "<td>".$row["SoDienThoai"]."</td>";
                            echo "<td>".$row["MaChiTietHoaDon"]."</td>";
                            echo "<td>".$row["SoLuong"]."</td>";
                            echo "<td>".$row["TenSanPham"]."</td>";
                            
                            echo "</tr>";
                        
                    }
                    echo "</table>";
        }else{
            echo"Không tìm thấy chi tiết hóa đơn!";
            echo header("refresh: 1; url='indexNVBH.php?hoa-don'");
        }
    }
    }

?>