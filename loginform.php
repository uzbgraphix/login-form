<?php
 #create your  database connection and add it here

 $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
 $email = trim($email);
 $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
 $password = trim($password);
 $errors = array();
 ?>
 <style type="text/css">
 	body{
 		background-image:url(../image/bg2.jpg);
 		background-repeat:repeat;
 		background-size: 100vw 100vh;
 		background-attachment: fixed;
}
#login-form{
    width: 50%;
    height: 60%;
    background-image:url(../image/bg4.jpg);
    border: 2px solid black;
    border-radius: 15px;
    box-shadow: 7px 7px 15px rgb(0,255,0,0.6);
    margin: 8% auto;
    padding: 15px;
    color: #fff;
    font-weight: bold;
}
.big{
  font-size: 60px;
  color: red;
}

 </style>
 	<div id="login-form">
 		<div>
 			<?php
 			if ($_POST) {
 				//form validetion
 				if (empty($_POST['email']) || empty($_POST['password'])) {

 					$errors[] = 'You must provide email and password';
 				}
 				//validete email
 					if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
 						$errors[] = 'You must enter a valid email';
 					}
 					//password is more than 6 charaters
 					if (strlen($password )< 6) {
 						$errors[] = 'Password must be atleast 6 characters';
 					}


 				//check if email exit in the database
 				$query = $db->query("SELECT * FROM users WHERE email = '$email'");
 				$user = mysqli_fetch_assoc($query);
 				$userCount = mysqli_num_rows($query);
 				if ($userCount < 1) {
 					$errors[] = 'user does not exit in the database';
 				}
 			if(!password_verify($password, $user['password'])) {
 					$errors[] = 'Wrong Password! Retype';
 				}

 				//check for errors
 			if (!empty($errors)) {
 				echo display_errors($errors);
 			}else{
 				// login user in
 				$user_id = $user['id'];
 				login($user_id);
                header('Location: index.php');
 			}
 			}
 			?>

 		</div>
 		<h2 class="text-center"><i class="fas fa-user-lock big"></i><br>Login</h2>
 		<form action="login.php" method="post">
 			<div class="form-group">
 				<label for="email">Email:*</label>
 				<i class="fas fa-envelope form-inline"></i><input type="text" name="email" id="email" value="<?=$email;?>" class="form-control" >
 			</div>
 			<div class="form-group">
 				<label for="password">Password:*</label>
 				<i class="fas fa-lock form-inline"></i><input type="password" name="password" id="password"
 				value="<?=$password;?>" class="form-control" >
 			</div>
 			<div class="form-group">
 				<input type="submit" value="Login" class="btn btn-primary">
 			</div>
 		</form>
 		<p class="text-right"><a href="/shop2020/index.php" alt="home"><i class="fas fa-home"></i>Visit Site</a></p>
 	</div>
