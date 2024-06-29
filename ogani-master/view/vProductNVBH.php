<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    .product-list {
        list-style: none;
        padding: 0;
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    /*
    .product-checkbox {
        margin-right: 10px;
    }
/*
    .product-name {
        margin: 0;
        padding: 5px;
        margin-left: 10px; 
    }
*/
    .product-quantity {
        width: 50px;
        padding: 5px;
        text-align: center;
    }
    </style>


</head>

<body>



    <?php
    include_once("Controller/cProductNVBH.php");

    class VProduct
    {
        function viewAllProduct()
        {
            $c = new CProduct();
            $tbl = $c->getAllProduct();
            showProduct($tbl);
        }
    }

    function showProduct($tbl)
    {
        if ($tbl) {
            echo "<ul>";

            while ($row = mysqli_fetch_assoc($tbl)) {
                /*
            echo "<li>";
            echo "<input type='checkbox' class='product-checkbox' data-product-id='" . $row["MaSanPham"] . "' data-product-price='" . $row["GiaBan"] . "'>";
            echo $row["TenSanPham"];
            echo "<input type='number' class='product-quantity' min='1' value='1'>";
            echo "</li>";
            */
                if ($row["trangThai"] == 1) {
                    echo "<li class='product-item'>";
                    echo "<input type='checkbox' class='product-checkbox' data-product-id='" . $row["MaSanPham"] . "' data-product-price='" . $row["GiaBan"] . "'>";
                    echo "<label class='product-name' for='product-quantity-" . $row["MaSanPham"] . "'>" . $row["TenSanPham"] . "</label>";
                    echo "<input type='number' id='product-quantity-" . $row["MaSanPham"] . "' class='product-quantity' min='1' value='1'>";
                    echo "</li>";
                }
            }

            echo "</ul>";
        } else {
            echo "Không có dữ liệu sản phẩm.";
        }
    }


    ?>

</body>

</html>