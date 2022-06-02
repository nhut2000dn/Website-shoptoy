<?php
    include "connect.php";
    $error  = array();
	$res    = array();
	
	$firstName = $_POST["first-name"];
	$lastName = $_POST["last-name"];
	$email = $_POST["email"];
	$password = md5($_POST["password"]);
	$cpassword = md5($_POST["cpassword"]);
	$gioitinh = $_POST["gioitinh"];
	$ngay = $_POST["date"];
	$thang = $_POST["month"];
	$nam = $_POST["year"];
	$check = true;
	$query_check  = 'SELECT email FROM account WHERE email="'.$email.'"';
	$result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
// while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
//   var_dump($row);
	// }
	if (strlen($firstName) == 0) {
		$error[]= "<li>Vui lòng nhập họ !</li>";
		$check = false;
	}
	if (strlen($lastName) == 0) {
		$error[]= "<li>Vui lòng nhập tên !</li>";
		$check = false;
	}
	if (strlen($email) == 0) {
		$error[]= "<li>Vui lòng nhập Email !</li>";
		$check = false;
	} elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
		$error[] .='<li>Email bạn nhập không hợp lệ !</li>';
		$check	= false;
	} elseif(mysqli_num_rows($result_check)!==0) {
		$error[] .='<li>Email bạn nhập đã tồn tại !</li>';
		$check	= false;
	}
	if (strlen($_POST["password"]) == 0) {
		$error[]= "<li>Vui lòng nhập password !</li>";
		$check = false;
	}
	if ($password != $cpassword) {
		$error[]= "<li>Password không trùng khớp với Comfirm Password !</li>";
		$check = false;
	}
	if ($gioitinh == "0") {
		$error[]= "<li>Vui lòng chọn giới tính !</li>";
		$check = false;
	}
	if ($ngay =='Ngày' || $thang =='Tháng' || $nam =='Năm' ) {
		$error[]= "<li>Vui lòng đầy đủ ( ngày / tháng / năm ) sinh bạn !</li>";
		$check = false;
	}
	if ($check==true) {
		$sqlInsert = 'INSERT INTO account(first_name, last_name, email, password, GT, date_of_birth, status, classify, avatar)
		VALUES("'.$firstName.'", "'.$lastName.'", "'.$email.'", "'.$password.'", "'.$gioitinh.'", "'.$nam.'/'.$thang.'/'.$ngay.'", "1", "0", "")';
		$result_check = mysqli_query($connection,$sqlInsert) or die ("loi".mysqli_error($connection));
		if ($result_check) {
			$resp['status']      = true;    
			echo json_encode($resp);
			exit;
		}
	}

	if(count($error)>0) {
        $resp['msg']    = $error;
        $resp['status'] = false;    
        echo json_encode($resp);
        exit;
    }
?>