<?php include 'admin_header.php'; ?>

<?php 
$success = '';
$error = '';

if (isset($_POST['submitcetegory'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $category = trim($_POST['category'] ?? '');
    
    if (!empty($category)) {
        secure_execute("INSERT INTO categories (category_name) VALUES (?)", 's', [$category]);
        $success = "Category added successfully.";
    } else {
        $error = "Please enter a category name.";
    }
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-tags"></i> Manage Place Categories</h2>
  </div>

  <div class="row">
    <div class="col-md-5">
      <div class="ts-form-card" style="margin:0; max-width:100%;">
        <h3 style="font-size:1.2rem; margin-bottom:15px;">Add New Category</h3>
        
        <?php if ($error): ?>
          <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="ts-alert ts-alert-success"><i class="fa fa-check-circle"></i> <?php echo esc($success); ?></div>
        <?php endif; ?>

        <form method="POST">
          <?php csrf_field(); ?>
          <div class="ts-input-group">
            <label>Category Name</label>
            <input type="text" name="category" class="ts-input" placeholder="e.g. Hill Station, Beach" required>
          </div>
          <button type="submit" name="submitcetegory" class="ts-btn ts-btn-primary ts-btn-full">
            Add Category
          </button>
        </form>
      </div>
    </div>

    <div class="col-md-7">
      <div class="ts-table-wrap" style="margin:0;">
        <div class="ts-table-title">Existing Categories</div>
        <div class="table-responsive">
          <table class="ts-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Category Name</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM categories";
              $res = secure_select($sql, '', []);
              foreach ($res as $row) {
                  echo '<tr>
                          <td>'.esc($row['category_id']).'</td>
                          <td><strong>'.esc($row['category_name']).'</strong></td>
                        </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>