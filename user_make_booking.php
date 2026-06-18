<?php include 'user_header.php'; ?>

<?php 
$today = date("Y-m-d");

$bid = (int)($_GET['bid'] ?? 0);
$title = $_GET['title'] ?? '';
$description = $_GET['description'] ?? '';
$amount = (float)($_GET['amount'] ?? 0);

if (isset($_POST['book'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $quantity = (int)($_POST['quantity'] ?? 1);
    $tour_date = $_POST['date'] ?? '';
    
    // Server-side recalculation to prevent tampering
    $total = $quantity * $amount;
    
    if ($bid > 0 && $quantity > 0 && !empty($tour_date)) {
        $q = "INSERT INTO booking (user_id, package_id, quantity, booked_date, tour_date, total_amount, status) 
              VALUES (?, ?, ?, now(), ?, ?, 'pending')";
        $new_bid = secure_execute($q, 'iiisd', [$_SESSION['logid'], $bid, $quantity, $tour_date, $total]);
        
        redirect('payment.php?id=' . $new_bid . '&amount=' . $total);
    }
}
?>

<div class="ts-booking-card">
  <h3><i class="fa fa-calendar-check-o"></i> Make a Booking</h3>
  
  <div class="ts-booking-summary">
    <p>Package: <strong><?php echo esc($title); ?></strong></p>
    <p>Description: <strong><?php echo esc($description); ?></strong></p>
    <p>Base Amount: <strong style="color:var(--primary);">₹<?php echo esc($amount); ?></strong> / person</p>
  </div>

  <form method="post">
    <?php csrf_field(); ?>
    
    <div class="ts-input-group">
      <label for="b-quantity">Number of People</label>
      <div class="ts-input-icon">
        <i class="fa fa-users"></i>
        <input type="number" id="b-quantity" name="quantity" class="ts-input" min="1" max="50" value="1" oninput="calculateTotal()" required>
      </div>
    </div>

    <div class="ts-input-group">
      <label for="b-date">Tour Date</label>
      <div class="ts-input-icon">
        <i class="fa fa-calendar"></i>
        <input type="date" id="b-date" name="date" class="ts-input" min="<?php echo $today; ?>" required>
      </div>
    </div>

    <div class="ts-amount-display" style="margin-top: 24px;">
      <div class="ts-amount-label">Total Amount to Pay</div>
      <div class="ts-amount-value" id="b-total-display">₹<?php echo esc($amount); ?></div>
    </div>

    <button type="submit" name="book" class="ts-btn ts-btn-primary ts-btn-full">
      Proceed to Payment <i class="fa fa-arrow-right"></i>
    </button>
  </form>
</div>

<script>
function calculateTotal() {
    var amount = <?php echo (float)$amount; ?>;
    var qty = document.getElementById('b-quantity').value;
    var total = amount * Math.max(1, qty);
    document.getElementById('b-total-display').innerText = '₹' + total;
}
</script>

<?php include 'footer.php'; ?>