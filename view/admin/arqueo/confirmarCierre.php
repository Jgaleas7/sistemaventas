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
                    <h1 class="page-header">¿Hacer cierre de caja?</h1>
                </div>
            </div>
        </div>

        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-12">
                <form action="<?php url("reportes/cierre"); ?>" method="post" role="form" target="_blank">
                    <?php if(isset($mensaje)) {?>
                        <div class="alert alert-<?= $tipo?>">
                            <?= $mensaje?>
                        </div>
                    <?php }?>
                    <div class="form-group">
                        <button type="submit" class=" btn btn-success " style="width:150px;"><i class="fa fa-check"></i> Sí</button>
                    </div>
                    <br>
                    <br>

                </form>

            </div>
        </div>


        <!-- Contenido Fin-->
    </div>
    <!-- /#page-wrapper -->
</div>

<?php include (VISTA_RUTA."includes/scripts.php");?>
</body>

</html>