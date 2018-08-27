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
                <h1>Cambiar contraseña</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if(isset($mensaje)) {?>
                            <div class="alert alert-<?= $tipo ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?= $mensaje ?>
                            </div>
                        <?php }?>
                        <form action="<?php url("clave/cambiar"); ?>" method="post" role="form">
                            <div class="form-group">
                                <label for="">Contraseña actual</label>
                                <input type="password" class="form-control" name="clave_actual" required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="">Contraseña nueva</label>
                                <input type="password" class="form-control" name="clave_nueva" required >
                            </div>

                            <div class="form-group">
                                <label for="">Confirmar contraseña</label>
                                <input type="password" class="form-control" name="clave_confirm" required >
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>

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