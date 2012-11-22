<div id="dialog-form-video" title="Agregar un video">
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
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioVideo" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinVideo" class="text ui-widget-content ui-corner-all" style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderVideo"></div>
        </div>
        
        <div id="colorFondoTab">
            <div id="colorSelectorVideo" ></div>
            <input type="hidden" name="colorHidden" id="colorHiddenVideo"/>
            <br><br>
            <label>Color seleccionado:</label>
            <div id="colorSeleccionadoVideo" class="colorButton"></div>
        </div>

    </div>
</div>	