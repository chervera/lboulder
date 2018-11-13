<?php
require "_init.php";

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

$bouldersQuery = $mysqli->query("SELECT * FROM boulder b WHERE sector_id = " . $sectorSelected["id"] . " ORDER BY b.order");
$boulders = array();

$counterQuery = $mysqli->query("select * from via v inner join boulder b on v.boulder_id = b.id where b.sector_id = " . $sectorSelected["id"]);
$preCounter = $counterQuery->fetch_All(MYSQLI_ASSOC);
$counter = calculateCounter($preCounter);

while($boulder = $bouldersQuery->fetch_assoc()){
    $viasQuery = $mysqli->query("SELECT v.*, s.slug as sector_slug, s.code as sector_code, z.slug as zona_slug, z.code as zona_code, g.name as grade, b.order as boulder_order, (select count(id) from media m where v.id = m.via_id and type=" . MEDIA_TYPE_IMAGE . ") as images, (select count(id) from media m where v.id = m.via_id and type=" . MEDIA_TYPE_VIDEO . ") as videos  FROM via v INNER JOIN grado g ON v.grade_id=g.id INNER JOIN boulder b ON b.id=v.boulder_id INNER JOIN sector s ON b.sector_id=s.id INNER JOIN zona z ON z.id=s.zona_id WHERE boulder_id = " . $boulder["id"] . " ORDER BY 'order'");
    $vias = $viasQuery->fetch_All(MYSQLI_ASSOC);
    $boulder["vias"] = $vias;
    $boulders[] = $boulder;
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
       <?php include("_head.php"); ?>

        <title>Reseñas del sector <?php echo $sectorSelected["name"];?> en la zona <?php echo $zoneSelected["name"]; ?> en Lleida</title>
        <meta name="description" content="Sector <?php echo $sectorSelected["name"];?> en la zona <?php echo $zoneSelected["name"]; ?> en Lleida" />

    </head>

    <body>
        <?php include("_menu.php"); ?>

        <section class="main piece jumbotron jumbotron-fluid">
            <div class="container">
                <div class="row">
				
				<div class="col-12">
                        <div class="side-menu">
                            <h1>Boulder
                            <strong><?php echo $zoneSelected["name"]; ?></strong>
                        </h1>
                        <h2>Sector
                            <?php echo $sectorSelected["name"]; ?>
                        </h2>
                            <p>
                                <?php echo $sector["comments"]; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <!---<h3>Reseña del sector <?php echo $sectorSelected["name"]; ?> de <?php echo $zoneSelected["name"]; ?></h3>-->
                        <?php if ($sectorSelected["image"]){ ?>
                        <img class="img-fluid" src="<?php echo IMG_PATH . $zoneSelected["slug"] . "/" . ($sectorSelected["image"]!=""?$sectorSelected["image"]:$sectorSelected["slug"].".jpg") ?>" alt="mapa del sector <?php echo $sectorSelected["name"]; ?> del <?php echo $zoneSelected["name"]; ?>"/>
                        <?php } ?>
                        <?php if($sectorSelected["map"]) { ?>
                        <div class="embed-responsive embed-responsive-21by9">
                            <iframe src="<?php echo $sectorSelected["map"]; ?>" height="480"></iframe>
                        </div>
                        <?php } ?>
                        <ul class="summary">
                            <li class="number"><span>Total Problemas:</span> <span class="value"><?php echo $counter["total"]; ?></span></li>
                            <li class="easy counter"><span> < 6A:</span> <span class="value"><?php echo $counter["easy"]; ?></span></li>
                            <li class="meddium counter"><span> 6A - 6C+:</span> <span class="value"><?php echo $counter["meddium"]; ?></span></li>
                            <li class="hard counter"><span> 7A - 7C+:</span> <span class="value"><?php echo $counter["hard"]; ?></span></li>
                            <li class="super counter"><span> > 8A:</span> <span class="value"><?php echo $counter["super"]; ?></span></li>
                        </ul>
						
						<!--<ul class="boulders">

                                <?php foreach($boulders as $boulder){ ?>
                                <li>
                                    <a href="#<?php echo $boulder["slug"]; ?>">
                                        <?php echo $boulder["name"]; ?>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>-->
                    </div>

                    
                </div>
            </div>
        </section>

        <?php foreach($boulders as $boulder){ ?>

        <section class="piece" id="<?php echo $boulder["slug"]; ?>">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3><?php echo $boulder["name"]; ?></h3>
                        <img class="img-fluid zoomable" src="<?php echo IMG_PATH . $zoneSelected["slug"] . "/" . $sectorSelected["slug"] ?>/<?php echo ($boulder["image"]!=""?$boulder["image"]:$boulder["slug"].".jpg") ?>" alt="mapa del sector <?php echo  $sectorSelected["name"] ?> de <?php echo  $zoneSelected["name"] ?>" />
                    </div>
                    <div class="col-md-4">
                        <ul class="boulders-list">

                            <?php foreach($boulder["vias"] as $via){ ?>
                            <li class="">
                                <span class="order <?php echo getDifficultColor($via["grade_id"]); ?>"><strong><?php echo $via["order"] ?></strong></span> -
                                <a href="<?php echo ROOT_PATH . $via["zona_slug"] . "/" . $via["sector_slug"] . "/" . $via["id"] ?>.html">
									<?php echo getViaName($via) . " - <strong>" ?>
									<?php if ($via["grade_id"]==GRADE_UNKNOWN_ID){ ?>
										<i class="grade_unknown fa fa-question-circle" aria-hidden="true" title="¿Sabes el grado de este bloque? Dinoslo en los comentarios"></i>
									<?php }else{
										echo $via["grade"];
									} ?>
									
									
									</strong>
                                </a>
								
								<?php if($via["images"]){ ?>
									<i class="fa fa-camera" aria-hidden="true" title="Tiene <?php echo $via["images"]; ?> imagenes"></i>								
								<?php } ?>
								<?php if($via["videos"]){ ?>
									<i class="fa fa-video-camera" aria-hidden="true" title="Tiene <?php echo $via["videos"]; ?> videos"></i>
								<?php } ?>


                                <?php if($via["sit_start"]){ ?>
									<i class="fa fa-chevron-circle-down" aria-hidden="true" title="Sit start"></i>
                                <?php } ?>
                                <?php if($via["featured"]){ ?>
									<i class="fa fa-heart" aria-hidden="true" title="Recomendada"></i>	
                                <?php } ?>
                                <?php if($via["expo"]){ ?>
									<i class="fa fa-exclamation-triangle" aria-hidden="true" title="Expo"></i>
                                <?php } ?>
                                <?php if($via["jump"]){ ?>
                                    <i class="fa fa-rocket" aria-hidden="true" title="Salto"></i>
                                <?php } ?>
                            </li>

                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <?php } ?>
		
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
					this.page.identifier = '<?php echo getSectorCode($sectorSelected, $zoneSelected); ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
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
