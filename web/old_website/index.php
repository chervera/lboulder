<?php 

require "_init.php";


$lastAddedViasQuery = $mysqli->query("SELECT v.*, s.slug as sector_slug, s.code as sector_code, s.name as sector_name, z.slug as zona_slug, z.name as zona_name, z.code as zona_code,  b.order as boulder_order, g.name as grade FROM via v INNER JOIN grado g ON v.grade_id=g.id INNER JOIN boulder b ON b.id=v.boulder_id INNER JOIN sector s ON b.sector_id=s.id INNER JOIN zona z ON z.id=s.zona_id ORDER BY v.id DESC LIMIT 5");
$lastAddedVias = $lastAddedViasQuery->fetch_All(MYSQLI_ASSOC);

$lastAddedSectorsQuery = $mysqli->query("SELECT s.*, z.name as zona_name, z.slug as zona_slug FROM sector s INNER JOIN zona z ON s.zona_id = z.id ORDER BY id DESC LIMIT 5");
$lastAddedSectores = $lastAddedSectorsQuery->fetch_All(MYSQLI_ASSOC);

$lastMediaQuery = $mysqli->query("SELECT m.*, v.*, s.slug as sector_slug, s.code as sector_code, s.name as sector_name, z.slug as zona_slug, z.name as zona_name, z.code as zona_code,  b.order as boulder_order, g.name as grade FROM media m INNER JOIN via v ON v.id = m.via_id INNER JOIN grado g ON v.grade_id=g.id INNER JOIN boulder b ON b.id=v.boulder_id INNER JOIN sector s ON b.sector_id=s.id INNER JOIN zona z ON z.id=s.zona_id WHERE m.type = " . MEDIA_TYPE_IMAGE . " ORDER BY v.id DESC LIMIT 2");
$lastImages = $lastMediaQuery->fetch_All(MYSQLI_ASSOC);

