<?php
    include "../connect.php";
    include "check-user.php";
    include "c-count.php";
    session_start();
    $anh;

    $error;
    $html_images = '';
    $i_img = 0;
    $count_img_file = 0;
    $check = true;
    $array = array();
    $array_img_file = array();
    $img_insert = '';

    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
    
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }
    if (isset($_POST["submit-btn"])) {
        $tenDoChoi = $_POST["ten"];
        $moTa = $_POST["mo-ta"];
        $chat_lieu = $_POST["chat-lieu"];
        $tuoi_thich_hop = $_POST["tuoi-thich-hop"];
        $gt_thich_hop = $_POST["gt-thich-hop"];
        $loai = $_POST["loai"];
        $soLuong = $_POST["so-luong"];
        $gia = $_POST["gia"];
        
      $phpFileUploadErrors = array(
          0 => 'There is no error, the file uploaded with success',
          1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
          2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
          3 => 'The uploaded file was only partially uploaded',
          4 => 'No file was uploaded',
          6 => 'Missing a temporary folder',
          7 => 'Failed to write file to disk.',
          8 => 'A PHP extension stopped the file upload.',
      );

      if (strlen($_POST["ten"]) == "0") {
        $error.= "<li>Tên đồ chơi không được để trống !</li>";
        $check = false;
      }
      if (strlen($_POST["mo-ta"]) == 0) {
        $error.= "<li>Mô Tả đồ chơi không được để trống !</li>";
        $check = false;
      }
      if (strlen($_POST["so-luong"]) == 0) {
        $error.= "<li>Số lượng không được để trống !</li>";
        $check = false;
      }
      if (strlen($_POST["gia"]) == 0) {
        $error.= "<li>Giá không được để trống !</li>";
        $check = false;
      }
      if (isset($_FILES['userfile'])) {
          $file_array = reArrayFiles($_FILES['userfile']);
          for ($i = 0; $i < count($file_array); $i++) {
              if($file_array[$i]['error']){
                  // echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
              } else {
                  $extensions = array('jpg', 'png', 'gif', 'jpeg');
                  $file_ext = explode('.', $file_array[$i]['name']);
                  $file_ext = end($file_ext);
                  if (!in_array($file_ext, $extensions)) {
                      $error.="<li>{$file_array[$i]['name']} - file phải có định dạng jpg, jpeg, gif, png !</li>";
                      $check = false;
                  }
                  if ($check == false) {
                  } else {
                      $array_img_file[$i]['temp-name'] = $file_array[$i]['tmp_name'];
                      $array_img_file[$i]['name'] = $file_array[$i]['name'];
                      if ($i_img == 0) {
                        $img_insert.= $file_array[$i]['name'];
                      } else {
                        $img_insert.=','.$file_array[$i]['name'];
                      }
                      $i_img++;
                      $count_img_file++;
                  }
              }
              if (!file_exists($file_array[$i]['tmp_name']) || !is_uploaded_file($file_array[$i]['tmp_name']))  {
                  $check = false;
                  $error.= "<li>Hình không được để trống !</li>";
              }
          }
      }
      if ($count_img_file >= 41) {
        $check = false;
        $error.= "<li>Hình không được vượt quá 40 hình !</li>";
      }
      if ($check == true) {
        $queryInsert = "INSERT INTO product(name_pd, url_name_pd, image_pd, describe_pd, material_pd, recommended_age, ideal_for, species_pd, amount_pd, price_pd) VALUES (N'$tenDoChoi', N'$tenDoChoi', '$img_insert', N'$moTa', '$chat_lieu', '$tuoi_thich_hop', '$gt_thich_hop', '$loai', '$soLuong','$gia');";
        $result   = mysqli_query($connection,$queryInsert)or die("loi cap nhat".mysqli_error($con));
        if($result) {
          foreach ($array_img_file as $row) {
            move_uploaded_file($row['temp-name'], '../images/'.$row['name']);
          }
          echo "<script type='text/javascript'>alert('Insert Thành Công');</script>";
          echo'<meta http-equiv="refresh" content="0; url=product.php" />';
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
  <link rel="stylesheet" href="css/css-edit-product.css">

  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
  <title>Document</title>
  <script>

    function readURL(input) {
      var numFiles = $("input:file")[0].files.length;
      var i = 0;
      var images = '.blah0';
      for (var i = 0; i < numFiles; i++) {
        if (input.files && input.files[i]) {
          var reader = new FileReader();

            var countI = 0;
            
            reader.onload = function (e) {
              countI++;
              $('.blah'+countI)
                .attr('src', e.target.result)
                .width(118)
                .height(118);
            };

          reader.readAsDataURL(input.files[i]);
        }
      }
    }
  </script>
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
        <p class="edit">Add Product</p>
        <p class="border-bottom"></p>
      </section>
      <form action="test3.php" method="POST" enctype="multipart/form-data">
        <table class="container-table">
            <tbody>
                <tr><td><span>Tên Đồ Chơi</span></td></tr>
                <tr><td><input name="ten" type="text" placeholder="Nhập Tên Đồ Chơi" value="<?php if(isset($tenDoChoi)) echo $tenDoChoi;?>"></td></tr>
                <tr><td><span>Hình Ảnh</span></td></tr>
                <tr>
                  <td class="container-images">
                  <!-- javascipt code -->
                  </td>
                </tr>
                <tr><td><span>Chọn Ảnh</span></td></tr>
                <tr><td><input type="file" name="userfile[]" value="" multiple="" onchange="readURL(this);"></td></tr>
                <tr></tr>
                <tr><td><span>Mô Tả</span></td></tr>
                <tr>
                  <td>
                    <textarea name="mo-ta" rows="7" cols="70"><?php if(isset($moTa)) echo $moTa;?></textarea>
                  </td>
                </tr>
                <tr><td><span>Chất Liệu</span></td></tr>
                <tr>
                    <td>
                        <select id="taikhoan" class="classify" name="chat-lieu">';
                            <?php
                                $query_check  = 'SELECT * FROM `pd_material` WHERE 1';
                                $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
                                while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
                                  if ($chat_lieu==$row["id"]) {
                                    echo '<option value = "' . $row["id"] . '" selected="selected"> ' . $row["name_material"] .' </option>';
                                  } else {
                                    echo '<option value = "' . $row["id"] . '"> ' . $row["name_material"] .' </option>';
                                  }
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr><td><span>Tuổi Thích Hợp</span></td></tr>
                <tr>
                    <td>
                        <select id="taikhoan" class="classify" name="tuoi-thich-hop">';
                            <?php
                                $query_check  = 'SELECT * FROM `pd_recommended_age` WHERE 1';
                                $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
                                while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
                                  if ($tuoi_thich_hop == $row['id']) {
                                    echo '<option value = "' . $row["id"] . '" selected="selected"> ' . $row["name_r_age"] .' </option>';
                                  } else {
                                    echo '<option value = "' . $row["id"] . '"> ' . $row["name_r_age"] .' </option>';
                                  }
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr><td><span>Thích Hợp Cho</span></td></tr>
                <tr>
                    <td>
                        <select id="taikhoan" class="classify" name="gt-thich-hop">';
                            <?php
                                $query_check  = 'SELECT * FROM `pd_ideal_for` WHERE 1';
                                $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
                                while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
                                  if ($tuoi_thich_hop == $row["id"]) {
                                    echo '<option value = "' . $row["id"] . '" selected="selected"> ' . $row["name_ideal_for"] .' </option>';
                                  } else {
                                    echo '<option value = "' . $row["id"] . '"> ' . $row["name_ideal_for"] .' </option>';
                                  }
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr><td><span>Loại Đồ Chơi</span></td></tr>  
                <tr>
                    <td>
                        <select id="taikhoan" class="classify" name="loai">';
                            <?php
                                $query_check  = 'SELECT * FROM `pd_species` WHERE 1';
                                $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
                                while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
                                  if ($loai == $row["id"]) {
                                    echo '<option value = "' . $row["id"] . '" selected="selected"> ' . $row["name_species"] .' </option>';
                                  } else {
                                    echo '<option value = "' . $row["id"] . '"> ' . $row["name_species"] .' </option>';
                                  }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td><span>Số Lượng</span></td></tr>
                <tr><td><input name="so-luong" type="number" placeholder="Nhập số lượng của đồ chơi" value="<?php if(isset($soLuong)) echo $soLuong;?>"></td></tr>
                <tr><td><span>Giá Đồ Chơi</span></td></tr>
                <tr><td><input name="gia" type="number" placeholder="Nhập giá của đồ chơi" value="<?php if(isset($gia)) echo $gia;?>"></td></tr>

                <tr>
                    <td>
                        <button type="submit" value="Upload" name="submit-btn">Update</button>
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
    var html = '';
    var boxToyCart = document.getElementsByClassName('container-images')[0];

    for (var i = 1; i <= 20; i++) {
      html='<img id="blah'+i+'" class="img-product blah'+i+'" src="../images/" alt="">';
      boxToyCart.insertAdjacentHTML('beforeend', html);
    }
  </SCRIPT>
</body>
</html>
