<div id="dialog-form-texto" title="Agregar texto"  style="display:none;">
    <div id="textTabs">
        <ul>
            <li><a href="#textoTab">Texto</a></li>
            <li><a href="#tiempoTab">Tiempo</a></li>
            <li><a href="#colorFondoTab">Color de fondo</a></li>
        </ul>

        <div id="textoTab">
            <div style="height: 320px;">
                <textarea id="textoTinyMce"></textarea>
            </div>
        </div>        
        <div id="tiempoTab">
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo inicial</legend>
                    <div class="row-fluid">                    
                        <div class="span2">
                            <input type="text" name="tiempoInicio" id="tiempoInicioTexto" class="text ui-widget-content ui-corner-all span12" style="text-align: center;" />
                        </div>
                        <div class="span10">
                            <div id="tiempoInicioSliderTexto" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo final</legend>
                    <div class="row-fluid">
                        <div class="span2">
                            <input type="text" name="tiempoFin" id="tiempoFinTexto" class="text ui-widget-content ui-corner-all span12" style="text-align: center;"/>
                        </div>
                        <div class="span10">
                            <div id="tiempoFinSliderTexto" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div id="colorFondoTab" style="overflow: hidden">
            <div style="width: 200px;float: left">
                <div id="colorSelectorTexto"></div>
                <input type="hidden" name="colorHidden" id="colorHiddenTexto"/>
            </div>
            <div style="width: 200px;float: right; text-align: left">
                <div class="colorSeleccionado">
                    <div>
                        <label>Color seleccionado:</label>
                        <div id="colorSeleccionadoTexto" class="colorButton"></div>
                    </div>
                    <br><br>
                    <button id="sinColorTexto" style="margin-top: 10px;">Sin color de fondo</button>
                </div>
            </div>
        </div>        
    </div>
</div>	