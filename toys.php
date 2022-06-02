<?php
  include ("connect.php");
  include ("c-cart.php");
  session_start();
  $number_view_toys = 12;
  ///////////////////////////////////////////////////////////////////
  function explode_image($image) {
    $img_pd          = $image;
    $pieces_img = explode(",", $img_pd);
    return $pieces_img[0];
  }
  ///////////////////////////////////////////////////////////////////
  function multiexplode ($delimiters,$string) {   
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
  }
  ///////////////////////////////////////////////////////////////////
  if (isset($_POST["btn-sign-out"])) {
    unset($_SESSION["emailUser"]);
    unset($_SESSION["passwordUser"]);
    header("Refresh:0");
  }
  ///////////////////////////////////////////////////////////////////
  if (isset($_POST["btn-search"])) {
    $link_search = 'location:toys.php?search='.$content_search;
    header ($link_search);
    // $content_search = strtolower($_POST["content-search"]);
    // $content_search_main = preg_replace('/\s+/', '-', $content_search);
  }
  //////////////////////////////////////////////////////////////////
  $query_species_pd = 'SELECT pd_species.id AS species_id, name_species, url_name_species FROM pd_species';
  $result_species_pd = mysqli_query($connection,$query_species_pd) or die ("loi".mysqli_error($connection));
  while($row_species_pd=mysqli_fetch_array($result_species_pd,MYSQLI_ASSOC)) {
    $query_product = 'SELECT * FROM product';
    $result_product = mysqli_query($connection,$query_product) or die ("loi".mysqli_error($connection));
    $count_product = mysqli_num_rows($result_product);
    while($row_product=mysqli_fetch_array($result_product,MYSQLI_ASSOC)) {
      if ($row_species_pd["species_id"]==$row_product["species_pd"]) {
        $name_species = $row_species_pd["name_species"];
        $count_species++;
      }
    }
    $html_species.='<a href="toys.php?category='.$row_species_pd["url_name_species"].'"><li class="item-category">'.$name_species.'<span class="amount-item-category">('.$count_species.')</span></li></a>';
    $count_species=0;
    $name_species="";
  }
  $html_species.='<a href="toys.php"><li class="item-category">All Toys<span class="amount-item-category">('.$count_product.')</span></li></a>';
  /////////////////////////////////////////////////////////////////////////////
  if (isset($_GET["category"])) {
    $query_species_name = 'SELECT pd_species.id AS species_id, name_species, url_name_species FROM pd_species WHERE url_name_species ="'.$_GET["category"].'"';
    $result_species_name = mysqli_query($connection,$query_species_name) or die ("loi".mysqli_error($connection));
    $row_species_name=mysqli_fetch_array($result_species_name,MYSQLI_ASSOC);
    $title .= ' <i class="fas fa-chevron-right" style="font-size: 19px; color: #7b98ff;"></i> '.$row_species_name["name_species"];
  }

  if (isset($_GET["recommended-age"])) {
    $query_r_age = 'SELECT * FROM pd_recommended_age WHERE url_name_r_age ="'.$_GET["recommended-age"].'"';
    $result_r_age = mysqli_query($connection,$query_r_age) or die ("loi".mysqli_error($connection));
    $row_r_age=mysqli_fetch_array($result_r_age,MYSQLI_ASSOC);
    $title .=  ' <i class="fas fa-chevron-right" style="font-size: 19px; color: #7b98ff;"></i> '.$row_r_age["name_r_age"];
  }

  if (isset($_GET["ideal-for"])) {
    $query_ideal_for = 'SELECT * FROM pd_ideal_for WHERE url_name_ideal ="'.$_GET["ideal-for"].'"';
    $result_ideal_for = mysqli_query($connection,$query_ideal_for) or die ("loi".mysqli_error($connection));
    $row_ideal_for=mysqli_fetch_array($result_ideal_for,MYSQLI_ASSOC);
    $title .=  ' <i class="fas fa-chevron-right" style="font-size: 19px; color: #7b98ff;"></i> '.$row_ideal_for["name_ideal_for"];
  }

  if (isset($_GET["material"])) {
    $query_material = 'SELECT * FROM pd_material WHERE url_name_material ="'.$_GET["material"].'"';
    $result_material = mysqli_query($connection,$query_material) or die ("loi".mysqli_error($connection));
    $row_material=mysqli_fetch_array($result_material,MYSQLI_ASSOC);
    $title .=  ' <i class="fas fa-chevron-right" style="font-size: 19px; color: #7b98ff;"></i> '.$row_material["name_material"];
  }

  if (isset($title)) {
    $html_title = '<h2>Toys'. $title .' </h2>';
  } else {
    $html_title = '<h2>Toys</h2>';
  }
  //////////////////////////////////////////////////////////////////
  static $sql_query = "SELECT product.id AS pd_id, product.name_pd, product.url_name_pd, product.image_pd, product.material_pd, product.recommended_age, 
      product.ideal_for, product.species_pd, product.price_pd, pd_species.id, pd_species.name_species, pd_species.url_name_species, 
      pd_recommended_age.id, pd_recommended_age.name_r_age, pd_recommended_age.url_name_r_age, pd_ideal_for.id, pd_ideal_for.name_ideal_for, 
      pd_ideal_for.url_name_ideal, pd_material.id, pd_material.name_material, pd_material.url_name_material 
    FROM product, pd_species, pd_recommended_age, pd_ideal_for, pd_material  ";
  $i = 0;
  static $check_get_contact = true;
  static $check_get_page = true;
  static $check_get_c_age = true;
  static $check_get_ideal_for = true;
  static $check_get_material = true;
  if (isset($_GET["page"]) || isset($_GET["category"]) || isset($_GET["search"]) || isset($_GET["ideal-for"]) || isset($_GET["recommended-age"]) || isset($_GET["material"])) {
    $check_get_contact = false;
  }
  if (isset($_GET["category"]) || isset($_GET["search"]) || isset($_GET["ideal-for"]) || isset($_GET["recommended-age"]) || isset($_GET["material"])) {
    $check_get_page = false;
  }
  if (isset($_GET["category"]) || isset($_GET["search"]) || isset($_GET["ideal-for"]) || isset($_GET["material"])) {
    $check_get_c_age = false;
  }
  if (isset($_GET["category"]) || isset($_GET["search"]) || isset($_GET["recommended-age"]) || isset($_GET["material"])) {
    $check_get_ideal_for = false;
  }
  if (isset($_GET["category"]) || isset($_GET["search"]) || isset($_GET["ideal-for"]) || isset($_GET["recommended-age"])) {
    $check_get_material = false;
  }
  $species_pd = $_GET["category"];
  $name_pd = $_GET["search"];
  $ideal_for = $_GET["ideal-for"];
  $recommended_age = $_GET["recommended-age"];
  $material = $_GET["material"];
  $filter_array = array("url_name_species" => "$species_pd", "name_pd" => "$name_pd", "url_name_ideal" => "$ideal_for", "url_name_r_age" => "$recommended_age", "url_name_material" => "$material");
  
  foreach($filter_array as $filter => $filter_value) {
    if( ! $i) {
      $sql_query .= "WHERE ";
    }
    else {
      $sql_query .= " AND ";
    }
    $sql_query .= $filter . " LIKE '%" . $filter_value . "%'";
    
    $i++;       
  }
  $sql_query.=' AND product.material_pd = pd_material.id AND product.recommended_age = pd_recommended_age.id AND product.ideal_for = pd_ideal_for.id 
    AND product.species_pd = pd_species.id';
  /////////////////////////////////////////////////////////////////
  $result_count_product = mysqli_query($connection,$sql_query) or die ("loi".mysqli_error($connection));
  $count_product = mysqli_num_rows($result_count_product);
  if ($check_get_page == true) {
    if (isset($_GET["page"])) {
      $page_current2 = explode("?page=", $_SERVER['REQUEST_URI']);
      $page_current = $page_current2[0].'?page=';
    } else {
      $page_current = $_SERVER['REQUEST_URI'].'?page=';
    }
  } else {
    if (isset($_GET["page"])) {
      $page_current2 = explode("&page=", $_SERVER['REQUEST_URI']);
      $page_current = $page_current2[0].'&page=';
    } else {
      $page_current = $_SERVER['REQUEST_URI'].'&page=';
    }
  }
  ///////////////////////////
  if (isset($page_current2[0])) {
    $page_current_r_age3 = $page_current2[0];
  } else {
    $page_current_r_age3 = $_SERVER['REQUEST_URI'];
  }
  ///////////////////////////
  $array_r_age=array();
  $array_r_age2=array();
  $select_r_age = 'SELECT * FROM pd_recommended_age';
  $i = 0;
  $result_r_age = mysqli_query($connection,$select_r_age) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_r_age,MYSQLI_ASSOC)) {
    array_push($array_r_age, '&recommended-age='.$row["url_name_r_age"]);
    array_push($array_r_age2, '?filter&recommended-age='.$row["url_name_r_age"]);
  }
  ///////////////
  if ($check_get_c_age == true) {
    if (isset($_GET["recommended-age"])) {
      $page_current_r_age4 = multiexplode($array_r_age2,$page_current_r_age3);
      $page_current_r_age5 = $page_current_r_age4[0].$page_current_r_age4[1];


      $page_current_r_age2 = explode("&recommended-age=", $page_current_r_age3);
      $page_current_r_age = $page_current_r_age2[0].'&recommended-age=';
    } else {
      $page_current_r_age = $page_current_r_age3.'?filter&recommended-age=';
    }
  } else {
    if (isset($_GET["recommended-age"])) {
      $page_current_r_age4 = multiexplode($array_r_age,$page_current_r_age3);
      $page_current_r_age5 = $page_current_r_age4[0].$page_current_r_age4[1];


      $page_current_r_age2 = explode("&recommended-age=", $page_current_r_age3);
      $page_current_r_age = $page_current_r_age2[0].'&recommended-age=';
    } else {
      $page_current_r_age5 = $page_current_r_age3;
      $page_current_r_age = $page_current_r_age3.'&recommended-age=';
    }
  }
  ///////////////////////////
  if (isset($page_current2[0])) {
    $page_current_ideal_for3 = $page_current2[0];
  } else {
    $page_current_ideal_for3 = $_SERVER['REQUEST_URI'];
  }
  ///////////////////////////
  $array_ideal_for=array();
  $array_ideal_for2=array();
  $select_ideal_for = 'SELECT * FROM pd_ideal_for';
  $i = 0;
  $result_ideal_for = mysqli_query($connection,$select_ideal_for) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_ideal_for,MYSQLI_ASSOC)) {
    array_push($array_ideal_for, '&ideal-for='.$row["url_name_ideal"]);
    array_push($array_ideal_for2, '?filter&ideal-for='.$row["url_name_ideal"]);
  }
  ///////////////
  if ($check_get_ideal_for == true) {
    if (isset($_GET["ideal-for"])) {
      $page_current_ideal_for4 = multiexplode($array_ideal_for2,$page_current_ideal_for3);
      $page_current_ideal_for5 = $page_current_ideal_for4[0].$page_current_ideal_for4[1];

      $page_current_ideal_for2 = explode("&ideal-for=", $page_current_ideal_for3);
      $page_current_ideal_for = $page_current_ideal_for2[0].'&ideal-for=';
    } else {
      $page_current_ideal_for = $page_current_ideal_for3.'?filter&ideal-for=';
    }
  } else {
    if (isset($_GET["ideal-for"])) {
      $page_current_ideal_for4 = multiexplode($array_ideal_for,$page_current_ideal_for3);
      $page_current_ideal_for5 = $page_current_ideal_for4[0].$page_current_ideal_for4[1];

      $page_current_ideal_for2 = explode("&ideal-for=", $page_current_ideal_for3);
      $page_current_ideal_for = $page_current_ideal_for2[0].'&ideal-for=';
    } else {
      $page_current_ideal_for5 = $page_current_ideal_for3;
      $page_current_ideal_for = $page_current_ideal_for3.'&ideal-for=';
    }
  }

  /////////////////////////
  if (isset($page_current2[0])) {
    $page_current_material3 = $page_current2[0];
  } else {
    $page_current_material3 = $_SERVER['REQUEST_URI'];
  }
  ///////////////////////////
  $array_material=array();
  $array_material2=array();
  $select_material = 'SELECT * FROM pd_material';
  $i = 0;
  $result_material = mysqli_query($connection,$select_material) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_material,MYSQLI_ASSOC)) {
    array_push($array_material, '&material='.$row["url_name_material"]);
    array_push($array_material2, '?filter&material='.$row["url_name_material"]);
  }
  ///////////////
  if ($check_get_material == true) {
    if (isset($_GET["material"])) {
      $page_current_material4 = multiexplode($array_material2,$page_current_material3);
      $page_current_material5 = $page_current_material4[0].$page_current_material4[1];

      $page_current_material2 = explode("&material=", $page_current_material3);
      $page_current_material = $page_current_material2[0].'&material=';
    } else {
      $page_current_material = $page_current_material3.'?filter&material=';
    }
  } else {
    if (isset($_GET["material"])) {
      $page_current_material4 = multiexplode($array_material,$page_current_material3);
      $page_current_material5 = $page_current_material4[0].$page_current_material4[1];

      $page_current_material2 = explode("&material=", $page_current_material3);
      $page_current_material = $page_current_material2[0].'&material=';
    } else {
      $page_current_material5 = $page_current_material3;
      $page_current_material = $page_current_material3.'&material=';
    }
  }

  ////////////////////////////////////////////////////////////////////////
  $html_option_page="";
  $max_count = $count_product / $number_view_toys;
  $max_page  = ceil($max_count);
  for ($i = 0; $i < $count_product; $i=$i + $number_view_toys) {
    static $count;
    $count++;
    if ($count == $_GET["page"]) {
      $html_option_page.='<option value="'.$page_current.$count.'" selected="selected">Page '.$count.' of '.$max_page.'</option>';
    } else {
      $html_option_page.='<option value="'.$page_current.$count.'">Page '.$count.' of '.$max_page.'</option>';
    }
  };
  /////////////////////////////////////////////////////////////////
  if (isset($_GET["page"])) {
    $page_btn_left_right = $_GET["page"];
  } else {
    $page_btn_left_right = 1;
  }
  /////////////////////////////////////////////////////////////////
  if (isset($_GET["page"])) {
    $page_max = $_GET["page"] * $number_view_toys;
    $page_min = $page_max - $number_view_toys;
    $sql_query.= ' LIMIT '.$page_min.', '.$number_view_toys;
  } else {
    $sql_query.= " LIMIT 0, 12";
  }
  // echo $sql_query;
  /////////////////////////////////////////////////////////////////
  $result_check = mysqli_query($connection,$sql_query) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    $hmtl_toys.='<form method="post" action="toys.php?action=add&name='.$row["url_name_pd"].'">';
    $hmtl_toys.='<div class="box-toys">';
    $hmtl_toys.='<div class="box-content-toys">';
    $hmtl_toys.='<a href="product-details.php?id='.$row["pd_id"].'">';
    $hmtl_toys.='<img src="images/'.explode_image($row["image_pd"]).'" alt="" class="toys">';
    $hmtl_toys.='<div class="box-information-toys">';
    $hmtl_toys.='<h2 class="name-toys">'.$row["name_pd"].'</h2>';
    $hmtl_toys.='<h2 class="price-toys">$'.$row["price_pd"].'</h2>';
    $hmtl_toys.='</div>';
    $hmtl_toys.='</a>';
    $hmtl_toys.='<div class="box-add-cart">';
    $hmtl_toys.='<input type="submit" value="Add to Cart" class="txt-add-cart" />';
    $hmtl_toys.='</div>';
    $hmtl_toys.='</div>';
    $hmtl_toys.='</div>';
    $hmtl_toys.='</form>';
  };
  /////////////////////////////////////////////////////////////////////////////
  $query_check  = 'SELECT * FROM pd_recommended_age';
  $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
    $html_filter_r_age.='<li class="filter-item">';
      if ($check_get_c_age == true) {
        if ($_GET['recommended-age'] == $row["url_name_r_age"]) { 
          $link_r_age = $page_current_r_age . $row["url_name_r_age"];
          $checked = 'checked';
        } else { 
          $link_r_age = $page_current_r_age . $row["url_name_r_age"];
          $checked = '';
        }
      } else {
        if ($_GET['recommended-age'] == $row["url_name_r_age"]) { 
          $link_r_age = $page_current_r_age5 . '&recommended-age='.$row["url_name_r_age"];
          $checked = 'checked';
        } else { 
          $link_r_age = $page_current_r_age5 . '&recommended-age='.$row["url_name_r_age"];
          $checked = '';
        }
      }
      $html_filter_r_age.='<input onclick="location.href=\''.$link_r_age.'\'" '.$checked.' type="radio" name="recommended-age" id="" value="'.$row["url_name_r_age"].'">'.$row["name_r_age"];
    $html_filter_r_age.='</li>';
  }
  if (isset($_GET["recommended-age"])) {
    $html_filter_r_age.='<li class="filter-item filter-remove-item">';
      $html_filter_r_age.='<a class="link-remove-filter" href="'.$page_current_r_age5.'"><i id="icon-remove" class="fas fa-times-circle"></i>Remove filter</a>';
    $html_filter_r_age.='</li>';
  }
  //////////////////
  $query_check  = 'SELECT * FROM pd_ideal_for';
  $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
    $html_filter_ideal_for.='<li class="filter-item">';
      if ($check_get_ideal_for == true) {
        if ($_GET['ideal-for'] == $row["url_name_ideal"]) { 
          $link_ideal_for = $page_current_ideal_for . $row["url_name_ideal"];
          $checked = 'checked';
        } else { 
          $link_ideal_for = $page_current_ideal_for . $row["url_name_ideal"];
          $checked = '';
        }
      } else {
        if ($_GET['ideal-for'] == $row["url_name_ideal"]) { 
          $link_ideal_for = $page_current_ideal_for5 . '&ideal-for='.$row["url_name_ideal"];
          $checked = 'checked';
        } else { 
          $link_ideal_for = $page_current_ideal_for5 . '&ideal-for='.$row["url_name_ideal"];
          $checked = '';
        }
      }
      $html_filter_ideal_for.='<input onclick="location.href=\''.$link_ideal_for.'\'" '.$checked.'  type="radio" name="ideal-for" id="" value="'.$row["url_name_ideal"].'">'.$row["name_ideal_for"];
    $html_filter_ideal_for.='</li>';
  }
  if (isset($_GET["ideal-for"])) {
    $html_filter_ideal_for.='<li class="filter-item filter-remove-item">';
      $html_filter_ideal_for.='<a class="link-remove-filter" href="'.$page_current_ideal_for5.'"><i id="icon-remove" class="fas fa-times-circle"></i>Remove filter</a>';
    $html_filter_ideal_for.='</li>';
  }
  ///////////////////
  $query_check  = 'SELECT * FROM pd_material';
  $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
    $html_filter_material.='<li class="filter-item">';
      if ($check_get_material == true) {
        if ($_GET['material'] == $row["url_name_material"]) { 
          $link_material = $page_current_material . $row["url_name_material"];
          $checked_material = 'checked';
        } else { 
          $link_material = $page_current_material . $row["url_name_material"];
          $checked_material = '';
        }
      } else {
        if ($_GET['material'] == $row["url_name_material"]) { 
          $link_material = $page_current_material5 . '&material='.$row["url_name_material"];
          $checked_material = 'checked';
        } else { 
          $link_material = $page_current_material5 . '&material='.$row["url_name_material"];
          $checked_material = '';
        }
      }
      $html_filter_material.='<input onclick="location.href=\''.$link_material.'\'" '.$checked_material.'  type="radio" name="material" id="" value="'.$row["url_name_material"].'">'.$row["name_material"];
    $html_filter_material.='</li>';
  }
  if (isset($_GET["material"])) {
    $html_filter_material.='<li class="filter-item filter-remove-item">';
      $html_filter_material.='<a class="link-remove-filter" href="'.$page_current_material5.'"><i id="icon-remove" class="fas fa-times-circle"></i>Remove filter</a>';
    $html_filter_material.='</li>';
  }
  /////////////////////////////////////////////////////////////////////////////
  if (isset($_GET["search"])) {
    $hmtl_toys = "";
    $page_max = $_GET["page"] * $number_view_toys;
    $page_min = $page_max - $number_view_toys;
    $query_check  = 'SELECT id, name_pd, image_pd, describe_pd, Material_pd, amount_pd, price_pd, species_pd  
      FROM product WHERE name_pd LIKE "%'.$_GET["search"] .'%" ';
    $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
    while($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
      $hmtl_toys.='<form method="post" action="toys.php?page='.$_GET["page"].'&action=add&image='.$row["image_pd"].'">';
      $hmtl_toys.='<div class="box-toys">';
      $hmtl_toys.='<div class="box-content-toys">';
      $hmtl_toys.='<a href="product-details.php?id='.$row["id"].'">';
      $hmtl_toys.='<img src="images/'.explode_image($row["image_pd"]).'" alt="" class="toys">';
      $hmtl_toys.='<div class="box-information-toys">';
      $hmtl_toys.='<h2 class="name-toys">'.$row["name_pd"].'</h2>';
      $hmtl_toys.='<h2 class="price-toys">$'.$row["price_pd"].'</h2>';
      $hmtl_toys.='</div>';
      $hmtl_toys.='</a>';
      $hmtl_toys.='<div class="box-add-cart">';
      $hmtl_toys.='<input type="submit" value="Add to Cart" class="txt-add-cart" />';
      $hmtl_toys.='</div>';
      $hmtl_toys.='</div>';
      $hmtl_toys.='</div>';
      $hmtl_toys.='</form>';
    }
  }
  ////////////////////////////////////////////////////////////////
  if ($check_get_contact == true) {
    $url_contact = '?contact';
  } else {
    $url_contact = '&contact';
  }
  if (isset($_GET["contact"])) {
    $url_page = $pieces = explode($url_contact, $_SERVER['REQUEST_URI']);
    $html_contact.='<form action="'.$_SERVER['REQUEST_URI'].'$url_contact" method="post">';
      $html_contact.='<div name="view"  class="view" id="view">';
        $html_contact.='<div class="modal__content contact">';
          $html_contact.='<a href="'.$url_page[0].'" class="modal__close">&times;</a>';
          $html_contact.='<h1 class="title-contact">Contact</h1>';
          $html_contact.='<form action="'.$_SERVER['REQUEST_URI'].$url_contact.'" method="post">';
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
  <link rel="stylesheet" href="css/mycss.css">
  <link rel="stylesheet" href="css/css-toys.css">
  <!-- <link rel="stylesheet" href="css/header-footer.css"> -->
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
        </div>
        <div class="box-cart">
          <i class="fas fa-shopping-cart" id="icon-cart"></i>
          <span class="txt-shopping">SHOPPING</span>
          <span class="txt-item"><span class="amount-cart"><?php if(isset($amount_cart)) { echo $amount_cart;} else echo 0 ?></span>
            item(s)-$<span class="price-cart"><?php if (isset($total_price)) echo $total_price; else echo 0 ?></span></span>
          <i class="fas fa-sort-down" id="icon-down"></i>

          <div class="box-toy-cart">
            <div class="box-item-cart">
              <?php echo $html_cart ?>
            </div><!-- javascript code -->
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
          <li class="item-menu" id="item-contact"><a href="<?php echo $_SERVER['REQUEST_URI'].$url_contact ?>" class="type-item-menu">CONTACT</a></li>
          <li class="item-menu" id="item-blog"><a href="#" class="type-item-menu">BLOG</a></li>
        </ul>
      </nav>
    </div>
  </menu>
  <main class="page-main">
    <div class="main">
      <aside class="main-left">
          <div class="box-title-category">
            <h2>Category</h2>
          </div>
          <div class="content-category">
            <ul class="cols-content-category">
                <?php
                  echo $html_species;
                ?>
            </ul>
          </div>
          <div class="container-filter">
            <h2 class="title-filter">Filter</h2>
            <div class="container-filter-item">
              <h4 class="title-filter-item">Recommended age</h4>
              <ul class="filter-item-bar">
                <?php echo $html_filter_r_age ?>
              </ul>
            </div>
            <div class="container-filter-item">
              <h4 class="title-filter-item">Ideal for</h4>
              <ul class="filter-item-bar">
                <?php echo $html_filter_ideal_for ?>
              </ul>
            </div>
            <div class="container-filter-item">
              <h4 class="title-filter-item">Material</h4>
              <ul class="filter-item-bar">
                <?php echo $html_filter_material ?>
              </ul>
            </div>
          </div>
      </aside>
      <article class="main-right">
          <div class="box-title-toys">
            <?php echo $html_title ?>
          </div>
          <div class="bar-toys">
            <?php
              if (isset($hmtl_toys)) {
                echo $hmtl_toys;
              } else {
                echo '<img src="images/no-product-found.jpg" alt="" height="" width="100%">';
              }
              
            ?>
          </div>
          <form action="toys.php">
          <div class="select-page-toys">
            <div class="box-select">
              <?php
                if(isset($hmtl_toys)) {
                  if ($page_btn_left_right == 1) {
                    echo '<a href="'.$page_current.(($page_btn_left_right)).'" class="btn-previous-out"><i class="fas fa-chevron-left"></i></a>';
                  } else {
                    echo '<a href="'.$page_current.(($page_btn_left_right) - 1).'" class="btn-previous"><i class="fas fa-chevron-left"></i></a>';
                  }
                } else {
                  echo '<a href="'.$page_current.(($page_btn_left_right)).'" class="btn-previous-out"><i class="fas fa-chevron-left"></i></a>';
                }
              ?>
              <select name="choose-page" id="choose-page" class="choose-page" onchange="javascript:handleSelect(this)">
                <?php
                  if (isset($hmtl_toys)) {
                    echo $html_option_page;
                  } else {
                    echo '<option value="0" selected="selected">Page 0</option>';
                  }
                ?>
              </select>
              <?php
                if (isset($hmtl_toys)) {
                  if ($page_btn_left_right == $max_page) {
                    echo '<a href="'.$page_current.(($page_btn_left_right)).'" class="btn-after-out"><i class="fas fa-chevron-right"></i></a>';
                  } else {
                    echo '<a href="'.$page_current.(($page_btn_left_right) + 1).'" class="btn-after"><i class="fas fa-chevron-right"></i></a>';
                  }
                } else {
                  echo '<a href="'.$page_current.(($page_btn_left_right)).'" class="btn-after-out"><i class="fas fa-chevron-right"></i></a>';
                }
              ?>
            </div>
          </div>
          </form>
      </article>
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
  <script type="text/javascript">

    function handleSelect(elm)
    {
    window.location = elm.value;
    }
  </script>
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