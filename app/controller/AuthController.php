<?php
if(isset($_SESSION['usuario'])){
    redirecciona()->to('admin');
}

use \libreria\ORM\EtORM;

class AuthController{

    public function index(){
        return Vista::crear("auth.login");

    }

    public function ingresar(){
        //if(val_csrf()){
            $usuario = input("usuario");
            $pass=encripta(input("clave"));
            $caja=input('caja');
            $orm=new EtORM();
            $data=$orm->Ejecutar("login",array($usuario,$pass));

            if(count($data) > 0){/*si las credenciales estan correctas*/

                /*$verifica_caja=$orm->Ejecutar('verifica_apertura_caja',array($caja));

                if($verifica_caja[0]['numero']>0) {//si hay una paertura abierta para la caja $caja
                    redirecciona()->to("/login")->withMessage(array(
                        "estado" => "true",
                        "mensaje" => "Ya hay una apertura vigente para esta caja"
                    ));
                    return;
                }
                */
                $_SESSION['usuario'] = $data[0]["usuario"];
                $_SESSION['id_usuario'] = $data[0]["id_usuario"];
                $_SESSION['privilegio'] = $data[0]["privilegio"];
                $_SESSION['id'] = $data[0]["id"];
                $_SESSION['caja'] = $caja;
                redireccionar("/admin");

            }
            else{
                redirecciona()->to("/login")->withMessage(array(
                    "estado"=>"true",
                    "mensaje"=>"Usuario/Contraseña incorrectos."
                ));
            }
        /*}
        else{
            echo "Error al ingresar";
        }*/
    }
}