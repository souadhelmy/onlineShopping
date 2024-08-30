<?php 
namespace OnlineShoping\Registeration;
use OnlineShoping\Session\Session;
use OnlineShoping\Users\User;
require_once '../../classes/Session.php';
require_once '../../classes/User.php';
class Register{
    private $name;
    private $email;
    private $password;
    private $cpassword;
    private $phone;
    private $address; 
    public $errors=['nameReq' => '' , 'emailReq' => '' , 'emailVal' => '' , 'passwordReq' => '' , 'notMatch' => '', 'phoneReq' => '' , 'phoneVal' => '' , 'addressReq' => ''];
    public function __construct()
    {
        $user = new User();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->name = trim(htmlspecialchars($_POST['name']));
            $this->email = trim(htmlspecialchars($_POST['email']));
            $this->password = trim(htmlspecialchars($_POST['password']));
            $this->cpassword = trim(htmlspecialchars($_POST['cpassword']));
            $this->phone = trim(htmlspecialchars($_POST['phone']));
            $this->address = trim(htmlspecialchars($_POST['address']));


            // name validation
            if(empty($this->name)){
                $this->errors['nameReq'] = 'name is required';
            }

            //email validation
            if(empty($this->email)){
                $this->errors['emailReq'] = 'email is required';
            }elseif(!filter_var($this->email , FILTER_VALIDATE_EMAIL)){
                $this->errors['emailVal'] = 'enter valid email';
            }

            // password validation

            if(empty($this->password)){
                $this->errors['passwordReq'] = 'password is required';
            }elseif($this->password !== $this->cpassword){
                $this->errors['notMatch'] = 'confirm is not matching';
            }

            // phone validation
            if(empty($this->phone)){
                $this->errors['phoneReq'] = 'phone is required';
            }elseif(!is_numeric($this->phone)){
                $this->errors['phoneVal'] = 'phone must be only number';
            }

            // addrss validation
            if(empty($this->address)){
                $this->errors['addressReq'] = 'address is required';
            }
            if(!empty($errors['nameReq']) ||  !empty($errors['emailReq']) || !empty($errors['emailVal']) || !empty($errors['passwordReq']) || !empty($errors['notMatch']) || !empty($errors['phoneReq']) || !empty($errors['phoneVal']) || !empty($errors['addressReq'])){
                $session = new Session();
                $session->set('errors' , $this->errors);
                header('location:../../register.php');
                die();
            }else{    
                $user->register($this->name , $this->email , $this->password,$this->phone, $this->address);
            }
        }else{
            header('location:../../register.php');
            die();
        }
    }
}
$register = new Register();

?>