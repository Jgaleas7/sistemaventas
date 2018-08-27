<?php
validaSesion();
use \libreria\ORM\EtORM;
use app\model\Config;
use app\model\Apertura;
class ReporteController{

    public function minimos(){
        $orm=new EtORM();
        $infoEmpresa=Config::find(1);
        $minimos=$orm->Ejecutar("reporte_minimos");
        return Vista::crear("reportes.minimos",array(
            "minimos"=>$minimos,
            "empresa"=>$infoEmpresa
        ));
    }
    public function diario(){
        return Vista::crear("reportes.diario");
    }

    public function reporteDiario(){
        $orm=new EtORM();
        $fecha=input('fechaReporte');
        $infoEmpresa=Config::find(1);
        $ventas=$orm->Ejecutar('reporte_diario',array($fecha));
        return Vista::crear("reportes.reporteDiario", array(
            "ventas" => $ventas,
            "empresa"=>$infoEmpresa,
            "fecha"=>$fecha
        ));
    }

    public function vistaProximos(){
        return Vista::crear("reportes.vistaProximos");
    }
    public function proximosVencer(){
        $orm=new EtORM();
        $fecha=input('fechaReporte');
        $infoEmpresa=Config::find(1);
        $productos=$orm->Ejecutar('proximosa_vencer',array($fecha));
        return Vista::crear("reportes.proximosVencer", array(
            "productos" => $productos,
            "empresa"=>$infoEmpresa,
            "fecha"=>$fecha
        ));
    }
    public function inventario(){
        $orm=new EtORM();
        $productos=$orm->Ejecutar("reporte_inventario");
        $infoEmpresa=Config::find(1);
        //echo '<br>';
        //echo json_response($infoEmpresa);
        return Vista::crear("reportes.inventario",array(
            "productos"=>$productos,
            "empresa"=>$infoEmpresa
        ));
    }

    public function confirmarcierre(){
        return Vista::crear("admin.arqueo.confirmarCierre");
    }
    public function cierre(){
        $orm=new EtORM();
        $fecha=date('Y-m-d');
        $datosApertura = $orm->Ejecutar("selecciona_apertura", array($_SESSION['caja']));
        if(count($datosApertura)) {
            $apertura = Apertura::find($datosApertura[0]['id']);
            $apertura->estado = 'cerrada';
            $apertura->guardar();

            $ventas = $orm->Ejecutar('reporte_cierre', array($fecha,$_SESSION['caja']));
            $orm->Ejecutar('elimina_ventastemporales',array($_SESSION['caja']));
            $infoEmpresa = Config::find(1);
            return Vista::crear("reportes.cierre", array(
                "apertura" => $datosApertura,
                "ventas" => $ventas,
                "empresa" => $infoEmpresa
            ));
        }
        else{
            return Vista::crear("admin.arqueo.confirmarCierre", array(
                "tipo" => 'info',
                "mensaje" => 'El lote de ventas esta vacio',
            ));
        }
    }

}