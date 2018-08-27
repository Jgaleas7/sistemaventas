<?php
class SessionController{

    public function salir(){
        session_destroy();
        session_unset();
        redirecciona()->to("");
    }

}