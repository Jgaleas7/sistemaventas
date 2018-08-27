<?php
validaSesion();
use app\model\VentaDetalle;
use app\model\VentadetalleTemp;
use  \libreria\ORM\EtORM;
class VentaDetalleController{

    public function agregar(){
        $postdata = file_get_contents("php://input");
        $postdata = json_decode($postdata);
        $data = $postdata->data;
        $id_venta = $postdata->id_venta;

        foreach ($data as $row) {
            $venta = new VentaDetalle();
            $venta->id = "";
            $venta->producto_id = $row->id;
            $venta->venta_id =$id_venta;
            $venta->cantidad = $row->cantidad;;
            $venta->precio = $row->precioDes;;
            $venta->precio_venta = $row->precio;
            $venta->impuesto = $row->impuesto;
            $venta->guardar();

            $venta = new VentadetalleTemp();
            $venta->id = "";
            $venta->producto_id = $row->id;
            $venta->venta_id =$id_venta;
            $venta->cantidad = $row->cantidad;;
            $venta->precio = $row->precioDes;;
            $venta->precio_venta = $row->precio;
            $venta->impuesto = $row->impuesto;
            $venta->guardar();
        }
    }

}