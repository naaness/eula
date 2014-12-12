<div class="row">
	<div class="col-md-6">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-key"></i>
                <h3 class="box-title">Permisos</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	Este modulo podra agregar, editar y eliminar los permisos del sistema. De esta forma permitira restringir el accesos a ciertas vistas o acciones a los usuarios que no posean estos permisos.
            	<p></p>
                <div class="callout callout-danger">
                    <h4>Usuarios autenticados</h4>
                    <p>Cualquier vista o bloque que halla sido protegido con estos permisos, los usuarios no autenticados no podran acceder.</p>
                </div>
                <div class="callout callout-info">
                    <h4>Vistas sin permisos</h4>
                    <p>Si una vista o bloque de codigo tiene identificado su permisos de acceso pero este no ha sido creado en este modulo, los usuarios autenticados podran tener acceso</p>
                </div>
                <a href="{$_layoutParams.root}acl/permisos">
                	<button class="btn btn-default btn-block">Ingresar</button>
                </a>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
	<div class="col-md-6">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-user"></i>
                <h3 class="box-title">Roles</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
            	En este modulo podra agrega, editar, eliminar y dar permisos a los roles que tendra el sistema. Cada usuario tendra que tener un role asignado, de lo contrario solo podra acceder a las vistas publicas del sistema.
            	<p></p>
                <div class="callout callout-danger">
                    <h4>Integridad del sistema</h4>
                    <p>Los deben tener un role para que defina su participacion dentro del sistema, por tanto hay que tener especial cuidado la asignacion y las responsabilidades que tendran cada quien.</p>
                </div>
                <div class="callout callout-info">
                    <h4>Un unico role</h4>
                    <p>Los usuarios tendran un unico role, y heredaran los permisos de dicho role. Los permisos podran luego ser modificados para personalizar aun mas el sistema segun el usuario.</p>
                </div>
                <a href="{$_layoutParams.root}acl/roles">
                	<button class="btn btn-default btn-block">Ingresar</button>
                </a>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-users"></i>
                <h3 class="box-title">Usuarios</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                En este modulo podra crear, editar, eliminar usuarios del sistema, asi como tambien personalizar que rol tendra y sus respectivos permisos. 
                <p></p>
                <a href="{$_layoutParams.root}usuarios">
                    <button class="btn btn-default btn-block">Ingresar</button>
                </a>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>

