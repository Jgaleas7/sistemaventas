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
                <h1 class="page-header">Listado de proveedores | <a class="btn btn-success" href="<?php url("proveedores/nuevo"); ?>"><i class="fa fa-plus"></i> Nuevo proveedor</a>
                    <a class="btn btn-warning" href="<?php url("proveedores"); ?>"><i class="fa fa-refresh"></i> Refrescar</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <table class="table table-hover" id="listadoProveedores">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Telefono 1</th>
                <th>Dirección 2</th>
                <th>Correo</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($proveedores as $proveedor){ ?>
                <tr>
                    <td><?= $proveedor->nombre; ?></td>
                    <td><?= $proveedor->tel1; ?></td>
                    <td><?= $proveedor->direccion; ?></td>
                    <td><?= $proveedor->correo; ?></td>
                    <td>
                        <a class="btn btn-primary btn-sn" href="<?php url("proveedores/editar/".$proveedor->id)?>"><i class="fa fa-edit"></i> Editar</a>
                        <button onclick="confirmar('<?php url("proveedores/eliminar/".$proveedor->id)?>')" class="btn btn-danger btn-sn"><i class="fa fa-trash"></i> Eliminar</button>
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
        $('#listadoProveedores').DataTable();
    });
</script>
</body>

</html>