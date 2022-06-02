<?php
  include "connect.php";
  session_start();
  $check = true;
  $errorEmail = "";
  $errorPassword = "";

  $email = $_POST["email-sign-in"];
  $passwordPost = $_POST["password-sign-in"];
  $password = md5($_POST["password-sign-in"]);
  
  if (strlen($_POST["email-sign-in"]) == 0) {
    $errorEmail = '<li class="error-sign-in">Vui lòng nhập Email !</li>';
    $check = false;
  }
  if (strlen($_POST["password-sign-in"]) == 0) {
    $errorPassword = '<li class="error-sign-in">Vui lòng nhập Password !</li>';
    $check = false;
  }
  if ($check == true) {
      $checkSign = false;
      $query    = "SELECT * FROM shop_toy.account WHERE email='$email' AND password='$password'";
      $result   = mysqli_query($connection,$query) or die ("Câu lệnh truy vấn lỗi :".mysqli_error($connection));
      $number   = mysqli_num_rows($result);
      $row      = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $classify	= $row["classify"];

      if ($classify == '1') {

        $_SESSION["emailUser"] = $email;
        $_SESSION["passwordUser"] = $_POST["password-sign-in"];
        $resp['status'] = true;
        echo json_encode($resp);
        exit;

      } elseif ($classify == '0') {

        $_SESSION["emailUser"] = $email;
        $_SESSION["passwordUser"] = $_POST["password-sign-in"];
        $resp['status'] = true;
        echo json_encode($resp);
        exit;

      } else {
        $errorSignIn = '<li class="error-sign-in">Email hoặc Password không đúng</li>';
        $resp['errorSignIn']  = $errorSignIn;
        $resp['errorEmail']   = "";
        $resp['errorPassword']    = "";
        echo json_encode($resp);
        exit;
      }
  }
  $resp['errorEmail']   = $errorEmail;
  $resp['errorPassword']    = $errorPassword;
  echo json_encode($resp);
  exit;

?>