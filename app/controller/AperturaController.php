<?php
validaSesion();
use \libreria\ORM\EtORM;
use \app\model\Apertura;
class AperturaController
{
    public function index(){
        return Vista::crear("admin.arqueo.apertura");
    }
    public function guardar(){

        $orm=new EtORM();
        $caja=$_SESSION['caja'];
        $verifica_caja=$orm->Ejecutar('verifica_apertura_caja',array($caja));

        if($verifica_caja[0]['numero']>0) {/*si hay una paertura abierta para la caja $caja*/
            return Vista::crear('admin.arqueo.apertura', array(
                "mensaje" => "La caja ya esta aperturada",
                "tipo" => "danger"
            ));
        }
        $apertura = new Apertura();
        $apertura->id="";
        $apertura->fecha = date('Y-m-d');
        $apertura->monto = input('montoApertura');
        $apertura->usuario = $_SESSION['id'];
        $apertura->caja = $caja;
        $apertura->estado = 'abierta';
        if (!$apertura->guardar()) {
            redirecciona()->to('apertura');
        } else {

            redirecciona()->to('ventas/nuevo');
        }

    }
    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
    public function editar(){
        $id=input('id');
        $apertura=Apertura::find($id);
        $apertura->monto=input('montoApertura');
        if(!$apertura->guardar()){
            return Vista::crear('admin.arqueo.modificar',array(
                "mensaje"=>"No es posible mificar la apertura",
                "tipo"=>"danger"
            ));
        }
        else{
            redirecciona()->to('apertura/historial');
        }
    }


    public function historial(){
        $orm=new EtORM();
        $aperturas=$orm->Ejecutar('historialAperturas');
        return Vista::crear('admin.arqueo.historial',array("aperturas"=>$aperturas));
    }
    public function modificar($id){
        validaPrivilegio();
        $apertura=Apertura::find($id);
        return Vista::crear('admin.arqueo.modificar',array("apertura"=>$apertura));
    }

}