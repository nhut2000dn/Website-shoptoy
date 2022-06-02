<?php
  include "../connect.php";
  include "c-search.php";
  include "check-user.php";
  include "c-count.php";
  function explode_image($image) {
    $img_pd          = $image;
    $pieces_img = explode(",", $img_pd);
    return $pieces_img[0];
  }
  $query_check  = 'SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
   order_product.address, order_product.phone_number, order_product.pay, order_product.status, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
   FROM order_product, account 
   WHERE order_product.id_account = account.id ORDER BY order_product.id DESC';
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    static $count = 0;
    static $i = 0;
    $count++;
    $i++;
    // var_dump($row);
    $html.='<tr>';
    $html.='<td>'.$i.'</td>';
    $html.='<td>'.$row["orderId"].'</td>';
    $html.='<td>'.$row["hoAccount"].' '.$row["tenAccount"].'</td>';
    $html.='<td>'.$row["created_date"].'</td>';
    if ($row["date_of_delivery"] == '') {
      $html.='<td>Chưa Xác Định</td>';
    } else {
      $html.='<td>'.$row["date_of_delivery"].'</td>';
    }
    $html.='<td>'.$row["address"].'</td>';
    $html.='<td>'.$row["phone_number"].'</td>';
    if ($row["pay"] == 0) {
      $html.='<td>Chưa Thanh Toán</td>';
    } else {
      $html.='<td>Đã Thanh Toán</td>';
    }

    if ($row["status"] == 1) {
      $html.='<td>Đang Đặt Hàng</td>';
    } else {
      $html.='<td>Đã Hủy</td>';
    }

    $html.='<td class="button"><a href="order-product.php?idOrder='.$row["orderId"].'" class="btn-Refesh">View</a></td>';
    $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-order-product.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
    $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
    $html.='</tr>'; 
  }
  if (isset($_POST["submit-btn"])) {
    $select_search = $_POST["select-search"];
    $content_search = $_POST["content-search"];
    $html = search_order_product($select_search, $content_search);
  }

  if(isset($_GET["idOrder"])) {
    $idOrder = $_GET["idOrder"];
    $html21;
    $query_check  = "SELECT order_details.id AS idOrderDetail, order_details.id_order, order_details.id_product, order_details.amount, order_details.price_product,
      order_product.id, product.id, product.name_pd, product.image_pd, product.price_pd
      FROM order_details, order_product, product 
      WHERE order_details.id_product = product.id AND order_details.id_order = order_product.id AND order_details.id_order='$idOrder'";
    $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
    while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
     static $countOrderDetail = 0;
     $countOrderDetail++;
     $i++;
     // var_dump($row);
     $html21.='<tr>';
     $html21.='<td>'.$countOrderDetail.'</td>';
     $html21.='<td>'.$row["idOrderDetail"].'</td>';
     $html21.='<td>'.$row["name_pd"].'</td>';
     $html21.='<td><img src="../images/'.explode_image($row["image_pd"]).'" alt="" class="img-product"></td>';
     $html21.='<td>'.$row["price_product"].'</td>';
     $html21.='<td>'.$row["amount"].'</td>';
     $TongTien = $row["amount"] * $row["price_product"];
     $html21.='<td>'.$TongTien.'</td>';
     $html21.='</tr>'; 
    }
    $html2 = '
      <div class="view" id="view">
        <div class="modal__content">
          <a href="order-product.php" class="modal__close">&times;</a>
          <h2 class="modal__heading">Detail Order Product</h2>
          <div class="container-order-details">
          <table class="member">
                  <thead>
                      <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên Đồ Chơi</th>
                        <th>Hình Ảnh</th>
                        <th>Giá</th>
                        <th>Số Lượng</th>
                        <th>Tổng Tiền</th>
                      </tr>
                  </thead>
                  <tbody class="content-table">
                    ' . $html21 . '
                  </tbody>
          </table>
          </div>
        </div>
      </div>';
    }
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
  <link rel="stylesheet" href="css/css-member.css">
  <link rel="stylesheet" href="css/css-order-product.css">
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
        </ul>
      </div>
    </div>
    <div class="main-right">
      <div class="content-main-right">
        <section class="name-main-right">
          <div class="title-bar">
            <div class="title-left">
              <p class="dashboard">Control Table - Order Product</p>
            </div>
            <div class="title-right">
              <form method="post" action="order-product.php" class="form-search">
                <input type="text" name="content-search" class="content-search">
                <select name="select-search" class="select-search">
                  <option value="all">Search All</option>
                  <option value="id">ID Order</option>
                  <option value="first-name">Họ Đệm Khách Hàng</option>
                  <option value="last-name">Tên Khách Hàng</option>
                  <option value="SDT">Số Điện Thoại</option>
                  <option value="thanh-toan">Thanh Toán</option>
                </select>
                <button type="submit" name="submit-btn" class="submit-btn">Search Order</button>
                <button type="submit" name="refesh-btn" class="submit-btn">refesh Table</button>
              </form>
            </div>
          </div>
          <!-- <p class="border-bottom"></p> -->
        </section>
        <article>
            <table class="member">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Khách Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Ngày Giao</th>
                        <th>Địa Chỉ Cần Giao</th>
                        <th>Số Điện Thoại Người Đặt</th>
                        <th>Thanh Toán</th>
                        <th>Tình Trạng</th>
                        <th colspan="3">View | Delete | Edit</th>
                    </tr>
                </thead>
                <tbody class="content-table">
                    <?php
                      echo $html; 
                    ?>
                </tbody>
            </table>
        </article>
      </div>
      <div class="bottom-main-right">
        <div class="nav-btom">
          <div class="txt-nav-bottom">
            <b>Tổng cộng số đơn hàng : </b>
            <span>
              <?php
                echo $count;
              ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer class="page-footer">
    <!-- <a href="#view" class="modal-open">Open Modal</a> -->
    <?php
      echo $html2;
    ?>
  </footer>
  <SCRIPT LANGUAGE="JavaScript">
      function confirmdelete() {
        return confirm("Bạn có chắc xóa đơn hàng này không !")
      }
    function confirmpass() {
        return confirm("Bạn có chắc refresh password thành viên này không !")
      }
    var boxUser = document.getElementById("box-user");
    var dropUser = document.getElementById("drop-user");
    boxUser.addEventListener("click", function () {
        if (dropUser.style.display == "none") {
            dropUser.style.display = "block";
        } else {
            dropUser.style.display = "none";
        }
    });
    function confirmlogout() {
        return confirm("Bạn có chắc muốn đăng xuất !")
    }
  </SCRIPT>
</body>
</html>
