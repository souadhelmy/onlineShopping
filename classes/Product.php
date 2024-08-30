<?php
namespace OnlineShoping\Products;
use OnlineShoping\Databases\Database;
use OnlineShoping\Session\Session;
use PDOException;

require_once __DIR__.'/Database.php';
require_once __DIR__.'/Session.php';
class Product{
    private $con;

    public function __construct()
    {
        $database = new Database();
        $this->con =  $database->getConnection();
    }

    public function create($title , $price , $id , $details , $imgTemp , $img_extension){
        try{
            $newImg = time().'.'.$img_extension;
            $sql = "INSERT INTO `products` (`title` , `price`,`details` ,`user_id`,`image`) VALUES (:title , :price , :details , :id ,'$newImg')";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->bindParam(':title',$title);
            $stmt->bindParam(':price',$price);
            $stmt->bindParam(':details',$details);
            if($stmt->execute()){
                move_uploaded_file($imgTemp,'../../uploads/'.$newImg);
                $session = new Session();
                $session->set('successAddProduct','product created successfully');
                header('location:../../index.php');
                die();
            }else{
                $session = new Session();
                $session->set('errorAddProduct','product not created');
                header('location:../../add.php');
                die();
            }
        }catch(PDOException $e){
            echo "Error".$e->getMessage();
        }
    }
    public function readAll($userId , $page , $limit , $offset){
        $sql = "SELECT COUNT(*) AS `total` FROM `products` WHERE `user_id` = '$userId'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetch()['total'];
        $totalNumPage = ceil($total / $limit);
        // if($page < 1){
        //     header('location:../../index.php?page=1');
        //     die();
        // }elseif($page > $totalNumPage){
        //     header('location:../../index.php?page='.$totalNumPage);
        //     die();
        // }
        $sql = "SELECT * FROM `products` WHERE `user_id` = '$userId' LIMIT $limit OFFSET $offset";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        // if($stmt->rowCount() > 0){
            $products = $stmt->fetchAll();
        // }
        return [
            'products' => $products,
            'totalNumPage' => $totalNumPage
        ];
    }
    public function readOne($id){
        $sql = "SELECT * FROM `products` WHERE `id` = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $product = $stmt->fetch();
        }
        return $product;
    }
    public function update($id , $title , $price , $details , $imgTemp , $img_extension){
        $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $product = $stmt->fetch();

            if($_FILES['image']['error'] !== 0){
                $sql = "UPDATE `products` SET `title` = '$title' , `price` = '$price' , `details` = '$details' WHERE `id` = '$id'";
            }else{
                $newImg = time().'.'.$img_extension;
                $sql = "UPDATE `products` SET `title` = '$title' , `price` = '$price' , `details` = '$details' , `image` = '$newImg' WHERE `id` = '$id'";
            }
            $stmt = $this->con->prepare($sql);
            if($stmt->execute()){
                if($_FILES['image']['error'] == 0){
                    unlink('../../uploads/'.$product['image']);
                    move_uploaded_file($imgTemp , '../../uploads/'.$newImg);
                }
                $session = new Session();
                $session->set('successUpdate' , 'product updated successfully');
                header('location:../../edit.php?id='.$id);
                die();
            }else{
                $session = new Session();
                $session->set('errorUpdate' , 'error while update');
                header('location:../../edit.php?id='.$id);
                die();
            }
        }
    }

    public function remove($id){
        $sql = "SELECT * FROM `products` WHERE `id` = :id";
        $stmt = $this->con->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        if($stmt->rowCount() == 1){
            $product = $stmt->fetch();
            unlink('../../uploads/'.$product['image']);
            $sql = "DELETE FROM `products` WHERE `id` = :id";
            $stmt = $this->con->prepare($sql);
            $stmt->bindParam(':id' , $id);
            if($stmt->execute()){
                $session = new Session();
                $session->set('successDelete' , 'product deleted successfully');
                header('location:../../index.php');
                die();
                echo 'yes';
            }else{
                $session = new Session();
                $session->set('serrorDelete' , 'error while delete product');
                header('location:../../index.php');
                die();
            }
        }
    }
}

?>