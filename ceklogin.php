<?php
require 'function.php';

if(isset($_SESSION['login'])){
    //sudah login
} else{
    //belum
    header('location:login.php');
}




?>