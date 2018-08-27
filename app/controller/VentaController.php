<?php
validaSesion();
use app\model\Venta;
use app\model\VentaDetalle;
use app\model\Config;
use  \libreria\ORM\EtORM;


class VentaController{
    public function index(){

        $orm=new EtORM();
        $ventas = $orm->Ejecutar("listar_ventas");
        return Vista::crear("admin.ventas.index", array(
            "ventas" => $ventas
        ));
    }

    public function ver($idventa){
        $encabezado=Venta::find($idventa);
        $orm=new EtORM();
        $detalle=$orm->Ejecutar("listar_detalle",array($idventa));
        return Vista::crear("admin.ventas.detalle",array(
            "encabezado"=>$encabezado,
            "detalle"=>$detalle
        ));
    }

    public function nuevo(){
        $orm=new EtORM();
        $verifica_caja=$orm->Ejecutar('verifica_apertura_caja',array($_SESSION['caja']));
        if($verifica_caja[0]['numero'] > 0){
            return Vista::crear("admin.ventas.nuevo");
        }else{
            return Vista::crear('admin.arqueo.apertura',array(
                "mensaje"=>"Haga apertura de caja para poder facturar",
                "tipo"=>"info"
            ));
        }
    }

    public function agregar(){
        $postdata = file_get_contents("php://input");
        $postdata = json_decode($postdata);
        $data = $postdata->data;

        $venta = new Venta();
        $venta->id = "";
        $venta->factura = $this->incrementaFactura();
        $venta->fecha = date("Y-m-d H:i:s");
        $venta->usuario = $_SESSION['id'];
        $venta->caja = $_SESSION['caja'];
        $venta->guardar();
        echo json_response($venta);
    }


    public function tiket(){
        if(isset($_POST['idventa_fact'])){
            $idventa=input("idventa_fact");
            $config=Config::all();
            $encabezado=Venta::find($idventa);
            $orm=new EtORM();
            $detalle=$orm->Ejecutar("listar_detalle",array($idventa));
            $tipopago=input('tipopago_fact');
            $efectivo=input('efectivo_fact');
            $cambio=input('cambio_fact');
            if($tipopago==1){
                $tipopago='Efectivo';
            }else{
                $tipopago='Tarjeta';
                $efectivo=0;
                $cambio=0;

            }

            $totales=array(
                "total"=>input("total_fact"),
                "subtotal"=>input("subtotal_fact"),
                "impto"=>input("impto_fact"),
                "descuento"=>input("descuento_fact"),
                "pagar"=>input("pagar_fact"),
                "efectivo"=>$efectivo,
                "cambio"=>$cambio,
                "cliente"=>input("cliente_fact"),
                "tipopago"=>$tipopago,
            );
            return Vista::crear("admin.ventas.tiket",array(
                "encabezado"=>$encabezado,
                "detalle"=>$detalle,
                "totales"=>$totales,
                "config"=>$config,
            ));
        }
    }

    public function testFactura(){
        echo $this->incrementaFactura();
    }
     public  function incrementaFactura(){

        $factura="";
        $orm = new EtORM();
        $base=$orm->Ejecutar("verifica_base");
         $cont=0;
        foreach ($base as $item){
             if($item["cantidad"]<=0){
                $cont=0;
             }
             else{
                 $cont++;
             }
         }
         $maximo=$orm->Ejecutar("incrementa_factura");
         foreach ($maximo as $item) {
             if($cont==0){
                 $factura=$item["base"]."-".$item["rango_inicial"];
                 return $factura;
             }else{
                 $maximo=$item["maximo"]+1;
                 if($maximo>=$item['rango_inicial']) {
                     $canti_ceros = substr("00000000", 0, 8 - strlen($maximo));
                     $factura = $canti_ceros . $maximo;
                     $factura = $item["base"] . "-" . $factura;
                     return $factura;
                 }
                 else{
                     $factura=$item["base"]."-".$item["rango_inicial"];
                     return $factura;
                 }
             }
         }

    }
}