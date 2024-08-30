<?php 
namespace OnlineShoping\Edit;

use OnlineShoping\Databases\Database;
use OnlineShoping\Products\Product;
use OnlineShoping\Session\Session;

require_once '../../classes/Session.php';
require_once '../../classes/Database.php';
require_once '../../classes/Product.php';
class Edit{
    private $id;
    private $title;
    private $price;
    private $details;
    private $image;
    private $imgName;
    private $imgTemp;
    private $imgSize;
    public $con;
    public $errors = ['titleUpdateReq' => '' , 'priceUpdateReq' => '' ,'priceUpdateVal' => '' , 'detailsUpdateReq' => '' , 'imgSizeUpdateError' => '' , 'imgFoundUpdateError' => ''];
    public function __construct()
    {
        $database = new Database();
        $this->con = $database->getConnection();

        $product = new Product();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->id = trim(htmlspecialchars($_POST['id']));
            $this->title = trim(htmlspecialchars($_POST['title']));
            $this->price = trim(htmlspecialchars($_POST['price']));
            $this->details = trim(htmlspecialchars($_POST['details']));
            if($_FILES['image']['error'] === 0){
                $this->image = $_FILES['image'];

                $this->imgName = $this->image['name'];
                $this->imgTemp = $this->image['tmp_name'];
                $this->imgSize = $this->image['size'] / (1024 * 1024);

                $allowed_extension = array('png' , 'jpg' , 'jpeg' , 'svg' , 'git');
                $img_extension = strtolower(pathinfo($this->imgName , PATHINFO_EXTENSION));

                if($this->imgSize > 3){
                    $this->errors['imgSizeUpdateError'] = 'file must be less than 3MB';
                }elseif(!in_array($img_extension , $allowed_extension)){
                    $this->errors['imgFoundUpdateError'] = 'file extension is not allowed';
                }

            }

            // name validation
            if(empty($this->title)){
                $this->errors['titleUpdateReq'] = 'title is required';
            }

            // price validation
            if(empty($this->price)){
                $this->errors['priceUpdateReq'] = 'price is required';
            }elseif(!is_numeric($this->price)){
                $this->errors['priceUpdateVal'] = 'price is number';
            }

            // details validation
            if(empty($this->details)){
                $this->errors['detailsUpdareReq'] = 'details is required';
            }

            if(!empty($this->errors['titleUpdateReq']) || !empty($this->errors['priceUpdateReq']) || !empty($this->errors['detailsUpdateReq'])){
                if($_FILES['image']['error'] == 0){
                    if(!empty($this->errors['imgSizeUpdateError']) || !empty($this->errors['imgFoundUpdateError'])){
                        $session = new Session();
                        $session->set('errors' , $this->errors);
                        header('location:../../edit.php?id='.$this->id);
                        die();
                    }
                }
            }else{
                $product->update($this->id , $this->title , $this->price , $this->details , $this->imgTemp , $img_extension);
            }
        }
    }
}
$edit = new Edit();

?>