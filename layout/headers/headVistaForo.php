<?php
require_once 'layout/headers/headBootstrap-wysiwyg.php';
?>
<link rel="stylesheet" href="/layout/css/discusiones.css" />
<script>
    var maxPagina = <?php echo json_encode($maxPagina); ?>;
    var paginaActual = <?php echo json_encode($pagina); ?>;
    var curso = <?php echo json_encode($cursoAux->idCurso); ?>;
    var rows = <?php echo json_encode($numRows); ?>;
    var orden = <?php echo json_encode($orden); ?>;
    var ascendente = <?php echo json_encode($ascendente); ?>;
    var numDiscusiones = <?php echo json_encode($numDiscusiones); ?>;
</script>
<script src="/js/vistaForoDocumentReady.js"></script>