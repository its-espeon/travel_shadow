<!DOCTYPE html>
<html>
<head>
	<title>Date difference</title>
</head>
<body>

	<?php

	$date1 = date_create("2013-03-15");
	$date2 = date_create("2013-12-12");
	$diff = date_diff($date1,$date2);
	//$arr = $diff[0]['days'];
	print_r($diff);

	?>

</body>
</html>


<script type="text/javascript">
	function alert()
	{
		alert('hai');
	}
</script>
