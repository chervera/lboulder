<?php 
require "_init.php";

$search = $_GET["search"];

$viaSelectedQuery = $mysqli->query("SELECT v.*, s.slug as sector_slug, s.name as sector_name, s.code as sector_code, z.slug as zona_slug, z.name as zona_name, z.code as zona_code, g.name as grade, b.order as boulder_order, (select count(id) from media m where v.id = m.via_id and type=" . MEDIA_TYPE_IMAGE . ") as images, (select count(id) from media m where v.id = m.via_id and type=" . MEDIA_TYPE_VIDEO . ") as videos  FROM via v INNER JOIN grado g ON v.grade_id=g.id INNER JOIN boulder b ON b.id=v.boulder_id INNER JOIN sector s ON b.sector_id=s.id INNER JOIN zona z ON z.id=s.zona_id WHERE LOWER(v.name) like '%" . strtolower($search) . "%' LIMIT 15");
$vias = $viaSelectedQuery->fetch_All(MYSQLI_ASSOC);

$sectorSelectedQuery = $mysqli->query("SELECT s.*, z.name as zona_name, z.slug as zona_slug FROM sector s INNER JOIN zona z ON s.zona_id = z.id WHERE s.name like '%" . $search . "%' LIMIT 15");
$sectores = $sectorSelectedQuery->fetch_All(MYSQLI_ASSOC);


?>


<!DOCTYPE html>
<html lang="en">

<head>
   <?php include("_head.php"); ?>
</head>

<body>
    <?php include("_menu.php"); ?>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-3">Busqueda:
                <?php echo $search;?>
            </h1>
            
          
        </div>
    </div>
    
    <section class="search">
        <div class="container">
            <div class="row">
                <?php if(count($vias)>0){ ?>
                    <div class="col-md-6">
                        <h2>Se han encontrado <?php echo count($vias); ?> vias:</h2>
                        <ul class="results vias">
                            <?php foreach($vias as $via){ ?>
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
                <?php if(count($sectores)>0){ ?>
                    <div class="col-md-6">
                        <h2>Se han encontrado <?php echo count($sectores); ?> sectores:</h2>
                        <ul class="results sectores">
                            <?php foreach($sectores as $sector){ ?>
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


    <?php include("_footer.php"); ?>
</body>

</html>
