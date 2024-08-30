<?php

use OnlineShoping\Session\Session;
use OnlineShoping\Products\Product;
require_once '../../classes/Session.php';
require_once '../../classes/Product.php';
class Add{
    private $id;
    private $title;
    private $price;
    private $details;
    private $image = [];
    private $imgName;
    private $imgTemp;
    private $imgSize;
    private $imgType;
    private $imgError;
    private $errors = ['titleReq' => '' , 'priceReq' => '','detailsReq' => '' , 'priceVal' => '' , 'imgReq' => '' , 'imgErrorSize' => '' , 'imgErrorFound' => ''];
    public function __construct()
    {
        $product = new Product();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $session = new Session();
            if($session->exist('userId')){
                $session = new Session();
                $this->id = $session->get('userId');
                $this->title = trim(htmlspecialchars($_POST['title']));
                $this->price = trim(htmlspecialchars($_POST['price']));
                $this->details = trim(htmlspecialchars($_POST['details']));
                $this->image = $_FILES['image'];
                $this->imgName = $this->image['name'];
                $this->imgTemp = $this->image['tmp_name'];
                $this->imgSize = $this->image['size'] / (1024 * 1024);
                $this->imgType = $this->image['type'];
                $this->imgError = $this->image['error'];

                // name validation
                if(empty($this->title)){
                    $this->errors['titleReq'] = 'title is required';
                }

                //price Validation
                if(empty($this->price)){
                    $this->errors['priceReq'] = 'price is required';
                }elseif(!is_numeric($this->price)){
                    $this->errors['priceVal'] = 'price is number';
                }

                // details validation
                if(empty($this->details)){
                    $this->errors['detailsReq'] = 'details is required';
                }

                // image validation
                if($this->imgError == 4){
                    $this->errors['imgReq'] = 'image is required';
                }else{
                    $allow_extension = array('png' , 'jpeg' , 'jpg' , 'git' , 'svg');
                    $img_extension = strtolower(pathinfo($this->imgName , PATHINFO_EXTENSION));
                    if($this->imgSize > 3){
                        $this->errors['imgErrorSize'] = 'file must be less than 3MB';
                    }elseif(!in_array($img_extension , $allow_extension)){
                        $this->errors['imgErrorFound'] = 'file extension is not allowed';
                    }
                }
                
                if(!empty($errors['nameReq']) || !empty($errors['priceReq']) || !empty($errors['detailsReq']) || !empty($errors['priceVal']) || !empty($errors['imgReq']) || !empty($errors['imgErrorSize']) || !empty($errors['imgErrorFound'])){
                    $session = new Session();
                    $session->set('errors',$this->errors);
                    header('location:../../add.php');
                    die();
                }else{
                    $product->create($this->title , $this->price , $this->id , $this->details , $this->imgTemp , $img_extension);
                }
            }else{
                header('location:../../login.php');
                die();
            }
        }
    }
}

$add = new Add();

?>