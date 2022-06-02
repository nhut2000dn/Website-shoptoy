<?php
    include "../connect.php";
    include "check-user.php";
    include "c-count.php";
    session_start();
    if(!isset($_GET["id"])) {
      header ("location:order-product.php");
    }
    $idUser = $_GET["id"];
    $query_check  = 'SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
        order_product.address, order_product.phone_number, order_product.pay, order_product.status, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
        FROM order_product, account 
        WHERE order_product.id_account = account.id AND order_product.id = "' . $idUser . '"';
    $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
    while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
        $diaChi = $row["address"];
        $SDT = $row["phone_number"];
        $thanhToan = $row["pay"];
        $tinhtrang = $row["status"];
        $giaoHang = $row["date_of_delivery"];
        $date = explode('-', $giaoHang);
        $yearGH = $date[0];
        $monthGH = $date[1];
        $dayGH  = $date[2];
    }
    if (isset($_POST["btn-change-password"])) {
      echo '<style type="text/css">
            tr.change-password {
            display: block;
            }
            </style>';
    } else {
      echo '<style type="text/css">
            tr.change-password {
            display: none;
            }
            </style>';
    }
    $error;
    $check = true;
    $check2 = true;
    if (isset($_POST["submit-btn"])) {
      $diaChiMoi = $_POST["dia-chi"];
      $SDTMoi = $_POST["so-dien-thoai"];
      $date = $_POST["date"];
      $month = $_POST["month"];
      $year = $_POST["year"];
      $ngayGiaoHang = $year.'/'.$month.'/'.$date;
      $thanhToanMoi = $_POST["thanh-toan"];
      $tinhtrangMoi = $_POST["tinh-trang"];
      if (strlen($_POST["dia-chi"]) == "0") {
        $error.= "<li>Địa chỉ không được để trống !</li>";
        $check = false;
      }
      if (strlen($_POST["so-dien-thoai"]) == 0) {
        $error.= "<li>Số điện thoại không được để trống !</li>";
        $check = false;
      }
      if ($check == true) {
        if ($ngayGiaoHang == 'Năm/Tháng/Ngày') {
            $queryUpdate  = "UPDATE order_product SET address='$diaChiMoi',phone_number='$SDTMoi',pay='$thanhToanMoi', status='$tinhtrangMoi' WHERE id='$idUser'";
            $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
            if($result) {
              echo "<script type='text/javascript'>alert('Update thanh cong');</script>";
              echo'<meta http-equiv="refresh" content="0; url=order-product.php" />';
            }
        } else {
            if ($_POST["date"] == 0 || $_POST["month"] == 0 || $_POST["year"] == 0) {
                $error.= "<li>Phải nhập đủ Ngày/Tháng/Năm !</li>";
                $check2 = false;
            }
            if ($check2 == true) {
                $queryUpdate  = "UPDATE order_product SET date_of_delivery='$ngayGiaoHang',address='$diaChiMoi',phone_number='$SDTMoi',pay='$thanhToanMoi', status='$tinhtrangMoi' WHERE id='$idUser'";
                $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
                if($result) {
                  echo "<script type='text/javascript'>alert('Update thanh cong');</script>";
                  echo'<meta http-equiv="refresh" content="0; url=order-product.php" />';
                }
            }
        }
      }
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
  <link rel="stylesheet" href="css/css-edit-user.css">
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
      <section class="name-main-right">
        <p class="edit">Edit Order</p>
        <p class="border-bottom"></p>
      </section>
      <form  method="post">
        <table>
            <tbody>
                <tr><td><span>Ngày Giao Hàng</span></td></tr>
                <tr>
                    <td>
                        <?php
                            echo '<select class = "sn" name="date">';
                            echo '<option value"=0">Ngày</option>';
                            for ($d = 1; $d <= 31; $d++) {
                                if (isset($date) && $date==$d || isset($dayGH) && $dayGH==$d) {
                                    echo '<option value="'.$d.'" selected="selected" >'.$d.'</option>';
                                } else {
                                    echo '<option value"='.$d.'">'.$d.'</option>';
                                }
                            }
                            echo '</select>';
                        ?>
                        <?php
                          echo '<select class = "sn" name="month">';
                          echo '<option value"=0">Tháng</option>';
                          for ($m = 1; $m <= 12; $m++) {
                            if (isset($month) && $month==$m || isset($monthGH) && $monthGH==$m) {
                              echo '<option value="'.$m.'" selected="selected" >'.$m.'</option>';
                            } else {
                              echo '<option value"='.$m.'">'.$m.'</option>';
                            }
                          }
                          echo '</select>';
                        ?>
                        <?php
                          echo '<select class = "sn" name="year">';
                          echo '<option value"=0">Năm</option>';
                          for ($y = 1930; $y <= 2019; $y++) {
                            if (isset($year) && $year==$y || isset($yearGH) && $yearGH==$y) {
                                echo '<option value="'.$y.'" selected="selected" >'.$y.'</option>';
                            } else {
                              echo '<option value"='.$y.'">'.$y.'</option>';
                            }
                          }
                          echo '</select>';
                        ?>
                    </td>
                </tr>
                <tr><td><span>Địa Chỉ</span></td></tr>
                <tr><td><input name="dia-chi" type="text" placeholder="Nhập địa chỉ giao hàng" value="<?php if(isset($diaChi)) echo $diaChi;?>"></td></tr>
                <tr><td><span>Số Điện Thoại Người Nhận</span></td></tr>
                <tr><td><input name="so-dien-thoai" type="text" placeholder="Nhập số điện thoại người nhận" value="<?php if(isset($SDT)) echo $SDT;?>"></td></tr>
                <tr><td><span>Thanh Toán</span></td></tr>
                <tr>
                    <td>
                        <select name="thanh-toan" id="trangthai" class="status">';
                            <option value="1" <?php if ($thanhToan == "1") { echo 'selected="selected"' ; }?>>Đã Thanh Toán</option>
                            <option value="0" <?php if ($thanhToan == "0") { echo 'selected="selected"'; }?>>Chưa Thanh Toán</option>
                        </select>
                    </td>
                </tr>
                <tr><td><span>Trạng Thái</span></td></tr>
                <tr>
                    <td>
                        <select name="tinh-trang" id="trangthai" class="status">';
                            <option value="1" <?php if ($tinhtrang == "1") { echo 'selected="selected"' ; }?>>Đang Đặt Hàng</option>
                            <option value="0" <?php if ($tinhtrang == "0") { echo 'selected="selected"'; }?>>Đã Hủy</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <button type="submit" name="submit-btn">Update</button>
                    </td>
                </tr>
            </tbody>
            <td>
            <ul>
              <?php
                echo $error; 
              ?>
            </ul>
            </td>
        </table>
      </form>
    </div>
  </main>
  <footer class="page-footer">
  </footer>
  <SCRIPT LANGUAGE="JavaScript">
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
