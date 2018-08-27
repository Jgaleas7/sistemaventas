<?php
validaSesion();
validaPrivilegio();
use \libreria\ORM\EtORM;
use app\model\Categoria;
class CategoriaController
{
    public function index()
    {
        $categorias=Categoria::all();
        return Vista::crear("admin.categorias.listado", array(
            "categorias" => $categorias
        ));
    }

    public function nuevo(){
        return Vista::crear("admin.categorias.crear");
    }

    public function editar($id){
        $categoria=categoria::find($id);
        if(count($categoria)){
            return Vista::crear("admin.categorias.crear",array("categoria"=>$categoria));
        }else{
            redirecciona()->to("categorias");
        }
    }

    public function agregar(){
        if(isset($_POST['categoria_id'])){
            $categoria = new Categoria();
            $categoria->id = input("categoria_id");
            $categoria->nombre = input("nombre");
            $categoria->guardar();
            redirecciona()->to("categorias");
        }
    }

    public function eliminar($id){
        $categoria=Categoria::find($id);
        if(count($categoria)){
            $categoria->eliminar($id);
            return redirecciona()->to("categorias");
        }else{
            return redirecciona()->to("categorias");
        }
    }




}