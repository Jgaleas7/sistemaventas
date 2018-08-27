<?php
//use vista\Vista;
validaSesion();
use \libreria\ORM\EtORM;
use app\model\Producto;
use app\model\Categoria;
use app\model\Medicion;
class ProductoController
{

    public function index()
    {
        $productos=Producto::vistaProductos();
        return Vista::crear("admin.productos.listado", array(
            "productos" => $productos
        ));
    }

    public function nuevo(){
        $categorias=Categoria::all();
        $mediciones=Medicion::all();
        return Vista::crear("admin.productos.crear",array(
            "categorias"=>$categorias,
            "mediciones"=>$mediciones
        ));
    }

    public function editar($id){
        $producto=Producto::find($id);
        if(count($producto)){
            $categorias=Categoria::all();
            $mediciones=Medicion::all();
            return Vista::crear("admin.productos.crear",array(
                "producto"=>$producto,
                "categorias"=>$categorias,
                "mediciones"=>$mediciones
            ));
        }else{
            redirecciona()->to("productos");
        }
    }

    public function agregar(){
        $producto = new Producto();
        $producto->id=input('id');
        $producto->codigo = input("codigo");
        $producto->nombre = input("nombre");
        $producto->precio = input("precio");
        $producto->minimo = input("minimo");
        $producto->estado = 1;
        $producto->impuesto = input("impuesto");
        $producto->descuento = input("descuento");
        $producto->medida = input("medida");
        $producto->categoria = input("categoria");
        $producto->existencia = input("existencia");
        $producto->margen = input("margen");
        $producto->guardar();
        redirecciona()->to("productos");
    }

    public function eliminar($id){
        $producto=Producto::find($id);
        if(count($producto)){
            $orm=new EtORM();
            $orm->Ejecutar("desactiva_producto",array($id));
            return redirecciona()->to("productos");
        }else{
            return redirecciona()->to("productos");
        }
    }

    public function todos(){
        $productos=Producto::vistaProductos();
        echo json_response($productos);
    }

}