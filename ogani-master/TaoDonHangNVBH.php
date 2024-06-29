<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Tạo Đơn Hàng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style_TDH.css">

    <style>

    </style>
</head>

<body>
    <header>
        <div class="row">
            <div class="col-1<2">
                <ul class="header-menu">
                    <li style="margin:10px;"><a style="color: #fff" href="indexNVBH.php">Trang chủ</a></li>
                </ul>
            </div>
        </div>
    </header>




    <?php
    include_once("Controller/cTaoDonHang_NVBH.php");
    $c = new CPay();
    $c->handlePay();
    ?>

    <div id="product-list">
        <h3>Sản Phẩm</h3>
        <!--
        <input type="text" id="product-search" placeholder="Tìm sản phẩm...">
        -->
        <?php

        include_once("View/vProductNVBH.php");
        $vProduct = new VProduct();
        $vProduct->viewAllProduct();

        ?>

    </div>

    <div id="order-form">
        <h2>Thông Tin Đơn Hàng</h2>
        <form action="#" method="get">
            <div>
                <label for="customer-name">Tên Khách Hàng:</label>
                <input type="text" id="customer-name" name="customer-name" required>
            </div>

            <div>
                <label for="customer-phone">Số Điện Thoại Khách Hàng:</label>
                <input type="text" id="customer-phone" name="customer-phone" required>
            </div>

            <div>
                <label for="customer-email">Email:</label>
                <input type="text" id="customer-email" name="customer-email" required>
            </div>

            <div>
                <label for="customer-diachi">Địa chỉ:</label>
                <!-- <input type="text" id="customer-diachi" name="customer-diachi" required> -->
                <input type="text" id="customer-diachi" name="customer-diachi" value="Offline">

            </div>
            <div id="order-products">
                <h4>Sản Phẩm đã chọn:</h4>

                <ul id="selected-products">



            </div>

            <div id="total-amount">
                <input type="hidden" id="total-amount-value2" name="tongtien" value="" />
                <h4>Tổng Tiền: <span id="total-amount-value">0 VNĐ</span></h4>
            </div>



            <!-- <button type="submit" name="btnAddOrder">Tạo Đơn Hàng</button> -->
            <button type="submit" name="btnAddOrder" onclick="return validateForm()">Tạo Đơn Hàng</button>

        </form>
    </div>
    <script>
    // JavaScript để thêm/xoá sản phẩm vào danh sách đơn hàng
    const productList = document.querySelector('#product-list');
    const selectedProducts = document.querySelector('#selected-products');

    //khi checkbox sản phẩm được chọn
    productList.addEventListener('change', (event) => {
        if (event.target.classList.contains('product-checkbox')) {
            const productId = event.target.getAttribute('data-product-id');
            const productPrice = event.target.getAttribute('data-product-price');
            const quantity = event.target.parentElement.querySelector('.product-quantity').value;

            const selectedProduct = document.querySelector(`#selected-products [value="${productId}"]`);

            if (event.target.checked) {
                const listItem = document.createElement('li');
                listItem.innerHTML =
                    `${productId} - ${quantity} x ${productPrice} VNĐ = <span class="selected-amount">${quantity * productPrice}</span> VNĐ`;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected-products[]';
                hiddenInput.value = `${productId}`;

                const hiddenInputQuantity = document.createElement('input');
                hiddenInputQuantity.type = 'hidden';
                hiddenInputQuantity.name = 'selected-quantity[]';
                hiddenInputQuantity.value = `${quantity}`;


                listItem.appendChild(hiddenInput);
                listItem.appendChild(hiddenInputQuantity);

                selectedProducts.appendChild(listItem);
            } else {
                if (selectedProduct) {
                    selectedProducts.removeChild(selectedProduct.parentNode);
                }
            }

            updateTotalAmount();
        }
    });

    function updateTotalAmount() {
        let totalAmount = 0;
        const selectedAmounts = document.querySelectorAll('.selected-amount');
        selectedAmounts.forEach((amount) => {
            totalAmount += parseFloat(amount.textContent);
        });

        document.getElementById('total-amount-value').textContent = totalAmount.toFixed(2) + ' VNĐ';
        document.getElementById('total-amount-value2').value = totalAmount;
    }

    //Kiểm tra các ràng buộc
    /*
        function validateForm() {
        var selectedProducts = document.querySelectorAll('.product-checkbox:checked');
        if (selectedProducts.length === 0) {
            alert('Bạn chưa chọn sản phẩm');
            return false;
        }

        var customerName = document.getElementById('customer-name').value;
        if (!isNaN(customerName)) {
            alert('Tên khách hàng không thể là số');
            return false;
        }

        var customerPhone = document.getElementById('customer-phone').value;
        if (!/^\d{10}$/.test(customerPhone)) {
            alert('Số điện thoại không hợp lệ');
            return false;
        }

        var customerEmail = document.getElementById('customer-email').value;
        if (!customerEmail.endsWith('@gmail.com')) {
            alert('Email phải có đuôi @gmail.com');
            return false;
        }

        return true;
    }
    */
    function validateForm() {
        var selectedProducts = document.querySelectorAll('.product-checkbox:checked');
        if (selectedProducts.length === 0) {
            alert('Bạn chưa chọn sản phẩm');
            return false;
        }

        var customerName = document.getElementById('customer-name').value.trim();
        if (customerName === '') {
            alert('Vui lòng nhập tên khách hàng');
            return false;
        } else if (!isNaN(customerName)) {
            alert('Tên khách hàng không thể là số');
            return false;
        }

        var customerPhone = document.getElementById('customer-phone').value.trim();
        if (customerPhone === '') {
            alert('Vui lòng nhập Số điện thoại khách hàng');
            return false;
        } else if (!/^\d{10}$/.test(customerPhone)) {
            alert('Số điện thoại không hợp lệ');
            return false;
        }

        var customerEmail = document.getElementById('customer-email').value.trim();
        if (customerEmail === '') {
            alert('Vui lòng nhập Email khách hàng');
            return false;
        } else if (customerEmail === '' || !customerEmail.endsWith('@gmail.com')) {
            alert('Email không hợp lệ. Vui lòng nhập đúng định dạng @gmail.com');
            return false;
        }

        return true;
    }

    // tìm kiếm
    </script>







</body>

</html>