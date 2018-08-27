<?php
//use vista\Vista;
validaSesion();
use \libreria\ORM\EtORM;
use app\model\Proveedor;
class ProveedorController
{

    public function index()
    {
        $proveedores=Proveedor::all();
        return Vista::crear("admin.proveedores.listado", array(
            "proveedores" => $proveedores
        ));
    }

    public function nuevo(){
        return Vista::crear("admin.proveedores.crear");
    }

    public function editar($id){
        $proveedor=Proveedor::find($id);
        if(count($proveedor)){
            return Vista::crear("admin.proveedores.crear",array("proveedor"=>$proveedor));
        }else{
            redirecciona()->to("proveedores");
        }
    }

    public function agregar(){
            $proveedor = new Proveedor();
            $proveedor->id = input("id");
            $proveedor->nombre = input("nombre");
            $proveedor->descripcion = input("descri");
            $proveedor->direccion = input("direc");
            $proveedor->tel1 = input("tel1");
            $proveedor->tel2 = input("tel2");
            $proveedor->correo = input("correo");
            $proveedor->contacto = input("contacto");
            $proveedor->guardar();
            redirecciona()->to("proveedores");
    }

    public function eliminar($id){
        $proveedor=Proveedor::find($id);
        if(count($proveedor)){
            $proveedor->eliminar($id);
            return redirecciona()->to("proveedores");
        }else{
            return redirecciona()->to("proveedores");
        }
    }



}