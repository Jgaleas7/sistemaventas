<?php

namespace libreria\ORM;


class Modelo extends EtORM{

    /*Propiedad que contiene a todas las propiedades*/
    private $data = array();
    protected static $table;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->data[$name];
    }

    function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->data[$name]=$value;
    }

    public function getColumnas(){

        return $this->data;
    }


}