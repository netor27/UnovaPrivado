<?php
require_once('layout/headers/headInicio.php');
require_once('layout/headers/headGridster.php');
require_once('layout/headers/headCierre.php');
?>
<div class="contenido">
    <section class="demo">

        <div class="gridster ready">
            <ul style="height: 480px; position: relative; ">
                <li id="1" class="cuadro" data-row="1" data-col="1" data-sizex="2" data-sizey="1" class="gs_w">
                    A <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>               
                <li id="2"  class="cuadro" data-row="3" data-col="1" data-sizex="1" data-sizey="1" class="gs_w">
                    B <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="3"  class="cuadro" data-row="3" data-col="2" data-sizex="2" data-sizey="1" class="gs_w">
                    C <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="4"  class="cuadro" data-row="1" data-col="3" data-sizex="2" data-sizey="2" class="gs_w">
                    D <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="5"  class="cuadro try gs_w" data-row="1" data-col="5" data-sizex="1" data-sizey="1">
                    E <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="6"  class="cuadro" data-row="2" data-col="1" data-sizex="2" data-sizey="1" class="gs_w">
                    F <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="7"  class="cuadro" data-row="3" data-col="4" data-sizex="1" data-sizey="1" class="gs_w">
                    G <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="8"  class="cuadro" data-row="1" data-col="6" data-sizex="1" data-sizey="1" class="gs_w">
                    H <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li id="9"  class="cuadro" data-row="3" data-col="5" data-sizex="1" data-sizey="1" class="gs_w">
                    I <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>

                <li id="10"  class="cuadro" data-row="2" data-col="5" data-sizex="1" data-sizey="1" class="gs_w">
                    J <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
                <li  id="11" class="cuadro" data-row="2" data-col="6" data-sizex="1" data-sizey="2" class="gs_w">
                    K <br>
                    <a  class="cuadroLink">Cambiar tamaño</a>
                </li>
            </ul>
        </div>

    </section>

    
</div>
<?php
require_once('layout/foot.php');
?>