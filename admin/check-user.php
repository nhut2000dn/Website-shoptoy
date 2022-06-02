<?php
    include "connect.php";
    session_start();
	$email    = $_SESSION["emailUser"];
	$password = md5($_SESSION["passwordUser"]);
	$query  ="SELECT * FROM account WHERE email='$email' AND password='$password'";
	$result = mysqli_query($connection,$query) or die ("loi".MYSQLI_ERROR($connection)) ;
	$row    = mysqli_fetch_array($result,MYSQLI_ASSOC);
	if($row["id"]==0){
		header ("location:../index.php");
	}
	if($row["status"] =='0'){
		header ("location:../index.php");
	}
	if($row["classify"] =='0'){
		header ("location:../index.php");
	}
?>