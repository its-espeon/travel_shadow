<?php include 'provider_header.php'; ?>

	<table border="1"  width="100%">
		<tr>
			<th>Category</th>	
		</tr>
		<?php
		$sql = "SELECT * FROM `categories`";
		$res = select($sql);
		foreach ($res as $row) {
			
			echo '<tr>

				<td>'.$row['category_name'].'</td>
			</tr>';
		}
		?>		
	</table>
<?php include 'footer.php'; ?>