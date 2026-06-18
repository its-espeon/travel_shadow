<?php include 'admin_header.php'; ?>
<table border="1" width="100%">
		<tr>
			<th>User id</th>	
			<th>Review id</th>
			<th>Description</th>
			<th>Rating</th>
			<th>Date</th>
		</tr>
		<?php
		$sql = "SELECT * FROM `feedback`";
		$res = select($sql);
		foreach ($res as $row) {
			
			echo '<tr>
				<td>'.$row['user_id'].'</td>
				<td>'.$row['review_id'].'</td>
				<td>'.$row['description'].'</td>
				<td>'.$row['rating'].'</td>
				<td>'.$row['date'].'</td>
			</tr>';
		}
		?>

		
	</table>
<?php include 'footer.php'; ?>