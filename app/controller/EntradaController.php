<?php
validaSesion();
validaPrivilegio();
use app\model\Entrada;
use app\model\EntradaDetalle;
use app\model\Proveedor;
use app\model\Estado;
use app\model\Producto;
use  \libreria\ORM\EtORM;
class EntradaController
{
    public function index(){
        $orm=new EtORM();
        $compras=$orm->Ejecutar('vista_compra');
        return Vista::crear('admin.entradas.index',array('compras'=>$compras));
    }

    public function nueva(){
        $proveedores=Proveedor::all();
        $estados=Estado::all();
        return Vista::crear('admin.entradas.nueva',
        array(
            'proveedores'=>$proveedores,
            'estados'=>$estados
        ));
    }

    public function guardarEncabezado(){
        $postdata = file_get_contents("php://input");
        $postdata = json_decode($postdata);
        $data = $postdata->data;

        foreach ($data as $row) {
            $entrada = new Entrada();
            $entrada->id = '';
            $entrada->fecha = $row->fecha;
            $entrada->idproveedor = $row->proveedor;
            $entrada->guardar();
            echo json_response($entrada);
        }
    }

    public function guardarDetalle(){
        $postdata = file_get_contents("php://input");
        $postdata = json_decode($postdata);
        $data = $postdata->data;
        $id_compra = $postdata->id_compra;

        foreach ($data as $row) {
            $entrada = new EntradaDetalle();
            $entrada->id = '';
            $entrada->identrada = $id_compra;
            $entrada->idproducto =$row->id_producto;
            $entrada->cantidad = $row->cantidad;
            $entrada->costo = $row->costo;
            $entrada->fecha_vencimiento = $row->fecha_vencimiento;
            $entrada->guardar();

            $producto=Producto::find($row->id_producto);
            $producto->precio=$row->precio_venta;
            $producto->guardar();
            echo json_response($entrada);
        }
    }
    public function actualizar(){

        $postdata = file_get_contents("php://input");
        $postdata = json_decode($postdata);
        $data = $postdata->data;
        $id_compra = $postdata->id_compra;
        $fecha = $postdata->fecha;
        $proveedor = $postdata->proveedor;

        $compra=Entrada::find($id_compra);
        $compra->fecha=$fecha;
        $compra->idproveedor=$proveedor;
        $compra->guardar();

        /*elimina el detalle de la compra*/
        $detalle=EntradaDetalle::where('identrada',$id_compra);
        foreach ($detalle as $item) {
            $registro=new EntradaDetalle();
            $registro->eliminar($id_compra,'identrada');
        }
        /*vuelve a crear el detalle*/
        foreach ($data as $row) {
            $registro=new EntradaDetalle();
            $registro->identrada=$id_compra;
            $registro->idproducto =$row->id;
            $registro->cantidad = $row->cantidad;
            $registro->costo = $row->costo;
            $registro->fecha_vencimiento = $row->fecha_vencimiento;
            $registro->guardar();

            $producto=Producto::find($row->id);
            $producto->precio=$row->precio_venta;
            $producto->guardar();
        }
    }
    public function ver($id){
        $orm=new EtORM();
        $entrada=Entrada::find($id);
        if(!count($entrada)){
            return redirecciona()->to("compras");
        }
        $proveedores=Proveedor::all();
        $productos=$orm->Ejecutar('detalle_compra',array($id));
        return Vista::crear('admin.entradas.nueva',array(
            'compra'=>$entrada,
            'productos'=>$productos,
            'proveedores'=>$proveedores,
        ));
    }

    public function eliminar($id){
        $compra=Entrada::find($id);
        if(count($compra)){
            $compra->eliminar($id);
            $detalle=EntradaDetalle::where('identrada',$id);
            foreach ($detalle as $item) {
                $registro=new EntradaDetalle();
                $registro->eliminar($id,'identrada');
            }
        }else{
        }
    }


}