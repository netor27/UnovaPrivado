$(document).ready(function() {
    
    //Inicializar los dialogs
    $( "#videoSubidoDialog" ).dialog({
        height: 160,
        width: 400,
        modal: true,
        autoOpen: false
    });
    $( "#dialog" ).dialog({
        height: 360,
        width: 500,
        modal: true,
        autoOpen: false
    });
    
    //Cambiamos la forma en la que el navegador ejecuta el drag y el drop
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });

    $('#fileupload').fileupload({            
        url: '/uploader.php',
        sequentialUploads: true,
        maxFileSize: 1500000000,
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(pdf|doc|docx|ppt|pptx|mov|mp4|wmv|avi|3gp|avi|flv|mpg|mpeg|mpe|mp3|wav|wma|ogg)$/i        
    });
    
    $('#fileupload').bind('fileuploaddone', 
        function (e, data) {          
            $.each(data.files, function (index, file) {
                if(file.type.indexOf("video") != -1){
                    bootbox.alert("<strong>Tu video se ha sido subido correctamente y se está transformando.</strong><br>Te enviaremos un correo electrónico cuando este listo");
                }
            });
        }
        ); 
            
    //    $('#fileupload').bind('fileuploadadd', 
    //        function (e, data) {
    //            $("#dialog").html("<h3>Carga iniciada</h3><p>Recuerda que si cambias o cierras esta página, tu descarga se cancelará</p>");
    //            $( "#dialog" ).dialog('open');
    //        }
    //        );  
            
    // Upload server status check for browsers with CORS support:
    if ($.support.cors) {
        $.ajax({
            url: '/uploader.php',
            type: 'HEAD'
        }).fail(function () {
            $('<span class="alert alert-error"/>')
            .text('Upload server currently unavailable - ' +
                new Date())
            .appendTo('#fileupload');
        });
    } 
    
    var primera = true;
    var imagen = "/layout/imagenes/1x1.gif?d=";
    function KeepAlive(){
        var d = new Date();
        var rand = d.getTime();
        $("#keepAlive").html("<img src='" + imagen + "?d=" + rand + "'>");        
    }
    setInterval(KeepAlive, '600000');
    
    
});