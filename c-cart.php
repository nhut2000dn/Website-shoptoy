<?php
  session_start();
  $db_handle = new DBController();
  static $productByCode;
  static $itemArray;
  if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
      case "add":
        static $quantily = 1;
        if(isset($quantily)) {
          $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE url_name_pd='" . $_GET["name"] . "'");
          $img_pd     = $productByCode[0]["image_pd"];
          $pieces_img = explode(",", $img_pd);
          $itemArray  = array($productByCode[0]["url_name_pd"]=>array('name_pd'=>$productByCode[0]["name_pd"], 'url_name_pd'=>$productByCode[0]["url_name_pd"], 'id'=>$productByCode[0]["id"], 'image'=>$productByCode[0]["image_pd"], 'quantity'=>$quantily, 'price_pd'=>$productByCode[0]["price_pd"], 'image_pd'=>$pieces_img[0]));
          if(!empty($_SESSION["cart_item"])) {
            if(in_array($productByCode[0]["url_name_pd"],array_keys($_SESSION["cart_item"]))) {
              foreach($_SESSION["cart_item"] as $k => $v) {
                  if($productByCode[0]["url_name_pd"] == $k) {
                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                      $_SESSION["cart_item"][$k]["quantity"] = 1;
                    }
                    $_SESSION["cart_item"][$k]["quantity"] += $quantily;
                  }
              }
            } else {
              $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
              // print_r($itemArray);
            }
          } else {
            $_SESSION["cart_item"] = $itemArray;
            // print_r($itemArray);
          }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      break;
      case "subtract":
        static $quantily = 1;
        if(isset($quantily)) {
          $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE url_name_pd='" . $_GET["name"] . "'");
          $img_pd     = $productByCode[0]["url_name_pd"];
          $pieces_img = explode(",", $img_pd);
          $itemArray  = array($productByCode[0]["url_name_pd"]=>array('name_pd'=>$productByCode[0]["name_pd"], 'url_name_pd'=>$productByCode[0]["url_name_pd"], 'id'=>$productByCode[0]["id"], 'image'=>$productByCode[0]["image_pd"], 'quantity'=>$quantily, 'price_pd'=>$productByCode[0]["price_pd"], 'image_pd'=>$pieces_img[0]));
          if(!empty($_SESSION["cart_item"])) {
            if(in_array($productByCode[0]["url_name_pd"],array_keys($_SESSION["cart_item"]))) {
              foreach($_SESSION["cart_item"] as $k => $v) {
                  if($productByCode[0]["url_name_pd"] == $k) {
                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                      $_SESSION["cart_item"][$k]["quantity"] = 1;
                    }
                    if ( $_SESSION["cart_item"][$k]["quantity"] == 1) {
                      $_SESSION["cart_item"][$k]["quantity"] = $quantily;
                    } else {
                      $_SESSION["cart_item"][$k]["quantity"] -= $quantily;
                    }
                  }
              }
            } else {
              $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
              // print_r($itemArray);
            }
          } else {
            $_SESSION["cart_item"] = $itemArray;
            // print_r($itemArray);
          }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      break;
      case "remove":
        if(!empty($_SESSION["cart_item"])) {
          foreach($_SESSION["cart_item"] as $k => $v) {
              if($_GET["name"] == $k)
                unset($_SESSION["cart_item"][$k]);				
              if(empty($_SESSION["cart_item"]))
                unset($_SESSION["cart_item"]);
          }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      break;
      case "empty":
        unset($_SESSION["cart_item"]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      break;	
    }
  }
  //////////////////////////////////////////////////////////////////////
  if(isset($_SESSION["cart_item"])) {
    $amount_cart = 0;
    $total_quantity = 0;
    $total_price = 0;
    foreach ($_SESSION["cart_item"] as $item) {
      $item_price = $item["quantity"]*$item["price_pd"];
      $total_quantity += $item["quantity"];
      $total_price += ($item["price_pd"]*$item["quantity"]);
      $amount_cart++;

      $html_cart.='<div class="item-toy-cart">';
        $html_cart.='<div class="box-img">';
          $html_cart.='<img src="images/'.$item["image_pd"].'" alt="" class="img-toy"><span style="font-size: 1.2em; color: #f9eedf;margin-top: 1.1em;float: left;">x'.$item["quantity"].'</span>';
        $html_cart.='</div>';
        $html_cart.='<div class="item-price-cart">';
          $html_cart.='<div class="box-price-cart">';
            $html_cart.='<span>Cart Item</span><br>';
            $html_cart.='<span class="price-add-cart">$'.$item["price_pd"].'</span>';
          $html_cart.='</div>';
        $html_cart.='</div>';
        $html_cart.='<div class="box-btn-cart">';
          $html_cart.='<div class="box-delete">';
            $html_cart.='<a href="'.basename($_SERVER['PHP_SELF']).'?action=remove&name='.$item["url_name_pd"].'" class="btnRemoveAction">';
              $html_cart.='<i class="fas fa-trash btn-delete"></i>';
            $html_cart.='</a>';
          $html_cart.='</div>';
        $html_cart.='</div>';
      $html_cart.='</div>';
    }
    $html_cart.='<div class="box-action-cart" style="display: block;">';
    $html_cart.='<a  href="'.basename($_SERVER['PHP_SELF']).'?action=empty"><button class="delete-all-cart">Clear Cart</button></a>';
    $html_cart.='<a href="cart.php">';
    $html_cart.='<button class="view-details-cart">Checkout</button>';
    $html_cart.='</a>';
    $html_cart.='</div>';
  }
  /////////////////////////////////////////////////////////////////////
  if(isset($_SESSION["cart_item"])) {
    $amount_cart = 0;
    $total_quantity = 0;
    $total_price = 0;
    foreach ($_SESSION["cart_item"] as $item) {
      $item_price = $item["quantity"]*$item["price_pd"];
      $total_quantity += $item["quantity"];
      $total_price += ($item["price_pd"]*$item["quantity"]);
      $amount_cart++;

      $hmtl_page_cart.='<form method="post" action="'.basename($_SERVER['PHP_SELF']).'">';
        $html_page_cart.='<div class="main-cart">';
          $html_page_cart.='<div class="box-img-cart">';
            $html_page_cart.='<img src="images/'.$item["image_pd"].'" alt="" class="img-cart">';
          $html_page_cart.='</div>';
          $html_page_cart.='<div class="box-informtion-cart">';
            $html_page_cart.='<p class="name-product-cart">'.$item["name_pd"].'</p>';
            $html_page_cart.='<a href="'.basename($_SERVER['PHP_SELF']).'?action=remove&name='.$item["url_name_pd"].'"><p class="remove-cart">Xóa</p></a>';
          $html_page_cart.='</div>';
          $html_page_cart.='<div class="box-main-price-cart">';
            $html_page_cart.='<p class="price-cart">$'.$item["price_pd"].'</p>';
          $html_page_cart.='</div>';
          $html_page_cart.='<div class="box-quantily">';
            $html_page_cart.='<a href="'.basename($_SERVER['PHP_SELF']).'?action=subtract&name='.$item["url_name_pd"].'" class="button-subtract">-</a><input type="" name="" value="'.$item["quantity"].'" class="quantily-product"><a href="'.basename($_SERVER['PHP_SELF']).'?action=add&name='.$item["url_name_pd"].'" class="button-add">+</a>';
          $html_page_cart.='</div>';
        $html_page_cart.='</div>';
      $hmtl_page_cart.='</form>';
    }
  }
?>