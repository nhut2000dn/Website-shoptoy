<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $id_ideal_for = addslashes($_GET['id']);
	if(!isset($_GET["id"])) {
		header("location:ideal-for-product.php");
	}
    $query_check  = "DELETE FROM pd_ideal_for WHERE id='$id_ideal_for'";
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:ideal-for-product.php");
	} else {
		echo "Xóa không thành công";
	} 
?>