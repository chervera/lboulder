<?php 
require "_init.php";

$viaId = $_GET["via_id"];
$zoneSelectedSlug = $_GET["zona_slug"];
$sectorSelectedSlug = $_GET["sector_slug"];



$zoneSelectedQuery = $mysqli->query("SELECT * FROM zona WHERE slug='" . $zoneSelectedSlug . "'");
$zoneSelected = $zoneSelectedQuery->fetch_assoc();

if(count($zoneSelected)==0){
    header('HTTP/1.1 404 Not Found'); 
	include 'error404.php';
    exit();
}

$sectorSelectedQuery = $mysqli->query("SELECT * FROM sector WHERE slug='" . $sectorSelectedSlug . "' AND zona_id=" . $zoneSelected["id"]);
$sectorSelected = $sectorSelectedQuery->fetch_assoc();

if(count($sectorSelected)==0){
    header('HTTP/1.1 404 Not Found'); 
	include 'error404.php';
    exit();
}

$viaSelectedQuery = $mysqli->query("SELECT v.*, s.slug as sector_slug, s.code as sector_code, s.name as sector_name, z.slug as zona_slug, z.name as zona_name, z.code as zona_code,  b.order as boulder_order, g.name as grade FROM via v INNER JOIN grado g ON v.grade_id=g.id INNER JOIN boulder b ON b.id=v.boulder_id INNER JOIN sector s ON b.sector_id=s.id INNER JOIN zona z ON z.id=s.zona_id WHERE v.id='" . $viaId . "' AND s.id=" . $sectorSelected["id"] . " AND s.zona_id=" . $zoneSelected["id"]);
$viaSelected = $viaSelectedQuery->fetch_assoc();

if(count($viaSelected)==0){
    header('HTTP/1.1 404 Not Found'); 
	include 'error404.php';
    exit();
}

$imagesQuery = $mysqli->query("SELECT * FROM media WHERE via_id='" . $viaId . "' AND type=" . MEDIA_TYPE_IMAGE . " ORDER BY id DESC");
$images = $imagesQuery->fetch_All(MYSQLI_ASSOC);

$videosQuery = $mysqli->query("SELECT * FROM media WHERE via_id='" . $viaId . "' AND type=" . MEDIA_TYPE_VIDEO . " ORDER BY id DESC");
$videos = $videosQuery->fetch_All(MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>
   <?php include("_head.php"); ?>
    <title>Boulder <?php echo $viaSelected["name"]; ?> en el sector <?php echo $sectorSelected["name"];?> en la zona <?php echo $zoneSelected["name"]; ?> en Lleida</title>
    <meta name=”description” content=”Boulder <?php echo $viaSelected["name"]; ?> en el sector <?php echo $sectorSelected["name"];?> en la zona <?php echo $zoneSelected["name"]; ?> en Lleida” />
</head>

<body>
    <?php include("_menu.php"); ?>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-3"><?php echo getViaName($viaSelected); ?> - <?php echo $viaSelected["grade"]; ?></h1>
            <h2>
                <a href="<?php echo ROOT_PATH . $zoneSelected["slug"] . "/" . $sectorSelected["slug"] ?>.html">
                    <?php echo $zoneSelected["name"]; ?> - <?php echo $sectorSelected["name"]; ?>
                </a>
            </h2>
            <p class="lead"><?php echo $viaSelected["comments"]; ?></p>
            <div class="icons">
				<?php if($viaSelected["sit_start"]){ ?>
					<i class="fa fa-chevron-circle-down fa-2x" aria-hidden="true" title="Sit start"></i>
				<?php } ?>
				<?php if($viaSelected["featured"]){ ?>
					<i class="fa fa-heart fa-2x" aria-hidden="true" title="Recomendada"></i>	
				<?php } ?>
				<?php if($viaSelected["expo"]){ ?>
					<i class="fa fa-exclamation-triangle fa-2x" aria-hidden="true" title="Expo"></i>
				<?php } ?>
				<?php if($viaSelected["jump"]){ ?>
					<i class="fa fa-rocket fa-2x" aria-hidden="true" title="Salto"></i>
				<?php } ?>
            </div>
        </div>
    </div>
    
    <section class="media">
        <div class="container">
            <div class="row">
                <?php if(count($images)>0){ ?>
                    <div class="col-md-6">
                        <h3>Imagenes</h3>
                        <?php foreach($images as $image){ ?>
                            <?php if($image["embed"]){ ?>
								<div class="">
									<?php echo $image["embed"]; ?>
								</div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if(count($videos)>0){ ?>
                <div class="col-md-6">
                    <h3>Videos</h3>
                     <?php foreach($videos as $video){ ?>
                            <?php if($video["embed"]){ ?>
								<div class="embed-responsive embed-responsive-16by9">
									<?php echo $video["embed"]; ?>
								</div>
                            <?php } ?>
                        <?php } ?>
                </div>
                <?php } ?>
				
            </div>
        </div>
    </section>
	
	<section class="media-info">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<p>Si tienes alguna imagen o algun video que quieras incluir en esta pagina, mándala a <?php echo ADMIN_MAIL; ?> (Solo fotos de instagram y videos de youtube y vimeo)</p>
				</div>
			</div>
		</div>
	</section>
	
	<section class="comments jumbotron jumbotron-fluid">
		<div class="container">
			<div class="row">
				<div class="col-12">
				<div id="disqus_thread"></div>
	<script>

					/**
					*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
					*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

					var disqus_config = function () {
					this.page.url = 'http://<?php echo REAL_HOST . "/" . $viaSelected["zona_slug"] . "/" . $viaSelected["sector_slug"] . "/" . $viaSelected["id"] ?>.html';  // Replace PAGE_URL with your page's canonical URL variable
					this.page.identifier = '<?php echo getViaCode($viaSelected); ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
					};

					(function() { // DON'T EDIT BELOW THIS LINE
					var d = document, s = d.createElement('script');
					s.src = 'https://www-lboulder-com.disqus.com/embed.js';
					s.setAttribute('data-timestamp', +new Date());
					(d.head || d.body).appendChild(s);
					})();
					</script>
					<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				</div>
			</div>
		</div>
	</section>
    

    <?php include("_footer.php"); ?>
	
	<script id="dsq-count-scr" src="//www-lboulder-com.disqus.com/count.js" async></script>
</body>

</html>
