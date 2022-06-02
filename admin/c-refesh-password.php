<?php
    include "../connect.php";
    $idUser = $_GET["id"];
    $password = md5(123456);
    $queryUpdate  = "UPDATE account SET Password='$password' WHERE id='$idUser'";
    $result   = mysqli_query($connection,$queryUpdate)or die("loi cap nhat".mysqli_error($connection));
    if($result) {
      echo "<script type='text/javascript'>alert('Refesh password Successful !');</script>";
      echo'<meta http-equiv="refresh" content="0; url=member.php" />';
    }
?>