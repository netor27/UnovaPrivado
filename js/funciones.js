function trim(stringToTrim) {
    return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
    return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
    return stringToTrim.replace(/\s+$/,"");
}
function encode_utf8( s ){
    return unescape( encodeURIComponent( s ) );
}

function decode_utf8( s ){
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
function validateEmail(email) {   
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function replaceAll( text, busca, reemplaza ){
    while (text.toString().indexOf(busca) != -1)
        text = text.toString().replace(busca,reemplaza);
    return text;
}