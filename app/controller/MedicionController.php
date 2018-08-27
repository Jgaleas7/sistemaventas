<?php
validaSesion();
validaPrivilegio();
use app\model\Medicion;
use \libreria\ORM\EtORM;
class MedicionController
{
    public function index()
    {
        $mediciones=Medicion::all();
        return Vista::crear("admin.mediciones.listado", array(
            "mediciones" => $mediciones
        ));
    }

    public function nuevo(){
        return Vista::crear("admin.mediciones.crear");
    }

    public function editar($id){
        $medicion=Medicion::find($id);
        if(count($medicion))
        {
            return Vista::crear("admin.mediciones.crear",array("medicion"=>$medicion));
        }
    }

    public function agregar(){

        if(isset($_POST['medicion_id'])){
            $medicion = new Medicion();
            $medicion->id = input("medicion_id");
            $medicion->medida = input("medida");
            $medicion->guardar();
            redirecciona()->to("mediciones");
        }
    }

    public function eliminar($id){
        $medicion=Medicion::find($id);
        if(count($medicion))
        {
            $medicion->eliminar($id);
            return redirecciona()->to("mediciones");
        }
    }

}