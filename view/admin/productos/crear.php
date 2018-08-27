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
                <h1 class="page-header"><?= isset($producto)? 'Actualizar':'Nuevo' ?> Producto | <a class="btn btn-success" href="<?php url("productos"); ?>"><i class="fa fa-backward"></i> Ver listado</a>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- Contenido Inicio-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("productos/agregar"); ?>" method="post" role="form">
                            <legend>Datos del producto</legend>
                        <div class="col-md-12">
                            <div class="col-md-6">

                                <input type="hidden" value="<?= isset($producto)? $producto->id:'' ?>" name="id">

                                <div class="form-group">
                                    <label for="">Código(requerido)</label>
                                    <input value="<?= isset($producto)? $producto->codigo:'' ?>"
                                           type="text" class="form-control" name="codigo" id="codigo"  required>
                                </div>

                                <div class="form-group">
                                    <label for="">Nombre(requerido)</label>
                                    <input value="<?= isset($producto)? $producto->nombre:'' ?>"
                                           type="text" class="form-control" name="nombre" id="nombre" required>
                                </div>

                                <div class="form-group">
                                    <label for="">Precio(requerido)</label>
                                    <input type="numeric" class="form-control" name="precio" id="precio" value="<?= isset($producto)? $producto->precio :''?>" required>
                                </div>
                                <?php //if(!isset($producto)){?>
                                    <div class="form-group">
                                        <label for="">Existencia</label>
                                        <input type="numeric" class="form-control" name="existencia" value="<?= isset($producto)? $producto->existencia :''?>" <?= isset($producto)? 'readonly' :''?>>
                                    </div>
                                <?php //}?>

                                <div class="form-group">
                                    <label for="">Categoría</label>
                                    <select name="categoria" id="categoria" class="form-control">
                                        <?php foreach ($categorias as $row) {
                                        if(isset($producto)){ ?>
                                        <option value='<?php echo $row->id; ?>' <?php if($producto->categoria==$row->id){echo "selected";} ?>>
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

                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Impuesto</label>
                                    <input type="numeric" class="form-control" name="impuesto" id="impuesto" value="<?= isset($producto)? $producto->impuesto :''?>" >
                                </div>

                                <div class="form-group">
                                    <label for="">Mínimo</label>
                                    <input type="numeric" class="form-control" name="minimo" id="minimo" value="<?= isset($producto)? $producto->minimo :''?>" >
                                </div>
                                <div class="form-group">
                                    <label for="">Descuento</label>
                                    <input type="numeric" class="form-control" name="descuento" id="descuento" value="<?= isset($producto)? $producto->descuento :''?>"  >
                                </div>

                                <div class="form-group">
                                    <label for="">Unidad de medida</label>
                                    <select name="medida" id="medida" class="form-control">
                                        <?php foreach ($mediciones as $row) {
                                        if(isset($producto)){ ?>
                                            <option value='<?php echo $row->id; ?>' <?php if($producto->medida==$row->id){echo "selected";} ?>>
                                            <?php }
                                            else
                                            {
                                                echo "<option value='" . $row->id . "'>";
                                            }
                                            echo $row->medida;
                                            echo "</option>";
                                            }
                                            ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Margen Util.</label>
                                    <select name="margen" id="margen" class="form-control">
                                        <?php for($i=5;$i<=100;$i+=5) {
                                            if(isset($producto)){
                                                if($i == $producto->margen)
                                                echo "<option value='" . $i . "' selected>".$i."%";
                                                echo "<option value='" . $i . "'>".$i."%";
                                            }
                                            else{
                                                echo "<option value='" . $i . "'>".$i."%";
                                            }
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                        </div>

                    </div>
                </div>
            </div>
            </form>
        </div>


        <!-- Contenido Fin-->
    </div>
    <!-- /#page-wrapper -->
</div>

<?php include (VISTA_RUTA."includes/scripts.php");?>
</body>

</html>