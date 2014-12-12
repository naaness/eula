<div class="row">
  <section class="col-lg-7">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Permisos</h3>
      </div>
      {if isset($permisos) && count($permisos)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Llave</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$permisos}
                <tr>
                  <td>{$rl.id}</td>
                  <td>{$rl.name}</td>
                  <td>{$rl.permission}</td>
                  <td>
                    {if $_acl->acceso_bloque("acl_permisos_editar")}
                      <a href="{$_layoutParams.root}acl/editar_permiso/{$rl.id}"><button class="btn btn-primary btn-sm">Editar</button></a>
                    {else}
                      Editar
                    {/if}
                  </td>
                  <td>
                    {if $_acl->acceso_bloque("acl_permisos_editar")}
                      <a href="{$_layoutParams.root}acl/eliminar_permiso/{$rl.id}"><div id="eliminar_{$rl.id}"><button class="btn btn-danger btn-sm">Eliminar</button></div></a>
                    {else}
                      Eliminar
                    {/if}
                  </td>
                </tr>
              {/foreach}
            </tbody>
        </table>
      {/if}
    </div>
  </section>
  {if $_acl->acceso_bloque("acl_permisos_nuevo")}
    <section class="col-lg-5 connectedSortable ui-sortable">
      <div class="box box-info" style="position: relative;">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="fa fa-key"></i>
            <h3 class="box-title">Nuevo Permiso</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post">
            <input type="hidden" name="guardar" value="1" />
            <div class="box-body">
              <div class="form-group">
                <label for="permiso">Nombre :</label>
                <input type="text" class="form-control" name="permiso" id="permiso"placeholder="Nombre del permiso" value="{$datos.permiso|default:''}">
              </div>
              <div class="form-group">
                <label for="key">Llave :</label>
                <input type="text" class="form-control" name="key" id="key" placeholder="Nombre de la clave en la vista" value="{$datos.key|default:''}">
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" style="width:100%">Crear</button>
              </div>
          </form>
        </div>
      </div>
    </section>
  {/if}
</div>