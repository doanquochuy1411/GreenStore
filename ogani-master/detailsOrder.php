<?php
session_start();
ob_start();
// include_once("model/connectdb.php");
$conn = mysqli_connect("localhost", "root", "", "raucu");
if (!isset($_SESSION['MaKhachHang']) || empty($_SESSION['MaKhachHang'])) {
    header('location: index.php');
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset(); // Xóa tất cả các biến trong session
    session_destroy(); // Hủy session
    header('location: index.php'); // Chuyển hướng về trang login.php
    exit();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="./css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="./css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="./css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="./css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="./css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="./css/slicknav.min.css" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="stylesheet" type="text/css" href="./css/main_long.css">
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="stylesheet" href="./css/index.css">
    <style>
    small {
        color: red;
    }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <!-- <div id="preloder">
        <div class="loader"></div>
    </div> -->
    <?php
    include_once('./controller/cDetailsOrder.php');
    include_once('./view/vDetailsOrder.php');


    $c = new CDetailsOrder();
    $v = new VDetailsOrder();

    $c->handleComment();
    $c->handleReturn();

    ?>

    <!-- Header Section Begin -->
    <?php
        include('view/supplementHeader.php');
    ?>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Chi tiết đơn hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th class="shoping__product">Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                $v->viewAllOrder();

                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Shoping Cart Section End -->

    <!-- Footer Begin -->
    <?php include('footer.php'); ?>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Đánh giá sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data" onsubmit="return confirmComment();">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tên sản phẩm</label>
                            <input type="email" class="form-control" id="nameProduct" placeholder="name@example.com"
                                disabled>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Hình ảnh</label>
                            <input type="file" name="fileAnh" class="form-control-file" id="exampleFormControlFile1"
                                placeholder="Hình ảnh sản phẩm">
                        </div>

                        <div class="form-group">
                            <label for="formControlRange">Mức độ hài lòng</label>
                            <input name="sao" type="range" min="0" max="5" class="form-control-range "
                                id="formControlRange" onInput="$('#rangeval').html($(this).val())">
                            <span id="rangeval">3
                                <!-- Default value -->
                            </span> <i style="color: #F7B400;" class="fa fa-star" aria-hidden="true"></i>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Nội dung đánh giá</label>
                            <textarea name="noidung" class="form-control" rows="3"></textarea>

                        </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="maSanPham" name="maSanPham" value="">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="btnComment" class="btn btn-outline-info">Xác nhận</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- model trả hàng  -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Trả sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="#" enctype="multipart/form-data" onsubmit="return confirmReturn();">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tên sản phẩm</label>
                            <input type="name" class="form-control" id="nameProduct2" placeholder="name@example.com"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Số lượng sản phẩm</label>
                            <input type="number" name="soLuong" class="form-control" id="soluongtra"
                                placeholder="Nhập số lượng">
                            <small id="soLuongTra-mess"></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Hình ảnh</label>
                            <input type="file" name='img_return' class="form-control-file" id="exampleFormControlFile1"
                                placeholder="Hình ảnh sản phẩm">
                        </div>


                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Lý do trả hàng</label>
                            <textarea name="noidungtrahang" class="form-control" id="noidungtrahang"
                                rows="3"></textarea>
                            <small id="noidungtrahang-mess"></small>
                        </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="maChiTietHoaDon" name="maChiTietHoaDon" value="">
                    <input type="hidden" id="soluongMua" value="">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
                    <!-- <button type="button" onClick="confirmReturn();">adadasd</button> -->
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="btnReturn" class="btn btn-outline-info">Xác nhận</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer End -->
    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    document.getElementById('soluongtra').value = 1

    function confirmComment() {
        return confirm("Bạn có chắc chắn muốn dánh giá sản phẩm này?");
    }

    function handleBtnComment(name, id) {
        // id là mã sản phẩm
        console.log(name)
        document.getElementById("nameProduct").value = name;
        document.getElementById("maSanPham").value = id;
    }

    function handleBtnReturn(name, id, soLuong) {
        // id là mã chi tiết hoá đơn 
        console.log(name)
        document.getElementById("nameProduct2").value = name;
        document.getElementById("maChiTietHoaDon").value = id;


        document.getElementById("soluongMua").value = parseInt(soLuong)
        console.log(document.getElementById("soluongMua").value)

    }

    function validateFormReturn() {
        let soluongmua = parseInt(document.getElementById("soluongMua").value)
        let soluongtra = parseInt(document.getElementById('soluongtra').value)
        let noidungtrahang = document.getElementById('noidungtrahang').value

        // Khởi tạo đối tượng chứa thông báo lỗi
        var errorMessages = {
            soluong: '',
            noidungtrahang: '',

        };

        // Kiểm tra điều kiện và lưu thông báo lỗi
        if (soluongmua < soluongtra || soluongtra <= 0) {
            errorMessages.soluong = 'Số lượng không hợp lệ';
        }

        if (noidungtrahang.trim() === '') {
            errorMessages.noidungtrahang = 'lý do trả hàng không được để trống';
        }

        // Hiển thị thông báo lỗi trong thẻ <small>
        document.getElementById('soLuongTra-mess').innerHTML = errorMessages.soluong;
        document.getElementById('noidungtrahang-mess').innerHTML = errorMessages.noidungtrahang;



        // Kiểm tra xem có thông báo lỗi nào không
        for (var field in errorMessages) {
            if (errorMessages[field] !== '') {
                return false; // Có ít nhất một lỗi, không submit form
            }
        }

        return true; // Không có lỗi, có thể submit form
    }

    function confirmReturn() {
        console.log('first')
        if (validateFormReturn()) {
            return confirm("Bạn có chắc chắn trả sản phẩm này?");
        } else {
            alert("kiểm tra lại thông tin")
            return false
        }
    }
    </script>


</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</html>