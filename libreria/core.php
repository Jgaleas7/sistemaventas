<?php
require_once ("help/helps.php");
define("APP_RUTA",RUTA_BASE."app/");
define("VISTA_RUTA",RUTA_BASE."view/");
define("RUTA",APP_RUTA."rutas/");
define("LIBRERIA",RUTA_BASE."libreria/");
define("MODELS",APP_RUTA."model/");

/*Configuraciones*/
require_once (RUTA_BASE."config/config.php");
require_once ("ORM/conexion.php");
require_once ("ORM/EtORM.php");
require_once ("ORM/Modelo.php");
require_once("help/class.inputfilter.php");

/*Librerias*/
require_once ("vendor/Redirecciona.php");
require_once ("vendor/Session.php");
require_once ("fpdf/fpdf.php");


includeModels();

require_once ("Vista.php");
include "Ruta.php";
include RUTA."rutas.php";
