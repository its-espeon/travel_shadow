<?php include 'provider_header.php'; ?>

<?php
$success = '';
$error = '';

if (isset($_POST['manage_places'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    
    $placetitle  = trim($_POST['placetitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $latitude    = trim($_POST['latitude'] ?? '');
    $longitude   = trim($_POST['longitude'] ?? '');
    
    $file = '';
    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        $name = uniqid();
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $file = 'products/' . $name . '.' . $ext;
        move_uploaded_file($_FILES['file']['tmp_name'], $file);
    }
    
    if (!empty($placetitle) && !empty($file)) {
        $q = "INSERT INTO places (place_name, place_image, description, latitude, longitude) 
              VALUES (?, ?, ?, ?, ?)";
        secure_execute($q, 'sssss', [$placetitle, $file, $description, $latitude, $longitude]);
        $success = "Place added successfully.";
    } else {
        $error = "Please fill all required fields and select an image.";
    }
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-map-marker"></i> Manage Places</h2>
  </div>

  <div class="ts-form-card" style="max-width: 600px;">
    <h3 style="font-size:1.2rem; margin-bottom:15px;">Add New Place</h3>
    
    <?php if ($error): ?>
      <div class="ts-alert ts-alert-error"><i class="fa fa-exclamation-circle"></i> <?php echo esc($error); ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="ts-alert ts-alert-success"><i class="fa fa-check-circle"></i> <?php echo esc($success); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <?php csrf_field(); ?>
      
      <div class="ts-input-group">
        <label>Place Name</label>
        <input type="text" name="placetitle" class="ts-input" placeholder="e.g. Munnar" pattern="[a-zA-Z\s]{1,30}" required>
      </div>

      <div class="ts-input-group">
        <label>Upload Image</label>
        <input type="file" name="file" class="ts-file-input" required>
      </div>

      <div class="ts-input-group">
        <label>Description</label>
        <textarea name="description" class="ts-input ts-textarea" placeholder="About this place..." required></textarea>
      </div>
      
      <div class="row">
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Latitude</label>
            <input type="text" name="latitude" class="ts-input" placeholder="e.g. 10.0889" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="ts-input-group">
            <label>Longitude</label>
            <input type="text" name="longitude" class="ts-input" placeholder="e.g. 77.0595" required>
          </div>
        </div>
      </div>

      <button type="submit" name="manage_places" class="ts-btn ts-btn-primary ts-btn-full">
        Add Place
      </button>
    </form>
  </div>

  <div class="ts-table-wrap">
    <div class="ts-table-title">Existing Places</div>
    <div class="table-responsive">
      <table class="ts-table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Place Name</th>
            <th>Description</th>
            <th>Coordinates (Lat, Lng)</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM places ORDER BY place_id DESC";
          $res = secure_select($sql, '', []);
          
          if (empty($res)) {
              echo '<tr><td colspan="4" class="ts-text-center">No places added yet.</td></tr>';
          } else {
              foreach ($res as $row) {
                  echo '<tr>
                          <td><img src="'.esc($row['place_image']).'" style="width:70px; height:70px;"></td>
                          <td><strong>'.esc($row['place_name']).'</strong></td>
                          <td><small>'.esc($row['description']).'</small></td>
                          <td><code>'.esc($row['latitude']).', '.esc($row['longitude']).'</code></td>
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
