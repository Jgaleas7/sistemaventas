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
                <h1 class="page-header">Configuración General | <a class="btn btn-success" href="<?php url("configuraciones"); ?>"><i class="fa fa-backward"></i> Volver</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <div class="row">
            <?php if(isset($mensaje)) {?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $mensaje ?>
                </div>
            <?php }?>
            <div class="col-md-12">
            <div class="panel panel-default">
            <div class="panel-body">
            <form action="<?php url("configuraciones/agregar"); ?>" method="post" role="form">
                <div class="col-md-6">
                    <?php if(isset($config)) {?>
                        <input type="hidden" value="<?= $config->id?>" name="id">
                    <?php }?>
                    <div class="form-group">
                        <label for="">Nombre de la empresa</label>
                        <input value="<?= isset($config)? $config->empresa:'' ?>" type="text" class="form-control" name="empresa" id="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="">Propietario</label>
                        <input type="text" class="form-control" name="propietario" value="<?= isset($config)? $config->propietario :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" value="<?= isset($config)? $config->telefono :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Correo</label>
                        <input type="email" class="form-control" name="correo" value="<?= isset($config)? $config->correo :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Dirección</label>
                        <input type="text" class="form-control" name="direccion" value="<?= isset($config)? $config->direccion :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">CAI</label>
                        <input type="text" class="form-control" name="cai" value="<?= isset($config)? $config->cai :''?>" >
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">RTN</label>
                        <input type="text" class="form-control" name="rtn" value="<?= isset($config)? $config->rtn :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Base de la factura</label>
                        <input type="text" class="form-control" name="base_factura" value="<?= isset($config)? $config->base_factura :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Rango inicial autorizado</label>
                        <input maxlength="8" type="text" class="form-control" name="rango_del" value="<?= isset($config)? $config->rango_del :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Rango final autorizado</label>
                        <input maxlength="8" type="text" class="form-control" name="rango_al" value="<?= isset($config)? $config->rango_al :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Rango inicial para el sistema</label>
                        <input maxlength="8" type="text" class="form-control" name="rango_inicial" value="<?= isset($config)? $config->rango_inicial :''?>" >
                    </div>

                    <div class="form-group">
                        <label for="">Fecha límite autorizada</label>
                        <input type="date" class="form-control" name="fecha_autorizada" value="<?= isset($config)? $config->fecha_autorizada :''?>" >
                    </div>
                </div>

             </div>
            </div>
            </div>
            </div>
            </form>



    </div>
        <!-- Contenido Fin-->
    </div>
    <!-- /#page-wrapper -->
</div>

<?php include (VISTA_RUTA."includes/scripts.php");?>
</body>

</html>