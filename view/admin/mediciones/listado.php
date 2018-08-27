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
                <h1 class="page-header">Listado de presentaciones | <a class="btn btn-success" href="<?php url("mediciones/nuevo"); ?>"><i class="fa fa-plus"></i> Nueva presentación</a>
                    <a class="btn btn-warning" href="<?php url("medicion"); ?>"><i class="fa fa-refresh"></i> Refrescar</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <table class="table table-hover" id="listadoMediciones">
            <thead>
            <tr>
                <th>Unidades de Medida</th>
                <th class="text-right">Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($mediciones as $medicion){ ?>
                <tr>
                    <td><?= $medicion->medida; ?></td>
                    <td class="text-right">
                        <a class="btn btn-primary btn-sn" href="<?php url("medicion/editar/".$medicion->id)?>"><i class="fa fa-edit"></i> Editar</a>
                        <button onclick="confirmar('<?php url("medicion/eliminar/".$medicion->id)?>')" class="btn btn-danger btn-sn"><i class="fa fa-trash"></i> Eliminar</button>
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
        $('#listadoMediciones').DataTable();
    });
</script>
</body>

</html>