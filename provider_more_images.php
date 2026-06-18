<?php include 'provider_header.php'; ?>

<h1>provider_manage_package</h1>

	<?php
	$id=$_SESSION['logid'];
	if(isset($_POST['manage_package'])){
		extract($_POST);
		
		$path="products/".$_FILES['file']['name'];
		$name=uniqid();
		$film="products/".$name.'.jpg';
		move_uploaded_file($_FILES['file']['tmp_name'],$film);
		$q="insert into images (package_id, image_path) values ('".$_GET['id']."', '$film')";
		insert($q);
	}

	

	if (isset($_GET['img_id'])) {
		$qry = "delete from images where image_id = ".$_GET['img_id'];
		insert($qry);
		$url = 'provider_more_images.php?id='.$_GET['id'];
		redirect($url);
	}
	?>
		<form method="POST" enctype="multipart/form-data">
		<center>
		<table>
		
		<tr>
		<td>Upload image</td>
		<td><input type="file" name="file" /></td>
		</tr>
		
		
		<tr align="right">
			<td>
				<input type="submit" name="manage_package" value="Add"></td>
				
		</tr>
		</table>
		</center>
	</form>


	
	<table border="1" width="100%">
		<tr>

			<th>Image</th>
			<th>Remove</th>
		</tr>
		<?php
		$sql = "SELECT * FROM `images` WHERE `package_id` = ".$_GET['id'];
		$res = select($sql);
		foreach ($res as $row) {
			
			echo '<tr>
				
				<td><img src="'.$row['image_path'].'" width="100px" height="100px" /></td>
				<td><a href="provider_more_images.php?&img_id='.$row['image_id'].'&id='.$_GET['id'].'">Remove</a></td>
			</tr>';
		}

		if (isset($_GET['status'])) {
			
			if($_GET['status'] == 'active')
			{
				echo $sql = "UPDATE packages set status = 'reject' WHERE package_id = ".$_GET['id'];
			}
			else
			{
				$sql = "UPDATE packages set status = 'active' WHERE package_id = ".$_GET['id'];
			}
			insert($sql);
			redirect('provider_manage_tour_packages.php');
		}

		?>
	</table>



  <?php
  include 'footer.php';
  ?>