<?php
    include "../connect.php";
    include "check-user.php";
    include "c-count.php";
    session_start();
    function vn_to_str ($str){
    
    $unicode = array(
    
      'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
      
      'd'=>'đ',
      
      'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
      
      'i'=>'í|ì|ỉ|ĩ|ị',
      
      'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
      
      'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
      
      'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
      
      'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
      
      'D'=>'Đ',
      
      'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
      
      'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
      
      'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
      
      'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
      
      'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
      
      );
      
      foreach($unicode as $nonUnicode=>$uni){
      
      $str = preg_replace("/($uni)/i", $nonUnicode, $str);
      
      }
      $str = str_replace(' ','-',$str);
      $str = str_replace('&','and',$str);
      
      return $str;
    }
    if(!isset($_GET["id"])) {
      header ("location:species-product.php");
    }
    $idIdealFor = $_GET["id"];
    $query_check  = 'SELECT * FROM pd_ideal_for WHERE id="'.$idIdealFor.'"';
    $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
    while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
        $nameIdealFor = $row["name_ideal_for"];
    }
    $error;
    $check = true;
    if (isset($_POST["submit-btn"])) {
        $urlNameIdealFor = strtolower(vn_to_str($_POST["nameIdealFor"]));
        if (strlen($_POST["nameIdealFor"]) == "0") {
            $error.= "<li>Tên Tuổi Thích Hợp không được để trống !</li>";
            $check = false;
        }
        if ($check == true) {
            $nameIdealFor = $_POST["nameIdealFor"];
            $queryUpdate  = "UPDATE pd_ideal_for SET name_ideal_for=N'$nameIdealFor', url_name_ideal=N'$urlNameIdealFor' WHERE id='$idIdealFor'";
            $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
            if($result) {
                echo "<script type='text/javascript'>alert('Update thanh cong');</script>";
                echo'<meta http-equiv="refresh" content="0; url=ideal-for-product.php" />';
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
        <p class="edit">Edit User</p>
        <p class="border-bottom"></p>
      </section>
      <form action="<?php echo "edit-ideal-for-product.php?id=$idIdealFor" ?>" method="post">
        <table>
            <tbody>
                <tr><td><span>Tên Tuổi Thích Hợp</span></td></tr>
                <tr><td><input name="nameIdealFor" type="text" placeholder="Nhập Tên Tuổi Thích Hợp" value="<?php if(isset($nameIdealFor)) echo $nameIdealFor;?>"></td></tr>
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
