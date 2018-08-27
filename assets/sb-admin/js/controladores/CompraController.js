var compraApp = angular.module("compraApp",[]);
compraApp.controller('compraController',['$scope','$http','$filter',function ($scope,$http,$filter) {

    $scope.productos=[];
    $scope.url=$("#urlPrincipal").val();
    $scope.productosAdd=[];
    $scope.producto={};
    $scope.productoTemp=null;
    $scope.detalle={};
    $scope.encabezado=[];
    $scope.encabezadoTemp={};



    $scope.cargaProductos= function () {
        $http.get($scope.url+"productos/todos").then(function ($request){
            $scope.productos=$request.data;
        });
    }

    $scope.registrarCompra = function(){
        if($scope.productosAdd.length>0) {
            $.confirm({
                title: "¿Registrar Compra?",
                content: "¿ Desea registrar la compra en el sistema ?",
                confirmButtonClass: 'btn-success',
                cancelButtonClass: 'btn-danger',
                confirmButton: 'Registrar',
                cancelButton: 'Cancelar',
                confirm: function(){
                    $scope.guardaEncabezado();
                }
            });
        }
        else{
            alerta("Agrege un producto","La lista de productos esta vacia","info")
        }
    }
    $scope.eliminarCompra = function(){
            $.confirm({
                title: "¿Eliminar Compra?",
                content: "¿ Si elimina la compra el inventario se rebajara del sistema?",
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-success',
                confirmButton: 'Elimnar',
                cancelButton: 'Cancelar',
                confirm: function(){
                    var id_compra=$('#compra_id').val();
                    var res = $http.post($scope.url+'compras/eliminar/'+id_compra);
                    res.success(function(data, status, headers, config) {
                        alerta("Compra Eliminada", "Los datos se actualizaron correctamente","success");
                        location.reload();
                    });
                    res.error(function(data, status, headers, config) {
                        alerta("Hubo un problema", "Los datos no se actualizaron","danger");
                    });
                }
            });
    }
    $scope.actualizarCompra = function(){
        if($scope.productosAdd.length>0) {
            $.confirm({
                title: "¿Actualizar Compra?",
                content: "La existencia del inventario se actualizara",
                confirmButtonClass: 'btn-success',
                cancelButtonClass: 'btn-danger',
                confirmButton: 'Actualizar',
                cancelButton: 'Cancelar',
                confirm: function(){
                    $scope.detalle =$scope.productosAdd;
                    var id_compra=$('#compra_id').val();
                    var fecha=$('#fecha').val();
                    var proveedor=$('#proveedor').val();
                    var res = $http.post($scope.url+'compras/actualizar',
                        {
                            data : $scope.detalle,
                            id_compra:id_compra,
                            fecha:fecha,
                            proveedor:proveedor
                        });
                    res.success(function(data, status, headers, config) {
                        $scope.limpiarCampos();
                        alerta("Compra Actualizada", "Los datos se actualizaron correctamente","success");
                        location.reload();

                    });
                    res.error(function(data, status, headers, config) {
                    });
                }
            });
        }
        else{
            alerta("Agrege un producto","La lista de productos esta vacia","info")
        }
    }
    $
    $scope.guardaEncabezado = function () {
        var proveedor=$('#proveedor').val();
        var fecha=$('#fecha').val();
        if(proveedor == '' || fecha == ''){
            alerta("Datos incorrectos", "Los datos del proveedor son incorrectos","danger");
            return;
        }
        $scope.encabezadoTemp={
            proveedor:proveedor,
            fecha:fecha
        };
        $scope.encabezado.push($scope.encabezadoTemp);
        var res = $http.post($scope.url + 'compras/guardarEncabezado',
            {
                data: $scope.encabezado
            });
        res.success(function (data, status, headers, config) {
            //console.log("encabexado: "+data);
            //alert(data);
            $scope.guardaDetalle(data["id"]);
        });
        res.error(function (data, status, headers, config) {
            alerta("Error", "La compra no pudo ser registrada","danger");
        });
    }

    $scope.guardaDetalle= function (id_compra) {
        $scope.detalle =$scope.productosAdd;
        var res = $http.post($scope.url+'compras/guardarDetalle',
            {
                data : $scope.detalle,
                id_compra:id_compra
            });
        res.success(function(data, status, headers, config) {
            //console.log(data);
            $scope.limpiarCampos();
            alerta("Compra Registrada", "La compra se registro con exito","success");

        });
        res.error(function(data, status, headers, config) {
        });
    }

    $scope.seleccionaProducto=function ($id_prodcuto) {
        var prod = $filter("filter")($scope.productos, {
            id: $id_prodcuto
        })[0];
        $scope.productoTemp={
            id:prod.id,
            producto:prod.nombre,
            cantidad:1,
            margen:prod.margen,
            medida:prod.medida
        };
        $('#producto').val(prod.nombre);
        $('#id_producto').val(prod.id);
        $('#cantidad').val(1);
        $('#margen').val(prod.margen+"%");
        $('#medida').val(prod.medida);
        $("#listaProductos").modal("hide");
    }

    $scope.agregaProducto=function () {
        var prod=$scope.productoTemp;
        if($scope.productoTemp == null){
            alerta("No hay producto", "Seleccione un prodcuto","danger");
            return;
        }
        else{
            var cantidad=$('#cantidad').val();
            var costo=$('#costo').val();
            var margen=prod.margen/100;
            var precio_venta=parseFloat(costo)+parseFloat(costo*margen);
            var fecha_vencimiento=$('#fechaVencimiento').val();
            if(cantidad == '' || costo == ''){
                alerta("Datos incorrectos", "La cantidad o el costo del producto son incorrectos","danger");
                return;
            }
            if(isNaN(cantidad) == true || isNaN(costo) == true){
                alerta("Datos incorrectos", "La cantidad o el costo del producto  son incorrectos","danger");
                return;
            }
            if(parseFloat(cantidad) <= 0 || parseFloat(costo) <= 0){
                alerta("Datos incorrectos", "La cantidad y el costo deben ser mayor a cero","danger");
                return;
            }
            $scope.producto={
                id_producto:prod.id,
                nombre:prod.producto,
                cantidad:parseFloat(cantidad),
                costo:parseFloat(costo),
                precio_venta:parseFloat(precio_venta),
                fecha_vencimiento:fecha_vencimiento,
                total:parseFloat(cantidad)*parseFloat(costo),
                medida:prod.medida
            };
            $scope.productosAdd.push($scope.producto);
            $scope.productoTemp=null;
            $scope.limpiarCamposProducto();
        }
    }


    $scope.eliminaProducto = function($id_producto){
        confirmaCallback("eliminaProducto1("+$id_producto+")","¿Quitar producto?","El producto se elimará de la compra","danger","success");
    }

    eliminaProducto1 = function($id_producto){

        var index = -1;
        var comArr = eval($scope.productosAdd);
        for (var i = 0; i < comArr.length; i++) {
            if (comArr[i].id == $id_producto) {
                index = i;
                break;
            }
        }
        if (index === -1) {
            alert("error");
        }
        $scope.productosAdd.splice(index, 1);
        $scope.cargaProductos();
    }

    $scope.getTotal=function () {
        var total=0;
        angular.forEach($scope.productosAdd,function (value,key) {
            total= total+parseFloat(value.total);
        });
        return total;
    }

    $scope.setCompra = function(producto_id,producto,cantidad,costo,precio_venta,fecha_vencimiento,medida){
        $scope.producto={
            id:producto_id,
            nombre:producto,
            cantidad:parseFloat(cantidad),
            costo:parseFloat(costo),
            precio_venta:parseFloat(precio_venta),
            fecha_vencimiento:fecha_vencimiento,
            total:parseFloat(cantidad)*parseFloat(costo),
            medida:medida
        };

        $scope.productosAdd.push($scope.producto);
        $scope.cargaProductos();
    }

    $scope.addCantidad=function ($id_prodcuto) {
        angular.forEach($scope.productosAdd,function (value,key) {
            if(value["id"]==$id_prodcuto){
                value.cantidad++;
                value.total=value.cantidad*value.costo;
            }
        });
    }
    $scope.resCantidad=function ($id_prodcuto) {
        angular.forEach($scope.productosAdd,function (value,key) {
            if(value["id"]==$id_prodcuto){
                if(value.cantidad>1) {
                    value.cantidad--;
                    value.total=value.cantidad*value.costo;
                }
            }
        });
    }


    $scope.limpiarCamposProducto=function () {
        $("#producto").val("");
        $("#costo").val("");
        $("#cantidad").val("");
        $('#fechaVencimiento').val("");
        $('#margen').val("");
        $('#medida').val("");
    }

    $scope.limpiarCampos=function () {
        var index = $scope.productosAdd.length;
        while(index>=0){
            $scope.productosAdd.splice(index);
            index--;
        }
        var index2 = $scope.encabezado.length;
        while(index2>=0){
            $scope.encabezado.splice(index2);
            index2--;
        }
        $("#producto").val("");
        $("#costo").val("");
        $("#cantidad").val("");
        $('#fechaVencimiento').val("");
        $('#margen').val("");
        $('#medida').val("");
    }

}
]);