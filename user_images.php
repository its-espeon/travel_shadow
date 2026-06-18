<?php include 'user_header.php'; ?>

<h1>View Images</h1>
	
	<table border="0" width="100%">
		
		<?php
		$sql = "SELECT * FROM `images` WHERE `package_id` = ".$_GET['id'];
		$res = select($sql);
		foreach ($res as $row) {
			
			echo '<tr>
				
				<td style="padding:10px;"><img src="'.$row['image_path'].'" width="100px" height="100px" /></td>
			</tr>';
		}

		?>
	</table>



  <?php
  include 'footer.php';
  ?>