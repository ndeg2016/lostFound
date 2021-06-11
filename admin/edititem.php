<?php 
  $corepage = explode('/', $_SERVER['PHP_SELF']);
    $corepage = end($corepage);
    if ($corepage!=='index.php') {
      if ($corepage==$corepage) {
        $corepage = explode('.', $corepage);
       header('Location: index.php?page='.$corepage[0]);
     }
    }
    
    $id = base64_decode($_GET['id']);
    $oldPhoto = base64_decode($_GET['photo']);

  if (isset($_POST['updateitem'])) {
  	$name = $_POST['name'];
  	$roll = $_POST['itemno'];
  	$address = $_POST['location'];
  	$pcontact = $_POST['contact'];
  	$class = $_POST['type'];
  	
  	if (!empty($_FILES['photo']['name'])) {
  		 $photo = $_FILES['photo']['name'];
	  	 $photo = explode('.', $photo);
		 $photo = end($photo); 
		 $photo = $roll.date('Y-m-d-m-s').'.'.$photo;
  	}else{
  		$photo = $oldPhoto;
  	}
  	

  	$query = "UPDATE `item_info` SET `name`='$name',`itemno`='$roll',`type`='$class',`location`='$address',`contact`='$pcontact',`photo`='$photo' WHERE `id`= $id";
  	if (mysqli_query($db_con,$query)) {
  		$datainsert['insertsucess'] = '<p style="color: green;">Item Updated!</p>';
		if (!empty($_FILES['photo']['name'])) {
			move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo);
			unlink('images/'.$oldPhoto);
		}	
  		header('Location: index.php?page=all-items&edit=success');
  	}else{
  		header('Location: index.php?page=all-items&edit=error');
  	}
  }
?>
<h1 class="text-primary"><i class="fas fa-user-plus"></i>  Edit Item Information!<small class="text-warning"> Edit Item!</small></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
     <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
     <li class="breadcrumb-item" aria-current="page"><a href="index.php?page=all-items">All Items </a></li>
     <li class="breadcrumb-item active" aria-current="page">Add Item</li>
  </ol>
</nav>

	<?php
		if (isset($id)) {
			$query = "SELECT `id`, `name`, `itemno`, `type`, `location`, `contact`, `photo`, `datetime` FROM `item_info` WHERE `id`=$id";
			$result = mysqli_query($db_con,$query);
			$row = mysqli_fetch_array($result);
		}
	 ?>
<div class="row">
<div class="col-sm-6">
	<form enctype="multipart/form-data" method="POST" action="">
		<div class="form-group">
		    <label for="name">Owner</label>
		    <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['name']; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="itemno">Item No</label>
		    <input name="itemno" type="text" class="form-control"  id="itemno" value="<?php echo $row['itemno']; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="location">Item Location</label>
		    <input name="location" type="text" class="form-control" id="location" value="<?php echo $row['location']; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="contact"> Contact NO</label>
		    <input name="contact" type="text" class="form-control" id="contact" value="<?php echo $row['contact']; ?>"  placeholder="01........." required="">
	  	</div>
	  	<div class="form-group">
		    <label for="class">Item Type</label>
		    <select name="type" class="form-control" id="type" required="" value="">
		    	<option>Select</option>
		    	<option value="1st" <?= $row['type']=='1st'? 'selected':'' ?>>Identity Card</option>
		    	<option value="2nd" <?= $row['type']=='2nd'? 'selected':'' ?>>Passport</option>
		    	<option value="3rd" <?= $row['type']=='3rd'? 'selected':'' ?>>Certificate</option>
		    	<option value="4th" <?= $row['type']=='4th'? 'selected':'' ?>>Phone</option>
		    	<option value="5th" <?= $row['type']=='5th'? 'selected':'' ?>>Huduma card</option>
		    	<option value="6th" <?= $row['type']=='5th'? 'selected':'' ?>>Other item</option>
		    </select>
	  	</div>
	  	<div class="form-group">
		    <label for="photo">Item Photo</label>
		    <input name="photo" type="file" class="form-control" id="photo">
	  	</div>
	  	<div class="form-group text-center">
		    <input name="updateitem" value="Add Item" type="submit" class="btn btn-danger">
	  	</div>
	 </form>
</div>
</div>