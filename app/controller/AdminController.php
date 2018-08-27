<?php
validaSesion();
use \libreria\ORM\EtORM;
class AdminController{

    public function index(){
        $meses_sig=2;
        $año=date('Y');
        $mes=date('m')+$meses_sig;
        $dia=date('d');
        if($mes>12){
            $mes=$mes-12;
            $año=$año+1;
        }
        $fecha_proximos=$año."-".$mes."-".$dia;
        $orm=new EtORM();
        $fecha=date('Y-m-d');
        $minimos=$orm->Ejecutar('reporte_minimos');
        $ventas=$orm->Ejecutar('reporte_diario',array($fecha));
        $proximosVencer=$orm->Ejecutar('proximosa_vencer',array($fecha_proximos));
        return Vista::crear("admin.index", array(
             "minimos" => $minimos,
             "ventas" => $ventas,
             "proximos" => $proximosVencer
         ));
    }

}