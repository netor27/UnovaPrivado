$(function(){
    $("#btnAyuda").click(function(){
        $("#mensaje").show();
        var $msg = "";
        $msg += "<p>Un archivo .csv tiene un formato de valores separados por comas (,)</p>";
        $msg += "<p>Se introduce la información de los usuarios, uno por cada línea. Ejemplo</p>";
        $msg += "<div class='well'>";
        $msg += "<div class='row'><div class='offset1'>ejemplo@mail.com, Mi Nombre</div></div>";
        $msg += "<div class='row'><div class='offset1'>ejemplo2@mail.com, Juan García</div></div>";
        $msg += "<div class='row'><div class='offset1'>ejemplo3@mail.com, Marco Rodríguez</div></div>";
        $msg += "<div class='row'><div class='offset1'>ejemplo4@mail.com, Otro Nombre</div></div>";
        $msg += "</div>";
        $msg += "<p>Este tipo de archivos puede ser generado desde cualquier editor de textos, estableciendo";
        $msg += " la extencion a .csv. También, es posible generarlos desde Microsoft Excel, en la opción";
        $msg += ' "Guardar Como", seleccionar archivo CSV</p>';
        bootbox.modal($msg,"Importar usuarios desde un archivo .csv");
    });
});