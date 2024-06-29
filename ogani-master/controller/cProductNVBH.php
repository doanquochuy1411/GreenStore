<?php
    include_once("Model/mProductNVBH.php");
    class cProduct{
        function getAllProduct(){
            $p = new mProduct();
            $tbl = $p -> selectAllProduct();
            return $tbl;
        }
    }

    function getProductById($productId) {
        $p = new mProduct();
        $result = $p->getProductById($productId);

        return $result;
    }
?>