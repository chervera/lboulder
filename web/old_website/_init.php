<?php
//constants
define("ROOT_PATH", "/");
define("REAL_HOST", "lboulder.com");
define("REAL_HOST_FULL", "http://www.lboulder.com");
define("IMG_PATH", ROOT_PATH . "assets/");
define("JS_PATH", ROOT_PATH . "js/");
define("JS_VENDOR_PATH", JS_PATH . "vendor/");

define("MEDIA_TYPE_IMAGE", 1);
define("MEDIA_TYPE_VIDEO", 2);

define("PAGE_TYPE_VIA", "V");
define("PAGE_TYPE_SECTOR", "S");

define("GRADE_UNKNOWN_ID", 30);

define("ADMIN_MAIL", "info[a]lboulder.com");


$mysqli = new mysqli("localhost", "mylboulder", "6bWEx40T", "lboulder");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

function getDifficultColor($id){
    if($id<=10){
        return "easy";
    }
    if($id<17){
        return "meddium";
    }
    if($id<23){
        return "hard";
    }
    return "super";

}

function calculateCounter($preCounter){
    $counter = array();
    $counter["total"] = count($preCounter);
    $counter["easy"] = 0;
    $counter["meddium"] = 0;
    $counter["hard"] = 0;
    $counter["super"] = 0;
    foreach($preCounter as $row){
        if($row["grade_id"]<11){
            $counter["easy"]= $counter["easy"] + 1;
        }else if($row["grade_id"]<17){
            $counter["meddium"]= $counter["meddium"] + 1;
        }else if($row["grade_id"]<23){
            $counter["hard"]= $counter["hard"] + 1;
        }else{
            $counter["super"]= $counter["super"] + 1;
        }
    }
    return $counter;
}

function getViaName($via){
  if($via["name"]){
    return $via["name"];
  }else{
    return getViaCode($via);
  }
}

function getViaCode($via){
	return $via["zona_code"] . $via["sector_code"] . $via["boulder_order"] . str_pad($via["order"], 2, "0", STR_PAD_LEFT);
}

function getSectorCode($sector, $zona){

    return $zona["code"] . $sector["code"];
  
}



?>
