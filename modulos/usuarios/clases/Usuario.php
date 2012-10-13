<?php

class Usuario {

    public $idUsuario;
    public $email;
    public $password;
    public $nombreUsuario;
    public $tipoUsuario;
    public $avatar;
    public $bio;
    public $activado;
    public $fechaRegistro;
    public $tituloPersonal;
    public $uuid;
    public $uniqueUrl;

    function setRandomProfilePic() {
        $rand = rand(0, 5);
        $this->avatar = "/archivos/avatarPredefinido" . $rand . ".jpg";
    }
}

?>