<div class="row">
    <section class="col-lg-12 connectedSortable ui-sortable">
      <div class="box box-info" style="position: relative;">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="fa fa-user"></i>
            <h3 class="box-title">Ingrese el nuevo nombre del role : {$datos.role|default:""}</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post">
            <input type="hidden" name="editar" value="1" />
            <div class="box-body">
              <div class="form-group">
                <label for="role">Role :</label>
                <input type="text" class="form-control" name="role" id="permiso"placeholder="Nombre del role" value="">
              </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" style="width:100%">Crear</button>
              </div>
          </form>
        </div>
      </div>
    </section>
</div>