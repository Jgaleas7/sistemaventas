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
                <h1>Configuración general
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <table class="table table-hover" id="">
            <thead>
            <tr>
                <th>Empresa</th>
                <th>Dirección</th>
                <th >Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($config as $config){ ?>
                <tr>
                    <td><?= $config->empresa; ?></td>
                    <td><?= $config->direccion; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sn" href="<?php url("configuraciones/editar/".$config->id)?>"><i class="fa fa-edit"></i> Editar</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>




        <!-- Contenido Fin-->

    </div>
    <!-- /#page-wrapper -->
</div>

<?php include (VISTA_RUTA."includes/scripts.php");?>

</body>

</html>