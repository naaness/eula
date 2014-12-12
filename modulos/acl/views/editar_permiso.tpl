<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Editar nobre y/o permiso</h3>
            </div>
            <form name="form1" action="" method="post">
                <input type="hidden" name="editar" value="1" />
                <div class="box-body">
                    <div class="form-group">
                        <label for="permiso">Nombre :</label>
                        <input type="text" class="form-control" name="permiso" id="permiso" placeholder="Nombre del permiso" value="{$datos.name}">
                    </div>
                    <div class="form-group">
                        <label for="key">Llave :</label>
                        <input type="text" class="form-control" name="key" id="key" placeholder="Nombre de la clave en la vista" value="{$datos.permission}">
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" style="width:100%">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
