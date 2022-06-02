<?php
    function search_members($select_search, $content_search) {
      include "../connect.php";
      if ($select_search == "all") {
        $html='';
        $query_search  = "SELECT * FROM shop_toy.account WHERE id LIKE '%$content_search' OR first_name LIKE '%$content_search' 
          OR last_name LIKE '%$content_search' OR email LIKE '%$content_search' OR GT LIKE '%$content_search' OR date_of_birth LIKE '%$content_search' 
          OR status LIKE '%$content_search' OR classify LIKE '%$content_search'";
        $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
        while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
          static $i = 0;
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
          $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
          $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
          $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
          $html.='</tr>'; 
        }
        if ($html == '') {
          $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          static $i = 0;
          $i++;
          $html.='<tr>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
          $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
          $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
          $html.='</tr>'; 
        }
      }
      if ($select_search == "id") {
        $html='';
        $query_search  = "SELECT * FROM shop_toy.account WHERE id='$content_search'";
        $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
        while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
          static $i = 0;
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
          $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
          $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
          $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
          $html.='</tr>'; 
        }
        if ($html == '') {
          $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          static $i = 0;
          $i++;
          $html.='<tr>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
          $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
          $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
          $html.='</tr>'; 
        }
      }
      else if ($select_search == "first-name") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.account WHERE first_name LIKE '%$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $i = 0;
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
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
      }
      else if ($select_search == "last-name") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.account WHERE last_name LIKE '%$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $i = 0;
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
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
      }
      else if ($select_search == "email") {
        $html='';
        $query_search  = "SELECT * FROM shop_toy.account WHERE email LIKE '%$content_search'";
        $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
        while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
          static $i = 0;
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
          $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
          $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
          $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
          $html.='</tr>'; 
        }
        if ($html == '') {
          $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          static $i = 0;
          $i++;
          $html.='<tr>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td>            </td>';
          $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
          $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
          $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
          $html.='</tr>'; 
        }
      }
      else if ($select_search == "GT") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.account WHERE GT='$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $i = 0;
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
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
      }
      else if ($select_search == "date_of_birth") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.account WHERE date_of_birth='$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $i = 0;
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
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
      }
      else if ($select_search == "status") {
          $html='';
          $content = '';
          if ($content_search == 'Đang Hoạt Động') {
              $content = 1;
          } else {
              $content = 0;
          }
          $query_search  = "SELECT * FROM shop_toy.account WHERE status LIKE '%$content'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $i = 0;
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
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
      }
      else if ($select_search == "role") {
          $html='';
          $content = '';
          if ($content_search == 'Admin') {
              $content = 1;
          } else {
              $content = 0;
          }
          $query_search  = "SELECT * FROM shop_toy.account WHERE classify LIKE '%$content'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $i = 0;
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
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a onclick="return confirmpass()" href="c-refesh-password.php?id='.$row["id"].'" class="btn-Refesh">Refesh</a></td>';
            $html.='</tr>'; 
          }
      }
        return $html;
      }

      function search_species($select_search, $content_search) {
        include "../connect.php";
        if ($select_search == "all") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.pd_species WHERE id LIKE '%$content_search' OR name_species LIKE '%$content_search' 
            OR describe_species LIKE '%$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id"].'</td>';
            $html.='<td>'.$row["name_species"].'</td>';
            $html.='<td>'.$row["url_name_species"].'</td>';
            $html.='<td>'.$row["describe_species"].'</td>';
        
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
        }
        else if ($select_search == "id") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.pd_species WHERE id='$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id"].'</td>';
            $html.='<td>'.$row["name_species"].'</td>';
            $html.='<td>'.$row["describe_species"].'</td>';
        
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
        }
        else if ($select_search == "name") {
          $html='';
          $query_search  = "SELECT * FROM shop_toy.pd_species WHERE name_species LIKE '%$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id"].'</td>';
            $html.='<td>'.$row["name_species"].'</td>';
            $html.='<td>'.$row["describe_species"].'</td>';
        
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
            static $i = 0;
            $i++;
            $html.='<tr>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td>            </td>';
            $html.='<td class="button"><a href="c-edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
        }
        return $html;
      }

      function search_product($select_search, $content_search) {
        include "../connect.php";
        if ($select_search == "all") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
            product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
            FROM product, pd_species 
            WHERE pd_species.id = product.species_pd AND product.id = '$content_search' OR product.name_pd='$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "id") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
            product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
            FROM product, pd_species 
            WHERE pd_species.id = product.species_pd AND product.id = '$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "ten") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
           product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
           FROM product, pd_species 
           WHERE pd_species.id = product.species_pd AND product.name_pd LIKE '%$content_search%'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "chat-lieu") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
           product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
           FROM product, pd_species 
           WHERE pd_species.id = product.species_pd AND product.Material_pd LIKE '%$content_search%'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "so-luong") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
           product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
           FROM product, pd_species 
           WHERE pd_species.id = product.species_pd AND product.amount_pd='$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "gia") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
           product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
           FROM product, pd_species 
           WHERE pd_species.id = product.species_pd AND product.price_pd='$content_search'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "loai") {
          $html='';
          $query_search  = "SELECT product.id AS id_pd, product.name_pd, product.image_pd, product.describe_pd, product.Material_pd, product.amount_pd,
           product.price_pd, product.species_pd, pd_species.id AS id_species, pd_species.name_species AS nameSpecies 
           FROM product, pd_species 
           WHERE pd_species.id = product.species_pd AND pd_species.name_species LIKE '%$content_search%'";
          $result_check = mysqli_query($connection,$query_search) or die ("loi".mysqli_error($connection));
          while($row=mysqli_fetch_array($result_check,MYSQLI_ASSOC)) {
            static $count = 0;
            static $i = 0;
            $count++;
            $i++;
            // var_dump($row);
            $html.='<tr>';
            $html.='<td>'.$i.'</td>';
            $html.='<td>'.$row["id_pd"].'</td>';
            $html.='<td class="name-product">'.$row["name_pd"].'</td>';
            $html.=
            '<td>
                <img src="../images/' .$row["image_pd"]. '" alt="" class="img-product">
            </td>';
            // $html.='<td>'.$row["image_pd"].'</td>';
            $html.='<td>'.$row["describe_pd"].'</td>';
            $html.='<td>'.$row["Material_pd"].'</td>';
            $html.='<td>'.$row["amount_pd"].'</td>';
            $html.='<td>'.$row["price_pd"].'</td>';
            $html.='<td class="species-product">'.$row["nameSpecies"].'</td>';
            
            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-edit">Edit</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["id"].'" class="btn-delete">Delete</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        return $html;
      }


      function search_order_product($select_search, $content_search) {
        include "../connect.php";
        if ($select_search == "all") {
          $html='';
          $query_check  = "SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
          order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
          FROM order_product, account 
          WHERE order_product.id_account = account.id AND order_product.id='$content_search' OR  order_product.phone_number='$content_search'";
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

            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-Refesh">View</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "id") {
          $html='';
          $query_check  = "SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
          order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
          FROM order_product, account 
          WHERE order_product.id_account = account.id AND order_product.id='$content_search'";
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

            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-Refesh">View</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "SDT") {
          $html='';
          $query_check  = "SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
          order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
          FROM order_product, account 
          WHERE order_product.id_account = account.id AND order_product.phone_number='$content_search'";
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

            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-Refesh">View</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "thanh-toan") {
          $content_thanhtoan;
          if ($content_search == 'Đã Thanh Toán') {
            $content_thanhtoan = 1;
          } else if ($content_search == 'Chưa Thanh Toán') {
            $content_thanhtoan = 0;
          }
          $html='';
          $query_check  = "SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
          order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
          FROM order_product, account 
          WHERE order_product.id_account = account.id AND order_product.pay='$content_thanhtoan'";
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

            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-Refesh">View</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "first-name") {
          $html='';
          $query_check  = "SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
          order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
          FROM order_product, account 
          WHERE order_product.id_account = account.id AND account.first_name LIKE '%$content_search'";
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

            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-Refesh">View</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        else if ($select_search == "last-name") {
          $html='';
          $query_check  = "SELECT order_product.id AS orderId, order_product.id_account, order_product.created_date, order_product.date_of_delivery,
          order_product.address, order_product.phone_number, order_product.pay, account.id AS accountID, account.first_name AS hoAccount, account.last_name AS tenAccount 
          FROM order_product, account 
          WHERE order_product.id_account = account.id AND account.last_name='$content_search'";
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

            $html.='<td class="button"><a href="edit-user.php?id='.$row["id"].'" class="btn-Refesh">View</a></td>';
            $html.='<td class="button"><a onclick="return confirmdelete()" href="c-delete-user.php?id='.$row["orderId"].'" class="btn-delete">Delete</a></td>';
            $html.='<td class="button"><a href="edit-order-product.php?id='.$row["orderId"].'" class="btn-edit">edit</a></td>';
            $html.='</tr>'; 
          }
          if ($html == '') {
            $html.='<p class="notify-member">Không Có Thông Tin Muốn Tìm</p>';
          }
        }
        return $html;
      }
?>