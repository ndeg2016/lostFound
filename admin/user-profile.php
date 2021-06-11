<?php 
$user=  $_SESSION['user_login'];
  $corepage = explode('/', $_SERVER['PHP_SELF']);
    $corepage = end($corepage);
    if ($corepage!=='index.php') {
      if ($corepage==$corepage) {
        $corepage = explode('.', $corepage);
       header('Location: index.php?page='.$corepage[0]);
     }
    }
?>
<h1 class="text-primary"><i class="fas fa-user"></i>  User Profile</h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
     <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
     <li class="breadcrumb-item active" aria-current="page">User Profile</li>
  </ol>
</nav>
<?php 
  $query = mysqli_query($db_con, "SELECT * FROM `users` WHERE `username` ='$user';");
  $row = mysqli_fetch_array($query);

 ?>
<div class="row">
  <div class="col-sm-6">
    <table class="table table-bordered">
      <tr>
        <td>User ID</td>
        <td><?php echo $row['id']; ?></td>
      </tr>
      <tr>
        <td>Name</td>
        <td><?php echo ucwords($row['name']); ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php echo $row['email']; ?></td>
      </tr>
      <tr>
        <td>Username</td>
        <td><?php echo ucwords($row['username']); ?></td>
      </tr>
      <tr>
        <td>Status</td>
        <td><?php echo ucwords($row['status']); ?></td>
      </tr>
      <tr>
        <td>Register Date</td>
        <td><?php echo $row['datetime']; ?></td>
      </tr>
    </table>
    <a class="btn btn-warning pull-right" href="index.php?page=edit-user&id=<?php echo base64_encode($row['id']); ?>">Edit Profile</a>
  </div>
  <div class="col-sm-6">
    <h3>Profile Picture</h3>
    <a href="images/<?php echo $row['photo']; ?>">
      <img class="img-thumbnail" id="imguser" src="images/<?php echo $row['photo']; ?>" width="200px">
    </a>
    <?php 
        if (isset($_POST['upphoto'])) {
          unlink('images/'.$row['photo']);
          $photofile = $_FILES['userphoto']['tmp_name'];
          $upphoto = $user.date('s-m-y-m-Y').$_FILES['userphoto']['name'];
          if (mysqli_query($db_con, "UPDATE `users` SET `photo` = '$upphoto' WHERE `users`.`username` = '$user';")) {
            move_uploaded_file($photofile, 'images/'.$upphoto);
          }else{
            echo "Profile Picture Not Uploaded";
          }
        }
     ?><br>
    <form method="POST" enctype="multipart/form-data">
      <input type="file" name="userphoto" required="" id="photo"><br>
      <input class="btn btn-info" type="submit" name="upphoto" value="Upload Photo">
    </form>
  </div>
</div>
