<?php
  include 'user_header.php';
 ?>

<?php 
	if(isset($_POST['book'])){
		extract($_POST);
		$id=$_SESSION['logid'];
		$total = $_GET['amount'];
		$bid = $_GET['id'];
		$sql = "INSERT INTO `payment`(`booking_id`, `amount`, `user_id`, `datetime`) VALUES ($bid, '$total', $id, now())";
		insert($sql);
		redirect('user_my_bookings.php');

	}

 ?>
<form method="post">
		<center>
	<table>
		<tr>
			<td>Total Amount</td>
			<td><input type="text" value="<?php echo $_GET['amount']; ?>" readonly="readonly"></td>
		</tr>

		<tr>
			<td>Card Number</td>
			<td><input type="text"  pattern="[0-9]{16}"></td>
		</tr>

		<tr>
			<td>Expiry Date</td>
			<td><input type="text" placeholder="MM/YY" name="amount" id="amount" ></td>
		</tr>

		<tr>
			<td>CVV</td>
			<td><input type="text" name="quantity"  pattern="[0-9]{3}"></td>
		</tr>

		<tr>
			<td>Card Holder Name</td>
			<td><input type="text" name="total" pattern="[a-zA-Z\s]{0,20}"></td>
		</tr>

		<tr align="right">
			<td></td>
			<td><input type="submit" name="book" value="Make Booking"></td>
		</tr>
		</table>
		</center>
	</form>


 <?php include 'footer.php'; ?>