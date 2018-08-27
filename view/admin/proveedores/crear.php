<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include (VISTA_RUTA."includes/head.php");?>
</head>

<body>

<div id="wrapper">
    <?php include (VISTA_RUTA."includes/menu.php");?>
    <!-- Navigation -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= isset($producto)? 'Actualizar':'Nuevo' ?> Proveedor | <a class="btn btn-success" href="<?php url("proveedores"); ?>"><i class="fa fa-backward"></i> Ver listado</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("proveedores/agregar"); ?>" method="post" role="form">
                            <legend>Datos del proveedor</legend>

                            <input type="hidden" value="<?= isset($proveedor)? $proveedor->id:'' ?>" name="id">

                            <div class="form-group">
                                <label for="">Nombre(Requerido)</label>
                                <input value="<?= isset($proveedor)? $proveedor->nombre:'' ?>"
                                       type="text" class="form-control" name="nombre" id="nombre" required>
                            </div>

                            <div class="form-group">
                                <label for="">Descripción</label>
                                <input type="text" class="form-control" name="descri" id="descri" value="<?= isset($proveedor)? $proveedor->descripcion :''?>" >
                            </div>
                            <div class="form-group">
                                <label for="">Dirección</label>
                                <input type="text" class="form-control" name="direc" id="direc" value="<?= isset($proveedor)? $proveedor->direccion :''?>" >
                            </div>

                            <div class="form-group">
                                <label for="">Telefono 1</label>
                                <input type="text" class="form-control" name="tel1" id="tel1" value="<?= isset($proveedor)? $proveedor->tel1 :''?>" >
                            </div>
                            <div class="form-group">
                                <label for="">Telefono 2</label>
                                <input type="text" class="form-control" name="tel2" id="tel2" value="<?= isset($proveedor)? $proveedor->tel2 :''?>" >
                            </div>

                            <div class="form-group">
                                <label for="">Correo</label>
                                <input type="email" class="form-control" name="correo" id="correo" value="<?= isset($proveedor)? $proveedor->correo :''?>" >
                            </div>
                            <div class="form-group">
                                <label for="">Contacto</label>
                                <input type="text" class="form-control" name="contacto" id="contacto" value="<?= isset($proveedor)? $proveedor->contacto :''?>" >
                            </div>



                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Contenido Fin-->
    </div>
    <!-- /#page-wrapper -->
</div>

<?php include (VISTA_RUTA."includes/scripts.php");?>
</body>

</html>