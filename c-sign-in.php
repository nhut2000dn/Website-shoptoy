<?php
    include "connect.php";
    session_start();

    $error  = array();
    $res    = array();
    $welcome = "";

    $check = true;
    $email = $_POST["emailSignIn"];
    $password = md5($_POST["passwordSignIn"]);

    if (strlen($email) == 0) {
        $error[] = "<li>Vui lòng nhập Email !</li>";
        $check = false;
    }
    if (strlen($_POST["passwordSignIn"]) == 0) {
        $error[] = "<li>Vui lòng nhập Password !</li>";
        $check = false;
    }

    if ($check == true) {
        $checkSign = false;
        $query    = "SELECT * FROM shop_toy.account WHERE email='$email' AND password='$password'";
        $result   = mysqli_query($connection,$query) or die ("Câu lệnh truy vấn lỗi :".mysqli_error($connection));
        $number   = mysqli_num_rows($result);
        $row      = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $classify	= $row["classify"];
        if($classify =='0') {
            $_SESSION["emailUser"] = $email;
            $_SESSION["passwordUser"] = $_POST["passwordSignIn"];
            $checkSign = true;
            $welcome =  'Chào quý khách '.$row["first_name"].' '.$row["last_name"].' chúc bạn Một ngày tốt lành !';  
        } elseif($classify =='1') {
            $_SESSION["emailUser"] = $email;
            $_SESSION["passwordUser"] = $_POST["passwordSignIn"];
            $checkSign = true;
            $welcome =  'Chào quản trị viên '.$row["first_name"].' '.$row["last_name"].' chúc bạn một ngày làm việc tốt lành !';
        }
        if ($checkSign == false) {
            $error[] = '<li>Email hoặc Password không đúng</li>'; 
            $resp['status']   = false;    
        }
    }

    if(count($error)>0) {
        $resp['msg']    = $error;
        $resp['status'] = false;    
        echo json_encode($resp);
        exit;
    } else {
        $resp['welcome']    = $welcome;
        $resp['status']      = true;    
        echo json_encode($resp);
        exit;
    }

?>