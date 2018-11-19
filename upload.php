<?php
// Include config file
require_once "config.php";
$email="";
$name="";
$phone="";
$sex="";
$dob="";
$resume ="";
$dp = "";
$img_src="";
$resume_src="";
$mode="";
if(isset($_GET["email"])&& isset($_GET["mode"])){
    $email = $_GET["email"];
    $mode = $_GET["mode"];
}
else{
    header("Location:init.php");
    exit();
}
if()
?>