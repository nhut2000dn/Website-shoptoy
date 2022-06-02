<?php
  include "connect.php";
  session_start();
  /////////////////////////////////////////////
  function explode_image($image) {
    $img_pd          = $image;
    $pieces_img = explode(",", $img_pd);
    return $pieces_img[0];
  }
  /////////////////////////////////////////////
  if (isset($_POST["btn-sign-out"])) {
    unset($_SESSION["emailUser"]);
    unset($_SESSION["passwordUser"]);
    header("Refresh:0");
  }
  /////////////////////////////////////////////
  if (isset($_POST["btn-search"])) {
    $link_search = 'location:toys.php?search='.$_POST["content-search"];
    header ($link_search);
  }
  /////////////////////////////////////////////
  include("c-cart.php");
  if ( isset($_SESSION["emailUser"]) && isset($_SESSION["passwordUser"]) ) {
    $email = $_SESSION["emailUser"];
    $passowrd = md5($_SESSION["passwordUser"]);
    $query_select_account = "SELECT * FROM shop_toy.account WHERE email = '$email' AND password = '$passowrd';";
    $result_account = mysqli_query($connection,$query_select_account) or die ("loi".mysqli_error($connection));
    $row=mysqli_fetch_array($result_account,MYSQLI_ASSOC);
    static $id_account = "";
    $id_account = $row["id"];
    $email_account = $row["email"];
    $check_login = true;
  } else {
    $check_login = false;
    header ("location:index.php");
  }
  ////////////////////////////////////////////////////////////////
  if (isset($_GET["order"])) {
    $count_ordered = 0;
    $count_order_removed = 0;
    $style_order = 'style="color: #0088b5;"';
    if ($check_login == true) {
      $query_order_pd = 'SELECT * FROM order_product WHERE order_product.status=1 AND id_account='.$id_account . ' ORDER BY order_product.id DESC';
      $result_order_pd = mysqli_query($connection,$query_order_pd) or die ("loi".mysqli_error($connection));
      while($row=mysqli_fetch_array($result_order_pd,MYSQLI_ASSOC)) {
        $count_ordered++;
        if ($row["pay"] == 0) {
          $pay = "Chưa thanh toán";
        } else {
          $pay = "Đã thanh toán";
        }
          $html_order.=' <div class="container-order">';
            $html_order.='<div class="container-order-information">';
              $html_order.='<div class="information-left">';
                $html_order.='<h3 class="title-order">Ordered : #'.$row["id"].'</h3>';
                $html_order.='<p class="day-order">Đặt ngày : '.$row["created_date"].'</p>';
                $html_order.='<p class="pay-order">Thanh Toán: '.$pay.'</p>';
              $html_order.='</div>';
              $html_order.='<div class="information-right">';
              $html_order.='</div>';
            $html_order.='</div>';
          $html_order.='</div>';
  
        $id_order = $row["id"];
        if ($row["status"] == 0) {
          $status = "Đã Hủy";
        } else {
          $status = "Đang chờ xử lý";
        }
  
        $query_order_details = 'SELECT * FROM shop_toy.order_details, shop_toy.product WHERE shop_toy.order_details.id_product = shop_toy.product.id AND id_order='.$id_order;
        $result_order_details = mysqli_query($connection,$query_order_details) or die ("loi".mysqli_error($connection));
        while($row=mysqli_fetch_array($result_order_details,MYSQLI_ASSOC)) {
          static $price_order = 0;
          static $i = 1;
            $html_order.='<div class="container-order-item">';
              $html_order.='<div class="container-title">';
                $html_order.='<h3 class="title-order-item"><i class="fas fa-gift"></i> Kiện hàng '.$i.'</h3>';
              $html_order.='</div>';
              $html_order.='<div class="container-item">';
                $html_order.='<div class="img-item">';
                  $html_order.='<img src="images/'.explode_image($row["image_pd"]).'" alt="" class="">';
                $html_order.='</div>';
                $html_order.='<div class="name-item">';
                  $html_order.='<p class="name">'.$row["name_pd"].'</p>';
                $html_order.='</div>';
                $html_order.='<div class="price-item">';
                  $html_order.='<p class="price">$'.$row["price_pd"].'</p>';
                $html_order.='</div>';
                $html_order.='<div class="quantity-item">';
                  $html_order.='<p class="quantity"><span class="color-quantily">Qty:</span> '.$row["amount"].'</p>';
                $html_order.='</div>';
              $html_order.='</div>';
            $html_order.='</div>';
            $price_order+= $row["price_pd"] * $row["amount"];
          
          $i++;
        }
          $html_order.='<div class="container-order-bottom">';
            $html_order.='<div class="order-bottom-left">';
              $html_order.='<p class="">Tình trạng:<span class=""> '.$status.'</span></p>';
            $html_order.='</div>';
            $html_order.='<div class="order-bottom-right">';
              $html_order.='<p class="">Số tiền phải trả: <span class="color-money">$'.$price_order.'</span></p>';
                $html_order.='<form action="user-function.php?order" method="post">';
                  $html_order.='<button onclick="return confirmRemove()" name="btn-remove-order" class="btn-remove-order" value="'.$id_order.'" type="submit">Hủy Đơn Hàng</button>';
                $html_order.='</form>';
            $html_order.='</div>';
          $html_order.='</div>';
      }
    }
    ////////////////////
    if ($check_login == true) {
      $query_order_pd = 'SELECT * FROM order_product WHERE order_product.status=0 AND id_account='.$id_account;
      $result_order_pd = mysqli_query($connection,$query_order_pd) or die ("loi".mysqli_error($connection));
      while($row=mysqli_fetch_array($result_order_pd,MYSQLI_ASSOC)) {
        $count_order_removed++;
        if ($row["pay"] == 0) {
          $pay = "Chưa thanh toán";
        } else {
          $pay = "Đã thanh toán";
        }
          $html_order_remove.=' <div class="container-order">';
            $html_order_remove.='<div class="container-order-information">';
              $html_order_remove.='<div class="information-left">';
                $html_order_remove.='<h3 class="title-order">Ordered : #'.$row["id"].'</h3>';
                $html_order_remove.='<p class="day-order">Đặt ngày : '.$row["created_date"].'</p>';
                $html_order_remove.='<p class="pay-order">Thanh Toán: '.$pay.'</p>';
              $html_order_remove.='</div>';
              $html_order_remove.='<div class="information-right">';
              $html_order_remove.='</div>';
            $html_order_remove.='</div>';
          $html_order_remove.='</div>';
  
        $id_order = $row["id"];
        if ($row["status"] == 0) {
          $status = "Đã Hủy";
        } else {
          $status = "Đang chờ xử lý";
        }
  
        $query_order_details = 'SELECT * FROM shop_toy.order_details, shop_toy.product WHERE shop_toy.order_details.id_product = shop_toy.product.id AND id_order='.$id_order;
        $result_order_details = mysqli_query($connection,$query_order_details) or die ("loi".mysqli_error($connection));
        while($row=mysqli_fetch_array($result_order_details,MYSQLI_ASSOC)) {
          static $price_order_remove = 0;
          static $i = 1;
            $html_order_remove.='<div class="container-order-item">';
              $html_order_remove.='<div class="container-title">';
                $html_order_remove.='<h3 class="title-order-item"><i class="fas fa-gift"></i> Kiện hàng '.$i.'</h3>';
              $html_order_remove.='</div>';
              $html_order_remove.='<div class="container-item">';
                $html_order_remove.='<div class="img-item">';
                  $html_order_remove.='<img src="images/'.explode_image($row["image_pd"]).'" alt="" class="">';
                $html_order_remove.='</div>';
                $html_order_remove.='<div class="name-item">';
                  $html_order_remove.='<p class="name">'.$row["name_pd"].'</p>';
                $html_order_remove.='</div>';
                $html_order_remove.='<div class="price-item">';
                  $html_order_remove.='<p class="price">$'.$row["price_pd"].'</p>';
                $html_order_remove.='</div>';
                $html_order_remove.='<div class="quantity-item">';
                  $html_order_remove.='<p class="quantity"><span class="color-quantily">Qty:</span> '.$row["amount"].'</p>';
                $html_order_remove.='</div>';
              $html_order_remove.='</div>';
            $html_order_remove.='</div>';
            $price_order_remove+= $row["price_pd"] * $row["amount"];
          
          $i++;
        }
          $html_order_remove.='<div class="container-order-bottom">';
            $html_order_remove.='<div class="order-bottom-left">';
              $html_order_remove.='<p class="">Tình trạng:<span class=""> '.$status.'</span></p>';
            $html_order_remove.='</div>';
            $html_order_remove.='<div class="order-bottom-right">';
              $html_order_remove.='<p class="">Số tiền phải trả: <span class="color-money">$'.$price_order_remove.'</span></p>';
            $html_order_remove.='</div>';
          $html_order_remove.='</div>';
      }
    }
    ////////////////////
    if (isset($_POST["btn-remove-order"])) {
      echo $_POST["btn-remove-order"];
      $query_update = 'UPDATE shop_toy.order_product SET status=0 WHERE id='.$_POST["btn-remove-order"];
      $result_update = mysqli_query($connection,$query_update) or die ("loi".mysqli_error($connection));
      if ($result_update) {
        echo'<meta http-equiv="refresh" content="0; url=user-function.php?order" />';
        echo "<script type='text/javascript'>alert('Hủy đặt hàng thành công');</script>";
      }
    }
    ////////////////////
    if (!isset($html_order)) {
      $html_order.='<div class="container-null-cart">';
        $html_order.='<div class="container-img-null-cart">';
          $html_order.='<img src="images/ordered.png" alt="" class="">';
          $html_order.='<p class="">Chưa có đơn hàng</p>';
        $html_order.='</div>';
      $html_order.='</div>';
    }
    if (!isset($html_order_remove)) {
      $html_order_remove.='<div class="container-null-cart">';
        $html_order_remove.='<div class="container-img-null-cart">';
          $html_order_remove.='<img src="images/ordered.png" alt="" class="">';
          $html_order_remove.='<p class="">Chưa có đơn hàng</p>';
        $html_order_remove.='</div>';
      $html_order_remove.='</div>';
    }
    ////////////////////

    $html_order_main.='<div class="tab">';
      $html_order_main.='<button class="tablinks tablinks-ordered" id="defaultOpen">Đang đặt hàng('.$count_ordered.')</button>';
      $html_order_main.='<button class="tablinks tablinks-ordered-removed">Đã hủy('.$count_order_removed.')</button>';
    $html_order_main.='</div>';

    $html_order_main.='<div id="ordered" class="tabcontent tab-hien">';
      $html_order_main.=$html_order;
    $html_order_main.='</div>';
    $html_order_main.='<div id="order-removed" class="tabcontent">';
      $html_order_main.=$html_order_remove;
    $html_order_main.='</div>';
  }
  /////////////////////////////////////////////////////////////////////
  if (isset($_GET["profile"])) {
    $style_drop_down_user = 'style="color: #0088b5;"';

    $query_check  = 'SELECT * FROM account WHERE id="'.$id_account.'"';
    $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
    while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
        $hoEdit = $row["first_name"];
        $tenEdit = $row["last_name"];
        $emailEdit = $row["email"];
        $gtEdit = $row["GT"];
        $ngaysinh = $row["date_of_birth"];
        $date = explode('-', $ngaysinh);
        $yearEdit = $date[0];
        $monthEdit = $date[1];
        $dayEdit  = $date[2];
        $avatar = $row["avatar"];
    }
    if (strlen($avatar) == "0") {
      $html_avatar = '<img class="img-avatar" id="blah" src="images/no-avatar.jpg" alt="">';
    } else {
      $html_avatar = '<img class="img-avatar" id="blah" src="images/'.$avatar.'" alt="">';
    }
    if (isset($_POST["btn-save-profile"])) {
      $check_update = true;
      $phpFileUploadErrors = array(
          0 => 'There is no error, the file uploaded with success',
          1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
          2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
          3 => 'The uploaded file was only partially uploaded',
          4 => 'No file was uploaded',
          6 => 'Missing a temporary folder',
          7 => 'Failed to write file to disk.',
          8 => 'A PHP extension stopped the file upload.',
      );
      if (isset($_FILES['img-file'])) {
          $anh = $_FILES['img-file']['name'];
          $ext_error = false;
          $extensions = array('jpg','jpeg','gif','png');
          $file_ext = explode('.',$_FILES['img-file']['name']);
          $file_ext = end($file_ext);
          
          if (!in_array($file_ext, $extensions)) {
              $ext_error = true;
          }
          if ($_FILES['img-file']['error']) {
              // echo $phpFileUploadErrors[$_FILES['img-file']['error']];
          }
          elseif ($ext_error) {
              // echo "Invalid file extensions";
              $check_update = false;
              $error.= "<li>file phải có định dạng jpg, jpeg, gif, png !</li>";
          }
          else {
              // echo "success! Image has been uploaded!";
          }
      }
      if (strlen($_POST["first-name"]) == "0") {
        $error.= "<li>Họ không được để trống !</li>";
        $check_update = false;
      }
      if (strlen($_POST["last-name"]) == 0) {
        $error.= "<li>Tên không được để trống !</li>";
        $check_update = false;
      }
      if ($_POST["date"] == 0 || $_POST["month"] == 0 || $_POST["year"] == 0) {
        $error.= "<li>Phải nhập đủ Ngày/Tháng/Năm !</li>";
        $check_update = false;
      }
      if ($check_update == true) {
        $first_name = $_POST["first-name"];
        $last_name = $_POST["last-name"];
        $GT = $_POST["gioi-tinh"];
        $date_of_birth = $_POST["year"].'/'.$_POST["month"].'/'.$_POST["date"];
        if (!file_exists($_FILES['img-file']['tmp_name']) || !is_uploaded_file($_FILES['img-file']['tmp_name']))  {
          $queryUpdate  = "UPDATE account SET first_name=N'$first_name', last_name=N'$last_name', GT='$GT', date_of_birth='$date_of_birth' WHERE id='$id_account'";
          $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
          if($result) {
            echo "<script type='text/javascript'>alert('Update thanh cong');</script>";
            echo'<meta http-equiv="refresh" content="0; url=user-function.php?profile" />';
          }
        } else {
          $queryUpdate  = "UPDATE account SET first_name=N'$first_name', last_name=N'$last_name', GT='$GT', date_of_birth='$date_of_birth', avatar = '$anh' WHERE id='$id_account'";
          $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
          if($result) {
            move_uploaded_file($_FILES['img-file']['tmp_name'], 'images/'.$_FILES['img-file']['name']);
            echo "<script type='text/javascript'>alert('Update thanh cong');</script>";
            echo'<meta http-equiv="refresh" content="0; url=user-function.php?profile" />';
          }
        }
      }
    }
    ////////////////////////////////////////
    $html_profile_main.='<form action="user-function.php?profile" method="post" enctype="multipart/form-data">';
      $html_profile_main.='<div class="main-container-function">';
        $html_profile_main.='<div class="container-title-function">';
          $html_profile_main.='<h1 class="title-function">Hồ Sơ Của Tôi</h1>';
          $html_profile_main.='<p class="txt-title-function">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>';
        $html_profile_main.='</div>';
        $html_profile_main.='<div class="container-inforamtion-function">';
          $html_profile_main.='<div class="inforamtion-function-left">';
            
            $html_profile_main.='<table class="table-inforamtion-function">';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function">Firstname</th>';
                $html_profile_main.='<td class="inforamtion-function">';
                  $html_profile_main.='<input name="first-name" type="text" placeholder="Nhập họ của bạn" value="'.$hoEdit.'">';
                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function">Lastname</th>';
                $html_profile_main.='<td class="inforamtion-function">';
                  $html_profile_main.='<input name="last-name" type="text" placeholder="Nhập họ của bạn" value="'.$tenEdit.'">';
                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function">Email</th>';
                $html_profile_main.='<td class="inforamtion-function">';
                  $html_profile_main.='<input type="text" placeholder="Nhập họ của bạn" value="'.$_SESSION["emailUser"].'"  readonly="readonly">';
                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function">Giới tính</th>';
                $html_profile_main.='<td class="inforamtion-function">';
                  if ($gtEdit == 'Nam') {
                    $html_profile_main.='<input type="radio" checked="checked" name="gioi-tinh" value="Nam" class=""> Nam';
                  } else {
                    $html_profile_main.='<input type="radio" name="gioi-tinh" value="Nam" class=""> Nam';
                  }
                  if ($gtEdit == 'Nữ') {
                    $html_profile_main.='<input checked="checked" type="radio" name="gioi-tinh" value="Nữ" class=""> Nữ';
                  } else {
                    $html_profile_main.='<input type="radio" name="gioi-tinh" value="Nữ" class=""> Nữ';
                  }
                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function">Ngày sinh</th>';
                $html_profile_main.='<td class="inforamtion-function">';

                  $html_profile_main.='<select class = "sn" name="date">';
                    $html_profile_main.='<option value"=0">Ngày</option>';
                      for ($d = 1; $d <= 31; $d++) {
                          if (isset($dayEdit) && $dayEdit==$d) {
                              $html_profile_main.='<option value="'.$d.'" selected="selected" >'.$d.'</option>';
                          } else {
                              $html_profile_main.='<option value"='.$d.'">'.$d.'</option>';
                          }
                      }
                  $html_profile_main.='</select>';

                  $html_profile_main.='<select class = "sn" name="month">';
                    $html_profile_main.='<option value"=0">Tháng</option>';
                    for ($m = 1; $m <= 12; $m++) {
                      if (isset($monthEdit) && $monthEdit==$m) {
                        $html_profile_main.='<option value="'.$m.'" selected="selected" >'.$m.'</option>';
                      } else {
                        $html_profile_main.='<option value"='.$m.'">'.$m.'</option>';
                      }
                    }
                  $html_profile_main.='</select>';

                  $html_profile_main.='<select class = "sn" name="year">';
                    $html_profile_main.='<option value"=0">Năm</option>';
                    for ($y = 1930; $y <= 2019; $y++) {
                      if (isset($yearEdit) && $yearEdit==$y) {
                          $html_profile_main.='<option value="'.$y.'" selected="selected" >'.$y.'</option>';
                      } else {
                        $html_profile_main.='<option value"='.$y.'">'.$y.'</option>';
                      }
                    }
                  $html_profile_main.='</select>';

                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function"></th>';
                $html_profile_main.='<td class="inforamtion-function">';
                    $html_profile_main.='<button name="btn-save-profile" class="btn-save-function" type="submit">Lưu</button>';
                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
              $html_profile_main.='<tr>';
                $html_profile_main.='<th class="label-function"></th>';
                $html_profile_main.='<td class="inforamtion-function">';
                    $html_profile_main.='<?php echo $error ?>';
                $html_profile_main.='</td>';
              $html_profile_main.='</tr>';
            $html_profile_main.='</table>';
            
          $html_profile_main.='</div>';
          $html_profile_main.='<div class="inforamtion-function-right">';
            $html_profile_main.='<table class="">';
              $html_profile_main.='<tr><td>'.$html_avatar.'</td></tr>';
              $html_profile_main.='<tr><td><span>Chọn Ảnh</span></td></tr>';
              $html_profile_main.='<tr><td><input type="file" name="img-file" onchange="readURL(this);"></td></tr>';
                $html_profile_main.='<tr><td><span class="img-txt">Dung lượng file tối đa 1MB</span></td></tr>';
                $html_profile_main.='<tr><td><span class="img-txt">File phải có định dạng jpg, jpeg, gif, png !</span></td></tr>';
            $html_profile_main.='</table>';
          $html_profile_main.='</div>';
        $html_profile_main.='</div>';
      $html_profile_main.='</div>';
    $html_profile_main.='</form>';
    ////////////////////////////
  }
  ///////////////////////////////////////////////////////////////////////////////////////////////////
  if (isset($_GET["change-password"])) {
    $style_drop_down_password = 'style="color: #0088b5;"';
    $check_password = true;
    if (isset($_POST["btn-save-change-password"])) {

      if ($_POST["password"] != $_SESSION["passwordUser"]) {
        $check_password = false;
        $error_password.='<li>Xin nhập đúng mật khẩu củ</li>';
      }
      
      if (strlen($_POST["password"]) == 0) {
        $check_password = false;
        $error_password.='<li>Xin nhập đầy đủ mật khẩu củ</li>';
      }
      if (strlen($_POST["new-password"]) == 0) {
        $check_password = false;
        $error_password.='<li>Xin nhập đầy đủ mật khẩu mới</li>';
      }
      if (strlen($_POST["new-repassword"]) == 0) {
        $check_password = false;
        $error_password.='<li>Xin nhập đầy đủ xác nhận mật khẩu củ</li>';
      }
      if ($_POST["new-password"] != $_POST["new-repassword"]) {
        $check_password = false;
        $error_password.='<li>Xin nhập mật khẩu mới và xác nhận đúng</li>';
      }
      if ($check_password == true) {
        $query_update_password = 'UPDATE shop_toy.account SET password="'.md5($_POST["new-repassword"]).'" WHERE id='.$id_account;
        echo $query_update_password;
        $result   = mysqli_query($connection,$query_update_password)or die("loi cap nhat".mysqli_error($con));
        if($result) {
          $_SESSION["passwordUser"] = $_POST["new-repassword"];
          echo'<meta http-equiv="refresh" content="0; url=user-function.php?change-password" />';
          echo "<script type='text/javascript'>alert('Update thanh cong');</script>";
        }
      }
    }
    $html_change_password.='<form action="user-function.php?change-password" method="post" enctype="multipart/form-data">';
      $html_change_password.='<div class="main-container-function">';
        $html_change_password.='<div class="container-title-function">';
          $html_change_password.='<h1 class="title-function">Đổi Mật Khẩu</h1>';
          $html_change_password.='<p class="txt-title-function">Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác</p>';
        $html_change_password.='</div>';
        $html_change_password.='<div class="container-inforamtion-function">';
          $html_change_password.='<div class="inforamtion-function-left">';
            $html_change_password.='<table class="table-inforamtion-function">';
              $html_change_password.='<tr>';
                $html_change_password.='<th class="label-function label-change-password">Mật khẩu hiện tại</th>';
                $html_change_password.='<td class="inforamtion-function">';
                    $html_change_password.='<input name="password" type="password" placeholder="Nhập mật khẩu hiện tại của bạn" value="'.$_POST["password"].'">';
                $html_change_password.='</td>';
              $html_change_password.='</tr>';
              $html_change_password.='<tr>';
                $html_change_password.='<th class="label-function label-change-password">Mật Khẩu Mới</th>';
                $html_change_password.='<td class="inforamtion-function">';
                    $html_change_password.='<input name="new-password" type="password" placeholder="Nhập mật Khẩu Mới của bạn" value="'.$_POST["new-password"].'">';
                $html_change_password.='</td>';
              $html_change_password.='</tr>';
              $html_change_password.='<tr>';
                $html_change_password.='<th class="label-function label-change-password">Xác nhận mật khẩu</th>';
                $html_change_password.='<td class="inforamtion-function">';
                    $html_change_password.='<input name="new-repassword" type="password" value="'.$_POST["new-repassword"].'" placeholder="Nhập xác nhận mật khẩu của bạn">';
                $html_change_password.='</td>';
              $html_change_password.='</tr>';
              $html_change_password.='<tr>';
                $html_change_password.='<th class="label-function label-change-password"></th>';
                $html_change_password.='<td class="inforamtion-function">';
                  $html_change_password.='<button name="btn-save-change-password" class="btn-save-function" type="submit">Lưu</button>';
                  $html_change_password.='</td>';
              $html_change_password.='</tr>';
              $html_change_password.='<tr>';
                $html_change_password.='<th class="label-function label-change-password"></th>';
                $html_change_password.='<td class="inforamtion-function">';
                  $html_change_password.=$error_password;
                $html_change_password.='</td>';
              $html_change_password.='</tr>';
            $html_change_password.='</table>';
          $html_change_password.='</div>';
        $html_change_password.='</div>';
      $html_change_password.='</div>';
    $html_change_password.='</form>';
  }
  ////////////////////////////////////////////////////////////////
  if (isset($_GET["contact"])) {
    $url_page = $pieces = explode('&contact', $_SERVER['REQUEST_URI']);
    $html_contact.='<form action="'.$_SERVER['REQUEST_URI'].'&contact" method="post">';
      $html_contact.='<div name="view"  class="view" id="view">';
        $html_contact.='<div class="modal__content contact">';
          $html_contact.='<a href="'.$url_page[0].'" class="modal__close">&times;</a>';  
          $html_contact.='<h1 class="title-contact">Contact</h1>';
          $html_contact.='<form action="'.$_SERVER['REQUEST_URI'].'&contact" method="post">';
            $html_contact.='<div class="box-send-msg">';
              $html_contact.='<div>';
                $html_contact.='<label><span class="star">* </span>From:</label>';
                $html_contact.='<input name="email-contact" type="email" placeholder="Enter your email address" class="input-email" required="">';
              $html_contact.='</div>';
              $html_contact.='<div class="box-send-to">';
                $html_contact.='<label><span class="star">* </span>To:</label>';
                $html_contact.='<label class="txt-admin">Admin</label>';
              $html_contact.='</div>';
              $html_contact.='<div class="box-textarea-message">';
                $html_contact.='<label class="txt-Message"><span class="star">* </span>Message:</label>';
                $html_contact.='<textarea name="content-contact" class="textarea-message" id="" cols="90" rows="10" required="" placeholder="We suggest you detail your product requirements and company information here."></textarea>';
              $html_contact.='</div>';
              $html_contact.='<div class="box-btn-send">';
                $html_contact.='<button name="btn-send-message" class="btn-send send">Send</button>';
              $html_contact.='</div>';
            $html_contact.='</div>';       
          $html_contact.='</form>';
        $html_contact.='</div>';
      $html_contact.='</div>';
    $html_contact.='</form>';
  }
  ////////////////////////////////////////////////////////////////
  if (isset($_POST["btn-send-message"])) {
    $email_contact = $_POST["email-contact"];
    $content_contact = $_POST["content-contact"];
    $query_insert_contact = "INSERT INTO `contact` (id, email_contact, content_message, status) VALUES (NULL,
      '$email_contact', '$content_contact', '0');";
    $result_insert_contact  = mysqli_query($connection,$query_insert_contact)or die("loi cap nhat".mysqli_error($con));
    if ($result_insert_contact) {
      $urlFile = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
      echo "<script type='text/javascript'>alert('Gửi tin nhắn cho admin thành công!');</script>";
      // echo'<meta http-equiv="refresh" content="0; url='.$urlFile.' />';
      header ("location:".$urlFile);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>E-commerce</title>
  <link rel="stylesheet" href="css/header-footer.css">
  <link rel="stylesheet" href="css/css_user-function.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
  <title>Document</title>
  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#blah')
              .attr('src', e.target.result)
              .width(150)
              .height(150);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
</head>

<body>
  <header class="page-header">
    <div class="box-header">
      <div class="logo-left">
        <a href="index.php">
           <img src="images/LOGO2.png" alt="" width="225px">
        </a>
      </div>
      <div class="search-center">
        <form method="post" action="index.php">
          <div class="box-search">
            <input name="content-search" type="text" value="" class="search" placeholder="Search">
              <button name="btn-search" type="submit" class="box-icon-search">
                <!-- <div class="box-icon-search"> -->
                  <i class="fas fa-search" id="icon-search"></i>
                <!-- </div> -->
              </button>
          </div>
        </form>
      </div>
      <div class="cart-right">
        <?php
          if ( isset($_SESSION["emailUser"]) && isset($_SESSION["passwordUser"]) ) {
            echo '
              <div class="box-txt-user">
                <div class="container-user">
                  <div class="container-username">
                    <p class="txt-username">'.$_SESSION["emailUser"].'</p>
                  </div>
                  <div class="container-icon-user">
                    <i class="far fa-user"></i>
                  </div>
                </div>
                <div class="drop-down-user" style="display: none;">
                  <div class="arrow-up"></div>
                  <form action="" method="post">
                    <div class="container-drop-user">
                      <ul class="bar-drop-user">
                        <li class="item-drop-user"><a href="user-function.php?order"><p class="txt-item-user">Đơn mua</p></a></li>
                        <li class="item-drop-user"><a href="user-function.php?profile"><p class="txt-item-user">Tài khoản của tôi</p></a></li>
                        <li class="item-drop-user"><button type="submit" name="btn-sign-out" class="btn-sign-out">Đăng Xuất</button></li>
                      </ul>
                    </div>
                  </form>
                </div>
              </div>
            ';
          } else {
            echo '<div class="box-txt-user"><p><a href="sign-up-in.php">Đăng Nhập</a>/<a><a href="sign-up-in.php">Đăng Ký</a></p></div>';
          }
        ?>
        <div class="box-cart">
          <i class="fas fa-shopping-cart" id="icon-cart"></i>
          <span class="txt-shopping">SHOPPING</span>
          <span class="txt-item"><span class="amount-cart"><?php if(isset($amount_cart)) { echo $amount_cart;} else echo 0 ?></span>
            item(s)-$<span class="price-cart"><?php if (isset($total_price)) echo $total_price; else echo 0 ?></span></span>
          <i class="fas fa-sort-down" id="icon-down"></i>

          <div class="box-toy-cart">
            <div class="box-item-cart">
              <?php echo $html_cart ?>
            </div>
          </div>
        </div>
        <div>
          <p class="txt-cart">CART</p>
        </div>
      </div>
      <div class="box-action">
        <div class="box-action-search">
          <i class="fas fa-search action-search"></i>
        </div>
        <div class="box-action-menu">
          <i class="fas fa-bars"></i>
        </div>
        <div class="box-icon-cart">
          <a href="">
            <img src="images/cart.png" height="32" width="32" alt="">
            <span href="#" class="count-product">1</span>
          </a>
        </div>
      </div>
    </div>
  </header>
  <div class="border-bottom">
    <p class="border"></p>
  </div>
  <menu class="page-menu">
    <div class="box-menu">
      <nav class="bar-menu">
        <ul class="menu">
          <li class="item-menu">
            <div class="item-icon-home">
              <a href="index.php" class="type-item-home"><i class="fas fa-home" id="icon-home"></i>HOME</a>
            </div>
          </li>
          <li class="item-menu"><a href="#" class="type-item-menu item-menu-down">TOYS BY TYPE<i
                class="fas fa-sort-down icon-down"></i></a>
            <div class="dropdown-menu">
                <?php
                $r_category_array = $db_handle->runQuery("SELECT * FROM pd_species");
                if (!empty($r_category_array)) { 
                  foreach($r_category_array as $key=>$value){
                ?>    
                  <a href="toys.php?category=<?php echo $r_category_array[$key]["url_name_species"]; ?>" class="type-dropdown-menu"><?php echo $r_category_array[$key]["name_species"]; ?></a>
                <?php
                  }
                }
                ?>
            </div>
          </li>
          <li class="item-menu"><a href="#" class="type-item-menu item-menu-down">TOYS BY AGES<i
                class="fas fa-sort-down icon-down"></i></a>
            <div class="dropdown-menu">
              <?php
              $r_age_array = $db_handle->runQuery("SELECT * FROM pd_recommended_age");
              if (!empty($r_age_array)) { 
                foreach($r_age_array as $key=>$value){
              ?>    
                <a href="toys.php?filter&recommended-age=<?php echo $r_age_array[$key]["url_name_r_age"]; ?>" class="type-dropdown-menu"><?php echo $r_age_array[$key]["name_r_age"]; ?></a>
              <?php
                }
              }
              ?>
            </div>
          </li>
          <li class="item-menu"><a href="toys.php?filter&recommended-age=0-to-2-years" class="type-item-menu">ORIGINAL BABY</a></li>
          <li class="item-menu"><a href="#" class="type-item-menu item-menu-down">TOY IDEAL FOR<i
                class="fas fa-sort-down icon-down"></i></a>
            <div class="dropdown-menu">
              <?php
              $ideal_for_array = $db_handle->runQuery("SELECT * FROM pd_ideal_for");
              if (!empty($ideal_for_array)) { 
                foreach($ideal_for_array as $key=>$value){
              ?>
                <a href="toys.php?filter&ideal-for=<?php echo $ideal_for_array[$key]["url_name_ideal"]; ?>" class="type-dropdown-menu"><?php echo $ideal_for_array[$key]["name_ideal_for"]; ?></a>
              <?php
                }
              }
              ?>
            </div>
          </li>
          <li class="item-menu"><a href="#" class="type-item-menu item-menu-down">TOY BY MATERIAL<i
                class="fas fa-sort-down icon-down"></i></a>
            <div class="dropdown-menu">
              <?php
              $ideal_for_array = $db_handle->runQuery("SELECT * FROM pd_material");
              if (!empty($ideal_for_array)) { 
                foreach($ideal_for_array as $key=>$value){
              ?>
                <a href="toys.php?filter&material=<?php echo $ideal_for_array[$key]["url_name_material"]; ?>" class="type-dropdown-menu"><?php echo 'Material ' . $ideal_for_array[$key]["name_material"]; ?></a>
              <?php
                }
              }
              ?>
            </div>
          </li>
          <li class="item-menu" id="item-contact"><a href="<?php echo $_SERVER['REQUEST_URI'].'&contact' ?>" class="type-item-menu">CONTACT</a></li>
          <li class="item-menu" id="item-blog"><a href="#" class="type-item-menu">BLOG</a></li>
        </ul>
      </nav>
    </div>
  </menu>

  <main class="page-main-order">
    <div class="main-left">
      <div class="container-main-left">
        <div class="container-account">
          <div class="icon-left">
            <i class="fas fa-user-circle"></i>
          </div>
          <div class="account-right">
            <h4 class=""><?php echo $email_account ?></h4>
            <a href="user-function.php?profile"><h5 class=""><i class="far fa-edit"></i>Sửa Hồ Sơ</h5></a>
          </div>
        </div>
        <div class="container-menu-account">
          <div class="container-item-account">
            <div class="icon-item-left">
              <i class="fas fa-user-circle"></i>
            </div>
            <div class="item-right">
              <p class="">Tài Khoản Của Tôi</p>
            </div>
          </div>
          <div class="drop-down-account">
            <ul class="bar-drop-down-account">
              <li class="item-drop-down"><a <?php echo $style_drop_down_user ?> href="user-function.php?profile">Hồ sơ</a></li>
              <li class="item-drop-down"><a <?php echo $style_drop_down_password ?> href="user-function.php?change-password">Đổi mật khẩu</a></li>
            </ul>
          </div>

          <a href="user-function.php?order">
            <div class="container-item-account">
              <div class="icon-item-left">
                <i class="fas fa-gifts"></i>
              </div>
              <div class="item-right">
                <p <?php echo $style_order ?> class="">Đơn mua hàng</p>
              </div>
            </div>
          </a>

        </div>
      </div>
    </div>
    <div class="main-right">
      <!-- ////////////////////////// -->
      <?php echo $html_order_main ?>
      <!-- ////////////////////////// -->
      <?php echo $html_profile_main ?>
      <!-- ////////////////////////// -->
      <?php echo $html_change_password ?>


  </main>
  <div class="main-action">
    <div class="bar-search-action">
      <input type="search" class="search-action" placeholder="Search">
      <div class="box-icon-search box-search-action">
        <i class="fas fa-search" id="icon-search"></i>
      </div>
    </div>
    <div>
      <div class="box-menu-action">
        <nav class="bar-menu">
          <ul class="menu">
            <li class="item-menu item-menu-action">
              <div class="item-icon-home">
                <a href="#" class="type-item-home"><i class="fas fa-home" id="icon-home"></i>HOME</a>
              </div>
            </li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu item-menu-down">TOYS BY TYPE<i
                  class="fas fa-sort-down icon-down"></i></a>
              <div class="dropdown-menu">
                <a href="#" class="type-dropdown-menu">Action Figures</a>
                <a href="#" class="type-dropdown-menu">Blind Bag Toys</a>
                <a href="#" class="type-dropdown-menu">Building Sets & Blocks</a>
                <a href="#" class="type-dropdown-menu">Games, Puzzles & Cards</a>
                <a href="#" class="type-dropdown-menu">Kids' Arts & Crafts</a>
                <a href="#" class="type-dropdown-menu">Vehicles & Remote Control Toys</a>
              </div>
            </li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu item-menu-down">TOYS BY AGES<i
                  class="fas fa-sort-down icon-down"></i></a>
              <div class="dropdown-menu">
                <a href="#" class="type-dropdown-menu">0 to 2 Years </a>
                <a href="#" class="type-dropdown-menu">3 to 4 Years </a>
                <a href="#" class="type-dropdown-menu">5 to 7 Years </a>
                <a href="#" class="type-dropdown-menu">8 to 11 Years </a>
                <a href="#" class="type-dropdown-menu">12 Years & up </a>
              </div>
            </li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu">ORIGINAL BABY</a></li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu item-menu-down">TOY BY CHARACTER<i
                  class="fas fa-sort-down icon-down"></i></a>
              <div class="dropdown-menu">
                <a href="#" class="type-dropdown-menu">Captain Marvel</a>
                <a href="#" class="type-dropdown-menu">How to Train Your Dragon</a>
                <a href="#" class="type-dropdown-menu">Star Wars Toys</a>
                <a href="#" class="type-dropdown-menu">Disney Princess Dolls</a>
                <a href="#" class="type-dropdown-menu">Jurassic World Toys</a>
              </div>
            </li>
            <li class="item-menu item-menu-action" id="item-faq"><a href="#" class="type-item-menu">FAQ</a></li>
            <li class="item-menu item-menu-action" id="item-contact"><a href="#" class="type-item-menu">CONTACT</a></li>
            <li class="item-menu item-menu-action" id="item-blog"><a href="#" class="type-item-menu">BLOG</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
  <footer class="page-footer">
    <div class="contailner">
      <ul class="navigation-footer uppercase">
        <li class="column">
          <h3>About us</h3>
          <ul class="column-item">
            <li><a href="#">About Shoptoy.cf</a></li>
            <li><a href="#">Site Map</a></li>
            <li><a href="#">Friendly Links</a></li>
          </ul>
        </li>
        <li class="column">
          <h3>Featured Service</h3>
          <ul class="column-item">
            <li><a href="#">Trade Resources</a></li>
            <li><a href="#">Logistics Partners</a></li>
            <li><a href="#">Import & Export Service</a></li>
          </ul>
        </li>
        <li class="column">
          <h3>Help</h3>
          <ul class="column-item">
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Submit a Complaint</a></li>
          </ul>
        </li>
        <li class="column">
          <h3>Social connection</h3>
          <ul class="column-item">
            <li>
              <img src="images/facebook-24.png" alt="Facebook">
              <a href="#"><span>Facebook</span></a>
            </li>
            <li>
              <img src="images/google_plus-24.png" alt="Google+">
              <a href="#"><span>Google+</span></a>
            </li>
            <li>
              <img src="images/youtube-24.png" alt="Youtube">
              <a href="#"><span>Youtube</span></a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="copyright-design">
      <div class="contailner">
        <div class="border-copyright-design">
          <p class="txt-copyright">@ 2018 - COPYRIGHT OF SHOPTOY</p>
          <p class="txt-design">DESIGN BY <a href="#" title="">DD.com</a></p>
        </div>
      </div>
    </div>
    <?php echo $html_contact ?>
  </footer>
  <?php echo $html_sign_up_in ?>

  <script src="js/js-cart.js"></script>
  <script>
    var containerUser = document.getElementsByClassName("container-user")[0];
    var userDropDown = document.getElementsByClassName("drop-down-user")[0];

    document.addEventListener("click", (evt) => {
      const flyoutElement = document.getElementsByClassName("container-user")[0];
      let targetElement = evt.target;
      do {
          if (targetElement == flyoutElement) {
            if (userDropDown.style.display == "none") {
              userDropDown.style.display = "block";
            } else {
              userDropDown.style.display = "none";
            }
            return;
          }
          targetElement = targetElement.parentNode;
      } while (targetElement);
      userDropDown.style.display = "none";
    });
    function confirmRemove() {
        return confirm("Bạn có chắc muốn hủy đơn hàng này ?");
    }
    document.getElementsByClassName("tablinks-ordered")[0].addEventListener("click", function(event){
      openCity(event, 'ordered');
    });
    document.getElementsByClassName("tablinks-ordered-removed")[0].addEventListener("click", function(event){
      openCity(event, 'order-removed')
    });
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    document.getElementById("defaultOpen").click();

  </script>
</body>

</html>