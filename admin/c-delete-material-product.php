<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $id_material = addslashes($_GET['id']);
	if(!isset($_GET["id"])) {
		header("location:material-product.php");
	}
    $query_check  = "DELETE FROM pd_material WHERE id='$id_material'";
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:material-product.php");
	} else {
		echo "Xóa không thành công";
	} 
?>