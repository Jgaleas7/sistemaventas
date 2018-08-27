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
                <h1 class="page-header"><?= isset($usuario)? 'Actualizar':'Nuevo' ?> Usuario | <a class="btn btn-success" href="<?php url("usuarios"); ?>"><i class="fa fa-backward"></i> Ver listado</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("usuarios/agregar"); ?>" method="post" role="form">
                            <legend>Datos del usuario</legend>

                            <?php if(isset($usuario)) {?>
                                <input type="hidden" value="<?= $usuario->id?>" name="usuario_id">
                            <?php }?>

                            <div class="form-group">
                                <label for="">Usuario</label>
                                <input value="<?= isset($usuario)? $usuario->id_usuario:'' ?>"
                                    type="text" class="form-control" name="id_usuario" id="id_usuario" required >
                            </div>

                            <div class="form-group">
                                <label for="">Nombre Usuario</label>
                                <input value="<?= isset($usuario)? $usuario->usuario:'' ?>" <?= isset($usuario)? 'readonly':'' ?>
                                       type="text" class="form-control" name="usuario" id="id_usuario" required >
                            </div>

                            <div class="form-group">
                                <label for="">Correo</label>
                                <input value="<?= isset($usuario)? $usuario->correo:'' ?>"
                                    type="text" class="form-control" name="correo" id="correo" maxlength="50">
                            </div>


                                <div class="form-group">
                                    <?php if(!isset($usuario)) {?>
                                    <label for="">Contraseña</label>
                                    <?php }?>
                                    <input type="<?= isset($usuario)? 'hidden':'password' ?>" class="form-control" name="clave" id="clave" <?= isset($usuario)? '' :'required'?> value="<?= isset($usuario)? $usuario->clave:'' ?>">
                                </div>


                            <div class="form-group">
                                <label for="">Privilegio</label>
                                <select name="privilegio" id="privilegio" class="form-control">
                                	<option <?= isset($usuario) && $usuario->privilegio=='admin'? 'selected' :''?> value="admin"> Administrador </option>
                                	<option <?= isset($usuario) && $usuario->privilegio=='venta'? 'selected' :''?> value="venta"> Vendedor </option>
                                </select>
                             </div>

                            <div class="form-group">
                                <label for="">Estado</label>
                                <select name="estado" id="estado" class="form-control">
                                    <option <?= isset($usuario) && $usuario->estado=='0'? 'selected' :''?> value="0"> Habilitado </option>
                                    <option <?= isset($usuario) && $usuario->estado=='1'? 'selected' :''?> value="1"> inhabilitado </option>
                                </select>
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