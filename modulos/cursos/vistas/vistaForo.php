<?php
require_once 'modulos/cursos/modelos/DiscusionModelo.php';
$numRows = 5;
$pagina = 1;
$sigPagina = 2;
$orden = "puntuacion";
$ascendente = 0;
$offset = $numRows * ($pagina - 1);
$array = getDiscusiones($cursoAux->idCurso, $offset, $numRows, $orden, $ascendente);
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
    var orden = <?php echo json_encode($orden); ?>;
    var ascendente = <?php echo json_encode($ascendente); ?>;
    var numDiscusiones = <?php echo json_encode($numDiscusiones); ?>;
</script>
<script src="/js/vistaForoDocumentReady.js"></script>

<div id="discusionesContainer">
    <div class="row-fluid">
        <div class="span4">
            <button class="btn btn-primary" id="btnAgregarDiscusion">
                <i class="icon-plus icon-white"></i> Agregar una entrada al foro
            </button>
        </div>
        <div class="span7 offset1">
            <div class="row-fluid">
                <div class="span2" style="margin-top:5px;">
                    Ordenar:
                </div>
                <div class="span5">
                    <select class="span12" id="selectOrden">
                        <option value="puntuacion">Por puntuación</option>
                        <option value="fecha">Por fecha publicación</option>
                        <option value="alfabetico">Alfabéticamente</option>
                    </select>
                </div>
                <div class="span5">
                    <select class="span12" id="selectAscendente">
                        <option value="0">De mayor a menor</option>
                        <option value="1">De menor a mayor</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div style="min-height: 530px;">
        <div id="discusionesPagerContent">
            <?php
            if (isset($discusiones)) {
                foreach ($discusiones as $discusion) {
                    printDiscusion($discusion, $cursoAux->uniqueUrl);
                }
            }
            ?>
        </div>
        <div id="discusionesPagerLoading" style="display:none;">
            <div class="row-fluid centerText">
                <div class="span2 offset5">
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


