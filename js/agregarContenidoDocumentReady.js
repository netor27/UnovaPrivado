$(document).ready(function() {
    
    //Cambiamos la forma en la que el navegador ejecuta el drag y el drop
    $(document).bind('drop dragover', function (e) {
        e.preventDefault();
    });

    $('#fileupload').fileupload({            
        url: '/uploader.php',
        sequentialUploads: true,
        maxFileSize: 3000000000, //Subir máximo 3GB
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(pdf|doc|docx|ppt|pptx|mov|mp4|wmv|avi|3gp|avi|flv|mpg|mpeg|mpe|mp3|wav|wma|ogg)$/i        
    });
    
    $('#fileupload').bind('fileuploaddone', 
        function (e, data) {          
            $.each(data.files, function (index, file) {
                if(file.type.indexOf("video") != -1){
                    bootbox.alert("<strong>Tu video se ha sido subido correctamente y se está transformando.</strong><br>Te enviaremos un correo electrónico cuando este listo");
                }
                if(file.type.indexOf("audio") != -1){
                    bootbox.alert("<strong>Tu archivo de audio se ha sido subido correctamente y se está transformando.</strong><br>Te enviaremos un correo electrónico cuando este listo");
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
    KeepAlive();
    setInterval(KeepAlive, '600000');
});