<?php
    class secured{
        public function test_input($data) {
            $data = trim($data); // Loại bỏ khoảng trắng ở đầu và cuối chuỗi
            $data = stripslashes($data); // Loại bỏ \ ' "
            $data = htmlspecialchars($data); // chuyển đổi các ý tự < > & " . Ví dụ < -> &lt
            return $data;
        // addslashes(): Thêm \ vào các ký tự đặc biệt như ' " \ \0
        }
    }
?>