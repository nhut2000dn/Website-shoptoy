<?php
  include("connect.php");
  include("c-cart.php");
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
  if (!isset($_GET["id"])) {
    header ("location:toys.php");
  }
  $id_toys = $_GET["id"];
  // $query_select_product = 'SELECT * FROM product, pd_species WHERE product.id = '.$id_toys.' AND product.species_pd = pd_species.id';
  $query_select_product = 'SELECT * FROM product, pd_species, pd_recommended_age, pd_ideal_for, pd_material 
    WHERE product.material_pd = pd_material.id AND product.recommended_age = pd_recommended_age.id AND product.ideal_for = pd_ideal_for.id 
    AND product.species_pd = pd_species.id AND product.id = '.$id_toys.'';
  $result_select_product= mysqli_query($connection,$query_select_product) or die ("loi".mysqli_error($connection));
  $row_product=mysqli_fetch_array($result_select_product,MYSQLI_ASSOC);

  $name_pd         = $row_product["name_pd"];
  $url_name_pd         = $row_product["url_name_pd"];
  $describe_pd     = $row_product["describe_pd"];
  $material_pd     = $row_product["name_material"];
  $recommended_age = $row_product["name_r_age"];
  $ideal_for       = $row_product["name_ideal_for"];
  $style_pd        = 'Education Toys';
  $amount_pd       = $row_product["amount_pd"];
  $price_pd        = $row_product["price_pd"];
  $species_pd      = $row_product["name_species"];
  $species_pd_number     = $row_product["species_pd"];

  $img_pd_main          = $row_product["image_pd"];
  $pieces_img = explode(",", $img_pd_main);
  for ($i = 0; $i < count($pieces_img); $i++) {
    $file_img = 'images/'.$pieces_img[$i];
    if (file_exists($file_img)) {
      static $count_img = 0;
      $count_img++;
      $html_img_main.='<div class="image detail-view mySlides" style="background-image: url(images/'.$pieces_img[$i].');"></div>';
      $html_img_change.='<div class="box-click">';
      $html_img_change.='<img class="mySlides-click" src="images/'.$pieces_img[$i].'" data-id="'.$count_img.'">';
      $html_img_change.='</div>';
    } else {
    }
  }
  //////////////////////////////////////////////////////////////
  $query_check  = 'SELECT @add_row:=@add_row+1 AS row_number, id, name_pd, image_pd, describe_pd, Material_pd, amount_pd, price_pd, species_pd  
    FROM product, (SELECT @add_row:=0)A 
    WHERE species_pd = '.$species_pd_number.' AND id !='.$id_toys.' ORDER BY rand()';
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    if ($row["row_number"] > 0 && $row["row_number"] <= 15) {
      $img_pd          = $row["image_pd"];
      $pieces_img = explode(",", $img_pd);

      $html_toys_suggest.='<div class="box-product-suggest">';
      $html_toys_suggest.='<a href="product-details.php?id='.$row["id"].'">';
      $html_toys_suggest.='<div class="product-suggest-img">';
      $html_toys_suggest.='<div class="img-hover-zoom">';
      $html_toys_suggest.='<img src="images/'.$pieces_img[0].'" alt="" class="product-suggest">';
      $html_toys_suggest.='</div>';
      $html_toys_suggest.='</div>';
      $html_toys_suggest.='<div class="product-suggest-information">';
      $html_toys_suggest.='<p class="name-product-suggest">'.$row["name_pd"].'</p>';
      $html_toys_suggest.='<p class="price-product-suggest">$'.$row["price_pd"].'</p>';
      $html_toys_suggest.='</div>';
      $html_toys_suggest.='</a>';
      $html_toys_suggest.='</div>';
    }
  }
  //////////////////////////////////////////////////////////////
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
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-comment-toys"])) {
    if ($check_login == true) {
      if (strlen($_POST["txt-comment-toys"]) == 0) {
        $html_error.='<ul class="error-list">';
        $html_error.='<li>Xin vui lòng nhập nội dung bình luận!</li>';
        $html_error.='</ul>';
        echo "<script type='text/javascript'>alert('Xin vui lòng nhập nội dung bình luận!');</script>";
      } else {
        $date = date('Y/m/d h:i:s', time());
        $txt_comment_toys = $_POST["txt-comment-toys"];
        $queryInsert = "INSERT INTO `pd_comments` (`id`, `id_pd`, `id_account`, `comment_content`, `date`, `status`) VALUES (NULL,
          '$id_toys', '$id_account', '$txt_comment_toys', '$date', '0');";
        $result   = mysqli_query($connection,$queryInsert)or die("loi cap nhat".mysqli_error($con));
        if($result) {
          echo "<script type='text/javascript'>alert('Bình Luận Thành Công!');</script>";
          echo'<meta http-equiv="refresh" content="0; url=product-details.php?id='.$id_toys.'" />';
        }
      }
    } else {
      echo "<script type='text/javascript'>alert('Xin vui lòng đăng nhập để bình luận đồ chơi này!');</script>";
    }
  }
  ////////////////////////////////////////////////////////////
  $query_select_comment = "SELECT first_name, last_name, id_pd, id_account, comment_content, shop_toy.pd_comments.date , shop_toy.account.id AS account_id
    FROM shop_toy.pd_comments, shop_toy.account
    WHERE pd_comments.id_account = shop_toy.account.id AND id_pd = $id_toys ORDER BY shop_toy.pd_comments.date DESC;";
  $result_select_comment = mysqli_query($connection,$query_select_comment) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_select_comment,MYSQLI_ASSOC)) {
    $ho_va_ten = $row["first_name"] . ' ' .$row["last_name"];
    $comment_content = $row["comment_content"];
    $date_comment = $row["date"];
    $html_comment.='<div class="box-user-comment">';
    $html_comment.='<p class="txt-name-user"><span>Bởi : </span>'.$ho_va_ten.'</p>';
    $html_comment.='<p class="txt-comment">-'.$comment_content.'</p>';
    $html_comment.='<p class="date-time-comment">Đã bình luận lúc: '.$date_comment.'</p>';
    $html_comment.='</div>';
  }
  ////////////////////////////////////////////////////////////
  if (isset($_POST["btn-send-message"])) {
    $email_contact = $_POST["email-contact"];
    $content_contact = $_POST["content-contact"];
    $query_insert_contact = "INSERT INTO `contact` (id, email_contact, content_message, status) VALUES (NULL,
      '$email_contact', '$content_contact', '0');";
      echo $query_insert_contact;
    $result_insert_contact  = mysqli_query($connection,$query_insert_contact)or die("loi cap nhat".mysqli_error($con));
    if ($result_insert_contact) {
      echo "<script type='text/javascript'>alert('Gửi tin nhắn cho admin thành công!');</script>";
      echo'<meta http-equiv="refresh" content="0; url=product-details.php?id='.$id_toys.'" />';
    }
  }
  ////////////////////////////////////////////////////////////
  $query_check  = 'SELECT @add_row:=@add_row+1 AS row_number, id, name_pd, image_pd, describe_pd, Material_pd, amount_pd, price_pd, species_pd  
    FROM product, (SELECT @add_row:=0)A 
    WHERE id !='.$id_toys.' ORDER BY rand()';
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    if ($row["row_number"] > 0 && $row["row_number"] <= 20) {
      $img_pd          = $row["image_pd"];
      $pieces_img = explode(",", $img_pd);

      $html_toys_view.='<a href="product-details.php?id='.$row["id"].'">';
      $html_toys_view.='<div class="box-img-left">';
      $html_toys_view.='<div class="img-hover-zoom img-padding">';
      $html_toys_view.='<img src="images/'.$pieces_img[0].'" alt="" class="product-left">';
      $html_toys_view.='</div>';
      $html_toys_view.='<div class="box-information-left">';
      $html_toys_view.='<h1 class="name-product-left">'.$row["name_pd"].'</h1>';
      $html_toys_view.='<p class="price-product-left">$'.$row["price_pd"].'</p>';
      $html_toys_view.='</div>';
      $html_toys_view.='</div>';
      $html_toys_view.='</a>';
    }
  }
  //////////////////////////////////////////////////////////////
  if(isset($_SESSION["cart_item"])) {
    $amount_cart = 0;
    $total_quantity = 0;
    $total_price = 0;
    foreach ($_SESSION["cart_item"] as $item) {
      $item_price = $item["quantity"]*$item["price_pd"];
      $total_quantity += $item["quantity"];
      $total_price += ($item["price_pd"]*$item["quantity"]);
      $amount_cart++;

      $html_cart_details.='<div class="item-toy-cart">';
        $html_cart_details.='<div class="box-img">';
          $html_cart_details.='<img src="images/'.$item["image_pd"].'" alt="" class="img-toy"><span style="font-size: 1.2em; color: #f9eedf;margin-top: 1.1em;float: left;">x'.$item["quantity"].'</span>';
        $html_cart_details.='</div>';
        $html_cart_details.='<div class="item-price-cart">';
          $html_cart_details.='<div class="box-price-cart">';
            $html_cart_details.='<span>Cart Item</span><br>';
            $html_cart_details.='<span class="price-add-cart">$'.$item["price_pd"].'</span>';
          $html_cart_details.='</div>';
        $html_cart_details.='</div>';
        $html_cart_details.='<div class="box-btn-cart">';
          $html_cart_details.='<div class="box-delete">';
            $html_cart_details.='<a href="'.basename($_SERVER['PHP_SELF']).'?id='.$id_toys.'&action=remove&image='.$item["image"].'" class="btnRemoveAction">';
              $html_cart_details.='<i class="fas fa-trash btn-delete"></i>';
            $html_cart_details.='</a>';
          $html_cart_details.='</div>';
        $html_cart_details.='</div>';
      $html_cart_details.='</div>';
    }
    $html_cart_details.='<div class="box-action-cart" style="display: block;">';
    $html_cart_details.='<a  href="'.basename($_SERVER['PHP_SELF']).'?id='.$id_toys.'&action=empty"><button class="delete-all-cart">Clear Cart</button></a>';
    $html_cart_details.='<a href="cart.php">';
    $html_cart_details.='<button class="view-details-cart">Checkout</button>';
    $html_cart_details.='</a>';
    $html_cart_details.='</div>';
  }
  ////////////////////////////////////////////////////////////////////////////
  if (isset($_POST["btn-buy"])) {
    static $quantily = 1;
    if(isset($quantily)) {
      $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE image_pd='" . $img_pd_main . "'");
      $img_pd     = $productByCode[0]["image_pd"];
      $pieces_img = explode(",", $img_pd);
      $itemArray  = array($productByCode[0]["image_pd"]=>array('name_pd'=>$productByCode[0]["name_pd"], 'id'=>$productByCode[0]["id"], 'image'=>$productByCode[0]["image_pd"], 'quantity'=>$quantily, 'price_pd'=>$productByCode[0]["price_pd"], 'image_pd'=>$pieces_img[0]));
      if(!empty($_SESSION["cart_item"])) {
        if(in_array($productByCode[0]["image_pd"],array_keys($_SESSION["cart_item"]))) {
          foreach($_SESSION["cart_item"] as $k => $v) {
              if($productByCode[0]["image_pd"] == $k) {
                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                  $_SESSION["cart_item"][$k]["quantity"] = 1;
                  header ("location:cart.php?buy");
                } else {
                  header ("location:cart.php?buy");
                }
              }
          }
        } else {
          $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
          header ("location:cart.php?buy");
          // print_r($itemArray);
        }
      } else {
        $_SESSION["cart_item"] = $itemArray;
        header ("location:cart.php?buy");
        // print_r($itemArray);
      }
    }
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
  <link rel="stylesheet" href="css/css-products-details.css">
  <link rel="stylesheet" href="css/mycss.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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
            item(s)-$<span class="price-cart"><?php if (isset($total_price)) echo $total_price; else echo '0.00' ?></span></span>
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
          <a href="cart.php">
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
  <main class="page-main-details">
    <div class="main-left-details">
      <div class="main-details">
        <div class="main-left">
          <div class="box-img-toy">
            <div class="box-image-container">
              <div class="image-container">
                <?php echo $html_img_main ?>
              </div>
            </div>
            <div class="box-click-slides">
              <?php echo $html_img_change ?>
            </div>
          </div>
        </div>
        <div class="main-right">
          <div class="box-titel">
            <h1 class="txt-titel"><?php echo $name_pd ?></h1>
          </div>
          <div class="box-price">
            <h2 class="price">$<?php echo $price_pd ?></h2>
          </div>
          <div class="box-information">
            <div class="box-information">
              <table>
                <tbody class="">
                  <tr>
                    <th class="th-label">Port:</th>
                    <td class="td-content">Đà Nẵng, Việt Nam </td>
                  </tr>
                  <tr>
                    <th class="th-label">Production Capacity:</th>
                    <td class="td-content">500000</td>
                  </tr>
                  <tr>
                    <th class="th-label">Payment Terms:</th>
                    <td class="td-content">L/C, T/T</td>
                </tbody>
              </table>
              <p class="boder-bottom"></p>
              <table>
                <tbody class="">
                  <tr>
                    <th class="th-label">Type:</th>
                    <td class="td-content"><?php echo $species_pd ?></td>
                  </tr>
                  <tr>
                    <th class="th-label">Age:</th>
                    <td class="td-content"> <?php echo $recommended_age ?> </td>
                  </tr>
                  <tr>
                    <th class="th-label">Material:</th>
                    <td class="td-content"><?php echo $material_pd ?></td>
                  </tr>
                  <tr>
                    <th class="th-label">Toy Department:</th>
                    <td class="td-content"> <?php echo $ideal_for ?> </td>
                  </tr>
                  <tr>
                    <th class="th-label">Style:</th>
                    <td class="td-content"> <?php echo $style_pd ?> </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <form method="post" action="product-details.php?id=<?php echo $id_toys ?>&action=add&name=<?php echo $url_name_pd ?>">
              <div class="box-add-cart">
                <input type="submit" value="ADD TO CART" class="txt-add-cart" />
              </div>
            </form>
            <form method="post" action="product-details.php?id=<?php echo $id_toys ?>">
              <div class="box-buy-now">
                <input name="btn-buy" type="submit" class="buy-now" value="BUY NOW">
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="main-left-description">
        <div class="tab">
          <button class="tablinks active" data="description">Product Description</button>
          <button class="tablinks" data="Shipping">Shipping & Returns</button>
          <button class="tablinks" data="Questions">Questions and Answers</button>
        </div>
        <div id="description" class="tabcontent" style="display: block;">
          <p class="information-description">
            <?php echo $describe_pd ?>
          </p>
          <!-- <ul class="information-description">
            <li>Ready to run, full function 1:15 scale RC</li>
            <li>Features forward, backward, left and right motions</li>
            <li>250 ft driving range, charges using USB</li>
            <li>For ages 4 and up</li>
          </ul> -->
        </div>
        <div id="Shipping" class="tabcontent">
          <h1 class="txt-shipping">Shipping details</h1>
          <p class="information-description txt-london">
            <ul class="information-return">
              <li>estimated ship dimensions: 2.5 inches length x 4.0 inches width x 11.0 inches height</li>
              <li>estimated ship weight: 0.8 pounds</li>
              <li>We regret that this item cannot be shipped to PO Boxes.</li>
            </ul>
          </p>
          <h1 class="txt-return">Return details</h1>
          <p class="information-description txt-london">
            <ul class="information-shipping">
              <li>This item can be returned to any Target store or Target.com.</li>
              <li>This item must be returned within 90 days of the ship date. See return policy for details.</li>
              <li>See the return policy for complete information.</li>
            </ul>
          </p>
        </div>
        <form action="<?php echo "product-details.php?id=$id_toys" ?>" method="post">
          <div id="Questions" class="tabcontent">
            <input name="txt-comment-toys" type="text" placeholder="Enter your question about this product" class="input-question"  required>
            <?php echo $html_error ?>
            <button name="btn-comment-toys" class="btn-send">Send</button>
          </div>
        </form>
      </div>

      <div class="main-left-send">
        <div class="box-send">
          <h1 class="txt-send">Send your message to this supplier</h1>
        </div>
        <form action="<?php echo "product-details.php?id=$id_toys" ?>" method="post">
          <div class="box-send-msg">
            <div>
              <label><span class="star">* </span>From:</label>
              <input name="email-contact" type="email" placeholder="Enter your email address" class="input-email"  required>
            </div>
            <div class="box-send-to">
              <label><span class="star">* </span>To:</label>
              <label class="txt-admin">Admin</label>
            </div>
            <div class="box-textarea-message">
              <label class="txt-Message"><span class="star">* </span>Message:</label>
              <textarea name="content-contact" class="textarea-message" name="" id="" cols="90" rows="10" required
                placeholder="We suggest you detail your product requirements and company information here."></textarea>
            </div>
            <div class="box-btn-send">
              <button name="btn-send-message" class="btn-send send">Send</button>
            </div>
          </div>          
        </form>
      </div>

      <div class="main-left-comment">
        <div class="box-titel-comment">
          <h1 class="txt-titel-comment"><span>Bình Luận về : </span><?php echo $name_pd ?></h1>
        </div>
        <?php echo $html_comment ?>
      </div>
      <div class="main-left-product">
        <div class="box-titel-product">
          <h1 class="txt-titel-product">People who viewed this also viewed</h1>
        </div>
        <div class="bar-display-product">
          <?php echo $html_toys_view ?>
        </div>
        <div class="box-btn-view box-btn-left">
          <button class="btn-left-view"><i class="fas fa-chevron-left"></i></button>
        </div>        
        <div class="box-btn-view box-btn-right">
          <button class="btn-right-view"><i class="fas fa-chevron-right"></i></button>
        </div>
      </div>
    </div>
    <div class="main-suggest-products">
      <div class="box-suggest-products">
        <div class="box-titel-suggest">
          <p class="txt-titel-suggest">You Might Also Like</p>
        </div>
        <?php echo $html_toys_suggest ?>
      </div>

      <div class="box-btn-see-more">
          <p class="btn-see-more"><i class="fas fa-chevron-down"></i> See More Toys</p>
          <p class="btn-hidden" style="display: none;"><i class="fas fa-chevron-up"></i> hidden Toys</p>
      </div>
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
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu item-menu-down">TOYS BY
                TYPE<i class="fas fa-sort-down icon-down"></i></a>
              <div class="dropdown-menu">
                <a href="#" class="type-dropdown-menu">Action Figures</a>
                <a href="#" class="type-dropdown-menu">Blind Bag Toys</a>
                <a href="#" class="type-dropdown-menu">Building Sets & Blocks</a>
                <a href="#" class="type-dropdown-menu">Games, Puzzles & Cards</a>
                <a href="#" class="type-dropdown-menu">Kids' Arts & Crafts</a>
                <a href="#" class="type-dropdown-menu">Vehicles & Remote Control Toys</a>
              </div>
            </li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu item-menu-down">TOYS BY
                AGES<i class="fas fa-sort-down icon-down"></i></a>
              <div class="dropdown-menu">
                <a href="#" class="type-dropdown-menu">0 to 2 Years </a>
                <a href="#" class="type-dropdown-menu">3 to 4 Years </a>
                <a href="#" class="type-dropdown-menu">5 to 7 Years </a>
                <a href="#" class="type-dropdown-menu">8 to 11 Years </a>
                <a href="#" class="type-dropdown-menu">12 Years & up </a>
              </div>
            </li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu">ORIGINAL BABY</a></li>
            <li class="item-menu item-menu-action"><a href="#" class="type-item-menu item-menu-down">TOY BY
                CHARACTER<i class="fas fa-sort-down icon-down"></i></a>
              <div class="dropdown-menu">
                <a href="#" class="type-dropdown-menu">Captain Marvel</a>
                <a href="#" class="type-dropdown-menu">How to Train Your Dragon</a>
                <a href="#" class="type-dropdown-menu">Star Wars Toys</a>
                <a href="#" class="type-dropdown-menu">Disney Princess Dolls</a>
                <a href="#" class="type-dropdown-menu">Jurassic World Toys</a>
              </div>
            </li>
            <li class="item-menu item-menu-action" id="item-faq"><a href="#" class="type-item-menu">FAQ</a>
            </li>
            <li class="item-menu item-menu-action" id="item-contact"><a href="#" class="type-item-menu">CONTACT</a></li>
            <li class="item-menu item-menu-action" id="item-blog"><a href="#" class="type-item-menu">BLOG</a></li>
            <li class="item-menu item-menu-action" id="item-blog"><a href="sign-up-in.php" class="type-item-menu">Sign Up/Sign In</a></li>
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
  <!-- include javascript -->
  <script src="js/js-products-details.js">
  </script>
  <script>
    var containerUser = document.getElementsByClassName("container-user")[0];
    var userDropDown = document.getElementsByClassName("drop-down-user")[0];
    containerUser.addEventListener("click", function(){
      if (userDropDown.style.display == "none") {
        userDropDown.style.display = "block";
      } else {
        userDropDown.style.display = "none";
      }
    });
  </script>
</body>

</html>