<?php 
//carrego les zones
$query = $mysqli->query("SELECT * FROM zona WHERE active='1' ORDER BY 'order'");
$zones = array();
while($zone = $query->fetch_assoc()){
    //per cada zona carrego els sectors
    $sectorsQuery = $mysqli->query("SELECT * FROM sector WHERE zona_id=" . $zone["id"] . " AND active='1' ORDER BY 'order'");
    $zone["sectors"] = $sectorsQuery->fetch_All(MYSQLI_ASSOC);
    $zones[] = $zone;
}


//var_dump($zones);

?>

<!--<div class="adds">
    anuncis
</div>-->

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo ROOT_PATH; ?>">L-Boulder</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php foreach($zones as $zone){ ?>
                <li class="nav-item dropdown <?php echo $zoneSelected["id"]==$zone["id"]?"active": "" ?>">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $zone["name"]; ?></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach($zone["sectors"] as $sector){ ?>
                            <a class="dropdown-item" href="<?php echo ROOT_PATH . $zone["slug"] . "/" . $sector["slug"] ?>.html"><?php echo $sector["name"] ?></a>
                            <?php } ?>
                        </div>
                </li>
            <?php } ?>
        </ul>
        <form class="form-inline" action="<?php echo ROOT_PATH ?>search.html">
            <input class="form-control mr-sm-2" name="search" type="text" placeholder="Buscar" aria-label="Buscar">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </div>
</nav>