<?php
include "connect.php";
include "c-cart.php";
// include "c-sign-up.php";
// include "c-sign-in.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/css-login.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script>
		$(document).ready(function(){
			$("#btn-sign-in").click(function(){
				var username = $("#emailSignIn").val().trim();
				var password = $("#passwordSignIn").val().trim();

				var data = $('#login-form').serialize(); // get form data
				$.ajax({
					url:'c-sign-in.php',
					type:'post',
					data: data,
					success:function(response){
						$( "#error-list-login" ).html("");
						response = JSON.parse(response);
						$.each(response['msg'],function(index,message) {
							$( "#error-list-login" ).append( message );
						});
						
						if (response['status'] == true) {
							alert(response['welcome']);
							window.location.href = 'index.php';
						}
					}
				});

				return false;
			});
		});
		/////////////////////////////////////////////////////
		$(document).ready(function(){
			$("#btn-sign-up").click(function(){
				var data = $('#sign-up-form').serialize(); // get form data
				$.ajax({
					url:'c-sign-up.php',
					type:'post',
					data: data,
					success:function(response){
						
						$( "#error-sign-up" ).html("");
						response = JSON.parse(response);
						$.each(response['msg'],function(index,message) {
							$( "#error-sign-up" ).append( message );
						});
						
						if (response['status'] == true) {
							alert("Dang Ky Thanh Cong");
							window.location.href = 'index.php';
						}
					}
				});

				return false;
			});
		});
	</script>

	<title>Document</title>
</head>

