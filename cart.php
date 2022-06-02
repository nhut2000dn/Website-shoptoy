<?php
  include "connect.php";
  session_start();
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
    $check_login = true;
  } else {
    $check_login = false;
  }
  if (isset($_POST["btn-order"])) {
    if ($check_login == true) {
      header ("location:cart.php?order");
    } else {
      header ("location:cart.php?sign-in");
    }
  }
  //////////////////////////////////////////////////////////////////
  if (isset($_GET["buy"])) {
    if ($check_login == true) {
      header ("location:cart.php?order");
    } else {
      header ("location:cart.php?sign-in");
    }
  }
  //////////////////////////////////////////////////////////////////
  if (isset($_GET["sign-in"])) {
    $html_sign_up_in.='<form id="form-sign-in" action="cart.php?sign-in" method="post">';
      $html_sign_up_in.='<div name="view"  class="view" id="view">';
        $html_sign_up_in.='<div class="modal__content">';
          $html_sign_up_in.='<a href="cart.php" class="modal__close">&times;</a>';
          $html_sign_up_in.='<h1 class="title-sign">Sign in</h1>';
          $html_sign_up_in.='<input value = "'.$email.'" class="input-user-name" type="text" name="email-sign-in" placeholder="username or email">';
          $html_sign_up_in.='<div class="error-emails"></div>';
          $html_sign_up_in.='<input value = "'.$passwordPost.'" class="input-password" type="password" name="password-sign-in" placeholder="your password">';
          $html_sign_up_in.='<div class="error-passwords"></div>';
          $html_sign_up_in.='<div class="container-btn-login">';
            $html_sign_up_in.='<button id="btn-sign-in" name="btn-sign-in" class="login100-form-btn" type="submit">Sign In</button>';
          $html_sign_up_in.='</div>';
          $html_sign_up_in.='<div class="error-sign-ins"></div>';
          $html_sign_up_in.='<div class="container-sign-up">';
            $html_sign_up_in.='<a href="cart.php?sign-up" class="sign-in">sign up</a>';
          $html_sign_up_in.='</div>';
        $html_sign_up_in.='</div>';
      $html_sign_up_in.='</div>';
    $html_sign_up_in.='</form>';
  }
  ////////////////////////////////////////////////////////////////////
  if (isset($_GET["sign-up"])) {
    $html_sign_up_in.='<form id="sign-up-form" action="cart.php?sign-up" method="post">';
      $html_sign_up_in.='<div name="view"  class="view" id="view">';
        $html_sign_up_in.='<div class="modal__content">';
          $html_sign_up_in.='<a href="cart.php" class="modal__close">&times;</a>';
          $html_sign_up_in.='<h1 class="title-sign">Sign up</h1>';

          $html_sign_up_in.='<input type="text" name="firstname" value="'.$_POST["firstname"].'" placeholder="Firstname" class="form-sign-up-in">';
          $html_sign_up_in.='<div class="error-firstname"></div>';
          $html_sign_up_in.='<input type="text" name="lastname" value="'.$_POST["lastname"].'" placeholder="Lastname" class="form-sign-up-in">';
          $html_sign_up_in.='<div class="error-lastname"></div>';
          $html_sign_up_in.='<input type="text" name="email" value="'.$_POST["email"].'" placeholder="Email" class="form-sign-up-in">';
          $html_sign_up_in.='<div class="error-email"></div>';
          $html_sign_up_in.='<input type="text" name="password" value="'.$_POST["password"].'" placeholder="Password" class="form-sign-up-in">';
          $html_sign_up_in.='<div class="error-password"></div>';
          $html_sign_up_in.='<input type="text" name="confirm-password" value="'.$_POST["confirm-password"].'" placeholder="Confirm Password" class="form-sign-up-in">';
          $html_sign_up_in.='<div class="error-cpassword"></div>';
          $html_sign_up_in.='<select id="gt" name="gioitinh" class="form-sign-up-in">';
              $html_sign_up_in.='<option value="0">Chọn Giới Tính</option>';
              if ($_POST["gioitinh"] == 'Nam') {
                $html_sign_up_in.='<option value="Nam" selected>Nam</option>';
              } else {
                $html_sign_up_in.='<option value="Nam">Nam</option>';
              }
              if ($_POST["gioitinh"] == 'Nữ') {
                $html_sign_up_in.='<option value="Nữ" selected>Nữ</option>';
              } else {
                $html_sign_up_in.='<option value="Nữ">Nữ</option>';
              }
            $html_sign_up_in.='</option>';
          $html_sign_up_in.='</select>';
          $html_sign_up_in.='<div class="error-gt"></div>';
          $html_sign_up_in.='<select id = "sn" name="date" class="form-select">';
            $html_sign_up_in.='<option value"=0">Ngày</option>';
            for ($d = 1; $d <= 31; $d++) {
              if (isset($_POST["date"]) && $_POST["date"]==$d) {
                $html_sign_up_in.='<option value="'.$d.'" selected="selected" >'.$d.'</option>';
              } else {
                $html_sign_up_in.='<option value"='.$d.'">'.$d.'</option>';
              }
            }
          $html_sign_up_in.='</select>';
          $html_sign_up_in.='<select id = "sn" name="month" class="form-select">';
            $html_sign_up_in.='<option value"=0">Tháng</option>';
            for ($m = 1; $m <= 12; $m++) {
              if (isset($_POST["month"]) && $_POST["month"]==$m) {
                $html_sign_up_in.='<option value="'.$m.'" selected="selected" >'.$m.'</option>';
              } else {
                $html_sign_up_in.='<option value"='.$m.'">'.$m.'</option>';
              }
            }
          $html_sign_up_in.='</select>';
          $html_sign_up_in.='<select id = "sn" name="year" class="form-select">';
            $html_sign_up_in.='<option value"=0">Năm</option>';
            for ($y = 1930; $y <= 2019; $y++) {
              if (isset($_POST["year"]) && $_POST["year"]==$y) {
                $html_sign_up_in.='<option value="'.$y.'" selected="selected" >'.$y.'</option>';
              } else {
                $html_sign_up_in.='<option value"='.$y.'">'.$y.'</option>';
              }
            }
          $html_sign_up_in.='</select>';
          $html_sign_up_in.='<div class="error-date-of-birth"></div>';
          $html_sign_up_in.='<div class="container-btn-login">';
            $html_sign_up_in.='<button id="btn-sign-up" name="btn-sign-up" class="login100-form-btn" type="submit">Sign up</button>';
          $html_sign_up_in.='</div>';

          $html_sign_up_in.='<div class="container-sign-up">';
            $html_sign_up_in.='<a href="cart.php?sign-in" class="sign-in">sign in</a>';
          $html_sign_up_in.='</div>';
        $html_sign_up_in.='</div>';
      $html_sign_up_in.='</div>';
    $html_sign_up_in.='</form>';
  }
  ////////////////////////////////////////////////////////////////////
  if (isset($_GET["order"])) {
    $html_order.='<form action="cart.php?order" method="post">';
      $html_order.='<div name="view"  class="view" id="view">';
        $html_order.='<div class="modal__content order">';
          $html_order.='<a href="cart.php" class="modal__close">&times;</a>';
          $html_order.='<h1 class="title-sign">Order</h1>';
          $html_order.='<input value = "'.$_POST["address"].'" class="input-address" type="text" name="address" placeholder="Enter the house number / Road / Ward / District / City">';
          $html_order.=$errorAddress;
          $html_order.='<input value = "'.$_POST["phone-number"].'" class="input-phone-number" type="text" name="phone-number" placeholder="your phone number">';
          $html_order.=$errorPhone;
          $html_order.='<div class="container-btn-login">';
            $html_order.='<button name="btn-order-finish" class="login100-form-btn" type="submit">Order</button>';
          $html_order.='</div>';
        $html_order.='</div>';
      $html_order.='</div>';
    $html_order.='</form>';
  }
  /////////////////////////////////////////////////////////////////////////////
  if (isset($_POST["btn-order-finish"])) {
      $check = true;
      $errorAddress = "";
      $errorPhone = "";
      $address = $_POST["address"];
      $phoneNumber = $_POST["phone-number"];
      if (strlen($address) == 0) {
        $errorAddress.= '<li class="error-sign-in">Vui lòng nhập Địa chỉ !</li>';
        $check = false;
      }
      if (strlen($_POST["phone-number"]) == 0) {
        $errorPhone.= '<li class="error-sign-in">Vui lòng nhập Phone number !</li>';
        $check = false;
      }
      if ($check == true) {
        $query_select = "SELECT MAX(id) FROM shop_toy.order_product";
        $result_select = mysqli_query($connection,$query_select) or die ("loi".mysqli_error($connection));
        while($row=mysqli_fetch_array($result_select,MYSQLI_ASSOC)) {
          $idOrder = ($row["MAX(id)"] + 1);
        }
        $date = date('Y/m/d h:i:s', time());
        $query_insert_order = 'INSERT INTO order_product (id, id_account, created_date, date_of_delivery, address,
          phone_number, pay, status) VALUES ('.$idOrder.', '.$id_account.', "'.$date.'", NULL, "'.$address.'", "'.$phoneNumber.'", "0", "1");';
        $result_insert_order  = mysqli_query($connection,$query_insert_order)or die("loi cap nhat".mysqli_error($con));
        if ($result_insert_order) {
          foreach ($_SESSION["cart_item"] as $item) {
            $query_insert = 'INSERT INTO order_details (id, id_order, id_product, amount, price_product) VALUES (NULL, '.$idOrder.', "'.$item["id"].'", "'.$item["quantity"].'", "'.$item["price_pd"].'");';
            $result_insert  = mysqli_query($connection,$query_insert)or die("loi cap nhat".mysqli_error($con));
            if ($result_insert) {
              unset($_SESSION["cart_item"]);
              header ("location:user-function.php?order");
              echo "<script type='text/javascript'>alert('Order Succesfull');</script>";
            }
          }
        }
      }
  }
  ////////////////////////////////////////////////////////////////
  if (isset($_GET["contact"])) {
    $html_contact.='<form action="'.$_SERVER['REQUEST_URI'].'?contact" method="post">';
      $html_contact.='<div name="view"  class="view" id="view">';
        $html_contact.='<div class="modal__content contact">';
          $html_contact.='<a href="'.basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']).'" class="modal__close">&times;</a>';
          $html_contact.='<h1 class="title-contact">Contact</h1>';
          $html_contact.='<form action="'.$_SERVER['REQUEST_URI'].'?contact" method="post">';
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
  <link rel="stylesheet" href="css/css_cart.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script>
    $( document ).ready(function() {
      $( "#btn-sign-up" ).click(function() {
          var data = $('#sign-up-form').serialize(); // get form data
          $.ajax({
            url:'c-sign-up-in-page.php',
            type:'post',
            data: data,
            success:function(response){
              response = JSON.parse(response);
              if (response['status']) {
                window.location.href = 'cart.php?sign-in';
              } else {
                $('.error-firstname').html(response['errorFirstname']);
                $('.error-lastname').html(response['errorLastname']);
                $('.error-email').html(response['errorEmail']);
                $('.error-password').html(response['errorPassword']);
                $('.error-cpassword').html(response['errorCPassword']);
                $('.error-gt').html(response['errorGT']);
                $('.error-date-of-birth').html(response['errorDateOfBirth']);
              }
            }
          });

          return false;
      });
    });
    ///////////////////////////////////////
    $( document ).ready(function() {
      $( "#btn-sign-in" ).click(function() {
          var data = $('#form-sign-in').serialize(); // get form data
          $.ajax({
            url:'c-sign-in-in-page.php',
            type:'post',
            data: data,
            success:function(response){
              response = JSON.parse(response);
              if (response['status']) {
                window.location.href = 'cart.php?order';
              } else {
                $('.error-sign-ins').html(response['errorSignIn']);
              }
              $('.error-emails').html(response['errorEmail']);
              $('.error-passwords').html(response['errorPassword']);
            }
          });

          return false;
      });
    });
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
      <div class="box-txt-login">
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
                        <li class="item-drop-user"><p class="txt-item-user">Tài khoản của tôi</p></li>
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
        </div>
        <div class="box-cart">
          <i class="fas fa-shopping-cart" id="icon-cart"></i>
          <span class="txt-shopping">SHOPPING</span>
          <span class="txt-item"><span class="amount-cart"><?php if(isset($amount_cart)) { echo $amount_cart;} else echo 0 ?></span>
            item(s)-$<span class="price-cart"><?php if (isset($total_price)) echo $total_price; else echo 0 ?></span></span>
          <i class="fas fa-sort-down" id="icon-down"></i>
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
          <li class="item-menu" id="item-contact"><a href="<?php echo $_SERVER['REQUEST_URI'].'?contact' ?>" class="type-item-menu">CONTACT</a></li>
          <li class="item-menu" id="item-blog"><a href="#" class="type-item-menu">BLOG</a></li>
        </ul>
      </nav>
    </div>
  </menu>

  <main class="page-main-cart">
    <h5 class="title-cart">Your Cart <span class="amount-Cart">(<?php echo $amount_cart ?> product)</span></h5>
    <div class="main-cart-left">
      <!-- <div class="main-cart">
        <div class="box-img-cart">
          <img src="images/product32.jpg" alt="" class="img-cart">
        </div>
        <div class="box-informtion-cart">
          <p class="name-product-cart">GUND Snuffles Teddy Bear Stuffed Animal Plush, White, 10"</p>
          <a href=""><p class="remove-cart">Xóa</p></a>
        </div>
        <div class="box-main-price-cart">
          <p class="price-cart">$200</p>
        </div>
        <div class="box-quantily">
          <button class="button-add" type="button">-</button><input type="" name="" value="1" class="quantily-product"><button class="button-div" type="button">+</button>
        </div>
      </div> -->

      <?php echo $html_page_cart ?>

    </div>
    <div class="main-cart-right">
      <div class="box-total-price">
        <p class="txt-total-price">Total price :</p>
        <p class="total-price"><strong class=""><?php echo $total_price ?>$</strong></p>
        <p class="text-right">
          <small>(Đã bao gồm VAT)</small>
        </p>
      </div>
      <form action="cart.php" method="post">
        <div class="box-btn-order">
          <button name="btn-order" class="btn-order" type="submit">Proceed to order</button>
        </div>
      </form>
    </div>
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
  </footer>
  <?php echo $html_sign_up_in ?>
  <?php echo $html_order ?>
  <?php echo $html_contact ?>


  <!-- include javascript -->
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
  </script>
</body>

</html>