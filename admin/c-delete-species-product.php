<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $id_species = addslashes($_GET['id']);
	if(!isset($_GET["id"])) {
		header("location:species-product.php");
	}
    $query_check  = "DELETE FROM pd_species WHERE id='$id_species'";
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:species-product.php");
	} else {
		echo "Xóa không thành công";
	} 
?>