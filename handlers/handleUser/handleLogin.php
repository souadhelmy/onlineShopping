<?php

use OnlineShoping\Session\Session;
use OnlineShoping\Users\User;

require_once '../../classes/Session.php';
require_once '../../classes/User.php';
class Login{
    private $email;
    private $password;
    private $errors = ['emailReq' => '' , 'emailVal' => '' , 'passwordReq' => ''];
    public function __construct()
    {
        $user  = new User();
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->email = trim(htmlspecialchars($_POST['email']));
            $this->password = trim(htmlspecialchars($_POST['password']));

            // email validation
            if(empty($this->email)){
                $this->errors['emailReq'] = 'email is required';
            }elseif(!filter_var($this->email , FILTER_VALIDATE_EMAIL)){
                $this->errors['emailVal'] = 'enter valid email';
            }

            // password Validation
            if(empty($this->password)){
                $this->errors['passwordReq'] = 'password is required';
            }

            if(!empty($this->errors['emailReq']) || !empty($this->errors['emailVal']) || !empty($this->errors['passwordReq'])){
                $session = new Session();
                $session->set('errors' , $this->errors);
                header('location:../../login.php');
                // print_r($this->errors);
                die();
            }else{
                $user->login($this->email , $this->password);
            }
        }else{
            header('location:../../login.php');
            die();
        }
    }
}

$login = new Login();
?>