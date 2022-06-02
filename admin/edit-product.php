<?php
    include "../connect.php";
    include "check-user.php";
    include "c-count.php";
    session_start();
    if(!isset($_GET["id"])) {
      header ("location:member.php");
    }
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


    $id_Product = $_GET["id"];
    // $query_check  = 'SELECT * FROM product WHERE id="'.$id_Product.'"';
    $query_check  = 'SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd,
    product.material_pd, product.recommended_age, product.ideal_for, product.amount_pd, product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies
    FROM product, pd_species 
    WHERE product.id="'.$id_Product.'" AND pd_species.id = product.species_pd';
    $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
    while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
      $name_pd = $row["name_pd"];

      $describe_pd = $row["describe_pd"];
      $material_pd = $row["material_pd"];
      $recommended_age = $row["recommended_age"];
      $ideal_for = $row["ideal_for"];
      $amount_pd = $row["amount_pd"];
      $price_pd = $row["price_pd"];
      $species_pd = $row["species_pd"];
      $name_species = $row["nameSpecies"];

      $img_insert = $row["image_pd"];
      $pieces_img = explode(",", $img_insert);
      for ($i = 0; $i < count($pieces_img); $i++) {
        $file_img = 'images/'.$pieces_img[$i];
        if (file_exists($file_img)) {
          $html_img_main.='<img id="blah" src="../images/'.$pieces_img[$i].'" alt="" class="img-product">';
        } else {
          $html_img_main.='<img id="blah" src="../images/'.$pieces_img[$i].'" alt="" class="img-product">';
        }
      }
    }
    $anh;
    $error;
    $check = true;
    $html_images = '';
    $i_img = 0;
    $count_img_file = 0;
    $array = array();
    $array_img_file = array();
    $img_insert = '';

    if (isset($_POST["submit-btn"])) {

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
      if (strlen($_POST["chat-lieu"]) == 0) {
        $error.= "<li>Chất liệu không được để trống !</li>";
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
          }
      }

      if ($check == true) {
        $tenDoChoi = $_POST["ten"];
        $moTa = $_POST["mo-ta"];
        $chatLieu = $_POST["chat-lieu"];
        $tuoiThichHop = $_POST["tuoi-thich-hop"];
        $gtThichHop = $_POST["gt-thich-hop"];
        $urlTenDoChoi = strtolower(vn_to_str($_POST["ten"])); 
        $soLuong = $_POST["so-luong"];
        $gia = $_POST["gia"];
        $loai = $_POST["loai"];

        $queryUpdate = "UPDATE product SET name_pd=N'$tenDoChoi', url_name_pd='$urlTenDoChoi', image_pd='$img_insert', describe_pd=N'$moTa', material_pd=N'$chatLieu', recommended_age='$tuoiThichHop', ideal_for='$gtThichHop', species_pd='$loai', amount_pd='$soLuong', price_pd='$gia' WHERE product.id = '$id_Product'";

        $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
        if($result) {
          echo "<script type='text/javascript'>alert('Update Thành Công');</script>";
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
      var boxToyCart = document.getElementsByClassName('container-images-old')[0].innerHTML = '';
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
        <p class="edit">Edit Product</p>
        <p class="border-bottom"></p>
      </section>
      <form action="<?php echo "edit-product.php?id=$id_Product" ?>" method="post" enctype="multipart/form-data">
        <table class="container-table">
            <tbody>
                <tr><td><span>Tên Đồ Chơi</span></td></tr>
                <tr><td><input name="ten" type="text" placeholder="Nhập Tên Đồ Chơi" value="<?php if(isset($name_pd)) echo $name_pd;?>"></td></tr>
                <tr><td><span>Hình Ảnh</span></td></tr>
                <tr><td  class="container-images-old"><?php echo $html_img_main ?></td></tr>
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
                    <textarea name="mo-ta" rows="7" cols="70"><?php if(isset($describe_pd)) echo $describe_pd;?></textarea>
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
                                  if ($material_pd == $row["id"]) {
                                    echo '<option value = " ' . $row["id"] . ' " selected="selected"> ' . $row["name_material"] .' </option>';
                                  } else {
                                    echo '<option value = " ' . $row["id"] . ' "> ' . $row["name_material"] .' </option>';
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
                                  if ($recommended_age == $row["id"]) {
                                    echo '<option value = " ' . $row["id"] . ' " selected="selected"> ' . $row["name_r_age"] .' </option>';
                                  } else {
                                    echo '<option value = " ' . $row["id"] . ' "> ' . $row["name_r_age"] .' </option>';
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
                                  if ($ideal_for == $row["id"]) {
                                    echo '<option value = " ' . $row["id"] . ' " selected="selected"> ' . $row["name_ideal_for"] .' </option>';
                                  } else {
                                    echo '<option value = " ' . $row["id"] . ' "> ' . $row["name_ideal_for"] .' </option>';
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
                                  if ($species_pd == $row["id"]) {
                                    echo '<option value = " ' . $row["id"] . ' " selected="selected"> ' . $row["name_species"] .' </option>';
                                  } else {
                                    echo '<option value = " ' . $row["id"] . ' "> ' . $row["name_species"] .' </option>';
                                  }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr><td><span>Số Lượng</span></td></tr>
                <tr><td><input name="so-luong" type="number" placeholder="Nhập số lượng của đồ chơi" value="<?php if(isset($amount_pd)) echo $amount_pd;?>"></td></tr>
                <tr><td><span>Giá Đồ Chơi</span></td></tr>
                <tr><td><input name="gia" type="number" placeholder="Nhập giá của đồ chơi" value="<?php if(isset($price_pd)) echo $price_pd;?>"></td></tr>
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
