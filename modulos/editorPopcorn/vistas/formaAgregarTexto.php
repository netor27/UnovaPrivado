<div id="dialog-form-texto" title="Cuadro de Texto"  style="display:none;">
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
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioTexto" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinTexto" class="text ui-widget-content ui-corner-all" style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderTexto"></div>
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