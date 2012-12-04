<?php

class Curso{
    public $idCurso;            //Integer autoincrement
    public $idUsuario;          //Integer
    public $titulo;             //varchar(100)
    public $uniqueUrl;          //varchar(100)
    public $publicado;          //tinyint
    public $descripcionCorta;   //varchar(140)
    public $descripcion;        //text    
    public $fechaPublicacion;   //DATE
    public $fechaCreacion;      //DATE
    public $imagen;             //varchar(200)
    public $rating;             //Integer
    public $totalViews;         //Integer    
    
    //Las siguientes no son parte de la bd
    public $nombreUsuario;    
    public $numeroDeClases;
    public $numeroDeAlumnos;
    public $fechaInscripcion;
    public $puntuacion;
    public $uniqueUrlUsuario;
    public $numeroDeTomadas;
    
    function toString(){
        return " idCurso=" . $this->idCurso . 
               " idUsuario=" . $this->idUsuario .
               " titulo=". $this->titulo .
               " descripcionCorta=". $this->descripcionCorta .
               " usuario =".$this->nombreUsuario;
    }
}
?>