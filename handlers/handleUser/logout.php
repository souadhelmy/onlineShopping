<?php

use OnlineShoping\Users\User;
require_once '../../classes/User.php';
$user = new User();
$user->logout();
header('location:../../login.php');
die();
?>