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
<?php if(isset($compra)) {?>
    <script>
        $( document ).ready(function() {
            $scope.
        });
    </script>
<?php } ?>
<div id="wrapper" ng-app="compraApp" ng-controller="compraController">
    <?php include (VISTA_RUTA."includes/menu.php");?>
    <div id="page-wrapper">
        <div class="row">

            <div class="col-lg-12">
                <div style="color:">
                    <h1 class="page-header">Editar Compra de Productos</strong></h1>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>INFORMACION DE LA COMPRA</h4>
                <input type="hidden" value="<?php url(""); ?>" id="urlPrincipal">
                <?php if (isset($compra)) {?>
                    <input type="hidden" value="<?php echo $compra->id ?>" name="compra_id">
                <?php }?>
                <div class="form-group  visible-lg-inline-block">
                    <label for="usuario">Proveedor</label>
                    <select name="proveedor" id="proveedor" class="form-control">
                        <?php foreach ($proveedores as $row)
                        {
                        if(isset($entrada)){ ?>
                        <option value='<?php echo $row->id; ?>' <?php if($entrada->idproveedor==$row->id){echo "selected";} ?>>
                            <?php }
                            else
                            {
                                echo "<option value='" . $row->id . "'>";
                            }
                            echo $row->nombre;
                            echo "</option>";
                            }
                            ?>
                    </select>
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <label for="usuario">Fecha</label>
                    <input type="date" value="<?php echo isset($compra) ? $compra->fecha : date('Y-m-d') ?>" required  name="fecha" id="fecha" class="form-control">
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <button class="btn btn-primary" ng-click="registrarCompra()"><i class="fa fa-save"></i> Guardar Cambios</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <button ng-click="cargaProductos()" data-toggle="modal" data-target="#listaProductos" type="submit" class="btn btn-success"><i class="fa fa-search"></i> Buscar producto</button>
            </div>
        </div>
        <div class="row" id="div_productos">
            <div class="col-md-12">
                <h4>INFORMACION DEL PRODUCTO</h4>
                <input type="hidden" name="id_producto" id="id_producto">
                <div class="form-group  visible-lg-inline-block">
                    <label for="">Producto</label>
                    <input type="text" value="" required  name="producto" id="producto" class="form-control" >
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <label for="">Cantidad</label>
                    <input type="text" value="" required  name="cantidad" id="cantidad" class="form-control" >
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <label for="">Costo</label>
                    <input type="text" value="" required  name="costo" id="costo" class="form-control" >
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <label for="">Margen Util.</label>
                    <input type="text"  required  name="margen" id="margen" class="form-control" >
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <label for="usuario">Fecha de Vencimiento</label>
                    <input type="date" value="" required  name="fechaVencimiento" id="fechaVencimiento" class="form-control" >
                </div>
                <div class="form-group  visible-lg-inline-block">
                    <button class="btn btn-success" ng-click="agregaProducto()"><i class="fa fa-plus"></i> Agregar</button>
                </div>
            </div>
        </div>


        <div class="row" style="">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <br>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Costo</th>
                                <th>Total</th>
                                <th>Precio Venta</th>
                                <th>Vence</th>
                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr >
                                <td>{{ pd.nombre}}</td>
                                <td>{{ pd.cantidad}}</td>
                                <td>{{ pd.costo | currency:'L.'}}</td>
                                <td>{{ pd.total | currency:'L'}}</td>
                                <td>{{ pd.precio_venta  | currency:'L.'}}</td>
                                <td>{{ pd.fecha_vencimiento}}</td>
                                <td>
                                    <button class="btn btn-default btn-ns" ng-click="eliminaProducto(pd.id)"> <span class="fa fa-trash"></span> </button>
                                </td>
                            <tr>
                                <th colspan="5" class="text-right">Importe Total
                                </th>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

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
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Existencia</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr  ng-repeat="producto in productos | filter:buscarProducto">
                                <td>{{ producto.codigo }}</td>
                                <td>{{ producto.nombre }}</td>
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


    </div><!--page graper-->
</div><!--graper-->

<?php include (VISTA_RUTA."includes/scripts.php");?>
<script>
    $(document).ready(function(){
        $('#listadoProductos').DataTable();
    });
</script>
</body>

</html>