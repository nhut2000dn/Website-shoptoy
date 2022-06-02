<?php
  include "../connect.php";
  include "check-user.php";
  include "c-count.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>Document</title>
</head>
<body>
  <header class="page-header">
    <div class="header-left">
      <a href="index.php"><p class="sb-admin-v20">SB Admin v2.0</p></a>
    </div>
    <div class="header-right">
      <div class="box-item">
        <i class="fas fa-envelope" id="icon-header"></i><i class="fas fa-sort-down" id="icon-down"></i>
      </div>
      <div class="box-item">
        <i class="fas fa-book" id="icon-header"></i><i class="fas fa-sort-down" id="icon-down"></i>
      </div>
      <div class="box-item">
        <i class="fas fa-bell" id="icon-header"></i><i class="fas fa-sort-down" id="icon-down"></i>
      </div>
      <div class="box-item" id="box-user">
        <i class="fas fa-user" id="icon-header"></i><i class="fas fa-sort-down" id="icon-down"></i>
        <div class="drop-down-user" id="drop-user" style="display: none;">
          <div class="btn-drop-down btn-log-out">
            <i class="fas fa-user-cog icon-drop-down" id="icon-drop-down"></i>
            <div class="txt-drop-down">Setting</div>
          </div>
          <a href="profile.php">
            <div class="btn-drop-down btn-log-out">
              <i class="far fa-id-card icon-drop-down" id="icon-drop-down"></i>
              <div class="txt-drop-down">ProFile</div>
            </div>
          </a>
          <a onclick="return confirmlogout()" href="log-out.php">
            <div class="btn-drop-down btn-log-out">
              <i class="fas fa-sign-out-alt icon-drop-down" id="icon-drop-down"></i>
              <div class="txt-drop-down">Log Out</div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </header>
  <main class="page-main">
    <div class="main-left">
      <div class="bar-item-tool">
        <ul class="all-item-tool">
          <a href="member.php">
            <li class="item-tool"><i class="fas fa-users" id="icon-main-left"></i>Member<span class=""> (<?php echo $count_account; ?>)</span></li>
          </a>
          <a href="product.php">
            <li class="item-tool"><i class="fas fa-ticket-alt" id="icon-main-left"></i>Product<span class=""> (<?php echo $count_product; ?>)</span></li>
          </a>
          <a href="order-product.php">
            <li class="item-tool"><i class="fas fa-shopping-cart" id="icon-main-left"></i></i>Cart<span class=""> (<?php echo $count_order; ?>)</span></li>
          </a>
          <a href="comment-product.php">
            <li class="item-tool"><i class="fas fa-comments" id="icon-main-left"></i>Comment<span class=""> (<?php echo $count_comment; ?>)</span></li>
          </a>
          <a href="contact.php">
            <li class="item-tool"><i class="fas fa-comment-dots" id="icon-main-left"></i>Contact<span class=""> (<?php echo $count_contact; ?>)</span></li>
          </a>
          <a href="OutOfStock.php">
            <li class="item-tool"><i class="fas fa-bezier-curve" id="icon-main-left"></i>Out Of Stock<span class=""> (<?php echo $count_out_stock; ?>)</span></li>
          </a>
          <a href="material-product.php">
            <li class="item-tool"><i class="far fa-chart-bar" id="icon-main-left"></i>Product Material<span class=""> (<?php echo $count_material; ?>)</span></li>
          </a>
          <a href="recommended-age-product.php">
            <li class="item-tool"><i class="far fa-chart-bar" id="icon-main-left"></i>Product Recommended Age<span class=""> (<?php echo $count_r_age; ?>)</span></li>
          </a>
          <a href="ideal-for-product.php">
            <li class="item-tool"><i class="far fa-chart-bar" id="icon-main-left"></i>Product Ideal For<span class=""> (<?php echo $count_ideal_for; ?>)</span></li>
          </a>
          <a href="species-product.php">
            <li class="item-tool"><i class="far fa-chart-bar" id="icon-main-left"></i>Product Species<span class=""> (<?php echo $count_species; ?>)</span></li>
          </a>
          <!-- <a href="#">
            <li class="item-tool"><i class="far fa-file" id="icon-main-left"></i>Sample Pages</li>
          </a> -->
        </ul>
      </div>
    </div>
    <div class="main-right">
      <section class="name-main-right">
        <p class="dashboard dashboard-index">Dashboard</p>
        <p class="border-bottom"></p>
      </section>
      <div class="bar-item-dashboard">
        <div class="box-item-dashboard" id="box-item-member">
          <a href="member.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-users" id="icon-item-dashboard"></i>
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_account;
                  ?>
                </p>
                <p class="name-item-dashboard">Member!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-member">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-member"></i>
          </div>
        </div>
        <div class="box-item-dashboard" id="box-item-tasks">
          <a href="species-product.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-book" id="icon-item-dashboard"></i>
              <!-- <i class="fas fa-tasks" id="icon-item-dashboard"></i> -->
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_species;
                  ?>
                </p>
                <p class="name-item-dashboard">Product Species!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-tasks">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-tasks"></i>
          </div>
        </div>
        <div class="box-item-dashboard" id="box-item-carts">
          <a href="order-product.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-shopping-cart" id="icon-item-dashboard"></i>
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_order
                  ?>
                </p>
                <p class="name-item-dashboard">New Carts!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-carts">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-carts"></i>
          </div>
        </div>
        <div class="box-item-dashboard" id="box-item-tickets">
          <a href="product.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-ticket-alt" id="icon-item-dashboard"></i>
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_product;
                  ?>
                </p>
                <p class="name-item-dashboard">Product!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-tickets">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-tickets"></i>
          </div>
        </div>
        <div class="box-item-dashboard" id="box-item-comment">
          <a href="comment-product.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-comments" id="icon-item-dashboard"></i>
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_comment;
                  ?>
                </p>
                <p class="name-item-dashboard">Comments!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-comment">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-comment"></i>
          </div>
        </div>

        <div class="box-item-dashboard" id="box-item-comment">
          <a href="contact.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-comment-dots" id="icon-item-dashboard"></i>
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_contact;
                  ?>
                </p>
                <p class="name-item-dashboard">Contact!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-comment">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-comment"></i>
          </div>
        </div>

        <div class="box-item-dashboard" id="box-item-tickets">
          <a href="OutOfStock.php">
            <div class="box-icon-inforamion">
              <i class="fas fa-ticket-alt" id="icon-item-dashboard"></i>
              <div class="informaion-dashboard">
                <p class="amount-dashboard">
                  <?php
                    echo $count_out_stock;
                  ?>
                </p>
                <p class="name-item-dashboard">Out Of Stock!</p>
              </div>
            </div>
          </a>
          <div class="box-view-details">
            <p class="view-detail" id="view-detail-comment">View Details</p>
            <i class="fas fa-arrow-right" id="icon-right-tickets"></i>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer class="page-footer">
  </footer>
  <script src="js/myjs.js"></script>
  <SCRIPT LANGUAGE="JavaScript">
      function confirmlogout() {
        return confirm("Bạn có chắc muốn đăng xuất !")
      }
    function confirmpass() {
        return confirm("Bạn có chắc refresh password thành viên này không !")
      }
  </SCRIPT>
</body>
</html>
