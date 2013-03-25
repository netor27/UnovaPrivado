<div id="dialog-form-video" title="Agregar un video"  style="display:none;">
    <div id="videoTabs">
        <ul>
            <li><a href="#videoTab">Video</a></li>
            <li><a href="#tiempoTab">Tiempo</a></li>
            <li><a href="#colorFondoTab">Color de fondo</a></li>
        </ul>
        
        <div id="videoTab">
            <label>Link al video:</label>
            <input type="text" name="url" id="urlVideo" class="text ui-widget-content ui-corner-all"  style="width:92%;"/>
        </div>
        
        <div id="tiempoTab">
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo inicial</legend>
                    <div class="row-fluid">                    
                        <div class="span2">
                            <input type="text" name="tiempoInicio" id="tiempoInicioVideo" class="text ui-widget-content ui-corner-all span12" style="text-align: center;" />
                        </div>
                        <div class="span10">
                            <div id="tiempoInicioSliderVideo" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo final</legend>
                    <div class="row-fluid">
                        <div class="span2">
                            <input type="text" name="tiempoFin" id="tiempoFinVideo" class="text ui-widget-content ui-corner-all span12" style="text-align: center;"/>
                        </div>
                        <div class="span10">
                            <div id="tiempoFinSliderVideo" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="colorFondoTab" style="overflow: hidden">
            <div style="width: 200px;float: left">
                <div id="colorSelectorVideo"></div>
                <input type="hidden" name="colorHidden" id="colorHiddenVideo"/>
            </div>
            <div style="width: 200px;float: right; text-align: left">
                <div class="colorSeleccionado">
                    <div>
                        <label>Color seleccionado:</label>
                        <div id="colorSeleccionadoVideo" class="colorButton"></div>
                    </div>
                    <br><br>
                    <button id="sinColorVideo" style="margin-top: 10px;">Sin color de fondo</button>
                </div>
            </div>     
        </div>
    </div>
</div>	