<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headDiscusionForo.php');
require_once('layout/headers/headCierre.php');
?>
<div class="row-fluid">
    <div class="span12 well" id="discusion" discusion="<?php echo $discusion->idDiscusion; ?>">
        <legend><h4><?php echo $discusion->titulo; ?></h4></legend>
        <div class="row-fluid">
            <div class="span2">
                <div class="row-fluid centerText">
                    <div class="span12">
                        <a href="/usuario/<?php echo $discusion->usuarioUrl; ?>"><?php echo $discusion->usuarioNombre; ?></a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span6 offset3">
                        <a href="/usuario/<?php echo $discusion->usuarioUrl; ?>">
                            <img class="img-polaroid hidden-phone" src="<?php echo $discusion->usuarioAvatar; ?>" />
                            <img class="img-polaroid visible-phone imageSmallPhone" src="<?php echo $discusion->usuarioAvatar; ?>" />
                        </a>
                    </div>
                </div>
            </div>
            <div class="span8 mostrarListas">
                <?php echo $discusion->texto; ?>
            </div>
            <div class="span2">              
                <p><?php echo transformaMysqlDateDDMMAAAAConHora($discusion->fecha); ?></p>
                <div class="row-fluid">
                    <div class="span12">
                        <p>Pertenece al curso:<br><a href="/curso/<?php echo $curso->uniqueUrl; ?>"><?php echo $curso->titulo; ?></a></p>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        Puntuación de esta entrada:
                        <div class='row-fluid'>
                            <div class='span4 offset2'>
                                <span class='discusionVotacion discusionVotacionMas' discusion='<?php echo $discusion->idDiscusion; ?>' id='votacionDiscusionMas_<?php echo $discusion->idDiscusion; ?>'>                                
                                    <i class='icon-thumbs-up'></i> <span><?php echo $discusion->puntuacionMas; ?></span>
                                </span>
                            </div>
                            <div class='span4'>
                                <span class='discusionVotacion discusionVotacionMenos' discusion='<?php echo $discusion->idDiscusion; ?>' id='votacionDiscusionMenos_<?php echo $discusion->idDiscusion; ?>'>
                                    <i class='icon-thumbs-down'></i> <span><?php echo $discusion->puntuacionMenos; ?></span>
                                </span>
                            </div>
                        </div>
                        <div class='row-fluid' style='min-height:3px;'>
                            <div class='span10' style='min-height:3px;'>
                                <div class='progress' style='height:3px;margin-bottom:0px;'>
                                    <div class='bar bar-success' style='width: <?php echo $porcentajePositivo . '%'; ?>;' id='porcentajeDiscusionPositivo_<?php echo $discusion->idDiscusion; ?>'></div>
                                    <div class='bar bar-danger' style='width: <?php echo $porcentajeNegativo . '%'; ?>;' id='porcentajeDiscusionNegativo_<?php echo $discusion->idDiscusion ?>'></div>
                                </div>                                
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <br><legend></legend>
        <div class="row-fluid">
            <h4 class="black">Comentarios</h4>
        </div>
        <div class="row-fluid">
            <div id="comentariosContainer">
                <div class="row-fluid">
                    <div class="span4">
                        <a href="#agregarComentarioModal" role="button" class="btn btn-primary" data-toggle="modal">
                            <i class="icon-comments"></i>  Hacer un comentario 
                        </a>
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
                    <div id="comentariosPagerContent">
                        <?php
                        if (isset($comentarios)) {
                            foreach ($comentarios as $comentario) {
                                printComentario($comentario);
                            }
                        }
                        ?>
                    </div>
                    <div id="comentariosPagerLoading" style="display:none;">
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
                        <div class="pagination pagination-centered" id="paginationComentario">
                            <ul >
                                <li class="btnPagination disabled" id="paginaMenos" pagina="1">
                                    <a href="javascript:void(0);">«</a></li>                    
                                </li>
                                <?php
                                for ($i = 1; $i <= $maxPagina; $i++) {
                                    if ($i == $pagina)
                                        echo '<li id="comentarioPager_' . $i . '" class="btnPagination active" pagina="' . $i . '"><a href="javascript:void(0);">' . $i . '</a></li>';
                                    else
                                        echo '<li id="comentarioPager_' . $i . '" class="btnPagination" pagina="' . $i . '"><a href="javascript:void(0);">' . $i . '</a></li>';
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
            <div id="agregarComentarioModal" class="modal fullWidth hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 id="myModalLabel">Hacer un comentario</h4>
                </div>
                <div class="modal-body">
                    <div class='row-fluid'>
                        <div id='dialogoErrorComentario' style='display:none;'></div>
                    </div>
                    <div class='row-fluid'>
                        <div class="span10 offset1">
                            <?php
                            require_once 'lib/js/bootstrap-wysiwyg/editorDiv.php';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnAgregarComentario">Aceptar</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once('layout/foot.php');
?>