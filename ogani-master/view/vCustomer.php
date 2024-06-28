<?php
    include_once("controller/cCustomer.php");
    class VCustomer{
        function viewAllCustomers(){
            $p = new CCustomer();
            $tbl = $p -> getAllCustomers();
            showCustomer($tbl);
        }
    }

    function showCustomer($tbl){
        if($tbl){
            if(mysqli_num_rows($tbl) >0){
                $dem=0;
                echo "<table class='prod_tbl'> <tr>";
                if ($row = mysqli_fetch_assoc($tbl)){
                    echo'
                    <table class="table table-bordered table-hover " id="myTable">
                    <thead class="table-secondary">
                        <tr class="ex">
                            <th width="auto">Mã Khách hàng</th>
                            <th width="auto">Tên Khách hàng</th>
                            <th>SĐT</th>
                            <th>Email</th>
                            <th>Địa chỉ</th>
                            <th class="tinh-nang">Tính Năng</th>
                        </tr>
                    </thead>
                    ';
                    while($row = mysqli_fetch_assoc($tbl)){
                        if($row["trangThai"] == 1){
                            echo "<tr >";
                            echo "<td>".$row["MaKhachHang"]."</td>";
                            echo "<td>".$row["HoTen"]."</td>";
                            echo "<td>".$row["SoDienThoai"]."</td>";
                            echo "<td>".$row["Email"]."</td>";
                            echo "<td>".$row["DiaChi"]."</td>";
                            echo "<td>
                                    <form action='#' method='get'>
                                        <input type='hidden' name='MaKhachHang' value='" . $row["MaKhachHang"] . "'>
                                        <button class='btnCus btn2 edit' type='submit' value='edit' name= 'btnProdAct'>
                                            <i class='fa fa-pencil' aria-hidden='true'></i>
                                        </button>
                                        <button class='btnCus btn2 delete' type='submit' value='delete' name= 'btnProdAct'>
                                            <i class='fa fa-trash-o' aria-hidden='true'></i>
                                        </button>
                                    </form>
                                </td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
            }
        }else{
            echo"Vui lòng nhập dữ liệu!";
        }
    }
}
?>

