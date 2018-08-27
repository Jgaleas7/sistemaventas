<?php
validaSesion();
use \libreria\ORM\EtORM;
use app\model\User;

class ClaveController
{

    public function index()
    {
        return Vista::crear("cuenta.clave");

    }

    public function cambiar()
    {
        $usuario = $_SESSION["id_usuario"];
        $pass = encripta(input("clave_actual"));
        $orm = new EtORM();
        $data = $orm->Ejecutar("login", array($usuario, $pass));
        $bandera=0;
        $clave_nueva=$_POST["clave_nueva"];
        $clave_confirm=$_POST["clave_confirm"];
        $clave_actual=$_POST["clave_actual"];
        if (count($data) > 0) {

            if($clave_nueva != $clave_confirm){
                $bandera++;
                return Vista::crear("cuenta.clave", array(
                    "mensaje" => "Las contraseñas no son iguales",
                    "tipo"=>"danger"
                ));
            }

            if(strlen($clave_nueva)<4 || strlen($clave_confirm)<4){
                $bandera++;
                return Vista::crear("cuenta.clave", array(
                    "mensaje" => "La contraseña debe tener más de 4 caracteres",
                    "tipo"=>"danger"
                ));
            }

            if($clave_nueva == $clave_actual){
                $bandera++;
                return Vista::crear("cuenta.clave", array(
                    "mensaje" => "La contraseña nueva de ser diferente a la anterior",
                    "tipo"=>"danger"
                ));
            }
            if($bandera == 0) {
                $user=new User();
                $user=User::find($_SESSION['id']);
                $user->clave = crypt($clave_nueva, '$2a$07$usesomesillystringforsalt$');
                $user->guardar();
                return Vista::crear("cuenta.clave", array(
                    "mensaje" => "La contraseña ha sido actualizada",
                    "tipo" => "success"
                ));
            }


        } else {
            return Vista::crear("cuenta.clave", array(
                "mensaje" => "Contraseña incorrecta",
                "tipo"=>"danger"
            ));
        }

    }
}
