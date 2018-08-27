<?php
//todas las rutas disponibles en nuestra aplicacion
$ruta=new Ruta();
$ruta->controladores(array(
    "/login"=>"AuthController",
    "/"=>"AuthController",
    "/usuarios"=>"UsuarioController",
    "/ventas"=>"VentaController",
    "/admin"=>"AdminController",
    "/productos"=>"ProductoController",
    "/ventadetalle"=>"VentaDetalleController",
    "/session"=>"SessionController",
    "/proveedores"=>"ProveedorController",
    "/configuraciones"=>"ConfigController",
    "/mensajes"=>"MensajeController",
    "/medicion"=>"MedicionController",
    "/categorias"=>"CategoriaController",
    "/clave"=>"ClaveController",
    "/reportes"=>"ReporteController",
    "/apertura"=>"AperturaController",
    "/cierre"=>"CierreController",
    "/compras"=>"EntradaController",

));
