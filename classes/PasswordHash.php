<?php 
namespace OnlineShoping\PasswordHash;
class PasswordHash{
    private $passwordHash;

    public function setPassword($password){
        $this->passwordHash = password_hash($password , PASSWORD_DEFAULT);
        return $this->passwordHash;
    }

    public function verifyPassword($password , $passwordHashed){
        return password_verify($password , $passwordHashed);
    }
}

?>