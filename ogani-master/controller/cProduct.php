<?php
    include_once("Model/mProduct.php");
    class CProduct{
        function getAllProducts(){
            $p = new MProduct();
            $tbl = $p -> selectAllProducts();
            return $tbl;
        }

        function getProductById($id){
            $p = new MProduct();
            $tbl = $p -> selectProductById($id);
            return $tbl;
        }
        
        function getProductByName($search){
            $p = new MProduct();
            $tbl = $p -> selectAllProductBySearch($search);
            return $tbl;
        }

        function getProductType(){
            $p = new MProduct();
            $tbl = $p -> selectProductType();
            return $tbl;
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

// ---------------------------------------------------
        function getAllAssess(){
            $p = new MProduct();
            $tbl = $p -> selectAllAssess();
            return $tbl;
        }


        function selectAssessByProduct($MaSanPham){
            $p = new ConnectDB();
            // $con;
            if($p -> connect_DB($con)){
                $str = "SELECT * FROM noidungdanhgia WHERE MaSanPham like N'%$MaSanPham%'";
                $tbl = mysqli_query($con, $str);
                $p -> closeDB($con);
                return $tbl;
            }else{
                return false;
            }
        }

        function getAllProductBySearch($search){
            $p = new MProduct();
            $tbl = $p -> selectAllProductBySearch($search);
            return $tbl;
        }

        function getDelProduct($MaSanPham){
            $p = new MProduct();
            $tbl = $p -> selectDelProduct($MaSanPham);
            return $tbl;
        }

        function addProduct($tenSP, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $hinhAnh, $hsd, $loaiSP, $nhaCC){
            $type = $hinhAnh["type"];
            $size = $hinhAnh["size"];
            $tenAnh = $tenSP.strstr($hinhAnh["name"], ".");

            if($type == 'image/jpg' || $type == 'image/png' || $type == 'image/jpeg'){
                if($size < 3*1024*1024){
                    if(move_uploaded_file($hinhAnh["tmp_name"], 'image/'.$tenAnh)){
                        $p = new MProduct();
                        $res = $p -> insertProduct($tenSP, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $tenAnh, $hsd, $loaiSP, $nhaCC);
                        if($res){
                            return 1; //insert thành công
                        }else{
                            return 0; //insert không thành công
                        }
                    }else{
                        return -3; //không thể upload ảnh
                    }
                }else{
                    return -2; //ảnh quá kích cỡ
                }
            }else{
                return -1; //ảnh không đúng định dạng
            }
        }


        function getProductToEdit($MaSanPham){
            $p = new MProduct();
            $tbl = $p -> selectProductToEdit($MaSanPham);
            return $tbl;
        }

        function editProduct($ma, $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $tenAnh, $hsd, $loaiSP, $nhaCC){
            $p = new MProduct();
            if($tenAnh['name'] == ''){
                $nameImg ="";
                $result = $p -> updateProduct($ma, $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $nameImg, $hsd, $loaiSP, $nhaCC);
                return $result ? 1 : 0;
            }else{
                $type = $tenAnh["type"];
                $size = $tenAnh["size"];
                $nameImg = $tenAnh["name"];

                if($type == 'image/jpg' || $type == 'image/png' || $type == 'image/jpeg'){
                    if($size < 3*1024*1024){
                        if(move_uploaded_file($tenAnh["tmp_name"], 'image/'.$nameImg)){
                            $res = $p -> updateProduct($ma, $ten, $slt, $moTa, $giaBan, $giaNhap, $thuongHieu, $nameImg, $hsd, $loaiSP, $nhaCC);
                            if($res){
                                return 1; //update thành công
                            }else{
                                return 0; //update không thành công
                            }
                        }else{
                            return -3; //không thể upload ảnh
                        }
                    }else{
                        return -2; //ảnh quá kích cỡ
                    }
                }else{
                    return -1; //ảnh không đúng định dạng
                }
            }
        }
    }
?>