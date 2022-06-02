<?php
	session_start();
	include "../connect.php";
	//Thiết lập và gắn giá trị.
    $user_id = addslashes($_GET['id']);
    echo $user_id;
	if(!isset($_GET["id"])) {
		header ("location:member.php");
	}
    $query_check  = 'DELETE FROM account WHERE id="'.$user_id.'"';
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
	if($result_check) {
		header("location:member.php");
	} else {
		echo "Xóa không thành công";
	} 
?>