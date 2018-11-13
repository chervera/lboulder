<?php 
require "_init.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <?php include("_head.php"); ?>
</head>

<body>
    <?php include("_menu.php"); ?>

    <div class="jumbotron jumbotron-fluid  error404">
        <div class="container">
            <h1 class="display-3">Upss, se ha producido un <span>error</span>.
            </h1>
            <span class="lead">Prueba de acceder dentro de un rato. Si el error persiste contacta con el administrador (<?php echo ADMIN_MAIL; ?>)</span>
        </div>
    </div>


    <?php include("_footer.php"); ?>
</body>

</html>
