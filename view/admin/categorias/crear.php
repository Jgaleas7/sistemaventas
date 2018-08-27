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
                <h1 class="page-header"><?= isset($categoria)? 'Actualizar':'Nuevo' ?> Categoria | <a class="btn btn-success" href="<?php url("categorias"); ?>"><i class="fa fa-backward"></i> Ver listado</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("categorias/agregar"); ?>" method="post" role="form">
                            <legend>Datos de la categoria</legend>
                            <input type="hidden" value="<?= isset($categoria)? $categoria->id:'' ?>" name="categoria_id">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input value="<?= isset($categoria)? $categoria->nombre:'' ?>"
                                       type="text" class="form-control" name="nombre" id="nombre" required AUTOFOCUS>
                            </div>
                            <button type="submit" class="btn btn-primary" name="enviar"><i class="fa fa-save"></i> Guardar</button>
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