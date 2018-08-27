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
                <h1 class="page-header">Listado de ventas | <a class="btn btn-success" href="<?php url("ventas/nuevo"); ?>"><i class="fa fa-plus"></i> Nueva venta</a>
                    <a class="btn btn-warning" href="<?php url("ventas"); ?>"><i class="fa fa-refresh"></i> Refrescar</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <table class="table table-hover" id="listadoVentas">
            <thead>
            <tr>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Caja</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ventas as $venta){ ?>
                <tr>
                    <td><?= $venta["factura"]; ?></td>
                    <td><?= $venta["fecha"]; ?></td>
                    <td><?= $venta["usuario"]; ?></td>
                    <td><?= $venta["caja"]; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sn" href="<?php url("ventas/ver/".$venta["id"])?>"><i class="fa fa-eye"></i> Ver</a>
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