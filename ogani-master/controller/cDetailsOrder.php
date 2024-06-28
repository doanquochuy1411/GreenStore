<?php
include_once("Model/mDetailsOrder.php");
include_once("./Secured/checkInput.php");
class CDetailsOrder
{
    function handleComment()
    {
        if (isset($_REQUEST["btnComment"])) {
            if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])){
                die('Invalid CSRF token');
            } else {
                $s = new secured();
                $sao = (int)$_REQUEST["sao"];
                $noidung = $s -> test_input($_REQUEST["noidung"]);
                // $noidung = $_REQUEST["noidung"];
                $maSanPham = (int)$_REQUEST["maSanPham"];
                $maKhachHang = (int)$_SESSION['MaKhachHang'];
                $hinhAnh = $_FILES["fileAnh"];
                
    
                if(isset($hinhAnh) && $hinhAnh['error'] == 0) {
                    $type = $hinhAnh["type"];
                    $size = $hinhAnh["size"];
                    $tenAnh = $maSanPham . strstr($hinhAnh["name"], ".");
                    
                    if ($type == 'image/jpg' || $type == 'image/png' || $type == 'image/jpeg') {
                        if ($size < 3 * 1024 * 1024) {
                            if (move_uploaded_file($hinhAnh["tmp_name"], 'img2/comment/' . $tenAnh)) {
                                $p = new MDetailsOrder();
                                $result = $p->createComment($maKhachHang,  $maSanPham,  $noidung, $sao, $tenAnh);
    
                                if ($result) {
                                    echo '<script>alert("Đánh giá sản phẩm thành công")
                                    window.location.href = "orderManage.php";
                                    </script>';
                                    // header('location: orderManage.php');
                                    // exit();
                                } else {
                                    echo '<script>alert("Đánh giá sản phẩm thất bại")</script>';
                                }
    
    
    
                                if ($result) {
                                    return 1; //insert thành công
                                } else {
                                    echo '<script>alert("Đánh giá sản phẩm thất bại")</script>';
                                    return 0; //insert không thành công
                                }
                            } else {
                                echo '<script>alert("Không thể upload ảnh")</script>';
                                return -3; //không thể upload ảnh
                            }
                        } else {
                            echo '<script>alert("Ảnh vượt quá kích thước")</script>';
                            return -2; //ảnh quá kích cỡ
                        }
                    } else {
                        echo '<script>alert("Ảnh không đúng định dạng")</script>';
                        return -1; //ảnh không đúng định dạng
                    }
                } else {
                    $p = new MDetailsOrder();
                    $hinhAnh = "";
                    $result = $p->createComment($maKhachHang,  $maSanPham,  $noidung, $sao, $hinhAnh);
                    if ($result) {
                        echo '<script>alert("Đánh giá sản phẩm thành công")
                        window.location.href = "orderManage.php";
                        </script>';
                        // header('location: orderManage.php');
                        // exit();
                    } else {
                        echo '<script>alert("Đánh giá sản phẩm thất bại")</script>';
                    }
                }
            }
            }
    }

    function handleReturn()
    {
        if (isset($_REQUEST["btnReturn"])) {
            if (!isset($_POST['_token']) || ($_POST['_token'] !== $_SESSION['_token'])){
                die('Invalid CSRF token');
            } else {
                $s = new secured();
                $maChiTietHoaDon = (int)$_REQUEST["maChiTietHoaDon"];
                $soLuong = (int)$_REQUEST['soLuong'];
                $noidung = $s -> test_input($_REQUEST["noidungtrahang"]);
                $hinhAnh = $_FILES["img_return"];
                // thêm bước xử lý hình ảnh
                // $hinhAnh = "hinh anh 123";
                if(isset($hinhAnh) && $hinhAnh['error'] == 0) {
                    $type = $hinhAnh["type"];
                    $size = $hinhAnh["size"];
                    $tenAnh = strstr($hinhAnh["name"], ".");
    
                    if ($type == 'image/jpg' || $type == 'image/png' || $type == 'image/jpeg') {
                        if ($size < 3 * 1024 * 1024) {
                            if (move_uploaded_file($hinhAnh["tmp_name"], 'img2/return/' . $tenAnh)) {
                                $p = new MDetailsOrder();
                                $result = $p->createReturn($maChiTietHoaDon,  $soLuong,  $noidung, $tenAnh);
    
                                if ($result) {
                                    echo '<script>alert("Chúng tôi đã ghi nhận thông tin vui lòng đợi nhân viên phản hồi qua email")
                                    window.location.href = "orderManage.php";
                                    </script>';
                                } else {
                                    echo '<script>alert("Yêu cầu hoàn trả thất bại")</script>';
                                }
                                
                                if ($result) {
                                    return 1; //insert thành công
                                } else {
                                    echo '<script>alert("Yêu cầu hoàn trả thất bại")</script>';
                                    return 0; //insert không thành công
                                }
                            } else {
                                echo '<script>alert("Không thể upload file")</script>';
                                return -3; //không thể upload ảnh
                            }
                        } else {
                            echo '<script>alert("Kích thước vượt quá")</script>';
                            return -2; //ảnh quá kích cỡ
                        }
                    } else {
                        echo '<script>alert("Ảnh không đúng định dạng")</script>';
                        return -1; //ảnh không đúng định dạng
                    }
                } else {
                    $p = new MDetailsOrder();
                    $hinhAnh = "";
                    $result = $p->createReturn($maChiTietHoaDon,  $soLuong,  $noidung, $hinhAnh);
                    if ($result) {
                        echo '<script>alert("Chúng tôi đã ghi nhận thông tin vui lòng đợi nhân viên phản hồi qua email")
                            window.location.href = "orderManage.php";
                            </script>';
                    } else {
                        echo '<script>alert("Yêu cầu hoản trả thất bại")</script>';
                    }
                }
            }

            // $p = new MDetailsOrder();
            // $result = $p->createReturn($maChiTietHoaDon,  $soLuong,  $noidung, $hinhAnh);

            // if ($result) {
            //     echo '<script>alert("Chúng tôi đã ghi nhận thông tin vui lòng đợi nhân viên phản hồi qua email")
            //     window.location.href = "orderManage.php";
            //     </script>';
            // } else {
            //     echo '<script>alert("Hoàn trả thất bại")</script>';
            // }
        }
    }


    function getAllOrder()
    {
        $maHoaDon = (int)$_REQUEST['maHoaDon'];
        $p = new MDetailsOrder();
        $tbl = $p->getAllDetailsOrder($maHoaDon);
        return $tbl;
    }
}