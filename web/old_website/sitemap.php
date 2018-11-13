<?php
  header('Content-type: application/xml');
 
  require_once "_init.php";
 
// configuration
  $default_timezone = 'UTC';
  $timezone_offset = '+00:00';
  $W3C_datetime_format_php = 'Y-m-d\Th:i:s'; // See http://www.w3.org/TR/NOTE-datetime
  $null_sitemap = '<urlset><url><loc></loc></url></urlset>';
 

	$sectorsQuery = $mysqli->query("SELECT s.*, z.slug as zona_slug FROM sector s INNER JOIN zona z ON z.id=s.zona_id WHERE z.active='1' AND s.active='1'");
	$sectors = $sectorsQuery->fetch_All(MYSQLI_ASSOC);
 
  $output = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
  $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
  echo $output;
?>
<url>
  <loc>http://www.lboulder.com</loc>
</url>
 <?php foreach($sectors as $sector){ ?>
 <url>
<loc><?php echo REAL_HOST_FULL . "/" . $sector["zona_slug"] . "/" . $sector["slug"] ?>.html</loc>
</url>
<?php } ?>
</urlset>