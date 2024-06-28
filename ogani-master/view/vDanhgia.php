<?php
include_once("controller/cProduct.php");
class vDanhgia
{
 
    function viewAllAssessByProduct($MaSanPham)
    {
        $p = new CProduct();
        $tbl = $p -> selectAssessByProduct($MaSanPham);
        showAssess($tbl);
    }

}

function showAssess($tbl)
{
if ($tbl) {
    if (mysqli_num_rows($tbl) >= 0) {
        if (true) {
        while ($row = mysqli_fetch_assoc($tbl)) {
            if ($row["MaSanPham"] == $_REQUEST["pro"]) {
                echo "
                
                <div class='tab-pane' id='tabs-3' role='tabpanel'>
                <div class='product__details__tab__desc'>
                    <p><b>Mã đánh giá:</b> " . $row['MaDanhGia'] . "</p>
                    <p><b>Mã khách hàng</b> " . $row['MaKhachHang'] . "</p>
                    <p><b>Nội dung đánh giá:</b> " . $row['NoiDungDanhGia'] . "</p>
                    <p><b>Thang điểm theo 5 sao:</b> " . $row['SoSao'] . "  <i class='fa fa-star'></i></p>
                    <p><b>Thời gian đánh giá:</b> " . $row['ThoiGianDanhGia'] . "</p>
                </div>
                </div>
                    
                        ";
                // echo "Noi dung: ". $row['NoiDungDanhGia'];
            }
        }
    } else {
        echo "Vui lòng nhập dữ liệu!";
    }
}
}
}