$lastVideosQuery = $mysqli->query("SELECT m.*, v.*, s.slug as sector_slug, s.code as sector_code, s.name as sector_name, z.slug as zona_slug, z.name as zona_name, z.code as zona_code,  b.order as boulder_order, g.name as grade FROM media m INNER JOIN via v ON v.id = m.via_id INNER JOIN grado g ON v.grade_id=g.id INNER JOIN boulder b ON b.id=v.boulder_id INNER JOIN sector s ON b.sector_id=s.id INNER JOIN zona z ON z.id=s.zona_id WHERE m.type = " . MEDIA_TYPE_VIDEO . " ORDER BY v.id DESC LIMIT 3");
$lastVideos = $lastVideosQuery->fetch_All(MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("_head.php"); ?>
	<title>Reseñas de Boulder en Lleida, Cogul, Castelldans, Torrebeses y mas topos.</title>
	<meta name=”description” content=”Boulder Reseñas de boulder en la zona de Lleida. Cogul, Castelldans, Albagés. Muchas topos y guias.” />
</head>

<body>
    <?php include("_menu.php"); ?>
    
    <?php 
     //carrego per a cada zona les vies que te, les zones son carregades en el menu
    foreach($zones as $keyz => $zona){
        foreach ($zona["sectors"] as $keys =>$sector){
            
            $counterQuery = $mysqli->query("select * from via v inner join boulder b on v.boulder_id = b.id where b.sector_id = " . $sector["id"]);
            $preCounter = $counterQuery->fetch_All(MYSQLI_ASSOC);
            $counter = calculateCounter($preCounter);
            $zones[$keyz]["sectors"][$keys]["counter"] = $counter;
            //var_dump($zones[$keyz]["sector"][$keys]);
        }
    }
    
    ?>

    <div class="jumbotron jumbotron-fluid main-header">
        <div class="container">
			<div class="banner-header">
				<h1 class="display-3">Reseñas boulder Lleida <span class="d-none d-sm-inline">y alrededores</span></h1>
				<p class="lead">Reseñas de bloque en las zonas de 
					<?php foreach($zones as $zona){ 
						echo $zona["name"] . ", ";
					} ?>...</p>
			</div>
        </div>
    </div>
    <div id="instafeed"></div>
    <?php foreach($zones as $zona){ ?>
        <section class="main piece zona">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2><?php echo $zona["name"] ?></h2>
                        <!--<p><?php echo $zona["introduction"]; ?></p>-->
                        <img src="<?php echo IMG_PATH . $zona["slug"] . "/" . ($zona["image"]!=""?$zona["image"]:$zona["slug"].".jpg") ?>" alt="Boulder <?php echo $zona["name"]; ?>" class="img-fluid" />
                    </div>
                    <div class="col-md-4">
                        <ul class="sectors">
                            <?php foreach($zona["sectors"] as $sector){ ?>            
                                <li>
                                    <a class="title" href="<?php echo ROOT_PATH . $zona["slug"] . "/" . $sector["slug"] ?>.html"><?php echo $sector["name"]; ?></a>
                                    <ul class="summary">
                                        <li class="easy counter"><span class="help">< 6A</span><span class="value"><?php echo $sector["counter"]["easy"]; ?></span></li>
                                        <li class="meddium counter"><span class="help">6A - 6C+</span><span class="value"><?php echo $sector["counter"]["meddium"]; ?></span></li>
                                        <li class="hard counter"><span class="help">7A - 7C+</span> <span class="value"><?php echo $sector["counter"]["hard"]; ?></span></li>
                                        <li class="super counter"><span class="help">> 8A</span><span class="value"><?php echo $sector["counter"]["super"]; ?></span></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    
    <section class="last_added jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <?php if(count($lastAddedVias)>0){ ?>
                    <div class="col-md-6">
                        <h2>Últimas vias añadidas</h2>
                        <ul class="results vias">
                            <?php foreach($lastAddedVias as $via){ ?>
                                <li>
                                    <a href="<?php echo ROOT_PATH . $via["zona_slug"] . "/" . $via["sector_slug"]; ?>.html"><?php echo $via["zona_name"];?> - <?php echo $via["sector_name"]; ?></a> -
                                    <a href="<?php echo ROOT_PATH . $via["zona_slug"] . "/" . $via["sector_slug"] . "/" . $via["id"] ?>.html">
                                        <?php echo getViaName($via); ?> - <?php echo $via["grade"]; ?>
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
                <?php } ?>
                <?php if(count($lastAddedSectores)>0){ ?>
                    <div class="col-md-6">
                        <h2>Ultimos sectores añadidos</h2>
                        <ul class="results sectores">
                            <?php foreach($lastAddedSectores as $sector){ ?>
                                <li>
                                    <a href="<?php echo ROOT_PATH . $sector["zona_slug"] . "/" . $sector["slug"]; ?>.html">
                                        <?php echo $sector["zona_name"];?> - <?php echo $sector["name"]; ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    
    <section class="last_media jumbotron jumbotron-fluid">
    	<div class="container">
    		<div class="row">
	    		<div class="col-md-6">
                	<h2>Últimas imagenes añadidas</h2>
                    <ul class="results imagenes">
                    	<?php foreach($lastImages as $image){ ?>
                                <li>
                                    <a href="<?php echo ROOT_PATH . $image["zona_slug"] . "/" . $$image["sector_slug"]; ?>.html"><?php echo $image["zona_name"];?> - <?php echo $image["sector_name"]; ?></a> -
                                    <a href="<?php echo ROOT_PATH . $image["zona_slug"] . "/" . $image["sector_slug"] . "/" . $image["id"] ?>.html">
                                        <?php echo getViaName($image); ?> - <?php echo $image["grade"]; ?>
                                    </a>
                                    <?php echo $image["embed"]; ?>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    
                    <div class="col-md-6">
                	<h2>Últimos videos añadidos</h2>
                    <ul class="results videos">
                    	<?php foreach($lastVideos as $video){ ?>
                                <li>
                                    <a href="<?php echo ROOT_PATH . $video["zona_slug"] . "/" . $video["sector_slug"]; ?>.html"><?php echo $video["zona_name"];?> - <?php echo $video["sector_name"]; ?></a> -
                                    <a href="<?php echo ROOT_PATH . $video["zona_slug"] . "/" . $video["sector_slug"] . "/" . $video["id"] ?>.html">
                                        <?php echo getViaName($video); ?> - <?php echo $video["grade"]; ?>
                                    </a>
									<div class="embed-responsive embed-responsive-16by9">
										<?php echo $video["embed"]; ?>
									</div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
    		</div>
    	</div>
    </section>

    <section class="map piece">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Mapa de las zonas de boulder de Lleida</h2>
                    <div class="embed-responsive embed-responsive-21by9">
                        <iframe src="https://www.google.com/maps/d/embed?mid=1iIR1vbcUjf2jlIuXRReWM84UFTE&hl=es" width="640" height="480"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include("_footer.php"); ?>
</body>

</html>
