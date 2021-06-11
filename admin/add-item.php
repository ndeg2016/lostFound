<?php 
  $corepage = explode('/', $_SERVER['PHP_SELF']);
    $corepage = end($corepage);
    if ($corepage!=='index.php') {
      if ($corepage==$corepage) {
        $corepage = explode('.', $corepage);
       header('Location: index.php?page='.$corepage[0]);
     }
    }

  if (isset($_POST['additem'])) {
  	$name = $_POST['name'];
  	$roll = $_POST['itemno'];
  	$address = $_POST['location'];
  	$pcontact = $_POST['contact'];
  	$class = $_POST['type'];
  	
  	$photo = explode('.', $_FILES['photo']['name']);
  	$photo = end($photo); 
  	$photo = $roll.date('Y-m-d-m-s').'.'.$photo;

  	$query = "INSERT INTO `item_info`(`name`, `itemno`, `type`, `location`, `contact`, `photo`) VALUES ('$name', '$roll', '$class', '$address', '$pcontact','$photo');";
  	if (mysqli_query($db_con,$query)) {
  		$datainsert['insertsucess'] = '<p style="color: green;">Item Inserted!</p>';
  		move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo);
  	}else{
  		$datainsert['inserterror']= '<p style="color: red;">Item Not Inserted, please input right informations!</p>';
  	}
  }
?>
<h1 class="text-primary"><i class="fas fa-user-plus"></i>  Add Item<small class="text-warning"> Add New Lost/Found Item!</small></h1>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
     <li class="breadcrumb-item" aria-current="page"><a href="index.php">Dashboard </a></li>
     <li class="breadcrumb-item active" aria-current="page">Add Item</li>
  </ol>
</nav>

<div class="row">
	
<div class="col-sm-6">
		<?php if (isset($datainsert)) {?>
	<div role="alert" aria-live="assertive" aria-atomic="true" class="toast fade" data-autohide="true" data-animation="true" data-delay="2000">
	  <div class="toast-header">
	    <strong class="mr-auto">Item Insert Alert</strong>
	    <small><?php echo date('d-M-Y'); ?></small>
	    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
	      <span aria-hidden="true">&times;</span>
	    </button>
	  </div>
	  <div class="toast-body">
	    <?php 
	    	if (isset($datainsert['insertsucess'])) {
	    		echo $datainsert['insertsucess'];
	    	}
	    	if (isset($datainsert['inserterror'])) {
	    		echo $datainsert['inserterror'];
	    	}
	    ?>
	  </div>
	</div>
		<?php } ?>
	<form enctype="multipart/form-data" method="POST" action="">
		<div class="form-group">
		    <label for="name">Owner Name</label>
		    <input name="name" type="text" class="form-control" id="name" value="<?= isset($name)? $name: '' ; ?>" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="roll">Item No.</label>
		    <input name="itemno" type="text" value="<?= isset($roll)? $roll: '' ; ?>" class="form-control"  id="itemno" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="address">Location</label>
		    <input name="location" type="text" value="<?= isset($address)? $address: '' ; ?>" class="form-control" id="location" required="">
	  	</div>
	  	<div class="form-group">
		    <label for="pcontact">Contact NO</label>
		    <input name="contact" type="text" class="form-control" id="contact"  value="<?= isset($pcontact)? $pcontact: '' ; ?>" placeholder="01........." required="">
	  	</div>
	  	<div class="form-group">
		    <label for="class">Item Type</label>
		    <select name="type" class="form-control" id="type" required="">
		    	<option>Select</option>
		    	<option value="1st">Identity Card</option>
		    	<option value="2nd">Passport</option>
		    	<option value="3rd">Huduma Card</option>
		    	<option value="4th">Certificate</option>
		    	<option value="5th">Other</option>
		    </select>
	  	</div>
	  	<div class="form-group">
		    <label for="photo">Photo</label>
		    <input name="photo" type="file" class="form-control" id="photo" required="">
	  	</div>
	  	<div class="form-group text-center">
		    <input name="additem" value="Add Item" type="submit" class="btn btn-danger">
	  	</div>
	 </form>
</div>
</div>