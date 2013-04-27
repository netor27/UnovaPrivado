<?php
require_once 'layout/headers/headBootstrap-wysiwyg.php';
?>
<link rel="stylesheet" href="/lib/js/jquery-ui/bootstrap-theme/jquery-ui-1.10.0.custom.css" />
<link rel="stylesheet" href="/layout/css/discusiones.css" />
<link rel="stylesheet" href="/layout/css/comentarios.css" />
<script>
    var maxPagina = <?php echo json_encode($maxPagina); ?>;
    var paginaActual = <?php echo json_encode($pagina); ?>;
    var discusion = <?php echo json_encode($discusion->idDiscusion); ?>;
    var rows = <?php echo json_encode($numRows); ?>;
    var orden = <?php echo json_encode($orden); ?>;
    var ascendente = <?php echo json_encode($ascendente); ?>;
    var numComentarios = <?php echo json_encode($numComentarios); ?>;
</script>
<script src="/lib/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<?php
//Si es tablet cargamos la librería touch-punch
if (getTipoLayout() == "tablet") {
    ?>
    <script src="/lib/js/jquery-ui/jquery.ui.touch-punch.min.js"></script>
    <?
}
?>

<script src="/js/vistaDiscusionForoDocumentReady.js"></script>