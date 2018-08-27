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
                <h1 class="page-header">Listado de productos | <a class="btn btn-success" href="<?php url("productos/nuevo"); ?>"><i class="fa fa-plus"></i> Nuevo producto</a>
                    <a class="btn btn-warning" href="<?php url("productos"); ?>"><i class="fa fa-refresh"></i> Refrescar</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <table class="table table-hover" id="listadoProductos">
            <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Medida</th>
                <th>Precio</th>
                <th>Impto</th>
                <th>Descto.</th>
                <th>Existencia</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $producto){ ?>
                <tr>
                    <td><?= $producto->codigo; ?></td>
                    <td><?= $producto->nombre; ?></td>
                    <td><?= $producto->medida; ?></td>
                    <td><?= "L ".number_format($producto->precio,2); ?></td>
                    <td><?= $producto->impuesto.""; ?></td>
                    <td><?= $producto->descuento.""; ?></td>
                    <td><?= $producto->existencia; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sn" href="<?php url("productos/editar/".$producto->id)?>"><i class="fa fa-edit"></i> Editar</a>
                        <button onclick="confirmar('<?php url("productos/eliminar/".$producto->id)?>')" class="btn btn-danger btn-sn"><i class="fa fa-trash"></i> Eliminar</button>
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
        $('#listadoProductos').DataTable();
    });
</script>
</body>

</html>