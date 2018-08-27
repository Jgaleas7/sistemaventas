<?php
/**
 * User: DAVID
 * Date: 27/8/2016
 * Time: 12:24 PM
 */

class conexion
{
    public static function conectar()
    {
        try
        {
            date_default_timezone_set('America/Guatemala');
            $cn = new PDO("mysql:host=".HOST.";dbname=".DB, USER, PASSWORD);
            return $cn;
        }catch (PDOException $ex){
            die("Error: fuera de servicio");
        }
    }
}

conexion::conectar();
