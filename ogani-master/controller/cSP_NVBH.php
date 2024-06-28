<?php
    include_once("Model/mSP_NVBH.php");
    class CProduct{
        function getAllProducts(){
            $p = new MProduct();
            $tbl = $p -> selectAllProducts();
            return $tbl;
        }

        function getAllProductBySearch($search){
            $p = new MProduct();
            $tbl = $p -> selectAllProductBySearch($search);
            return $tbl;
        }

        
    }
?>