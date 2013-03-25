<div id="dialog-form-link" title="Agregar una página web"  style="display:none;">
    <div id="linkTabs">
        <ul>
            <li><a href="#linkTab">Página web</a></li>
            <li><a href="#tiempoTab">Tiempo</a></li>
            <li><a href="#colorFondoTab">Color de fondo</a></li>
        </ul>
        <div id="linkTab">
            <label>Link a la página:</label><br>
            <input type="text" name="url" id="urlLink" class="text ui-widget-content ui-corner-all"  style="width:97%;" value="http://"/>
        </div>
        <div id="tiempoTab">
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo inicial</legend>
                    <div class="row-fluid">                    
                        <div class="span2">
                            <input type="text" name="tiempoInicio" id="tiempoInicioLink" class="text ui-widget-content ui-corner-all span12" style="text-align: center;" />
                        </div>
                        <div class="span10">
                            <div id="tiempoInicioSliderLink" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo final</legend>
                    <div class="row-fluid">
                        <div class="span2">
                            <input type="text" name="tiempoFin" id="tiempoFinLink" class="text ui-widget-content ui-corner-all span12" style="text-align: center;"/>
                        </div>
                        <div class="span10">
                            <div id="tiempoFinSliderLink" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="colorFondoTab" style="overflow: hidden">
            <div style="width: 200px;float: left">
                <div id="colorSelectorLink"></div>
                <input type="hidden" name="colorHidden" id="colorHiddenLink"/>
            </div>
            <div style="width: 200px;float: right; text-align: left">
                <div class="colorSeleccionado">
                    <div>
                        <label>Color seleccionado:</label>
                        <div id="colorSeleccionadoLink" class="colorButton"></div>
                    </div>
                    <br><br>
                    <button id="sinColorLink" style="margin-top: 10px;">Sin color de fondo</button>
                </div>
            </div>
        </div>
    </div>	
</div>