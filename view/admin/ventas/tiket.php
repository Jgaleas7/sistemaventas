<!DOCTYPE html>
<SCRIPT language="javascript">
    function imprimir()
    { if ((navigator.appName == "Netscape")) { window.print() ;
    }
    else
    { var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
        document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
    }
    }
</SCRIPT>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include (VISTA_RUTA."includes/head.php");?>
</head>

<body style="margin-:0;" onload="imprimir()">
        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-12">

                        <?php foreach ($config  as $row){?>
                        <div style="text-align: center">
                            <h3><?= isset($row)? $row->empresa."<br>":'' ?></h3>
                            <?= isset($row)? $row->direccion."<br>":'' ?>
                            <?= isset($row)? $row->propietario."<br>":'' ?>
                            <?= isset($row)? $row->telefono."<br>":'' ?>
                            <?= isset($row)? $row->correo."<br>":'' ?>
                        </div>
                        <div>
                            <?= isset($row)? "CAI: ".$row->cai."<br>":'' ?>
                            <?= isset($row)? "RTN: ".$row->rtn."<br>":'' ?>
                            <?= isset($row)? "Rango autorizado: ".$row->rango_del." al ".$row->rango_al."<br>":'' ?>
                            <?= isset($row)? "Fecha limite: ".$row->fecha_autorizada."<br>":'' ?>
                        </div>
                        <?php }?>
                        <div>
                            <?= isset($totales)? "Factura: ".$encabezado->factura."<br>":'' ?>
                            <?= isset($totales)? "Cliente: ".$totales["cliente"]."<br>":'' ?>
                        </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                        <table class="table">
                            <thead>
                            <tr>
                                <th style="width: 50%">Producto</th>
                                <th style="width: 10%">Cant.</th>
                                <th style="width: 40%">Precio</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($detalle as $fila){ ?>
                            <tr>
                                <td><?= $fila["nombre"]; ?></td>
                                <td><?= $fila["cantidad"]; ?></td>
                                <td><?= "L ".number_format($fila["precio"],2); ?></td>
                            </tr>
                            <?php }?>
                                <th colspan="2" class="text-right" style="border:0;">Subtotal
                                </th>
                                <td style="border:0;">L <?= isset($totales)? number_format($totales["subtotal"],2):'' ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-right" style="border:0;">ISV
                                </th>
                                <td style="border:0;">L <?= isset($totales)? number_format($totales["impto"],2):'' ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-right" style="border:0;">Descuento
                                </th>
                                <td style="border:0;">L <?= isset($totales)? number_format($totales["descuento"],2):'' ?></td>
                            </tr>
                            <tr >
                                <th colspan="2" class="text-right" style="border:0;">Total a pagar
                                </th>
                                <td style="border:0;">L <?= isset($totales)? number_format($totales["pagar"],2):'' ?></td>
                            </tr>


                            </tr>
                            </tbody>
                        </table>
            </div>
        </div>



        <div class="row">
            <div class="col-md-4">
                <label for="">Pago</label>
                <input value="<?= isset($totales)? $totales["tipopago"]:'' ?>" readonly style="border: 0">
            </div>
            <div class="col-md-4">
                <label for="">Efectivo</label>
                <input value="L <?= isset($totales)? number_format($totales["efectivo"],2):'' ?>" readonly style="border: 0">
            </div>
            <div class="col-md-4">
                <label for="">Cambio</label>
                <input value=" L <?= isset($totales)? number_format($totales["cambio"],2):'' ?>" readonly style="border: 0">
            </div>
            <div style="text-align: center;">
                <h5>Gracias por su compra!</h5>
            </div>
        <!-- Contenido Fin-->
         </div>

</body>

</html>