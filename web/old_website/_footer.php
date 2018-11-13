<footer class="bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-4">
                <span>
                    <div class="title">Català</div>
                         Si tens el nom d'algún bloc, algun sector que falta o alguna cosa a comentar, pots fer-ho a aquest e-mail <?php echo ADMIN_MAIL; ?>
                 </span>
            </div>
            <div class="col-12 col-md-4">
                <span>
                            <div class="title">Español</div>
                            Si tienes en nombre de algún bloque, algun sector que falta o algo a comentar, puedes hacerlo en este e-mail <?php echo ADMIN_MAIL; ?>
                        </span>
            </div>
            <div class="col-12 col-md-4">
                <span>
                            <div class="title">English</div>
                            If you have the name of a boulder, a missed sector or something to comment, you can do it in the following e-mail <?php echo ADMIN_MAIL; ?>
                        </span>
            </div>
        </div>
    </div>
</footer>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="<?php echo ROOT_PATH; ?>js/vendor/jquery-zoom/jquery.zoom.min.js"></script>
<script>
$(document).ready(function(){
  $('img.zoomable')
    .wrap('<span style="display:inline-block"></span>')
    .css('display', 'block')
    .parent()
    .zoom({on: 'grab'});
});
</script>