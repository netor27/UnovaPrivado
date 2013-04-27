<link rel="stylesheet" href="/lib/js/jquery-ui/bootstrap-theme/jquery-ui-1.10.0.custom.css" />
<link rel="stylesheet" href="/layout/css/editarCurso.css" />
<script src="/lib/js/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
<?php
//Si es tablet cargamos la librería touch-punch
if (getTipoLayout() == "tablet") {
    ?>
    <script src="/lib/js/jquery-ui/jquery.ui.touch-punch.min.js"></script>
    <?
}
?>
<script src="/js/tomarCursoDocumentReady.js" type="text/javascript"></script>
