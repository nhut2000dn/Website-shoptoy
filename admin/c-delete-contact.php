<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $id_contact = addslashes($_GET['id']);
	if(!isset($_GET["id"])) {
		header("location:contact.php");
	}
    $query_check  = "DELETE FROM `contact` WHERE id='$id_contact'";
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:contact.php");
	} else {
		echo "Xóa không thành công";
	} 
?>