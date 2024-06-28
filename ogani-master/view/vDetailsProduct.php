<?php
include_once("controller/cProduct.php");
class vDetailsProduct

{
    function viewAllProducts()
    {
        $p = new CProduct();
        $tbl = $p -> getAllProducts();
        showProduct2($tbl);
    }
}

function showProduct2($tbl)
{
    if ($tbl) {
        if (mysqli_num_rows($tbl) >= 0) {
            if (true) {
                while ($row = mysqli_fetch_assoc($tbl)) {
                    $id = (int)$_REQUEST["pro"];
                    if ($row["MaSanPham"] == $id) {
                        echo "
                           <div class='product__details__pic__item'>
                                <img src='./img2/" . $row['HinhAnh'] . "'/>
                            </div>
                            <div class='product__details__pic__slider owl-carousel'>
                            <img data-imgbigurl='../img2/xem2.jpg'
                                src='./img2/" . $row['HinhAnh'] . "'/>
                            <img data-imgbigurl='../img2/xem3.jpg'
                                src='./img2/" . $row['HinhAnh'] . "'/>
                            <img data-imgbigurl='../img2/xem3.jpg'
                                src='./img2/" . $row['HinhAnh'] . "'/>
                            <img data-imgbigurl='../img2/xem5.jpg'
                                src='./img2/" . $row['HinhAnh'] . "'/>
                        </div>
                    </div>
                </div>
                <div class='col-lg-6 col-md-6'>
                <div class='product__details__text'>

                        <h3>" . $row['TenSanPham'] . "</h3>
                        <div class='product__d'etails__rating'>
                     
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>
                            <i class='fa fa-star'></i>                       
                        </div>
                        <div class='product__details__price'> 

                        <img width=20% height=100% src='./img2/" . $row['HinhAnh'] . "'/>
                        <h6>Giá bán </a></h6> 
                        <h5>" . number_format($row['GiaBan'], 0, ',', '.') . "đ</h5></div>
                        
                
                        <form action='#' method='post'>
                        <div class='product__details__quantity'>
                            <div class='quantity'><h6>Số lượng</h6>
                                <div class='pro-qty'>
                                    <input type='text' value='1' name='quantity'>
                                </div>
                            </div>
                        </div><br>
                            <input type='hidden' value='" . $_REQUEST["pro"] . "' name='idProduct'>
                            <input type='submit' value='Thêm vào giỏ hàng' name='submitAddToCart' class='primary-btn'/>
                            <input type='submit' value='Đặt hàng' name='orderNow' class='primary-btn'/>
                        </form>
                        <ul>
                            <li><b>Số lượng tồn kho:</b> " . $row['SoLuongTon'] . "</li>
                            <li><b>Thương hiệu:</b> " . $row['ThuongHieu'] . "</li>
                            <li><b>Chia sẻ đến:</b>
                                <div class='share'>
                                    <a href='#'><i class='fa fa-facebook'></i></a>
                                    <a href='#'><i class='fa fa-twitter'></i></a>
                                    <a href='#'><i class='fa fa-instagram'></i></a>
                                    <a href='#'><i class='fa fa-pinterest'></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class='col-lg-12'>
                    <div class='product__details__tab'>
                        <ul class='nav nav-tabs' role='tablist'>
                            <li class='nav-item'>
                                <a class='nav-link active' data-toggle='tab' href='#tabs-1' role='tab'
                                    aria-selected='true'>Mô tả sản phẩm</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' data-toggle='tab' href='#tabs-2' role='tab'
                                    aria-selected='false'>Thông tin sản phẩm</a>
                            </li>
                            <li class='nav-item'>
                                <a class='nav-link' data-toggle='tab' href='#tabs-3' role='tab'
                                    aria-selected='true'>Đánh giá</a>
                            </li>
                        </ul>

                        <div class='tab-content'>

                            <div class='tab-pane active' id='tabs-1' role='tabpanel'>
                                <div class='product__details__tab__desc'>
                                    <p>" . $row['MoTa'] . "</a></p>
                                </div>
                            </div>

                            <div class='tab-pane' id='tabs-2' role='tabpanel'>
                                <div class='product__details__tab__desc'>
                                    <p><b>Mã sản phẩm:</b> " . $row['MaSanPham'] . "</p>
                                    <p><b>Tên sản phẩm:</b> " . $row['TenSanPham'] . "</p>
                                    <p><b>Thương hiệu:</b> " . $row['ThuongHieu'] . "</p>
                                </div>
                            </div>


                            <div class='tab-pane' id='tabs-3' role='tabpanel'>
                            <div class='product__details__tab__desc'>
                                <p></p>";
                                    // $productId=1;
                                    include_once("view/vDanhgia.php");
                                    $p = new vDanhgia();
                                    $p->viewAllAssessByProduct($id);
                                
                           echo  "</div>
                            </div>
                      
                       
                            </div>  
                                             
                            </div>
                            </div>
                        </div>
                                    ";
                            }
                        }
                    }
                } else {
                    echo 'Vui lòng nhập dữ liệu!';
                }
            }
        }
             
        
     
                        
   