<?php

class Comentario{
    public $idComentario;
    public $idDiscusion;
    public $idUsuario;
    public $fecha;
    public $texto;    
    public $puntuacionMas;
    public $puntuacionMenos;
    
    //no son parte de la bd
    public $puntuacion;
    public $usuarioAvatar;
    public $usuarioNombre;
    public $usuarioUrl;
}
?>