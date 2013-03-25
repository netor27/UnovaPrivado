<div id="dialog-form-cuestionario" title="Agregar cuestionario" style="display:none;">
    <div id="cuestionarioTabs">
        <ul>
            <li><a href="#textoTab">Preguntas</a></li>
            <li><a href="#tiempoTab">Tiempo inicial</a></li>
            <li><a href="#opcionesTab">Opciones del cuestionario</a></li>
        </ul>
        <div id="textoTab">
            <div class="row-fluid">
                <div class="span12">
                    <div class="preguntasContainer">
                        <div class="row-fluid" id="generandoCuestionario">
                            <div class="span6 ">
                                <div class="row-fluid">                                    
                                    <img src="/layout/imagenes/loadingBlack.gif"/>
                                    <strong>
                                        <p>Generando cuestionario, espera un momento.</p>
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid" id="cuestionarioGenerado" style="display:none;">
                            <div class="span12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div id="tiempoTab">
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo inicial</legend>
                    <div class="row-fluid">                    
                        <div class="span2">
                            <input type="text" name="tiempoInicio" id="tiempoInicioCuestionario" class="text ui-widget-content ui-corner-all span12" style="text-align: center;" />
                        </div>
                        <div class="span10">
                            <div id="tiempoInicioSliderCuestionario" class="tiempoSlider"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div id="opcionesTab" style="overflow: hidden">
            <h1>Opciones</h1>
        </div>        
    </div>
</div>	