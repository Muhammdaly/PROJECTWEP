<?php
function check_login(){
    if(empty($_SESSION['user'])){
        header("location:login.php");
        exit;
    }
}