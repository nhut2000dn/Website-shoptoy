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
  $query_selectStatus0  = 'SELECT pd_comments.id AS idComments, pd_comments.id_pd, pd_comments.id_account, pd_comments.comment_content,
    pd_comments.status, pd_comments.date, account.id ,account.first_name, account.last_name, account.email, product.id ,product.name_pd, product.image_pd 
    FROM pd_comments, account, product 
    WHERE pd_comments.id_account = account.id AND pd_comments.id_pd = product.id AND pd_comments.status = 0 ORDER BY pd_comments.id DESC';
  $result_check = mysqli_query($connection,$query_selectStatus0) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    static $count_see_yet = 0;
    static $i = 0;
    $count_see_yet++;
    $i++;
    // var_dump($row);
    $html.='<tr>';
    $html.='<td>'.$i.'</td>';
    $html.='<td>'.$row["idComments"].'</td>';
    $html.='<td>'.$row["email"].'</td>';
    $html.='<td>'.$row["name_pd"].'</td>';
    $html.=
    '<td>
        <img src="../images/' .explode_image($row["image_pd"]). '" alt="" class="img-product">
    </td>';
    $html.='<td>'.$row["date"].'</td>';
    $html.='<td class="button"><a href="comment-product.php?idComments='.$row["idComments"].'" class="btn-edit">View</a></td>';
    $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-comment.php?id='.$row["idComments"].'" class="btn-delete">Delete</a></td>';
    $html.='</tr>'; 
  }

  $query_selectStatus1  = 'SELECT pd_comments.id AS idComments, pd_comments.id_pd, pd_comments.id_account, pd_comments.comment_content,
    pd_comments.status, pd_comments.date, account.id ,account.first_name, account.last_name, account.email, product.id ,product.name_pd, product.image_pd 
    FROM pd_comments, account, product 
    WHERE pd_comments.id_account = account.id AND pd_comments.id_pd = product.id AND pd_comments.status = 1 ORDER BY pd_comments.id DESC';
  $result_check = mysqli_query($connection,$query_selectStatus1) or die ("loi".mysqli_error($connection));
  while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
    static $count_saw = 0;
    static $i = 0;
    $count_saw++;
    $i++;
    // var_dump($row);
    $html2.='<tr>';
    $html2.='<td>'.$i.'</td>';
    $html2.='<td>'.$row["idComments"].'</td>';
    $html2.='<td>'.$row["email"].'</td>';
    $html2.='<td>'.$row["name_pd"].'</td>';
    $html2.=
    '<td>
        <img src="../images/' .explode_image($row["image_pd"]). '" alt="" class="img-product">
    </td>';
    $html2.='<td>'.$row["date"].'</td>';
    $html2.='<td class="button"><a href="comment-product.php?idComments='.$row["idComments"].'" class="btn-edit">View</a></td>';
    $html2.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-comment.php?id='.$row["idComments"].'" class="btn-delete">Delete</a></td>';
    $html2.='</tr>'; 
  }



  
  if (isset($_POST["submit-btn"])) {
    $select_search = $_POST["select-search"];
    $content_search = $_POST["content-search"];
    $html = search_species($select_search, $content_search);
  }

  if(isset($_GET["idComments"])) {
    $idComments = $_GET["idComments"];
    $htmlContentComment1;
    $queryUpdate = "UPDATE pd_comments SET status='1' WHERE pd_comments.id='$idComments'";
    $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($con));
    $query_selectContent  = "SELECT pd_comments.id AS idComments, pd_comments.id_pd, pd_comments.id_account, pd_comments.comment_content,
    pd_comments.status, account.id ,account.first_name, account.last_name, product.id ,product.name_pd, product.image_pd 
    FROM pd_comments, account, product 
    WHERE pd_comments.id_account = account.id AND pd_comments.id_pd = product.id AND pd_comments.id='$idComments'";
    $result_check = mysqli_query($connection,$query_selectContent) or die ("loi".mysqli_error($connection));
    while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
     static $countOrderDetail = 0;
     $countOrderDetail++;
     $i++;
     $htmlContentComment1.='<p>' . $row["comment_content"] .'</p>';
    }
    $htmlContentComment2 = '
      <div class="view" id="view">
        <div class="modal__content">
          <a href="comment-product.php" class="modal__close">&times;</a>
          <h2 class="modal__heading">Detail Comment</h2>
          <p>' . $htmlContentComment1 . '</p>
          </table>
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
  <link rel="stylesheet" href="css/css-comment-product.css">
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
              <p class="dashboard">Control Table - Comment</p>
            </div>
            <div class="title-right">
              <form method="post" action="species-product.php" class="form-search">
                <input type="text" name="content-search" class="content-search">
                <select name="select-search" class="select-search">
                  <option value="all">Search All</option>
                  <option value="id">ID Loại</option>
                  <option value="name">Tên Loại</option>
                </select>
                <button type="submit" name="submit-btn" class="submit-btn">Search Comment</button>
                <button type="submit" name="refesh-btn" class="submit-btn">refesh Table</button>
              </form>
            </div>
          </div>
          <!-- <p class="border-bottom"></p> -->
        </section>
        <article>
            <div class="tab">
                <button class="tablinks" onclick="openCity(event, 'chua-xem')" id="defaultOpen">Chưa Xem(<?php echo $count_see_yet ?>)</button>
                <button class="tablinks" onclick="openCity(event, 'da-xem')">Đã Xem(<?php echo $count_saw ?>)</button>
            </div>

            <div id="chua-xem" class="tabcontent tab-hien">
                <table class="member">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Người Nhận Xét</th>
                            <th>Đồ Chơi</th>
                            <th>Hình Ảnh</th>
                            <th>Ngày Bình Luận</th>
                            <th colspan="2">View | Delete</th>
                        </tr>
                    </thead>
                    <tbody class="content-table">
                        <?php
                        echo $html; 
                        ?>
                    </tbody>
                </table>
            </div>

            <div id="da-xem" class="tabcontent">
                <table class="member">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Tài Khoản Nhận Xét</th>
                            <th>Đồ Chơi</th>
                            <th>Hình Ảnh</th>
                            <th>Ngày Bình Luận</th>
                            <th colspan="2">View | Delete</th>
                        </tr>
                    </thead>
                    <tbody class="content-table">
                        <?php
                        echo $html2; 
                        ?>
                    </tbody>
                </table>
            </div>

        </article>
      </div>
      <div class="bottom-main-right">
        <div class="nav-btom">
          <div class="txt-nav-bottom">
            <b>Tổng cộng số Comment : </b>
            <span>
              <?php
                echo $count_saw + $count_see_yet;
              ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer class="page-footer">
    <?php
      echo $htmlContentComment2;
    ?>
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
      return confirm("Bạn có chắc xóa Comment này không !")
    }
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </SCRIPT>
</body>
</html>
