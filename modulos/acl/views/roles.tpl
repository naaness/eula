<div class="row">
  <section class="col-lg-7 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Roles</h3>
      </div>
      {if isset($roles) && count($roles)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Role</th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$roles}
                <tr>
                  <td>{$rl.id}</td>
                  <td>{$rl.role}</td>
                  <td>
                  	{if $_acl->acceso_bloque("acl_roles_permisos")}
  						<a href="{$_layoutParams.root}acl/permiso_role/{$rl.id}"><button class="btn btn-primary btn-sm">Permisos</button></a>
  					{else}
  						Permisos
  					{/if}
                  </td>
                  <td>
                    {if $_acl->acceso_bloque("acl_roles_editar")}
                      <a href="{$_layoutParams.root}acl/editar_role/{$rl.id}"><button class="btn btn-primary btn-sm">Editar</button></a>
                    {else}
                      Editar
                    {/if}
                  </td>
                  <td>
                    {if $_acl->acceso_bloque("acl_roles_editar")}
                      <a href="{$_layoutParams.root}acl/eliminar_role/{$rl.id}"><div id="eliminar_{$rl.id}"><button class="btn btn-danger btn-sm">Eliminar</button></div></a>
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
  {if $_acl->acceso_bloque("acl_roles_nuevo")}
    <section class="col-lg-5 connectedSortable ui-sortable">
      <div class="box box-info" style="position: relative;">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="fa fa-user"></i>
            <h3 class="box-title">Nuevo Role</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post">
            <input type="hidden" name="guardar" value="1" />
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
  {/if}
</div>