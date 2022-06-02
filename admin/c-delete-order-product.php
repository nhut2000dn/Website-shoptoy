<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $id = addslashes($_GET['id']);
    echo $id;
	if(!isset($_GET["id"])) {
		header ("location:order-product.php");
	}
    $query_check  = 'DELETE FROM `order_details` WHERE id_order="'.$id.'"';
    $query_delete  = 'DELETE FROM `order_product` WHERE id="'.$id.'"';
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
    $result_check2 = mysqli_query($connection,$query_delete) or die ("loi".mysqli_error($connection));
	if($result_check2) {
        echo "Xóa thành công";
		header("location:order-product.php");
	} else {
		echo "Xóa không thành công";
	} 
?>