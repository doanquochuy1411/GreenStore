<?php
include_once("controller/cProduct.php");
class VProduct
{
    function viewProductSlide()
    {
        $p = new CProduct();
        $tbl = $p->getAllProducts();
        $this -> showProductSlide($tbl);
    }

    function viewAllProduct()
    {
        $p = new CProduct();
        $tbl = $p->getAllProducts();
        $this -> showAllProduct($tbl);
    }

    function viewProductType()
    {
        $p = new CProduct();
        $tbl = $p->getProductType();
        if (mysqli_num_rows($tbl) > 0){
            echo '<ul>';
            while ($row = mysqli_fetch_assoc($tbl)){
                echo '
                    <li><a href="#" class="category">'.$row['LoaiSanPham'].'</a></li>
                ';
            }
            echo '</ul>';
        }
    }

    function viewProductTypeAtShop()
    {
        $p = new CProduct();
        $tbl = $p->getProductType();
        if (mysqli_num_rows($tbl) > 0){
            echo '<ul id="filterList" style="line-height: initial; cursor: pointer;">';
                echo '<li class="active" data-filter="*">Tất cả</li>';
                while ($row = mysqli_fetch_assoc($tbl)) {
                        $className = $this -> getNameByCategory($row['LoaiSanPham']);
                        echo '
                        <li data-filter=".'.$className.'">
                            '.$row['LoaiSanPham'].'
                        </li>
                    ';
                }
                echo '</ul>';
        }
        
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    // view product type at featured product
    function viewFeatureProductType()
    {
        $p = new CProduct();
        $tbl = $p->getProductType();
        $this -> showFeaturedProductType($tbl);
    }

    function viewSearchProduct($search)
    {
        $p = new CProduct();
        $data = $p->getProductByName($search);
        if ($data) {
            foreach ($data as $row) { 
                if ($row["trangThai"] == 1) {
                    $className = $this -> getNameByCategory($row['LoaiSanPham']);
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mix '.$className.'">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="img2/'.$row['HinhAnh'].'">
                            <ul class="featured__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="featured__item__text">
                            <h6><a href="#">'.$row['TenSanPham'].'</a></h6>
                            <h5>'.number_format($row['GiaBan'], 0, '', '.').' đ</h5>
                        </div>
                    </div>
                </div>';
                }
            }
        } else {
            // echo "Không tìm thấy: <script>alert('ban da bi hack');</script>";
            echo "Không tìm thấy: ".$search;
        }
    }

    
    function showProductSlide($tbl)
    {
        if ($tbl) {
            if (mysqli_num_rows($tbl) > 0) {
                while ($row = mysqli_fetch_assoc($tbl)) {
                    if ($row["trangThai"] == 1) {
                        echo '<div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="img2/'.$row['HinhAnh'].'">
                                <h5><a href="#">'.$row['TenSanPham'].'</a></h5>
                            </div>
                        </div>';
                    }
                }
            } else {
                echo "Vui lòng nhập dữ liệu!";
            }
        }
    }

    function showAllProduct($tbl)
    {
        if ($tbl) {
            if (mysqli_num_rows($tbl) > 0) {
                echo "<form action='#' method='post' style='display: contents'>";
                while ($row = mysqli_fetch_assoc($tbl)) {
                    if ($row["trangThai"] == 1) {
                        $className = $this -> getNameByCategory($row['LoaiSanPham']);
                        echo '<div class="col-lg-3 col-md-4 col-sm-6 mix '.$className.'">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg" data-setbg="img2/'.$row['HinhAnh'].'">
                                    <ul class="featured__item__pic__hover">
                                        <li><a href="vDetailProduct.php?pro='.$row['MaSanPham'].'"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="featured__item__text">
                                    <h6><a href="vDetailProduct.php?pro='.$row["MaSanPham"].'">'.$row['TenSanPham'].'</a></h6>
                                    <h5>'.number_format($row['GiaBan'], 0, '', '.').' đ</h5>
                                </div>
                            </div>
                    </div>';
                }
            }
            echo '</form>';
            } else {
                echo "Vui lòng nhập dữ liệu!";
            }
        }
    }

    function showFeaturedProductType($tbl)
    {
        if ($tbl) {
            if (mysqli_num_rows($tbl) > 0) {
                echo '<ul id="filterList">';
                echo '<li class="active" data-filter="*">Tất cả</li>';
                while ($row = mysqli_fetch_assoc($tbl)) {
                        $className = $this -> getNameByCategory($row['LoaiSanPham']);
                        echo '
                        <li data-filter=".'.$className.'">
                            '.$row['LoaiSanPham'].'
                        </li>
                    ';
                }
                echo '</ul>';
            } else {
                echo "Vui lòng nhập dữ liệu!";
            }
        }
    }

    function getNameByCategory($category) {
        $products = array(
            array(
                "name" => "nhom-rau-xanh",
                "category" => "Nhóm rau xanh"
            ),
            array(
                "name" => "trai-cay",
                "category" => "Trái cây"
            ),
            array(
                "name" => "nhom-hat",
                "category" => "Nhóm hạt"
            ),
            array(
                "name" => "nhom-trai-cay",
                "category" => "Nhóm trái cây"
            ),
            array(
                "name" => "nhom-bong",
                "category" => "Nhóm bông"
            ),
            array(
                "name" => "nhom-cu",
                "category" => "Nhóm củ"
            )
        );
        foreach ($products as $product) {
            if ($product["category"] === $category) {
                return $product["name"];
            }
        }
        return null; // Return null if category not found
    }
}