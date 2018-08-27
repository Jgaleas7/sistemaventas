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
                <div style="color:#337ab7">
                    <h1 class="page-header">Bienvenido al sistema <strong> <?= $_SESSION['usuario']; ?></strong></h1>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->


        <div class="row">
            <!-- Panel 1 inicio-->
        <div class="col-md-4">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">
                                <?php
                                $total=0;
                                if(isset($ventas)){
                                    foreach ($ventas as $venta) {
                                        $total=$total+$venta['total'];
                                    }
                                }
                                echo 'L. '.number_format($total,2);
                                ?>
                            </div>
                            <div>Ventas del día</div>
                        </div>
                    </div>
                </div>
                <a href="<?php url("reportes/diario"); ?>">
                    <div class="panel-footer">
                        <span class="pull-left">Ver detalles</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <!-- Panel 1 fin-->
            <!-- Panel 2 inicio-->
            <div class="col-md-4">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-star-half-empty fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    <?php
                                    $cont=0;
                                    if(isset($minimos)){
                                        foreach ($minimos as $minimo) {
                                            $cont++;
                                        }
                                    }
                                    echo $cont;
                                    ?>
                                </div>
                                <div>Productos bajos en existencia</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php url("reportes/minimos"); ?>" target="_blank">
                        <div class="panel-footer">
                            <span class="pull-left">Ver detalles</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Panel 2 fin-->
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-primary">
                    <div class="panel-heading" >
                        <h4 style="color: white">Productos prximos a vencer en los proximos dos meses</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table" id="tabla_proximos">
                            <thead>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th>Existencia</th>
                                <th>Fecha Vencimiento</th>
                            </thead>
                            <tbody>
                            <?php foreach ($proximos as $producto){ ?>
                            <tr>
                                <td><?= $producto['codigo']; ?></td>
                                <td><?= $producto['nombre']; ?></td>
                                <td><?= $producto['medida']; ?></td>
                                <td><?= $producto['existencia']; ?></td>
                                <td><?= $producto['fecha_vencimiento']; ?></td>
                            </tbody>
                            <?php }?>
                        </table>
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
<script>

</script>
</html>
