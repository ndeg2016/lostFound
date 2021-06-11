
<?php 
session_start();
if (isset($_SESSION['user_login'])) {
	$id = base64_decode($_GET['id']);
	$photo = base64_decode($_GET['photo']);
	if(mysqli_query($db_con,"DELETE FROM `item_info` WHERE `id` = '$id'")){
		unlink('images/'.$photo);
		header('Location: index.php?page=all-items&delete=success');
	}else{
		header('Location: index.php?page=all-items&delete=error');
	}
}else{
	header('Location: login.php');
 }
