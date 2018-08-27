<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include (VISTA_RUTA."includes/head.php");?>
</head>

<body style="margin-:0;">

 <div id="wrapper" ng-app="ventaApp" ng-controller="ventaController" style="margin-:0;">
     <?php // include (VISTA_RUTA."includes/menu.php");?>
    <!-- Navigation -->
     <div id="page-wrapper" style="width: 100%; margin-left: 0;">

         <!-- Contenido Inicio-->
         <br>
         <div class="row">
             <div class="col-md-4">
                 <div class="panel panel-default">
                     <div class="panel-body">
                             <input type="hidden" value="<?php url(""); ?>" id="urlPrincipal">

                             <?php if (isset($venta)) {?>
                                 <input type="hidden" value="<?php echo $venta->id ?>" name="venta_id">
                             <?php }?>

                             <div class="form-group">
                                 <label for="usuario">Nombre del cliente</label>
                                 <input value="<?php echo isset($venta) ? $venta->cliente : 'Consumidor Final' ?>" required type="text" name="cliente" class="form-control"  placeholder="Contoso Alfaro" id="cliente">
                             </div>

                             <div class="form-group">
                                 <label for="">Tipo de pago</label>
                                 <select name="tipopago" id="tipopago" class="form-control">
                                     <option value="1">Efectivo</option>
                                     <option value="2">Tarjeta</option>
                                 </select>
                             </div>
                         <label for="">Imprimir Factura</label>
                         <div class="form-group">
                             <input type="checkbox" id="bandera_factura">
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-md-2">
                 <div class="form-group">
                     <button class="btn btn-danger" style="width:150px;" ng-click="nueva()" ><i class="fa fa-trash"></i> Cancelar venta</button>
                 </div>
                 <div class="form-group">
                     <a href="<?php url("admin"); ?>" style="width:150px;" class="btn btn-primary"><i class="fa fa-backward"></i> Regresar</a>
                 </div>
             </div>
             <div class="col-md-4" style="text-align: center">
                 <h1>Farmacia Santa Rosa</h1>
                 <h1>Nueva venta</h1>
             </div>
         </div>
     

         <div class="row" style="">
             <div class="col-md-12">
                 <div class="panel panel-default">
                     <div class="panel-body">
                         <button ng-click="cargaProductos()" data-toggle="modal" data-target="#listaProductos" type="submit" class="btn btn-success">Agregar producto</button>
                         <br>
                         <br>
                         <table class="table table-hover">
                             <thead>
                             <tr>
                                 <th>Producto</th>
                                 <th>Medida</th>
                                 <th>Cantidad</th>
                                 <th>Precio</th>
                                 <th>Descto.</th>
                                 <th>Impto</th>
                                 <th>Total</th>
                                 <th>Acción</th>
                             </tr>
                             </thead>
                             <tbody>
                             <tr ng-repeat="pd in productosAdd">
                                 <td>{{ pd.nombre}}</td>
                                 <td>{{ pd.medida}}</td>
                                 <td>{{ pd.cantidad}}</td>
                                 <td>{{ pd.precio | currency:'L.'}}</td>
                                 <td>{{ pd.descuento | currency:'L'}}</td>
                                 <td>{{ pd.impuestoL | currency:'L'}}</td>
                                 <td>{{ pd.subtotal | currency:'L.'}}</td>
                                 <td>
                                     <button class="btn btn-default btn-ns" ng-click="addCantidad(pd.id)"> <span class="fa fa-plus"></span> </button>
                                     <button class="btn btn-default btn-ns" ng-click="resCantidad(pd.id)"> <span class="fa fa-minus"></span> </button>
                                     <button class="btn btn-default btn-ns" ng-click="eliminaProducto(pd.id)"> <span class="fa fa-trash"></span> </button>
                                 </td>
                             <tr>
                                 <th colspan="5" class="text-right">Subtotal
                                 </th>
                                 <td>{{ getSubtotal() | currency:'L.' }}</td>
                             </tr>
                             <tr>
                                 <th colspan="5" class="text-right">ISV
                                 </th>
                                 <td>{{ getIsv() | currency:'L.' }}</td>
                             </tr>
                             <!--<tr>
                                 <th colspan="5" class="text-right">Total
                                 </th>
                                 <td>{{ getTotal() | currency:'L.' }}</td>
                             </tr>-->
                             <tr>
                                 <th colspan="5" class="text-right">Descuento
                                 </th>
                                 <td>{{  getDescuento() | currency:'L.' }}</td>
                             </tr>
                             <tr>
                                 <th colspan="5" class="text-right">Total a pagar
                                 </th>
                                 <td>{{ getTotalPagar() | currency:'L.' }}</td>
                             </tr>


                             </tr>
                             </tbody>
                         </table>

                     </div>
                 </div>
             </div>
         </div>

         <div class="row">
             <div class="col-md-4">
                 <input type="number" class="form-control" id="efectivo" value="" placeholder="Efectivo">
             </div>
             <div class="col-md-4">
                 <input type="numeric" class="form-control" id="cambio" readonly value="0">
             </div>
             <div class="col-md-4" style="text-align: inherit">
                 <button id="btn_cobrar" class="btn btn-success" style="" ng-click="guardarVenta()"><span class="fa fa-save"  ></span> Cobrar</button>
             </div>
         </div>
         <br>
         <!-- Modal -->
         <div class="modal fade" id="listaProductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="height: 500px; overflow: auto">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                         <h4 class="modal-title" id="myModalLabel">Lista de productos</h4>
                     </div>
                     <div class="modal-body">
                         <input type="text" class="form-control" placeholder="Buscar" ng-model="buscarProducto">
                         <hr>
                         <table class="table table-hover" id="tablaproductos">
                             <thead>
                             <tr>
                                 <th>Codigo</th>
                                 <th>Producto</th>
                                 <th>Medida</th>
                                 <th>Precio</th>
                                 <th>Existencia</th>
                                 <th>Acción</th>
                             </tr>
                             </thead>
                             <tbody>
                             <tr  ng-repeat="producto in productos | filter:buscarProducto">
                                 <td>{{ producto.codigo }}</td>
                                 <td>{{ producto.nombre }}</td>
                                 <td>{{ producto.medida }}</td>
                                 <td>{{ producto.precio | currency:'L.'}}</td>
                                 <td>{{ producto.existencia}}</td>
                                 <td> <button ng-click="seleccionaProducto(producto.id)" type="button" class="btn btn-success btn-sm"><span class="fa fa-plus"></span> Agregar</button> </td>
                             </tr>
                             </tbody>
                         </table>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Contenido Fin-->
     </div>
     </form>
    <!-- /#page-wrapper -->
</div>

 <form action="<?php url('ventas/tiket'); ?>" method="post" target="_blank" id="form_print">
     <input type="hidden" id="efectivo_fact" name="efectivo_fact">
     <input type="hidden" id="cambio_fact" name="cambio_fact">
     <input type="hidden" id="idventa_fact" name="idventa_fact">
     <input type="hidden" id="subtotal_fact" name="subtotal_fact">
     <input type="hidden" id="impto_fact" name="impto_fact">
     <input type="hidden" id="total_fact" name="total_fact">
     <input type="hidden" id="descuento_fact" name="descuento_fact">
     <input type="hidden" id="pagar_fact" name="pagar_fact">
     <input type="hidden" id="cliente_fact" name="cliente_fact">
     <input type="hidden" id="tipopago_fact" name="tipopago_fact">
 </form>

<?php include (VISTA_RUTA."includes/scripts.php");?>
<script>

</script>
</body>

</html>