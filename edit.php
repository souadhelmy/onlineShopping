<?php include 'inc/header.php'; ?>
<?php 

use OnlineShoping\Products\Product;
require_once __DIR__.'/classes/Product.php';
$productObj = new Product();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $product = $productObj->readOne($id);
}else{
    header('location:./index.php');
    die();
}
?>
<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">


            <form method="POST" action="./handlers/handleProduct/handleEdit.php" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" class="form-control" id="id" value="<?= $product['id']?>"  name="id">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control" id="title" value="<?= $product['title']?>"  name="title">
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input type="number" class="form-control" id="price" value="<?= $product['price']?>" name="price">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Details:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                        name="details"><?= $product['details']?></textarea>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Image:</label>
                    <input class="form-control" type="file" id="formFile" name="image">
                </div>

                <!-- <div class="col-lg-3"> -->
                    <img src="uploads/<?= $product['image'] ?>" alt="" width="100px" srcset="">
                <!-- </div> -->

                <center><button on type="submit" class="btn btn-primary" name="submit">Add</button></center>
            </form>
        </div>
    </div>
</div>



<?php include 'inc/footer.php'; ?>