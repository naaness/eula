<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{$titulo|default:"Sin título"}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{$template_dir}www/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="{$template_dir}css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="{$template_dir}css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="{$template_dir}css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="{$template_dir}css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="{$template_dir}css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{$template_dir}css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        {if isset($_layoutParams.css) && count($_layoutParams.css)}
            {foreach item=css from=$_layoutParams.css}
                <link rel="stylesheet" href="{$css}"/>
            {/foreach}
        {/if}
    </head>
    <body class="skin-black fixed">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="{$_layoutParams.root}" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                EULA
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        {if count($emails_sis)>0}
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope"></i>
                                    <span class="label label-success">{count($emails_sis)}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes {count($emails_sis)} mensajes</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            {foreach item=ers from=$emails_sis}
                                                <li>
                                                    <a href="">
                                                        <i class="{$ers.class}"></i>{$ers.message}
                                                    </a>
                                                    <a href="{$ers.url}">
                                                        <div class="pull-left">
                                                            <img src="{$template_dir}{$ers.dir_img}" class="img-circle" alt="User Image"/>
                                                        </div>
                                                        <h4>
                                                            {$ers.title}
                                                            <small><i class="fa fa-clock-o"></i> {$ers.time}</small>
                                                        </h4>
                                                        <p>{$ers.message}</p>
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                        {/if}
                        <!-- Notifications: style can be found in dropdown.less -->
                        {if count($alerts_sis)>0}
                            <li class="dropdown notifications-menu open">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-warning"></i>
                                    <span class="label label-warning">{count($alerts_sis)}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes {count($alerts_sis)} notificaciones</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            {foreach item=ers from=$alerts_sis}
                                                <li>
                                                    <a href="{$ers.url}">
                                                        <i class="{$ers.class}"></i>{$ers.message}
                                                    </a>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                        {/if}
                        {if count($tasks_sis)>0}
                            <!-- Tasks: style can be found in dropdown.less -->
                            <li class="dropdown tasks-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-tasks"></i>
                                    <span class="label label-danger">{count($tasks_sis)}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">Tienes {count($tasks_sis)} tareas</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            {foreach item=ers from=$tasks_sis}
                                                <li><!-- Task item -->
                                                    <a href="{$ers.url}">
                                                        <h3>
                                                            {$ers.title}
                                                            <small class="pull-right">{$ers.percent}%</small>
                                                        </h3>
                                                        <div class="progress xs">
                                                            <div class="progress-bar progress-bar-{$ers.color}" style="width: {$ers.percent}%" role="progressbar" aria-valuenow="{$ers.percent}" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">{$ers.percent}% Completa</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li><!-- end task item -->
                                            {/foreach}
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                        <!-- User Account: style can be found in dropdown.less -->
                        {if $_acl->getId()!=0}
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i>
                                    <span>{$_acl->getUsername()} <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header bg-light-blue">
                                        <img src="{$template_dir}img/avatar3.png" class="img-circle" alt="User Image" />
                                        <p>
                                            {$_acl->getUsername()} - Web Developer
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Followers</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Sales</a>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <a href="#">Friends</a>
                                        </div>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{$_layoutParams.root}login/cerrar" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        {else}
                            <li class="dropdown user user-menu" id="go-to-login">
                                <a href="{$_layoutParams.root}login" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-log-in"></i>
                                    <span>Login</span>
                                </a>
                            </li>
                        {/if}
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    {if $_acl->getId()!=0}
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img src="{$template_dir}img/avatar3.png" class="img-circle" alt="User Image" />
                            </div>
                            <div class="pull-left info">
                                <p>Hola, {$_acl->getUsername()}</p>

                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                        <!-- search form -->
                        <form action="#" method="get" class="sidebar-form">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                                <span class="input-group-btn">
                                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                    {/if}
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="{$_layoutParams.root}">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        {if $_acl->acceso_bloque("acl")}
                            <li class="treeview">
                                <a href="{$_layoutParams.root}acl">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <span>ACL</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="{$_layoutParams.root}acl/permisos"><i class="fa fa-angle-double-right"></i>Permisos</a>
                                    </li>
                                    <li><a href="{$_layoutParams.root}acl/roles"><i class="fa fa-angle-double-right"></i>Roles</a></li>
                                    <li><a href="{$_layoutParams.root}usuarios"><i class="fa fa-angle-double-right"></i>Usuarios</a></li>
                                </ul>
                            </li>
                        {/if}
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>Admin Grupos</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{$_layoutParams.root}grupos/crear_editar"><i class="fa fa-angle-double-right"></i> Crear Editar</a></li>
                                <li><a href="{$_layoutParams.root}grupos/administracion"><i class="fa fa-angle-double-right"></i> Administracion</a></li>
                            </ul>
                        </li>
                        <li >
                            <a href="{$_layoutParams.root}cursos">
                                <i class="fa fa-edit"></i> <span>Admin Cursos</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Simple tables</a></li>
                                <li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="pages/calendar.html">
                                <i class="fa fa-calendar"></i> <span>Calendar</span>
                                <small class="badge pull-right bg-red">3</small>
                            </a>
                        </li>
                        <li>
                            <a href="pages/mailbox.html">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <small class="badge pull-right bg-yellow">12</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                                <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                                <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                                <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                                <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                                <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$titulo|default:"Sin título"}
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{$_layoutParams.root}"><i class="fa fa-dashboard"></i> Home</a></li>
                        {if is_array($ruta_suave)}
                            {foreach item=rs from=$ruta_suave}
                                {if $rs.url!=""}
                                    <li><a href="{$_layoutParams.root}{$rs.url}"><i class="fa {$rs.ico}"></i>{$rs.name}</a></li>
                                {else}
                                    <li class="active">{$rs.name}</li>
                                {/if}
                            {/foreach}
                        {/if}
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    {include file=$_contenido}
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <script src="{$template_dir}www/js/jquery.min.js"></script>
        <script src="{$template_dir}www/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="{$template_dir}www/js/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="{$template_dir}www/js/raphael-min.js"></script>
        <script src="{$template_dir}js/plugins/morris/morris.min.js" type="text/javascript"></script>

        <script src="{$template_dir}js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="{$template_dir}js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="{$template_dir}js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="{$template_dir}js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="{$template_dir}js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="{$template_dir}js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{$template_dir}js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="{$template_dir}js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        

        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}" type="text/javascript"></script>
            {/foreach}
        {/if}

        <!-- AdminLTE App -->
        <script src="{$template_dir}js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="{$template_dir}js/AdminLTE/dashboard.js" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
    </body>
</html>
