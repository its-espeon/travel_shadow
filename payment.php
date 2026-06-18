<?php include 'user_header.php'; ?>

<?php 
$bid = (int)($_GET['id'] ?? 0);
$total = (float)($_GET['amount'] ?? 0);

if (isset($_POST['ADD'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    // Process payment (simulated)
    if ($bid > 0 && $total > 0) {
        $sql = "INSERT INTO payment (booking_id, amount, user_id, datetime) VALUES (?, ?, ?, now())";
        secure_execute($sql, 'idi', [$bid, $total, $_SESSION['logid']]);
        
        redirect('user_my_bookings.php');
    }
}
?>

<div class="ts-payment-card">
  <h3>Secure Checkout</h3>
  
  <div class="ts-payment-notice">
    <i class="fa fa-info-circle" style="font-size:1.2rem;"></i>
    Payments are non-refundable. Please verify your details before proceeding.
  </div>

  <div class="ts-text-center" style="margin-bottom: 24px;">
    <img src="img/credit_card.png" alt="Credit Cards" style="max-width: 280px; width: 100%; opacity: 0.85;">
  </div>

  <div class="ts-amount-display">
    <div class="ts-amount-label">Amount to Pay</div>
    <div class="ts-amount-value">₹<?php echo esc($total); ?></div>
  </div>

  <form method="post">
    <?php csrf_field(); ?>

    <div class="ts-input-group">
      <label for="cc-number">Card Number</label>
      <div class="ts-input-icon">
        <i class="fa fa-credit-card"></i>
        <input type="text" id="cc-number" class="ts-input" placeholder="1234 5678 9101 1121" required pattern="[0-9]{16}" title="Enter 16 digit Card number" autocomplete="cc-number">
      </div>
    </div>

    <div class="row">
      <div class="col-6">
        <div class="ts-input-group">
          <label for="cc-cvv">CVV</label>
          <div class="ts-input-icon">
            <i class="fa fa-lock"></i>
            <input type="password" id="cc-cvv" class="ts-input" placeholder="123" required pattern="[0-9]{3}" title="Enter 3 digit CVV number">
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="ts-input-group">
          <label for="cc-exp">Expiry Date</label>
          <div class="ts-input-icon">
            <i class="fa fa-calendar-o"></i>
            <input type="text" id="cc-exp" class="ts-input" placeholder="MM/YY" required pattern="[0-9/]{5}" title="Format: MM/YY" autocomplete="cc-exp">
          </div>
        </div>
      </div>
    </div>

    <div class="ts-input-group">
      <label for="cc-name">Card Holder Name</label>
      <div class="ts-input-icon">
        <i class="fa fa-user"></i>
        <input type="text" id="cc-name" class="ts-input" placeholder="Name on card" required autocomplete="cc-name">
      </div>
    </div>

    <button type="submit" name="ADD" class="ts-btn ts-btn-primary ts-btn-full" style="margin-top: 10px;">
      <i class="fa fa-lock"></i> Pay ₹<?php echo esc($total); ?> Securely
    </button>
  </form>
</div>

<?php include 'footer.php'; ?>