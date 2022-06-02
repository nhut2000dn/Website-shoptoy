<?php
  include "../connect.php";
  include "c-search.php";
  include "check-user.php";
  include "c-count.php";
  $query_check  = 'SELECT * FROM account';
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    static $count = 0;
    static $i = 0;
    $count++;
    $i++;
    // var_dump($row);
    $html.='<tr>';
    $html.='<td>'.$i.'</td>';
    $html.='<td>'.$row["id"].'</td>';
    $html.='<td>'.$row["first_name"].' '.$row["last_name"].'</td>';
    $html.='<td>'.$row["email"].'</td>';
    $html.='<td>'.$row["GT"].'</td>';
    $html.='<td>'.$row["date_of_birth"].'</td>';
    if ($row["status"] == "1") {
      $html.='<td>Đang Hoạt Động</td>';
    } else {
      $html.='<td>Đã Ngừng Hoạt Động</td>';
    }
    if ($row["classify"] == "1") {
      $html.='<td>Admin</td>';
    } else {
      $html.='<td>customers</td>';
    }
    $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
    $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
    $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
    $html.='</tr>'; 
  }
  if (isset($_POST["submit-btn"])) {
    $select_search = $_POST["select-search"];
    $content_search = $_POST["content-search"];
    $html = search_members($select_search, $content_search);
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
              <p class="dashboard">Control Table - Members</p>
            </div>
            <div class="title-right">
              <form method="post" action="member.php" class="form-search">
                <input type="text" name="content-search" class="content-search">
                <select name="select-search" class="select-search">
                  <option value="all">Search All</option>
                  <option value="id">ID User</option>
                  <option value="first-name">Họ Đệm</option>
                  <option value="last-name">Tên</option>
                  <option value="email">Email</option>
                  <option value="GT">Giới Tính</option>
                  <option value="date_of_birth">Ngày Sinh</option>
                  <option value="status">Trạng Thái</option>
                  <option value="role">Tài Khoản</option>
                </select>
                <button type="submit" name="submit-btn" class="submit-btn">Search Member</button>
                <button type="submit" name="refesh-btn" class="submit-btn">refesh Member</button>
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
                        <th>Họ và Tên</th>
                        <th>Email</th>
                        <th>Giới Tính</th>
                        <th>Ngày Sinh</th>
                        <th>Trạng Thái</th>
                        <th>Tài Khoản</th>
                        <th colspan="3">Edit | Delete | Password</th>
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
            <b>Tổng cộng số thành viện : </b>
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
  </footer>
  <SCRIPT LANGUAGE="JavaScript">
      function confirmdelete() {
        return confirm("Bạn có chắc xóa thành viên này không !")
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
