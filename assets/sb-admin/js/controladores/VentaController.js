
var ventaApp = angular.module("ventaApp",[]);
ventaApp.controller('ventaController',['$scope','$http','$filter',function ($scope,$http,$filter) {

    $scope.productos=[];
    $scope.url=$("#urlPrincipal").val();
    $scope.productosAdd=[];
    $scope.producto={};
    $scope.detalle={};
    $scope.encabezado={};

    /*funcion para calcular el cambio en tiempo real*/


    $( "#efectivo" ).keyup(function(event){
        var total=$scope.getTotalPagar();
        var efectivo=$("#efectivo").val();
        if(efectivo=="" || total==""){
            $("#cambio").val("")
            return
        }
        var cambio=efectivo-total;
        cambio=parseFloat(cambio).toFixed(2);
        $("#cambio").val(cambio);
    });

    $scope.cargaProductos= function () {
        $http.get($scope.url+"productos/todos").then(function ($request){
            $scope.productos=$request.data;
        });
        var table = document.getElementById("tablaproductos");
        var rowCount = table.rows.length;
    }

    $scope.nueva=function () {
        if($scope.productosAdd.length>0) {
            $.confirm({
                title: "¿Cancelar venta?",
                content: "Los productos ingresados se eliminarán",
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-success',
                confirmButton: 'Sí',
                cancelButton: 'No',
                confirm: function(){
                    $scope.limpiarCampos();
                    $scope.cargaProductos();
                }
            });
        }
    }
    $scope.guardarVenta = function(){
        if($("#tipopago").val()==1) {
            if ($("#efectivo").val() < $scope.getTotalPagar()) {
                alerta("Valor incorrecto", "El efectivo no puede ser menor que el total a pagar", "danger");
                return;
            }
        }
        if($scope.productosAdd.length>0) {
            $.confirm({
                title: "¿Registrar venta?",
                content: "La venta se guardara en el sistema",
                confirmButtonClass: 'btn-success',
                cancelButtonClass: 'btn-danger',
                confirmButton: 'Registrar',
                cancelButton: 'Cancelar',
                confirm: function(){
                    //window.open('tiket');
                    $scope.guardaEncabezado();
                }
            });
        }
        else{
            alerta("Agrege un producto","La lista de productos esta vacia","danger")
        }
    }
    $scope.guardaEncabezado = function () {
            var res = $http.post($scope.url + 'ventas/agregar',
                {
                    data: $scope.encabezado
                });
            res.success(function (data, status, headers, config) {
                $scope.guardaDetalle(data["id"]);
                alerta("Venta registra", "La venta se guardo correctamente","success");
            });
            res.error(function (data, status, headers, config) {
                alerta("Error", "La venta no pude ser registrada","danger");
            });
    }

    $scope.guardaDetalle= function (id_venta) {
        $scope.detalle =$scope.productosAdd;
        var res = $http.post($scope.url+'ventadetalle/agregar',
            {
                data : $scope.detalle,
                id_venta:id_venta
            });
        res.success(function(data, status, headers, config) {
            if($("#bandera_factura").is(':checked')){
                imprimieTiket(id_venta);
            }
            $scope.limpiarCampos();

        });
        res.error(function(data, status, headers, config) {
        });
    }

    $scope.seleccionaProducto=function ($id_prodcuto) {
        var prod = $filter("filter")($scope.productos, {
            id: $id_prodcuto
        })[0];
        var agregar = true;
        if ($scope.productosAdd.length == 0) {
            $scope.agregarProducto(prod);
            agregar = false;
        } else {
            angular.forEach($scope.productosAdd, function (value, key) {
                if (value["id"] == $id_prodcuto) {
                    value.cantidad++;
                    value.subtotal = value.cantidad * value.precio;
                    value.impuestoL= $scope.calculaImpto(prod)*value.cantidad;
                    value.descuento= value.descuento2*value.cantidad;
                    agregar = false;
                }
            });
        }
        if (agregar) {
            $scope.agregarProducto(prod);
        }
        //$("#listaProductos").modal("hide");
    }
    $scope.agregarProducto=function (prod) {
        cantidad=1;
        cantidad=prompt("Ingrese la cantidad","1");
        //alert(cantidad);
        if (cantidad == null) {
            //alerta('Cantidad incorrecta','La cantidad ingresada es incorrecta','danger')
            return;
        }
        else if (cantidad == 0) {
            alerta('Cantidad incorrecta','La cantidad ingresada es incorrecta','danger')
            return;
        }
        if(isNaN(parseInt(cantidad))){
            alerta('Cantidad incorrecta','Solo puede ingresar valores numericos','danger')
            return;
        }
        if(cantidad < 1){
            alerta('Cantidad incorrecta','La cantidad debe ser mayor que cero','danger')
            return;
        }

        var isv=$scope.calculaImpto(prod);
        $scope.producto={
            id:prod.id,
            nombre:prod.nombre,
            cantidad:cantidad,
            precio:prod.precio,
            precioDes:prod.precio-(prod.precio*(prod.descuento*0.01)),
            descuento:prod.precio*(prod.descuento*0.01),
            descuento2:prod.precio*(prod.descuento*0.01),
            subtotal:prod.precio*cantidad,
            impuestoL:isv*1,
            impuestoL2:isv*1,
            impuesto:prod.impuesto,
            medida:prod.medida
        };
        $scope.productosAdd.push($scope.producto);
    }
    $scope.calculaImpto=function (prod) {
        var impto=prod.impuesto;
        var imptoPrc=impto*0.01;
        var precio=prod.precio;
        var descuento=prod.descuento;
        var descuentoPrc=descuento*0.01
        var precioDes=precio-(precio*descuentoPrc)
        var isv=precioDes-(precioDes/(1+imptoPrc));
        return isv;
    }


    $scope.eliminaProducto = function($id_producto){
        confirmaCallback("eliminaProducto1("+$id_producto+")","¿Quitar producto?","El producto se elimará de la venta","danger","success");
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
            total= total+parseFloat(value.subtotal);
        });
        return total;
    }
    $scope.getIsv=function (){
        var isv=0;
        angular.forEach($scope.productosAdd,function (value,key) {
            isv= isv+parseFloat(value.impuestoL);
        });
        return isv;
    }
    $scope.getSubtotal=function () {
        var subtotal=$scope.getTotal()-$scope.getIsv();
        return subtotal;
    }
    $scope.getDescuento=function () {
        var descuento=0;
            angular.forEach($scope.productosAdd,function (value,key) {
                descuento=descuento+parseFloat(value.descuento);
            });
        return descuento;
    }
    $scope.getTotalPagar=function () {
        var totalpagar=$scope.getTotal()-$scope.getDescuento();
        return totalpagar;
    }
    $scope.addCantidad=function ($id_prodcuto) {
        angular.forEach($scope.productosAdd,function (value,key) {
            if(value["id"]==$id_prodcuto){
                value.cantidad++;
                value.subtotal= value.cantidad * value.precio;
                value.impuestoL= value.impuestoL2*value.cantidad;
                value.descuento= value.descuento2*value.cantidad;
            }
        });
    }
    $scope.resCantidad=function ($id_prodcuto) {
        angular.forEach($scope.productosAdd,function (value,key) {
            if(value["id"]==$id_prodcuto){
                if(value.cantidad>1) {
                    value.cantidad--;
                    value.subtotal= value.cantidad * value.precio;
                    value.impuestoL= value.impuestoL2*value.cantidad;
                    value.descuento= value.descuento2*value.cantidad;
                }
            }
        });
    }

    $scope.limpiarCampos=function () {
        var index = $scope.productosAdd.length;
        while(index>=0){
            $scope.productosAdd.splice(index);
            index--;
        }
        $("#efectivo").val("");
        $("#cambio").val("");
        $('#bandera_factura').prop('checked', false);
    }

    $( "#efectivo" ).keypress(function( event ){//cuando le de enter
        if ( event.which == 13) {
            $scope.guardarVenta();

        }
    });

    function imprimieTiket(id_venta){
        document.getElementById('idventa_fact').value=id_venta;
        document.getElementById('total_fact').value=$scope.getTotal();
        document.getElementById('subtotal_fact').value=$scope.getSubtotal();
        document.getElementById('impto_fact').value=$scope.getIsv();
        document.getElementById('descuento_fact').value=$scope.getDescuento();
        document.getElementById('pagar_fact').value=$scope.getTotalPagar();
        document.getElementById('efectivo_fact').value=$("#efectivo").val();
        document.getElementById('cambio_fact').value=$("#cambio").val();
        document.getElementById('cliente_fact').value=$("#cliente").val();
        document.getElementById('tipopago_fact').value=$("#tipopago").val();
        $( "#form_print" ).submit();
    }
}
]);