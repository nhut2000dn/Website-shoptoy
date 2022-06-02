<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $id_r_age = addslashes($_GET['id']);
	if(!isset($_GET["id"])) {
		header("location:recommended-age-product.php");
	}
    $query_check  = "DELETE FROM pd_recommended_age WHERE id='$id_r_age'";
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:recommended-age-product.php");
	} else {
		echo "Xóa không thành công";
	} 
?>