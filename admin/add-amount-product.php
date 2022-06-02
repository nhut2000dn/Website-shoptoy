<?php
    include "../connect.php";
    include "check-user.php";
    include "c-count.php";
    session_start();
    if(!isset($_GET["id"])) {
      header ("location:member.php");
    }
    $id_Product = $_GET["id"];
    $query_check  = 'SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd,
    product.Material_pd, product.amount_pd, product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies
    FROM product, pd_species 
    WHERE product.id="'.$id_Product.'" AND pd_species.id = product.species_pd';
    $result_check = mysqli_query($connection, $query_check) or die ("loi".mysqli_error($connection));
    while ($row=mysqli_fetch_array($result_check, MYSQLI_ASSOC)) {
      $name_pd = $row["name_pd"];
      $image_pd = $row["image_pd"];
      $describe_pd = $row["describe_pd"];
      $Material_pd = $row["Material_pd"];
      $amount_pd = $row["amount_pd"];
      $price_pd = $row["price_pd"];
      $species_pd = $row["species_pd"];
      $name_species = $row["nameSpecies"];
    }
    $anh;
    $error;
    $check = true;

    if (isset($_POST["submit-btn"])) {

      if (strlen($_POST["ten"]) == "0") {
        $error.= "<li>Tên đồ chơi không được để trống !</li>";
        $check = false;
      }
      if (strlen($_POST["so-luong"]) == 0) {
        $error.= "<li>Số lượng không được để trống !</li>";
        $check = false;
      }
      if ($check == true) {
        $soLuong = $_POST["so-luong"];

        $queryUpdate = "UPDATE product SET amount_pd='$soLuong' WHERE product.id = '$id_Product'";
        $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
        if($result) {
          echo "<script type='text/javascript'>alert('Update Thành Công');</script>";
          echo'<meta http-equiv="refresh" content="0; url=OutOfStock.php" />';
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
  <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
  <title>Document</title>
  <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#blah')
              .attr('src', e.target.result)
              .width(118)
              .height(118);
        };
        reader.readAsDataURL(input.files[0]);
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
      <form action="<?php echo "add-amount-product.php?id=$id_Product" ?>" method="post" enctype="multipart/form-data">
        <table>
            <tbody>
                <tr><td><span>Tên Đồ Chơi</span></td></tr>
                <tr><td><input name="ten"  type="text" placeholder="Nhập Tên Đồ Chơi" value="<?php if(isset($name_pd)) echo $name_pd;?>" readonly></td></tr>
                <tr><td><span>Hình Ảnh</span></td></tr>
                <tr><td><img id="blah" src="../images/<?php if(isset($image_pd)) echo $image_pd;?>" alt="" class="img-product"></td></tr>

                <tr><td><span>Số Lượng</span></td></tr>
                <tr><td><input name="so-luong" type="number" placeholder="Nhập số lượng của đồ chơi" value="<?php if(isset($amount_pd)) echo $amount_pd;?>"></td></tr>
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
  </SCRIPT>
</body>
</html>
