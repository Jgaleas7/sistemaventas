<script src="<?php asset("sb-admin/bower_components/jquery/dist/jquery.min.js"); ?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php asset("sb-admin/bower_components/bootstrap/dist/js/bootstrap.min.js"); ?>"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?php asset("sb-admin/bower_components/metisMenu/dist/metisMenu.min.js"); ?>"></script>
<!-- Morris Charts JavaScript -->
<script src="<?php asset("sb-admin/bower_components/raphael/raphael-min.js"); ?>"></script>
<script src="<?php asset("sb-admin/bower_components/morrisjs/morris.min.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/morris-data.jss"); ?>"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php asset("sb-admin/dist/js/sb-admin-2.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/jquery-confirm.min.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/angular.min.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/controladores/VentaController.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/controladores/CompraController.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/dataTables.min.js"); ?>"></script>
<script src="<?php asset("sb-admin/js/dataTables.bootstrap.min.js"); ?>"></script>
<script>
    function confirmar(url){
        $.confirm({
            title: '¿Desea eliminar este registro?',
            content: 'Se eliminará completamente del sistema',
            confirmButtonClass: 'btn-danger',
            cancelButtonClass: 'btn-success',
            confirmButton: 'Confirmar',
            cancelButton: 'Cancelar',
            confirm: function(){
                window.location.href=url;
            }
        });
    }
    function confirmaCallback(callback,titulo,mensaje,btnconfirm,btncancel){
        $.confirm({
            title: titulo,
            content: mensaje,
            confirmButtonClass: 'btn-'+btnconfirm,
            cancelButtonClass: 'btn-'+btncancel,
            confirmButton: 'Confirmar',
            cancelButton: 'Cancelar',
            confirm: function(){
                setTimeout(callback,0);
            }
        });
    }
    function alerta(titulo,mensaje,tipo){
        $.confirm({
            title: titulo,
            content: mensaje,
            confirmButtonClass: 'btn-'+tipo,
            cancelButtonClass: '',
            confirmButton: 'Aceptar',
            cancelButton: ''
        });
    }
</script>
