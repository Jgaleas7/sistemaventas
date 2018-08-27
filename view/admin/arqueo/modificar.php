<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .cuadrado{
            border-radius:0;
        }
    </style>
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
                <div >
                    <h1 class="page-header">Modificar apertura de caja</h1>
                </div>
            </div>
        </div>

        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if(isset($mensaje)) {?>
                            <div class="alert alert-<?= $tipo?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?= $mensaje?>
                            </div>
                        <?php }?>
                        <form action="<?php url("apertura/editar"); ?>" method="post" role="form">

                            <input type="hidden" value="<?= isset($apertura)? $apertura->id:'' ?>" name="id" >
                            <div class="form-group">
                                <label for="">Fecha</label>
                                <input type="text" class="form-control" name="" readonly value="<?= isset($apertura)? $apertura->fecha:'' ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Monto de Apertura</label>
                                <input type="numeric" class="form-control" name="montoApertura" required value="<?= isset($apertura)? $apertura->monto:'' ?>">
                            </div>
                            <button type="submit" class=" btn btn-primary "><i class="fa fa-save"></i> Guardar</button>

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