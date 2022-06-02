<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $product_id = addslashes($_GET['id']);
    echo $product_id;
	if(!isset($_GET["id"])) {
		header ("location:product.php");
	}
    $query_check  = 'DELETE FROM product WHERE id="'.$product_id.'"';
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:product.php");
	} else {
		echo "Xóa không thành công";
	} 
?>