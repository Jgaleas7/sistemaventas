<?php //namespace Vista;

class Vista{

    public static function crear($path,$key=null,$value=null){

        if($path != ""){
            $path = explode(".",$path);
            $ruta="";
            for($i=0; $i< count($path);$i++){
                if($i==count($path)-1){
                    $ruta.=$path[$i].".php";
                }
                else{
                    $ruta.=$path[$i]."/";
                }
            }
            if(file_exists(VISTA_RUTA.$ruta)) {
                //comprobar si existe
                if(!is_null($key)){
                    if(is_array($key)){
                        extract($key,EXTR_PREFIX_SAME,"");
                    }
                    else{
                        ${$key} = $value;
                    }
                }
                include VISTA_RUTA.$ruta;
            }
        }
        return null;
    }

}