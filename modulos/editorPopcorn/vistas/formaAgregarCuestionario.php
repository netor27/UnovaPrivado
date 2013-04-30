<div id="dialog-form-cuestionario" title="Agregar pregunta" style="display:none;">
    <div id="cuestionarioTabs">
        <ul>
            <li><a href="#textoTab">Pregunta</a></li>
            <li><a href="#tiempoTab">Tiempo</a></li>
        </ul>
        <div id="textoTab">
            <div id="errorContainerPreguntas">
                
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="preguntasContainer">
                        <div id="seleccionarTipoPregunta" class="paginaPregunta">
                            <h4 class="black">Selecciona el tipo de pregunta:</h4>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid">                                
                                <button class="btn " style="font-weight: bolder;" onclick="mostrarPaginaPregunta('preguntaAbierta')">
                                    <i class="icon-align-left"> </i>  Pregunta abierta
                                </button>
                            </div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid">
                                <button class="btn " style="font-weight: bolder;" onclick="mostrarPaginaPregunta('opcionMultiple')">
                                    <i class="icon-list"> </i>  Opción múltiple
                                </button>
                            </div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid">
                                <button class="btn " style="font-weight: bolder;" onclick="mostrarPaginaPregunta('completarEspacios')">
                                    <i class="icon-text-width"> </i>  Completar espacios en blanco
                                </button>
                            </div>
                        </div>
                        <div id="preguntaAbierta" class="paginaPregunta" style="display:none;">
                            <div class="row-fluid">
                                <h4 class="black ">Escribe la pregunta:</h4>
                            </div>
                            <div class="row-fluid">
                                <textarea id="preguntaAbiertaTexto" class="span12" rows="5"></textarea>
                            </div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <button class="btn btn-inverse btnCambiarTipoPregunta" onclick="mostrarPaginaPregunta('seleccionarTipoPregunta')">
                                        <i class="icon-white icon-arrow-left"> </i> Cambiar tipo de pregunta
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="opcionMultiple" class="paginaPregunta" style="display:none;">
                            <div class="row-fluid">
                                <h4 class="black">Escribe la pregunta:</h4>
                            </div>
                            <div class="row-fluid">
                                <textarea id="preguntaOpcionMultipleTexto" class="span12" rows="3"></textarea>
                            </div>
                            <div class="row-fluid">
                                <h4 class="black">Opciones de respuesta:</h4>
                            </div>
                            <div class="row-fluid">
                                <div class="span12" id="respuestasContainer">
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <button class="btn" id="btnAgregarOtraOpcion">
                                        <i class="icon-plus"> </i> Agregar otra opción
                                    </button>
                                </div>
                            </div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid"><h6></h6></div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <button class="btn btn-inverse btnCambiarTipoPregunta" onclick="mostrarPaginaPregunta('seleccionarTipoPregunta')">
                                        <i class="icon-white icon-arrow-left"> </i> Cambiar tipo de pregunta
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="completarEspacios" class="paginaPregunta" style="display:none;">
                            <div class="row-fluid">
                                <h4 class="black ">Escribe la pregunta:</h4>
                                <p>Escribe entre corchetes [ ] la parte de la oración que el estudiante debe completar.</p>
                            </div>
                            <div class="row-fluid">
                                <textarea id="preguntaCompletarTexto" class="span12" rows="5"></textarea>
                            </div>
                            <div class="row-fluid">
                                <h4 class="black ">Resultado:</h4>
                            </div>
                            <div class="row-fluid">
                                <div class="span12" id="preguntaCompletarResultado" style="min-height: 100px;">
                                    
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span3">
                                    <button class="btn btn-inverse btnCambiarTipoPregunta" onclick="mostrarPaginaPregunta('seleccionarTipoPregunta')">
                                        <i class="icon-white icon-arrow-left"> </i> Cambiar tipo de pregunta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <div id="tiempoTab">
            <div class="row-fluid">
                <div class="span12">
                    <legend>Tiempo en el que aparece la pregunta</legend>
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
    </div>
</div>	

<div id="dialog-form-responderPregunta" title="Pregunta" style="display:none;">
    <div id="preguntaContainer">
        
    </div>
</div>