<div id="dialog-form-imagen" title="Agregar una imagen" style="display:none;">
    <div id="imagenTabs">
        <ul>
            <li><a href="#imagenTab">Imagen</a></li>
            <li><a href="#tiempoTab">Tiempo</a></li>
            <li><a href="#colorFondoTab">Color de fondo</a></li>
        </ul>

        <div id="imagenTab">
            <div id="formaSubirImagen">
                <p><strong>Para agregar una imagen, puedes subirla o escribir el link a la imagen</strong></p>
                
                <form name="form" action="" method="POST" enctype="multipart/form-data">                     
                    <input id="fileToUploadImage" type="file" name="imagen" title="<i class='icon-picture'/> Click para seleccionar imagen">
                    <br><br>
                    <button class="button" id="buttonUpload" onclick="return ajaxImageFileUpload();">Subir imagen</button>
                    <div id="loadingUploadImage" style="display: none;">
                        <h4>Tu imagen se esta subiendo...</h4>
                        <br>
                        <img src="/layout/imagenes/loading.gif" style="width: 50px;">
                    </div>
                </form>
                <br>
                <label>Ó puedes escribir el link a la imagen:</label>
                <input placeholder=" Link a la imagen" type="text" name="url" id="urlImagen" class="text ui-widget-content ui-corner-all" style="width:92%;"/>
            </div>
            <div id="formaElegirForma">
                <label>Selecciona una forma predefinda</label>
                <div>
                    <div id="formasContainer" style="overflow: hidden;">
                        <?php
                        foreach ($formasPredefinidas as $formaPredefinida) {
                            echo '<div class="formaPredefinida ui-corner-all" url="' . $formaPredefinida->imagen . '">
                                <img src="' . $formaPredefinida->imagen . '">
                                    
                                  </div>';
                        }
                        ?>                    
                    </div>
                </div>
            </div>            
            <div id="resultadoDeSubirImagen" style="display:none;">
            </div>
        </div>

        <div id="tiempoTab">
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo inicial</legend>
                    <div class="row-fluid">                    
                        <div class="span2">
                            <input type="text" name="tiempoInicio" id="tiempoInicioImagen" class="text ui-widget-content ui-corner-all span12" style="text-align: center;" />
                        </div>
                        <div class="span10">
                            <div id="tiempoInicioSliderImagen" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo final</legend>
                    <div class="row-fluid">
                        <div class="span2">
                            <input type="text" name="tiempoFin" id="tiempoFinImagen" class="text ui-widget-content ui-corner-all span12" style="text-align: center;"/>
                        </div>
                        <div class="span10">
                            <div id="tiempoFinSliderImagen" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="colorFondoTab" style="overflow: hidden">
            <div style="width: 200px;float: left">
                <div id="colorSelectorImagen"></div>
                <input type="hidden" name="colorHidden" id="colorHiddenImagen"/>
            </div>
            <div style="width: 200px;float: right; text-align: left">
                <div class="colorSeleccionado">
                    <div>
                        <label>Color seleccionado:</label>
                        <div id="colorSeleccionadoImagen" class="colorButton"></div>
                    </div>
                    <br><br>
                    <button  id="sinColorImagen" style="margin-top: 10px;">Sin color de fondo</button> 
                </div>
            </div>
        </div>
    </div>
</div>	