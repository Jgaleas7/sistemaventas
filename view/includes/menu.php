<?php
if(isset($_SESSION['usuario'])){

}else{
    redirecciona()->to("login");
}
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php url("admin"); ?>" style="color:#337ab7"><strong>FARMACIA SANTA ROSA</strong></a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">

        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['id_usuario'];?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>-->
                <li><a href="<?php url("clave"); ?>"><i class="fa fa-gear fa-fw"></i> Cuenta</a>
                </li>
                <li class="divider"></li>
                <li><a href=" <?php url("session/salir"); ?>"><i class="fa fa-power-off fa-fw"></i> Salir</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-sort-numeric"></i>Caja #<?= $_SESSION['caja']?></a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?php url("admin"); ?>"><i class="fa fa-home fa-fw"></i> Inicio</a>
                </li>
                <?php if($_SESSION['privilegio'] == 'admin'){ ?>
                <li>
                    <a href="#"><i class="fa fa-cogs fa-fw"></i> Administración<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">

                        <li>
                            <a href="<?php url("configuraciones"); ?>"><i class="fa fa-cog fa-fw"></i> Ajustes</a>
                        </li>
                        <li>
                            <a href="<?php url("categorias"); ?>"><i class="fa fa-bars fa-fw"></i> Categorias</a>
                        </li>
                        <li>
                            <a href="<?php url("medicion"); ?>"><i class="fa fa-eye fa-fw"></i> Presentaciones</a>
                        </li>
                        <li>
                            <a href="<?php url("usuarios"); ?>"><i class="fa fa-users fa-fw"></i> Usuarios</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <?php } ?>
                <li>
                    <a href="#"><i class="fa fa-key fa-fw"></i> Apertura<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("apertura"); ?>"><i class="fa fa-arrow-circle-right fa-fw"></i> Hacer Apertura</a>
                        </li>
                        <li>
                            <a href="<?php url("apertura/historial"); ?>"><i class="fa fa-file-text fa-fw"></i> Historial de Aperturas</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-suitcase fa-fw"></i> Cierre<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("reportes/confirmarcierre"); ?>"><i class="fa fa-arrow-circle-right fa-fw"></i> Hacer Cierre</a>
                        </li>
                    </ul>
                </li>
                <?php if($_SESSION['privilegio'] == 'admin'){ ?>
                <li>
                    <a href="#"><i class="fa fa-shopping-cart fa-fw"></i> Compras<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("compras/nueva"); ?>"><i class="fa fa-plus"></i> Nueva Compra</a>
                        </li>
                        <li>
                            <a href="<?php url("compras"); ?>"><i class="fa fa-folder"></i> Ver Compras</a>
                        </li>
                    </ul>
                </li>
                <?php }?>
                <li>
                    <a href="#"><i class="fa fa-money fa-fw"></i> Facturación<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("ventas/nuevo"); ?>"><i class="fa fa-pencil-square-o fa-fw"></i> Facturar</a>
                        </li>
                        <li>
                            <a href="<?php url("ventas"); ?>"><i class="fa fa-folder fa-fw"></i> Ver Facturas</a>
                        </li>
                    </ul>
                </li>
                <?php if($_SESSION['privilegio'] == 'admin'){ ?>
                <li>
                    <a href="<?php url("productos"); ?>"><i class="fa fa-table fa-fw"></i> Productos</a>
                </li>
                <?php }?>
                <?php if($_SESSION['privilegio'] == 'admin'){ ?>
                <li>
                    <a href="<?php url("proveedores"); ?>"><i class="fa fa-users fa-fw"></i> Proveedores</a>
                </li>
                <?php }?>
                <?php if($_SESSION['privilegio'] == 'admin'){ ?>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart fa-fw"></i> Reportes<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a target="_blank" href="<?php url("reportes/minimos"); ?>"><i class="fa fa-file-text fa-fw"></i> Bajos en existenia</a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php url("reportes/inventario"); ?>"><i class="fa fa-file-text fa-fw"></i> Inventario</a>
                            </li>
                            <li>
                                <a href="<?php url("reportes/diario"); ?>"><i class="fa fa-file-text fa-fw"></i> Ventas por día</a>
                            </li>
                            <li>
                                <a href="<?php url("reportes/vistaProximos"); ?>"><i class="fa fa-file-text fa-fw"></i> Proximos a vencer</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>