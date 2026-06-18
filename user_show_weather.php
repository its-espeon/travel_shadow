<?php include 'user_header.php'; ?>
<?php
// Validate latitude and longitude as numeric
$lat = $_GET['latitude'] ?? '';
$lng = $_GET['longitude'] ?? '';

$weatherData = null;
$error = '';

if (is_numeric($lat) && is_numeric($lng)) {
    // Legacy HERE API endpoint (Deprecated, using config credentials)
    $url = "https://weather.cit.api.here.com/weather/1.0/report.json?product=observation&latitude={$lat}&longitude={$lng}&oneobservation=true&app_id=" . HERE_APP_ID . "&app_code=" . HERE_APP_CODE;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
    $json = curl_exec($ch);
    
    if (!$json) {
        $error = "Failed to connect to weather service: " . curl_error($ch);
    } else {
        $array = json_decode($json, true);
        if (isset($array['observations']['location'][0]['observation'][0])) {
            $weatherData = $array['observations']['location'][0]['observation'][0];
        } else {
            $error = "Weather data not available for this location.";
        }
    }
    curl_close($ch);
} else {
    $error = "Invalid location coordinates provided.";
}
?>

<div class="container ts-mt-0 ts-mb-24">
  <div class="ts-page-header">
    <h2><i class="fa fa-cloud"></i> Current Weather Report</h2>
  </div>

  <?php if ($error): ?>
    <div class="ts-alert ts-alert-error">
      <i class="fa fa-exclamation-triangle"></i> <?php echo esc($error); ?>
    </div>
    <div class="ts-text-center ts-mt-20">
      <a href="user_view_places.php" class="ts-btn ts-btn-outline"><i class="fa fa-arrow-left"></i> Back to Places</a>
    </div>
  <?php elseif ($weatherData): ?>
    <div class="ts-text-center" style="margin-bottom: 24px;">
      <h3 style="color:#fff; font-size:1.8rem;">
        <?php echo esc($weatherData['city'] ?? ''); ?>, <?php echo esc($weatherData['state'] ?? ''); ?>
      </h3>
      <p class="ts-text-muted"><?php echo esc($weatherData['country'] ?? ''); ?></p>
      
      <?php if (!empty($weatherData['iconLink'])): ?>
        <img src="<?php echo esc($weatherData['iconLink']); ?>" alt="Weather Icon" style="width: 80px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));">
      <?php endif; ?>
      <h4 style="color:var(--primary); font-size:1.5rem; margin-top:10px;">
        <?php echo esc($weatherData['description'] ?? ''); ?>
      </h4>
    </div>

    <div class="ts-weather-grid">
      <div class="ts-weather-item">
        <div class="ts-weather-item__label"><i class="fa fa-thermometer-half"></i> Temperature</div>
        <div class="ts-weather-item__value"><?php echo esc($weatherData['temperature'] ?? '--'); ?>°</div>
      </div>
      <div class="ts-weather-item">
        <div class="ts-weather-item__label">Feels Like</div>
        <div class="ts-weather-item__value"><?php echo esc($weatherData['temperatureDesc'] ?? '--'); ?></div>
      </div>
      <div class="ts-weather-item">
        <div class="ts-weather-item__label"><i class="fa fa-arrow-up"></i> High</div>
        <div class="ts-weather-item__value"><?php echo esc($weatherData['highTemperature'] ?? '--'); ?>°</div>
      </div>
      <div class="ts-weather-item">
        <div class="ts-weather-item__label"><i class="fa fa-arrow-down"></i> Low</div>
        <div class="ts-weather-item__value"><?php echo esc($weatherData['lowTemperature'] ?? '--'); ?>°</div>
      </div>
      <div class="ts-weather-item">
        <div class="ts-weather-item__label"><i class="fa fa-tint"></i> Humidity</div>
        <div class="ts-weather-item__value"><?php echo esc($weatherData['humidity'] ?? '--'); ?>%</div>
      </div>
      <div class="ts-weather-item">
        <div class="ts-weather-item__label"><i class="fa fa-cloud"></i> Sky</div>
        <div class="ts-weather-item__value" style="font-size:1rem;"><?php echo esc($weatherData['skyDescription'] ?? '--'); ?></div>
      </div>
    </div>

    <div class="ts-text-center" style="margin-top:30px;">
      <a href="user_view_places.php" class="ts-btn ts-btn-outline"><i class="fa fa-arrow-left"></i> Back to Places</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>