<?php include 'provider_header.php'; ?>

<?php
$id = $_SESSION['logid'];
$success = '';
$error = '';

// Get the actual provider_id for the logged-in user
$providerInfo = secure_select("SELECT tour_provider_id FROM tour_providers WHERE login_id = ?", 'i', [$id]);
$provider_id = !empty($providerInfo) ? $providerInfo[0]['tour_provider_id'] : 0;

if (isset($_POST['manage_package'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $title       = trim($_POST['packagetitle'] ?? '');
    $places      = trim($_POST['placeincluded'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $desc        = trim($_POST['descriptions'] ?? '');
    $amount      = trim($_POST['amount'] ?? '');
    
    // File upload
    $film = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $name = uniqid();
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $film = 'products/' . $name . '.' . $ext;
        move_uploaded_file($_FILES['file']['tmp_name'], $film);
    }
    
    if ($provider_id > 0 && !empty($title) && !empty($film)) {
        $q = "INSERT INTO packages (package_title, package_image, places_included, category_id, description, amount, tour_provider_id, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'active')";
        secure_execute($q, 'sssisss', [$title, $film, $places, $category_id, $desc, $amount, $provider_id]);
        $success = "Package created successfully.";
    } else {
        $error = "Please fill all fields and select an image.";
    }
}

if (isset($_POST['update_package'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $pkg_id      = (int)($_GET['id'] ?? 0);
    $title       = trim($_POST['packagetitle'] ?? '');
    $places      = trim($_POST['placeincluded'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $desc        = trim($_POST['descriptions'] ?? '');
    $amount      = trim($_POST['amount'] ?? '');

    if (isset($_FILES['file']) && $_FILES['file']['size'] > 0 && $_FILES['file']['error'] === 0) {
        $name = uniqid();
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $film = 'products/' . $name . '.' . $ext;
        move_uploaded_file($_FILES['file']['tmp_name'], $film);

        $qry = "UPDATE packages SET package_title=?, package_image=?, places_included=?, category_id=?, description=?, amount=? WHERE package_id = ?";
        secure_execute($qry, 'sssisii', [$title, $film, $places, $category_id, $desc, $amount, $pkg_id]);
    } else {
        $qry = "UPDATE packages SET package_title=?, places_included=?, category_id=?, description=?, amount=? WHERE package_id = ?";
        secure_execute($qry, 'ssisii', [$title, $places, $category_id, $desc, $amount, $pkg_id]);
    }
    $success = "Package updated successfully.";
}

// Handle status change via GET
if (isset($_GET['status']) && isset($_GET['id'])) {
    $status = ($_GET['status'] === 'active') ? 'reject' : 'active';
    secure_execute("UPDATE packages SET status = ? WHERE package_id = ?", 'si', [$status, (int)$_GET['id']]);
    redirect('provider_manage_tour_packages.php');
}

$edit_mode = isset($_GET['option']) && $_GET['option'] === 'edit';
$edit_data = [];
if ($edit_mode) {
    $res2 = secure_select("SELECT * FROM packages WHERE package_id = ?", 'i', [(int)$_GET['id']]);
    if (!empty($res2)) $edit_data = $res2[0];
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-suitcase"></i> Manage Tour Packages</h2>
  </div>

  <div class="ts-form-card" style="max-width: 700px;">
    <h3 style="font-size:1.2rem; margin-bottom:15px;">
      <?php echo $edit_mode ? 'Edit Package' : 'Add New Package'; ?>
    </h3>
    
    <?php if ($error): ?>
      <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="ts-alert ts-alert-success"><i class="fa fa-check-circle"></i> <?php echo esc($success); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <?php csrf_field(); ?>
      
      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Package Title</label>
            <input type="text" name="packagetitle" class="ts-input" placeholder="Title" required 
                   value="<?php echo esc($edit_data['package_title'] ?? ''); ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Category</label>
            <select name="category_id" class="ts-input ts-select" required>
              <option value="">-- Select --</option>
              <?php
              $cats = secure_select("SELECT * FROM categories", '', []);
              foreach ($cats as $c) {
                  $sel = ($edit_mode && $edit_data['category_id'] == $c['category_id']) ? 'selected' : '';
                  echo "<option value='{$c['category_id']}' {$sel}>".esc($c['category_name'])."</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>

      <div class="ts-input-group">
        <label>Upload Cover Image</label>
        <input type="file" name="file" class="ts-file-input" <?php echo $edit_mode ? '' : 'required'; ?>>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Places Included</label>
            <input type="text" name="placeincluded" class="ts-input" placeholder="E.g. Munnar, Thekkady" required 
                   value="<?php echo esc($edit_data['places_included'] ?? ''); ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Amount (₹)</label>
            <input type="text" name="amount" class="ts-input" placeholder="Price per person" pattern="[0-9]+" required 
                   value="<?php echo esc($edit_data['amount'] ?? ''); ?>">
          </div>
        </div>
      </div>

      <div class="ts-input-group">
        <label>Description</label>
        <textarea name="descriptions" class="ts-input ts-textarea" required><?php echo esc($edit_data['description'] ?? ''); ?></textarea>
      </div>

      <button type="submit" name="<?php echo $edit_mode ? 'update_package' : 'manage_package'; ?>" class="ts-btn ts-btn-primary">
        <?php echo $edit_mode ? 'Update Package' : 'Register Package'; ?>
      </button>
      <?php if ($edit_mode): ?>
        <a href="provider_manage_tour_packages.php" class="ts-btn ts-btn-outline" style="margin-left: 10px;">Cancel</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">My Packages</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Places</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($provider_id > 0) {
              $sql = "SELECT * FROM packages WHERE tour_provider_id = ?";
              $res = secure_select($sql, 'i', [$provider_id]);
              foreach ($res as $row) {
                  $badge = ($row['status'] === 'active') ? 'ts-badge-active' : 'ts-badge-rejected';
                  echo '<tr>
                          <td><img src="'.esc($row['package_image']).'" style="width:60px; height:60px;"></td>
                          <td><strong>'.esc($row['package_title']).'</strong></td>
                          <td>'.esc($row['places_included']).'</td>
                          <td>₹'.esc($row['amount']).'</td>
                          <td><span class="ts-badge '.$badge.'">'.esc($row['status']).'</span></td>
                          <td>
                            <a href="provider_manage_tour_packages.php?status='.esc($row['status']).'&id='.$row['package_id'].'" class="ts-btn ts-btn-sm ts-btn-outline" style="margin-right:4px;">Toggle Status</a>
                            <a href="provider_manage_tour_packages.php?option=edit&id='.$row['package_id'].'" class="ts-btn ts-btn-sm ts-btn-primary" style="margin-right:4px;">Edit</a>
                            <a href="provider_more_images.php?id='.$row['package_id'].'" class="ts-btn ts-btn-sm ts-btn-outline">More Images</a>
                          </td>
                        </tr>';
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>