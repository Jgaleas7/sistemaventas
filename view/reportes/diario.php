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
                <h1 class="page-header"> Reporte de ventas por día
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("reportes/reporteDiario"); ?>" method="post" role="form" target="_blank">
                        <legend>Seleccione el día</legend>
                        <div class="form-group">
                            <label for="">Fecha</label>
                            <input type="date" class="form-control" name="fechaReporte" value="<?= date('Y-m-d') ?>">
                        </div>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> ver reporte</button>
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