<body>
	<header class="page-header">
		<div class="box-header">
			<div class="logo-left">
				<a href="index.php">
					 <img src="images/LOGO2.png" alt="" width="225px">
				</a>
			</div>
		</div>
	</header>
	<main class="page-main">
		<div class="box-main-left">
			<h2 class="formTitle first">Enter Your Account Information</h2>
			<fieldset class="dangky">
				<form id="sign-up-form" action="" method="post">
					<table border="0">
						<tbody>
							<tr>
								<td><span class="__web-inspector-hide-shortcut__"><span class="star">* </span>Họ</span>
								</td>
							</tr>
							<tr>
								<td><input type="text" name="first-name" value="<?php if(isset($_POST["first-name"])) echo $firstName ?>" placeholder="Nhập email của bạn !"></td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Tên</span></td>
							</tr>
							<tr>
								<td><input type="text" name="last-name" value="<?php if(isset($_POST["last-name"])) echo $lastName ?>" placeholder="Nhập email của bạn !"></td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Email</span></td>
							</tr>
							<tr>
								<td><input type="text" name="email" value="<?php if(isset($_POST["email"])) echo $email ?>" placeholder="Nhập email của bạn !"></td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Password</span></td>
							</tr>
							<tr>
								<td><input type="password" name="password" value="<?php if(isset($_POST["password"])) echo $_POST["password"] ?>" placeholder="Nhập password của bạn !"></td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Confirm Password</span></td>
							</tr>
							<tr>
								<td><input type="password" name="cpassword" value="<?php if(isset($_POST["cpassword"])) echo $_POST["cpassword"] ?>" placeholder="Nhập lại password của bạn !"></td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Giới tính</span></td>
							</tr>
							<tr>
								<td>
									<select id="gt" name="gioitinh">
										<option value="0">Chọn</option>
										<option value="Nam" <?php if($gioitinh =='Nam') echo "selected='selected'" ?>>Nam</option>
										<option value="Nữ" <?php if($gioitinh =='Nữ') echo "selected='selected'" ?>>Nữ</obtn-sign-inption>
									</select>
								</td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Ngày sinh</span></td>
							</tr>
							<tr>
								<td>
									<?php
										echo '<select id = "sn" name="date">';
										echo '<option value"=0">Ngày</option>';
										for ($d = 1; $d <= 31; $d++) {
											if (isset($_POST["date"]) && $_POST["date"]==$d) {
												echo '<option value="'.$d.'" selected="selected" >'.$d.'</option>';
											} else {
												echo '<option value"='.$d.'">'.$d.'</option>';
											}
										}
										echo '</select>';
									?>
									<?php
										echo '<select id = "sn" name="month">';
										echo '<option value"=0">Tháng</option>';
										for ($m = 1; $m <= 12; $m++) {
											if (isset($_POST["month"]) && $_POST["month"]==$m) {
												echo '<option value="'.$m.'" selected="selected" >'.$m.'</option>';
											} else {
												echo '<option value"='.$m.'">'.$m.'</option>';
											}
										}
										echo '</select>';
									?>
									<?php
										echo '<select id = "sn" name="year">';
										echo '<option value"=0">Năm</option>';
										for ($y = 1930; $y <= 2019; $y++) {
											if (isset($_POST["year"]) && $_POST["year"]==$y) {
												echo '<option value="'.$y.'" selected="selected" >'.$y.'</option>';
											} else {
												echo '<option value"='.$y.'">'.$y.'</option>';
											}
										}
										echo '</select>';
									?>
								</td>
							</tr>
							<tr>
								<td style="height:20px;"></td>
							</tr>
							<tr>
								<td>
									<input type="submit" value="Create My Account" name="btn-sign-up" id="btn-sign-up" class="btn-sign-up">
								</td>
							</tr>
							<tr>
								<td>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				<ul id="error-sign-up">
				</ul>
			</fieldset>
		</div>
		<div class="box-main-right">
			<div id="right_one">
				<div id="right_text">
					<span class="txt-login">Login</span>
				</div>
			</div>
			<fieldset class="dangnhap">
				<form id="login-form" action="/c-sign-in.php" method="post">
					<table border="0">
						<tbody>
							<tr>
								<td><span><span class="star">* </span>Email</span></td>
							</tr>
							<tr>
								<td><input type="text" name="emailSignIn" id="emailSignIn" value="" placeholder="Nhập email của bạn !"></td>
							</tr>
							<tr>
								<td><span><span class="star">* </span>Password</span></td>
							</tr>
							<tr>
								<td><input type="password" name="passwordSignIn" id="passwordSignIn" value="" placeholder="Nhập password của bạn !"></td>
							</tr>
							<tr>
								<td>
									<input type="submit" value="sign-in" id="btn-sign-in" class="btn-sign-in" name="btn-sign-in">
								</td>
							</tr>
							<tr>
								<td>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				<ul id="error-list-login">
				</ul>
			</fieldset>
		</div>
	</main>
	<footer class="page-footer">
		<div class="contailner">
			<ul class="navigation-footer uppercase">
				<li class="column">
					<h3>About us</h3>
					<ul class="column-item">
						<li><a href="#">About Shoptoy.cf</a></li>
						<li><a href="#">Site Map</a></li>
						<li><a href="#">Friendly Links</a></li>
					</ul>
				</li>
				<li class="column">
					<h3>Featured Service</h3>
					<ul class="column-item">
						<li><a href="#">Trade Resources</a></li>
						<li><a href="#">Logistics Partners</a></li>
						<li><a href="#">Import & Export Service</a></li>
					</ul>
				</li>
				<li class="column">
					<h3>Help</h3>
					<ul class="column-item">
						<li><a href="#">FAQ</a></li>
						<li><a href="#">Contact Us</a></li>
						<li><a href="#">Submit a Complaint</a></li>
					</ul>
				</li>
				<li class="column">
					<h3>Social connection</h3>
					<ul class="column-item">
						<li>
							<img src="images/facebook-24.png" alt="Facebook">
							<a href="#"><span>Facebook</span></a>
						</li>
						<li>
							<img src="images/google_plus-24.png" alt="Google+">
							<a href="#"><span>Google+</span></a>
						</li>
						<li>
							<img src="images/youtube-24.png" alt="Youtube">
							<a href="#"><span>Youtube</span></a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="copyright-design">
			<div class="contailner">
				<div class="border-copyright-design">
					<p class="txt-copyright">@ 2018 - COPYRIGHT OF SHOPTOY</p>
					<p class="txt-design">DESIGN BY <a href="#" title="">DD.com</a></p>
				</div>
			</div>
		</div>
	</footer>
	<script src="js/js-sign-up.js"></script>
</body>

</html>