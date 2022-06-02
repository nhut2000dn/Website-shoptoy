<?php
  session_start();
  if (isset($_POST["btn-sign-out"])) {
    unset($_SESSION["emailUser"]);
    unset($_SESSION["passwordUser"]);
    header("Refresh:0");
  }
  include("connect.php");
  include("c-cart.php");
  if (isset($_POST["btn-search"])) {
    $content_search = strtolower($_POST["content-search"]);
    $link_search = 'location:toys.php?search='.$content_search;
    header ($link_search);
  }
  /////////////////////////////////////////////////////////////
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
  <link rel="stylesheet" href="css/mycss.css">
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
          <li class="item-menu" id="item-contact"><a href="<?php echo $_SERVER['REQUEST_URI'].'?contact' ?>" class="type-item-menu">CONTACT</a></li>
          <li class="item-menu" id="item-blog"><a href="#" class="type-item-menu">BLOG</a></li>
        </ul>
      </nav>
    </div>
  </menu>
  <main class="page-main">
    <div class="main">
      <article class="main-left">
        <div class="slides-show-highlights">
          <div class="box-toy-hightlights">
            <?php
            $product_array = $db_handle->runQuery("SELECT * FROM product LIMIT 22,7");
            if (!empty($product_array)) { 
              foreach($product_array as $key=>$value){
                $img_pd          = $product_array[$key]["image_pd"];
                $pieces_img = explode(",", $img_pd);
            ?>    
              <form method="post" action="index.php?action=add&name=<?php echo $product_array[$key]["url_name_pd"]; ?>">
                <div class="main-toy-highlights">
                <div class="img-toy-highlights">
                <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>"><img src="images/<?php echo $pieces_img[0]; ?>" alt="" class="toy-highlights"></a>
                </div>
                <div class="information-toy-highlights">
                <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>">
                <p class="name-toy-highlights"><?php echo $product_array[$key]["name_pd"]; ?></p>
                <p class="information-toy-highlights"><?php echo $product_array[$key]["describe_pd"]; ?></p>
                <p class="price-toy-highlights">$<?php echo $product_array[$key]["price_pd"]; ?></p>
                </a>
                <div class="add-cart-btn-highlights">
                <p class="add-to-cart-highlights" data-id =' + listProducts()[i].id + '>ADD TO CART</p>
                </div>
                </div>
                </div>
              </form>
            <?php
              }
            }
            ?>
          </div>
          <div class="box-btn-slides">
            <button class="btn-slides-show" id="btn-left-slides">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="btn-slides-show" id="btn-right-slides">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
        </div>
        <div class="main-toy-latest">
          <div class="box-latest">
            <P class="latest">LATEST</P>
              <?php
              $product_array = $db_handle->runQuery("SELECT * FROM product LIMIT 0,5");
              if (!empty($product_array)) { 
                foreach($product_array as $key=>$value){
                  $img_pd          = $product_array[$key]["image_pd"];
                  $pieces_img = explode(",", $img_pd);
              ?>    
                <form method="post" action="index.php?action=add&name=<?php echo $product_array[$key]["url_name_pd"]; ?>">
                  <div class="box-products-latest">
                    <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>"><div class="img-hover-zoom"><img src="images/<?php echo $pieces_img[0]; ?>" alt="" class="product-latest"></div></a>
                    <div class="information-product-latest">
                        <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>">
                          <p class="name-product-latest"><?php echo $product_array[$key]["name_pd"]; ?></p>
                          <p class="price-product-latest">$<?php echo $product_array[$key]["price_pd"]; ?></p>
                        </a>
                      <div class="add-cart-btn-latest">
                          <div class="cart-action">
                            <input type="submit" value="Add to Cart" class="add-cart-btn-latest" />
                          </div>
                      </div>
                    </div>
                  </div>
                </form>
              <?php
                }
              }
              ?>
          </div>
        </div>
        <div class="main-toy-latest">
          <div class="box-latest">
          <P class="CONSECTETUR">CONSECTETUR</P>
            <?php
            $product_array = $db_handle->runQuery("SELECT * FROM product LIMIT 15,5");
            if (!empty($product_array)) { 
              foreach($product_array as $key=>$value){
                $img_pd          = $product_array[$key]["image_pd"];
                $pieces_img = explode(",", $img_pd);
            ?>    
              <form method="post" action="index.php?action=add&name=<?php echo $product_array[$key]["url_name_pd"]; ?>">
                <div class="box-products-latest">
                  <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>"><div class="img-hover-zoom"><img src="images/<?php echo $pieces_img[0]; ?>" alt="" class="product-latest"></div></a>
                  <div class="information-product-latest">
                      <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>">
                        <p class="name-product-latest"><?php echo $product_array[$key]["name_pd"]; ?></p>
                        <p class="price-product-latest">$<?php echo $product_array[$key]["price_pd"]; ?></p>
                      </a>
                    <div class="add-cart-btn-latest">
                        <div class="cart-action">
                          <input type="submit" value="Add to Cart" class="add-cart-btn-latest" />
                        </div>
                    </div>
                  </div>
                </div>
              </form>
            <?php
              }
            }
            ?>
          </div>
        </div>
      </article>
      <aside class="main-right">
        <div class="main-toy-speacial">

            <div class="box-speacial">
              <p class="speacial">SPEACIAL</p>
          <?php
          $product_array = $db_handle->runQuery("SELECT * FROM product LIMIT 15,1");
          if (!empty($product_array)) { 
            foreach($product_array as $key=>$value){
              $img_pd          = $product_array[$key]["image_pd"];
              $pieces_img = explode(",", $img_pd);
          ?>    
          <form method="post" action="index.php?action=add&name=<?php echo $product_array[$key]["url_name_pd"]; ?>">
          </div>
          <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>"><div class="img-hover-zoom"><img src="images/<?php echo $pieces_img[0] ?>" alt="" class="product-speacial"></div></a>
          <div class="information-product-speacial">
          <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>">
          <p class="name-product-speacial"><?php echo $product_array[$key]["name_pd"]; ?></p>
          <p class="price-product-speacial"><span class="oldprice-product-speacial">$150</span>$<?php echo $product_array[$key]["price_pd"]; ?></p>
          </a> 
          <div class="box-add-cart-special">
            <input type="submit" value="Add to Cart" class="add-cart-btn-special" />
          </div>
          </form>
          <?php
            }
          }
          ?>
          </div>
        </div>
        <div class="main-toy-categories">
          <div class="box-toy-categories">
            <p class="categories">CATEGORIES</p>
          </div>
          <div class="bar-categories">
            <ul class="bar-item">
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">Cars</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">Robots</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">Plane</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">Dolly</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">House</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">VIP</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">Baby</p>
                </li>
              </a>
              <a href="#" class="type-item-categories">
                <li class="item-categories">
                  <p class="name-item-categories">Adult</p>
                </li>
              </a>
            </ul>
          </div>
        </div>
        <div class="main-toy-new">
          <div class="box-toy-new">
            <p class="new">NEW</p>
          </div>
          <?php
            $product_array = $db_handle->runQuery("SELECT * FROM product LIMIT 15,3");
            if (!empty($product_array)) { 
              foreach($product_array as $key=>$value){
                $img_pd          = $product_array[$key]["image_pd"];
                $pieces_img = explode(",", $img_pd);
            ?>    

              <div class="box-img-information">
                <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>" class="img-hover-zoom img-hover"><img src="images/<?php echo $pieces_img[0]; ?>" alt="" class="toy-new"></a>
                <div class="information-toy-new">
                  <a href="product-details.php?id=<?php echo $product_array[$key]["id"]; ?>">
                    <p class="name-toy-new"><?php echo $product_array[$key]["name_pd"]; ?></p>
                    <p class="price-toy-new">$<?php echo $product_array[$key]["price_pd"]; ?></p>
                  </a>
                </div>
              </div>
            <?php
              }
            }
            ?>
        </div>
      </aside>
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
  <script src="js/myjs.js"></script>
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