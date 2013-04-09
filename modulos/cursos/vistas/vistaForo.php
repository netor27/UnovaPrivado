<?php
require_once 'modulos/cursos/modelos/DiscusionModelo.php';
$numRows = 5;
$pagina = 1;
$sigPagina = 2;
$offset = $numRows * ($pagina - 1);
$array = getDiscusiones($cursoAux->idCurso, $offset, $numRows);
$discusiones = $array['discusiones'];
$numDiscusiones = $array['n'];
$maxPagina = ceil($numDiscusiones / $numRows);
?>
<link rel="stylesheet" href="/layout/css/discusiones.css" />
<script>
    var maxPagina = <?php echo json_encode($maxPagina); ?>;
    var paginaActual = <?php echo json_encode($pagina); ?>;
    var curso = <?php echo json_encode($cursoAux->idCurso); ?>;
    var rows = <?php echo json_encode($numRows); ?>;
    var numDiscusiones = <?php echo json_encode($numDiscusiones); ?>;
</script>
<script src="/js/vistaForoDocumentReady.js"></script>

<div id="discusionesContainer">
    <div class="row-fluid">
        <div class="span9">
            <strong><p>Temas de discusión en este curso:</p></strong>
        </div>
        <div class="span3">
            <button class="btn btn-primary" id="btnAgregarDiscusion">
                <i class="icon-plus icon-white"></i> Agregar un tema de discusión
            </button>
        </div>        
    </div>
    <div style="min-height: 530px;">
        <div id="discusionesPagerContent">
            <?php
            if (isset($discusiones)) {
                foreach ($discusiones as $discusion) {
                    printDiscusion($discusion);
                }
            }
            ?>
        </div>
        <div id="discusionesPagerLoading" style="display:none;">
            <div class="row-fluid">
                <div class="span3 offset1">
                    <img src="/layout/imagenes/loading2.gif">
                    <strong><p>Cargando...</p></strong>
                </div>           
            </div>            
        </div>        
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="pagination pagination-centered" id="paginationDiscusion">
                <ul >
                    <li class="btnPagination disabled" id="paginaMenos" pagina="1">
                        <a href="javascript:void(0);">«</a></li>                    
                    </li>
                    <?php
                    for ($i = 1; $i <= $maxPagina; $i++) {
                        if ($i == $pagina)
                            echo '<li id="discusionPager_' . $i . '" class="btnPagination active" pagina="' . $i . '"><a href="javascript:void(0);">' . $i . '</a></li>';
                        else
                            echo '<li id="discusionPager_' . $i . '" class="btnPagination" pagina="' . $i . '"><a href="javascript:void(0);">' . $i . '</a></li>';
                    }
                    if ($maxPagina < $sigPagina) {
                        $sigPagina = $maxPagina;
                    }
                    if ($sigPagina == $pagina) {
                        $auxSigPagina = "disabled";
                    } else {
                        $auxSigPagina = "";
                    }
                    ?>
                    <li class="btnPagination <?php echo $auxSigPagina; ?>" id="paginaMas" pagina="<?php echo $sigPagina; ?>">
                        <a href="javascript:void(0);">»</a>
                    </li>
                </ul>
            </div>            
        </div>
    </div>
</div>


