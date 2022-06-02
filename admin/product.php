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
  $query_check  = 'SELECT product.id AS pd_id, product.name_pd, product.url_name_pd, product.image_pd, product.describe_pd, product.material_pd, product.recommended_age, 
  product.ideal_for, product.species_pd, product.price_pd, product.amount_pd, pd_species.id, pd_species.name_species, pd_species.url_name_species, 
  pd_recommended_age.id, pd_recommended_age.name_r_age, pd_recommended_age.url_name_r_age, pd_ideal_for.id, pd_ideal_for.name_ideal_for, 
  pd_ideal_for.url_name_ideal, pd_material.id, pd_material.name_material, pd_material.url_name_material 
  FROM product, pd_species, pd_recommended_age, pd_ideal_for, pd_material 
  WHERE product.material_pd = pd_material.id AND product.recommended_age = pd_recommended_age.id AND product.ideal_for = pd_ideal_for.id 
    AND product.species_pd = pd_species.id ORDER BY product.id';
  $result_check = mysqli_query($connection,$query_check) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    static $count = 0;
    static $i = 0;
    $count++;
    $i++;
    // var_dump($row);
    $html.='<tr>';
    $html.='<td>'.$i.'</td>';
    $html.='<td>'.$row["pd_id"].'</td>';
    $html.='<td class="name-product">'.$row["name_pd"].'</td>';
    $html.='<td class="name-product">'.$row["url_name_pd"].'</td>';
    $html.=
    '<td>
        <img src="../images/'.explode_image($row["image_pd"]).'" alt="" class="img-product">
    </td>';
    // $html.='<td>'.$row["image_pd"].'</td>';
    $html.='<td class="describe">'.$row["describe_pd"].'</td>';
    $html.='<td>'.$row["name_material"].'</td>';
    $html.='<td>'.$row["name_r_age"].'</td>';
    $html.='<td>'.$row["name_ideal_for"].'</td>';
    $html.='<td class="species-product">'.$row["name_species"].'</td>';
    $html.='<td>'.$row["amount_pd"].'</td>';
    $html.='<td>'.$row["price_pd"].'</td>';
    
    $html.='<td class="button"><a href="edit-product.php?id='.$row["pd_id"].'" class="btn-edit">Edit</a></td>';
    $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-product.php?id='.$row["pd_id"].'" class="btn-delete">Delete</a></td>';
    $html.='</tr>'; 
  }
  if (isset($_POST["submit-btn"])) {
    $select_search = $_POST["select-search"];
    $content_search = $_POST["content-search"];
    $html = search_product($select_search, $content_search);
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
  <link rel="stylesheet" href="css/css-product.css">
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
              <p class="dashboard">Control Table - Product</p>
            </div>
            <div class="title-right">
              <form method="post" action="product.php" class="form-search">
                <input type="text" name="content-search" class="content-search">
                <select name="select-search" class="select-search">
                  <option value="all">Search All</option>
                  <option value="id">ID Product</option>
                  <option value="ten">Tên Đồ Chơi</option>
                  <option value="url-ten">URL Đồ Chơi</option>
                  <option value="chat-lieu">Chất Liệu</option>
                  <option value="so-luong">Số Lượng</option>
                  <option value="gia">Giá Đồ Chơi</option>
                  <option value="loai">Loại Đồ Chơi</option>
                </select>
                <button type="submit" name="submit-btn" class="submit-btn">Search Product</button>
                <button type="submit" name="refesh-btn" class="submit-btn">refesh Table</button>
                <a href="add-product.php" class="submit-btn btn-add">
                    Thêm Đồ Chơi
                  <i class="fas fa-plus-square"></i>
                </a>
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
                        <th>Tên Đồ Chơi</th>
                        <th>URL Đồ Chơi</th>
                        <th>Ảnh Đồ Chơi</th>
                        <th>Mô Tả</th>
                        <th>Chất Liệu</th>
                        <th>Tuổi thích hợp</th>
                        <th>thích hợp cho</th>
                        <th>Loại</th>
                        <th>Amount</th>
                        <th>Giá</th>
                        <th colspan="2">Edit | Delete</th>
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
            <b>Tổng cộng số Đồ Chơi : </b>
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
        return confirm("Bạn có chắc xóa Đồ Chơi này không !")
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
