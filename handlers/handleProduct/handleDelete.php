<?php 
// namespace OnlineShoping\Remove;

use OnlineShoping\Products\Product;
require_once '../../classes/Product.php';
// class Remove{
//     public function __construct()
//     {
        
//     }
// }

// $remove = new Remove();

        $productObj = new Product();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $product = $productObj->remove($id);
        }else{
            header('location:../../index.php');
            die();
        }

?>