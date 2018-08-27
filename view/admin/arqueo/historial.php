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
                <h1 class="page-header">Historial de aperturas
                    <a class="btn btn-warning" href="<?php url("apertura/historial"); ?>"><i class="fa fa-refresh"></i> Refrescar</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <table class="table table-hover" id="listadoVentas">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto de apertura</th>
                <th>Usuario</th>
                <th>Caja</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($aperturas as $apertura){ ?>
                <tr>
                    <td><?= $apertura['fecha']; ?></td>
                    <td><?='L.'. number_format($apertura['monto'],2); ?></td>
                    <td><?= $apertura['usuario']; ?></td>
                    <td><?= $apertura['caja']; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sn" href="<?php url("apertura/modificar/".$apertura["id"])?>">
                            <i class="fa fa-edit"></i> Modificar</a>
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
<script>
    $(document).ready(function(){
        $('#listadoVentas').DataTable();
    });
</script>
</body>

</html>