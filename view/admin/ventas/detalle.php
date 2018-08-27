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
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                       <legend>Datos de la venta</legend>
                        <?php
                            if(isset($encabezado)){
                                $datos = explode(" ", $encabezado->fecha);
                                $fecha=$datos[0];
                                $hora=$datos[1];
                            }
                        ?>
                        <div class="col-md-4">
                            <label for="">Factura</label>
                            <input value="<?php echo isset($encabezado) ? $encabezado->factura : '' ?>" disabled type="text" class="form-control" >
                        </div>
                        <div class="col-md-4">
                            <label for="">Fecha</label>
                            <input value="<?php echo isset($encabezado) ? $fecha : '' ?>" disabled type="text" class="form-control" >
                        </div>
                        <div class="col-md-4">
                            <label for="">Hora</label>
                            <input value="<?php echo isset($encabezado) ? $hora : '' ?>" disabled type="text" class="form-control" >
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Detalle de la venta</legend>
                        <a  href="<?php url("ventas/index"); ?>" class="btn btn-success"><i class="fa fa-backward"></i> Volver</a>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th>Cantidad</th>
                                <th>Precio vendido</th>
                                <th>Descuento</th>
                                <th>Impuesto</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $subtotal=0;
                            $descuento=0;
                            $total=0;
                            $isv=0;
                            foreach ($detalle as $fila){ ?>

                                <tr>
                                    <td><?= $fila["nombre"]; ?></td>
                                    <td><?= $fila["cantidad"]; ?></td>
                                    <td><?= $fila["medida"]; ?></td>
                                    <td><?= $fila["precio"]; ?></td>
                                    <td><?= "L. ".number_format($fila["descuento"],2); ?></td>
                                    <td><?= $fila["impuesto"]; ?></td>
                                    <td><?= 'L. '.number_format($fila["total"],2); ?></td>
                                </tr>
                            <?php
                                $total+=$fila['total'];
                                $isv=($isv)+(($fila['total'])-(($fila['total'])/(1+($fila['impuesto']/100))));
                                $descuento+=$fila['descuento'];
                                $subtotal=$total-$isv;
                                }
                            ?>
                            <tr>
                                <th colspan="5" class="text-right">Subtotal
                                </th>
                                <td><?= 'L. '.number_format($subtotal,2) ?></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">ISV
                                </th>
                                <td><?= 'L. '.number_format($isv,2) ?></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Descuento
                                </th>
                                <td><?= 'L. '.number_format($descuento,2) ?></td>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-right">Total
                                </th>
                                <td><?= 'L. '.number_format($total,2) ?></td>
                            </tr>
                            </tbody>
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
<script>
</script>
</body>

</html>