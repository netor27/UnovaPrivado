<div id="dialog-form-imagen" title="Agregar una imagen">
    <div id="imagenTabs">
        <ul>
            <li><a href="#imagenTab">Imagen</a></li>
            <li><a href="#tiempoTab">Tiempo</a></li>
            <li><a href="#colorFondoTab">Color de fondo</a></li>
        </ul>
        
        <div id="imagenTab">
            <label>Url de la imagen:</label>
            <input type="text" name="url" id="urlImagen" class="text ui-widget-content ui-corner-all" style="width:92%;"/>

        </div>

        
        <div id="tiempoTab">
            <table>
                <tr>
                    <td><label for="Tiempo Inicial">Tiempo inicial</label></td>
                    <td><input type="text" name="tiempoInicio" id="tiempoInicioImagen" class="text ui-widget-content ui-corner-all" style="width:40px;"/><br></td>
                </tr>
                <tr>
                    <td><label for="Tiempo Final">Tiempo final</label></td>
                    <td><input type="text" name="tiempoFin" id="tiempoFinImagen" class="text ui-widget-content ui-corner-all"style="width:40px;"/></td>
                </tr> 
            </table>
            <div id="tiempoRangeSliderImagen"></div>
        </div>
        
        <div id="colorFondoTab">
            <div id="colorSelectorImagen" ></div>
            <input type="hidden" name="colorHidden" id="colorHiddenImagen"/>
            <br><br>
            <label>Color seleccionado:</label>
            <div id="colorSeleccionadoImagen" class="colorButton"></div>
        </div>
        
    </div>
</div>	