
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Siste de ventas | Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php asset("sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css"); ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php asset("sb-admin/bower_components/metisMenu/dist/metisMenu.min.css"); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php asset("sb-admin/dist/css/sb-admin-2.css"); ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php asset("sb-admin/bower_components/font-awesome/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css">


    <script src="<?php asset('sb-admin/js/html5shiv.js'); ?>"></script>
    <script src="<?php asset('sb-admin/js/respond.js'); ?>"></script>


</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center" style=""><strong>INGRESAR AL SISTEMA</strong></h3>
                </div>
                <div class="panel-body">
                    <form role="form" action="<?php url("login/ingresar"); ?>" method="post">
                        <input type="hidden" value="<?php csrf_token(); ?>" name="_token">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Usuario" name="usuario" type="text" autofocus required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Contraseña" name="clave" type="password" value="" required>
                            </div>
                            <!--<div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Recordarme
                                </label>
                            </div>-->
                            <!-- Change this to a button or input when using this as a form -->
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
                        </fieldset>
                    </form>
                    <br>

                    <?php if(Session::has("estado") && Session::has("mensaje")){ ?>

                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Error! </strong> <?php echo Session::get("mensaje");?>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
