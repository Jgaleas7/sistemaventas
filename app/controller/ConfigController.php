<?php
validaSesion();
validaPrivilegio();
use app\model\Config;
use  \libreria\ORM\EtORM;
class ConfigController{

    public function index(){
        $config=Config::all();
        return Vista::crear("admin.config.index",array(
            "config"=>$config
        ));
    }

    public function editar($id){
        $config=Config::find($id);
        if(count($config)){
            return Vista::crear("admin.config.editar",array("config"=>$config));
        }else{
            redirecciona()->to("configuraciones");
        }
    }

    public function agregar(){
            $config = Config::find(1);
            $config->empresa = $empresa = input("empresa");;
            $config->propietario = $propietario = input("propietario");;
            $config->telefono = $telefono = input("telefono");;
            $config->correo = $correo = input("correo");;
            $config->direccion = $direccion = input("direccion");;
            $config->cai = $cai = input("cai");;
            $config->rtn = $rtn = input("rtn");;
            $config->base_factura = $base_factura = input("base_factura");
            $config->rango_del = $rango_del = input("rango_del");
            $config->rango_al = $rango_al = input("rango_al");
            $config->rango_inicial = $rango_inicial = input("rango_inicial");
            $config->fecha_autorizada = $fecha_autorizada = input("fecha_autorizada");
            $config->guardar();
            redirecciona()->to("configuraciones");
    }
}