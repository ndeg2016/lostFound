<?php require_once 'db_con.php'; 
	session_start();
	if (isset($_POST['register'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$c_password = $_POST['c_password'];

		$photo = explode('.', $_FILES['photo']['name']);
		$photo= end($photo);
		$photo_name= $username.'.'.$photo;

		$input_error = array();
		if (empty($name)) {
			$input_error['name'] = "The Name Filed is Required";
		}
		if (empty($email)) {
			$input_error['email'] = "The Email Filed is Required";
		}
		if (empty($username)) {
			$input_error['username'] = "The UserName Filed is Required";
		}
		if (empty($password)) {
			$input_error['password'] = "The Password Filed is Required";
		}
		if (empty($photo)) {
			$input_error['photo'] = "The Photo Filed is Required";
		}

		if (!empty($password)) {
			if ($c_password!==$password) {
				$input_error['notmatch']="You Typed Wrong Password!";
			}
		}

		if (count($input_error)==0) {
			$check_email= mysqli_query($db_con,"SELECT * FROM `users` WHERE `email`='$email';");

			if (mysqli_num_rows($check_email)==0) {
				$check_username= mysqli_query($db_con,"SELECT * FROM `users` WHERE `username`='$username';");
				if (mysqli_num_rows($check_username)==0) {
					if (strlen($username)>7) {
						if (strlen($password)>7) {
								$password = sha1(md5($password));
							$query = "INSERT INTO `users`(`name`, `email`, `username`, `password`, `photo`, `status`) VALUES ('$name', '$email', '$username', '$password','$photo_name','active');";
									$result = mysqli_query($db_con,$query);
								if ($result) {
									move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo_name);
									header('Location: register.php?insert=sucess');
								}else{
									header('Location: register.php?insert=error');
								}
						}else{
							$passlan="This password more than 8 charset";
						}
					}else{
						$usernamelan= 'This username more than 8 charset';
					}
				}else{
					$username_error="This username already exists!";
				}
			}else{
				$email_error= "This email already exists";
			}
			
		}
		
	}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container"><br>
          <h1 class="text-center">Register Users!</h1><hr><br>
          <div class="d-flex justify-content-center">
          	<?php 
          		if (isset($_GET['insert'])) {
          			if($_GET['insert']=='sucess'){ echo '<div role="alert" aria-live="assertive" aria-atomic="true" align="center" class="toast alert alert-success fade hide" data-delay="2000">Your Data Inserted!</div>';}
          		}
          	;?>
          </div>
          <div class="row animate__animated animate__pulse">
            <div class="col-md-8 offset-md-2">
             	<form method="POST" enctype="multipart/form-data">
				  <div class="form-group row">
				    <div class="col-sm-6">
				      <input type="text" class="form-control" value="<?= isset($name)? $name:'' ?>" name="name" placeholder="Name" id="inputEmail3"><?= isset($input_error['name'])? '<label for="inputEmail3" class="error">'.$input_error['name'].'</label>':'';  ?>
				    </div>
				    <div class="col-sm-6">
				      <input type="email" class="form-control" value="<?= isset($email)? $email:'' ?>" name="email" placeholder="Email" id="inputEmail3"><?= isset($input_error['email'])? '<label class="error">'.$input_error['email'].'</label>':'';  ?>
				      <?= isset($email_error)? '<label class="error">'.$email_error.'</label>':'';  ?>
				    </div>
				  </div>
				  <div class="form-group row">
				  	<div class="col-sm-4">
				      <input type="text" name="username" value="<?= isset($username)? $username:'' ?>" class="form-control" id="inputPassword3" placeholder="Username"><?= isset($input_error['usrname'])? '<label class="error">'.$input_error['username'].'</label>':'';  ?><?= isset($username_error)? '<label class="error">'.$username_error.'</label>':'';  ?><?= isset($usernamelan)? '<label class="error">'.$usernamelan.'</label>':'';  ?>
				    </div>
				    <div class="col-sm-4">
				      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password"><?= isset($input_error['password'])? '<label class="error">'.$input_error['password'].'</label>':'';  ?> <?= isset($passlan)? '<label class="error">'.$passlan.'</label>':'';  ?>  
				    </div>
				    <div class="col-sm-4">
				      <input type="password" name="c_password" class="form-control" id="inputPassword3" placeholder="Confirm Password"><?= isset($input_error['notmatch'])? '<label class="error">'.$input_error['notmatch'].'</label>':'';  ?> <?= isset($passlan)? '<label class="error">'.$passlan.'</label>':'';  ?>
				    </div>
				  </div>
				  <div class="row">
				  	<div class="col-sm-3"><label for="photo">Choose your photo</label></div>
				  	<div class="col-sm-9">
				      <input type="file" id="photo" name="photo" class="form-control" id="inputPassword3" >
				      <br>
				    </div>
				  </div>
				  <div class="text-center">
				      <button type="submit" name="register" class="btn btn-danger">Register!</button>
				    </div>
				  </div>
				</form>
            </div>
          </div>
              <p>If you have account, you can <a href="login.php">Login</a> your account!</p>
    </div>
    <footer>
    	<p>Copyright &copy; 2016 to <?php echo date('Y') ?></p>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
    	$('.toast').toast('show')
    </script>
  </body>
</html>