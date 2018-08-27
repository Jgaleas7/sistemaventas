<?php
validaSesion();
validaPrivilegio();

//use vista\Vista;
use app\model\User;
class UsuarioController{


    public function index(){
        $usuarios=User::where2('id',$_SESSION['id'],'<>');
        return Vista::crear("admin.usuarios.listado",array(
            "usuarios"=>$usuarios
        ));
    }

    public function nuevo(){
        return Vista::crear("admin.usuarios.crear");
    }

    public function editar($id){
        $usuario=User::find($id);
        if(count($usuario)){
            return Vista::crear("admin.usuarios.crear",array("usuario"=>$usuario));
        }else{
            redirecciona()->to("usuarios");
        }
    }

    public function agregar(){
        try{
            $user = new User();
            if(isset($_POST['usuario_id'])){
                $user=User::find(input("usuario_id"));
            }
            if(!isset($_POST['usuario_id'])){
                $user->id = "";
            }
            $user->correo = $_POST['correo'];
            $user->id_usuario = input("id_usuario");
            $user->usuario = input("usuario");
            if(input("clave")){
                $user->clave = crypt(input("clave"), '$2a$07$usesomesillystringforsalt$');
            }
            $user->privilegio = input("privilegio");
            $user->estado = input("estado");
            $user->guardar();
            redirecciona()->to("usuarios");
        }catch (Exception $e){
            echo "Error al guaradar";
        }
    }

    public function eliminar($id){
        $usuario=User::find($id);
        if(count($usuario)){
            $usuario->eliminar($id);
            return redirecciona()->to("usuarios");
        }else{
            return redirecciona()->to("usuarios");
        }
    }


}