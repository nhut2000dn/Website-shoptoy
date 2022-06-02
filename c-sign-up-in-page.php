<?php
  include "connect.php";
  $check = true;
  $errorFirstname = "";
  $errorLastname = "";
  $errorEmail = "";
  $errorPassword = "";
  $errorCPassword = "";
  $errorGT = "";
  $errorDateOfBirth = "";

  $query_check  = 'SELECT email FROM account WHERE email="'.$_POST["email"].'"';
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  if (strlen($_POST["firstname"]) == 0) {
    $errorFirstname.= '<li class="error-sign-in">Vui lòng nhập Họ !</li>';
    $check = false;
  }
  if (strlen($_POST["lastname"]) == 0) {
    $errorLastname.= '<li class="error-sign-in">Vui lòng nhập Tên !</li>';
    $check = false;
  }
  if (strlen($_POST["email"]) == 0) {
    $errorEmail.= '<li class="error-sign-in">Vui lòng nhập Email !</li>';
    $check = false;
  } elseif(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST["email"])) {
    $errorEmail .='<li class="error-sign-in">Email bạn nhập không hợp lệ !</li>';
    $check	= false;
  } elseif(mysqli_num_rows($result_check)!==0) {
    $errorEmail .='<li class="error-sign-in">Email bạn nhập đã tồn tại !</li>';
    $check	= false;
  } 
  if (strlen($_POST["password"]) == 0) {
    $errorPassword.= '<li class="error-sign-in">Vui lòng nhập Password !</li>';
    $check = false;
  }
  if (strlen($_POST["confirm-password"]) == 0) {
    $errorCPassword.= '<li class="error-sign-in">Vui lòng nhập Xác nhận mật khẩu !</li>';
    $check = false;
  } else if ($_POST["password"] != $_POST["confirm-password"]) {
    $errorCPassword.= '<li class="error-sign-in">Vui lòng nhập Xác nhận mật khẩu đúng !</li>';
    $check = false;
  }
  if ($_POST["gioitinh"] == "0") {
    $errorGT.= '<li class="error-sign-in">Vui lòng chọn giới tính !</li>';
    $check = false;
  }
  if ($_POST["date"] =='Ngày' || $_POST["month"] =='Tháng' || $_POST["year"] =='Năm' ) {
    $errorDateOfBirth.= '<li class="error-sign-in">Vui lòng đầy đủ ( ngày / tháng / năm ) sinh bạn !</li>';
    $check = false;
  }
  if ($check == true) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $passwordPost = $_POST["password"];
    $password = md5($_POST["password"]);
    $cpassword = $_POST["confirm-password"];
    $GT = $_POST["gioitinh"];
    $date = $_POST["date"];
    $month = $_POST["month"];
    $year = $_POST["year"];

    $sqlInsert = 'INSERT INTO account(first_name, last_name, email, password, GT, date_of_birth, status, classify, avatar)
    VALUES("'.$firstname.'", "'.$lastname.'", "'.$email.'", "'.$password.'", "'.$GT.'", "'.$year.'/'.$month.'/'.$date.'", "1", "0", "")';
    $result_check = mysqli_query($connection,$sqlInsert) or die ("loi".mysqli_error($connection));
    if ($result_check) {
      $resp['status'] = true;
      echo json_encode($resp);
      exit;
    }
  }
  if ($check == false) {
    $resp['errorFirstname']   = $errorFirstname;
    $resp['errorLastname']    = $errorLastname;
    $resp['errorEmail']       = $errorEmail;
    $resp['errorPassword']    = $errorPassword;
    $resp['errorCPassword']   = $errorCPassword;
    $resp['errorGT']          = $errorGT;
    $resp['errorDateOfBirth'] = $errorDateOfBirth;
    $resp['status'] = false;
    echo json_encode($resp);
    exit;
  }
?>