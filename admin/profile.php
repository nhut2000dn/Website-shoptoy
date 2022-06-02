<?php
  include "../connect.php";
  include "c-search.php";
  include "check-user.php";
  include "c-count.php";
  session_start();
  $email = $_SESSION["emailUser"];
  $password = md5($_SESSION["passwordUser"]);
  $query_check  = "SELECT * FROM account WHERE email='$email' AND password='$password'";
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  $rows = mysqli_fetch_array($result_check,MYSQLI_ASSOC);
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-update-fullname"])) {
    $first_name = $_POST["first-name"];
    $last_name = $_POST["last-name"];
    $query_update  = "UPDATE account
      SET first_name='$first_name', last_name='$last_name'
      WHERE email='$email';";
    $result   = mysqli_query($connection,$query_update)or die("loi cap nhat".mysqli_error($con));
    if ($result) {
      header("Refresh:0");
    }
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-update-password"])) {
    $password = md5($_POST["password"]);
    $password_session = $_POST["password"];
    if (!strlen($_POST["password"]) == "0") {
      $query_update  = "UPDATE account
        SET password='$password'
        WHERE email='$email';";
      $result   = mysqli_query($connection,$query_update)or die("loi cap nhat".mysqli_error($con));
      if ($result) {
        $_SESSION["passwordUser"] = $password_session;
        include "check-user.php";
        header("Refresh:0");
      }
    } else {
      echo "<script type='text/javascript'>alert('không được để trống password');</script>";
      header("Refresh:0");
    }
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-update-gt"])) {
    $GT = $_POST["gioitinh"];
    $query_update  = "UPDATE account
      SET GT=N'$GT'
      WHERE email='$email';";
    $result   = mysqli_query($connection,$query_update)or die("loi cap nhat".mysqli_error($con));
    echo $query_update;
    if ($result) {
      header("Refresh:0");
    }
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-update-birth"])) {
    $date = $_POST["date"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    $dateOfBirth = $year.'/'.$month.'/'.$date;
    if ($_POST["date"] == 0 || $_POST["month"] == 0 || $_POST["year"] == 0) {
      echo "<script type='text/javascript'>alert('Phải điền đầy đủ Ngày/Tháng/Năm');</script>";
      header("Refresh:0");
    } else {
      $query_update  = "UPDATE account
        SET date_of_birth='$dateOfBirth'
        WHERE email='$email';";
      $result   = mysqli_query($connection,$query_update)or die("loi cap nhat".mysqli_error($con));
      if ($result) {
        header("Refresh:0");
      }
    }
  }

  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-full-name"])) {
    $html_fullname.= '
    <th>Họ và Tên:</th>
    <td>
      <input name="first-name" type="text" value="'. $rows["first_name"] .'" style="width:auto">
      <input name="last-name" type="text" value="'. $rows["last_name"] .'" size="5">
    </td>
    <td><button name="btn-update-fullname" class="btn-edit">Update</button></td>';
  } else {
    $html_fullname.= '
    <th>Họ và Tên:</th>
    <td>'. $rows["first_name"] . '  ' . $rows["last_name"] . '</td>
    <td><button name="btn-full-name" class="btn-edit">Edit</button></td>';
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-password"])) {
    $html_password.= '
      <th>Password:</th>
      <td><input name="password" type="text" style="width: 315px;"></td>
      <td><button name="btn-update-password" class="btn-edit">Update</button></td>
    ';
  } else {
    $html_password.= '
      <th>Password:</th>
      <td>'. $rows["password"]. '</td>
      <td><button name="btn-password" class="btn-edit">Edit</button></td>
    ';
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-gt"])) {
    $html_gt.='<th>Giới Tính:</th>';
    $html_gt.='<td>';
    $html_gt.='<select name="gioitinh" id="gt" class="gt">';
    if ($rows["GT"] == "Nam") {
      $html_gt.='
        <option value="Nam" selected="selected">Nam</option>
        <option value="Nữ">Nữ</option>
      ';
    } else {
      $html_gt.='
        <option value="Nam">Nam</option>
        <option value="Nữ" selected="selected">Nữ</option>
      ';
    }
    $html_gt.='</select>';
    $html_gt.='</td>';
    $html_gt.='<td><button name="btn-update-gt" class="btn-edit">Update</button></td>';
  } else {
    $html_gt = '
      <th>Giới Tính:</th>
      <td>'. $rows["GT"]. '</td>
      <td><button name="btn-gt" class="btn-edit">Edit</button></td>
    ';
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-password"])) {
    $html_password= '
      <th>Password:</th>
      <td><input name="password" type="text" style="width: 315px;"></td>
      <td><button name="btn-update-password" class="btn-edit">Update</button></td>
    ';
  } else {
    $html_password='
      <th>Password:</th>
      <td>'. $rows["password"]. '</td>
      <td><button name="btn-password" class="btn-edit">Edit</button></td>
    ';
  }
  //////////////////////////////////////////////////////////////
  if (isset($_POST["btn-date-birth"])) {
    $ngaysinh = $rows["date_of_birth"];
    $date = explode('-', $ngaysinh);
    $yearEdit = $date[0];
    $monthEdit = $date[1];
    $dayEdit  = $date[2];

    $html_date_birth.= '<th>Ngày Sinh:</th>';
    $html_date_birth.= '<td>';
    $html_date_birth.= '<select class = "sn" name="date">';
    $html_date_birth.=  '<option value"=0">Ngày</option>';
    for ($d = 1; $d <= 31; $d++) {
        if (isset($dayEdit) && $dayEdit==$d) {
          $html_date_birth.= '<option value="'.$d.'" selected="selected" >'.$d.'</option>';
        } else {
          $html_date_birth.= '<option value"='.$d.'">'.$d.'</option>';
        }
    }
    $html_date_birth.= '</select>';
    $html_date_birth.= '<select class = "sn" name="month">';
    $html_date_birth.= '<option value"=0">Tháng</option>';
    for ($m = 1; $m <= 12; $m++) {
      if (isset($monthEdit) && $monthEdit==$m) {
        $html_date_birth.= '<option value="'.$m.'" selected="selected" >'.$m.'</option>';
      } else {
        $html_date_birth.= '<option value"='.$m.'">'.$m.'</option>';
      }
    }
    $html_date_birth.= '</select>';
    $html_date_birth.= '<select class = "sn" name="year">';
    $html_date_birth.= '<option value"=0">Năm</option>';
    for ($y = 1930; $y <= 2019; $y++) {
      if (isset($yearEdit) && $yearEdit==$y) {
          $html_date_birth.= '<option value="'.$y.'" selected="selected" >'.$y.'</option>';
      } else {
        $html_date_birth.= '<option value"='.$y.'">'.$y.'</option>';
      }
    }
    $html_date_birth.= '</select>';
    $html_date_birth.= '</td>';
    $html_date_birth.= '<td><button name="btn-update-birth" class="btn-edit">Update</button></td>';
  } else {
    $html_date_birth= '
      <th>Ngày Sinh:</th>
      <td>'. $rows["date_of_birth"]. '</td>
      <td><button name="btn-date-birth" class="btn-edit">Edit</button></td>
    ';
  }
  //////////////////////////////////////////////
  if (isset($_POST["btn-upload"])) {
    $anh = $_FILES['img-file']['name'];
    $ext_error = false;
    $extensions = array('jpg','jpeg','gif','png');
    $file_ext = explode('.',$_FILES['img-file']['name']);
    $file_ext = end($file_ext);
    
    if (!in_array($file_ext, $extensions)) {
        $ext_error = true;
    }
    if ($_FILES['img-file']['error']) {
        echo $phpFileUploadErrors[$_FILES['img-file']['error']];
    }
    elseif ($ext_error) {
        echo "<script type='text/javascript'>alert('file không hợp lệ');</script>";
    }
    if (!file_exists($_FILES['img-file']['tmp_name']) || !is_uploaded_file($_FILES['img-file']['tmp_name']))  {
      echo "<script type='text/javascript'>alert('Chưa Chọn file ảnh');</script>";
    }
    else {
      $queryUpdate = "UPDATE account SET avatar=N'$anh' WHERE email='$email';";
      $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
      if($result) {
        move_uploaded_file($_FILES['img-file']['tmp_name'],'../images/'.$_FILES['img-file']['name']);
        header("Refresh:0");
      }
    }
  }
  /////////////////////////////////////////////////////
  if (strlen($rows["avatar"]) == "0") {
    $html_avatar = '<img class="img-avatar" src="../images/no-avatar.jpg" alt="">';
  } else {
    $html_avatar = '<img class="img-avatar" src="../images/'.$rows["avatar"].'" alt="">';
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
  <link rel="stylesheet" href="css/css-species-pd.css">
  <link rel="stylesheet" href="css/css-profile.css">
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
              <p class="dashboard">Control Table - Profile</p>
            </div>
          </div>
          <!-- <p class="border-bottom"></p> -->
        </section>
        <article class="profile-panel">
              <?php
                echo '
                <form class="profile-box" action="profile.php" method="post" enctype="multipart/form-data">
                  <div class="box-avatar">
                    '.$html_avatar.'
                    <div class="bar-button-avatar">
                    </div>
                    <div class="bus-edit"></div>

                    <div class="overlay" style="display: none;">
                      <div class="modal-wrapper">
                        <div class="modal-content">
                          <a class="close">x</a>
                          <input name="img-file" class="files" type="file" name="file_up">
                          <input name="btn-upload" type="submit" value="Upload">
                        </div>
                      </div>
                    </div>

                  </div>
                  <table class="profile">
                    <tr>
                      '.$html_fullname.'
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>'.$rows["email"].'</td>
                        <td>Default</td>
                    </tr>
                    <tr>
                      '.$html_password.'
                    </tr>
                    <tr>
                      '.$html_gt.'
                    </tr>
                    <tr>
                      '.$html_date_birth.'
                    </tr>
                    <tr>
                        <th>Trạng Thái:</th>
                        <td>Đang Hoạt Động</td>
                        <td>Default</td>
                    </tr>
                    <tr>
                        <th>Tài Khoản:</th>
                        <td>Admin</td>
                        <td>Default</td>
                    </tr>
                  </table>
                </form>
                ';
              ?>
        </article>
      </div>
      <div class="bottom-main-right">
        <div class="nav-btom">
          <div class="txt-nav-bottom">
                 
          </div>
        </div>
      </div>
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

    function confirmdelete() {
      return confirm("Bạn có chắc xóa thành viên này không !")
    }
    function confirmpass() {
      return confirm("Bạn có chắc refresh password thành viên này không !")
    }
    var btnChooseFile = document.getElementsByClassName("bus-edit")[0];
    btnChooseFile.addEventListener("click", function() {
      boxChooseFile.style.display = "flex";
    });
    var btnClose = document.getElementsByClassName("close")[0];
    var boxChooseFile = document.getElementsByClassName("overlay")[0];
    btnClose.addEventListener("click", function() {
      boxChooseFile.style.display = "none";
    });
  </SCRIPT>
</body>
</html>
