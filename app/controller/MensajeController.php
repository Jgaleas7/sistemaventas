<?php
//use vista\Vista
validaSesion();
use \libreria\ORM\EtORM;
class MensajeController{

    public function denegado(){
        return Vista::crear("mensajes.denegado");
    }
}