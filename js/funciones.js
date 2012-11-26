function trim(stringToTrim) {
    return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
    return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
    return stringToTrim.replace(/\s+$/,"");
}
function encode_utf8( s )
{
    return unescape( encodeURIComponent( s ) );
}

function decode_utf8( s )
{
    return decodeURIComponent( escape( s ) );
}

function redirect(url){
    document.location.href = url;
}

function KeepAlive(){
    $.ajax({
        type: "get",
        url: "/index.php?a=mantenerSesionAbierta" ,
        dataType: "text",
        success: function(data) {
            //Se realizó correctamente
        }
    });
}