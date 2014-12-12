<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-users"></i>
          <h3 class="box-title">Listado de Usuarios</h3>
          <p></p>
          <a href="{$_layoutParams.root}usuarios/crear_usuario">
            <button class="btn btn-primary btn-sm">Nuevo Usuario</button>
          </a>
      </div>
      {if isset($usuarios) && count($usuarios)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nombre</th>
                <th>Role</th>
                <th>Permisos</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=us from=$usuarios}
                <tr id="tr_{$us.id}">
                <td>{$us.id}</td>
                <td>{$us.username}</td>
                <td>{$us.name}</td>
                <td>
                  {if $us.id_role==1}
                    <span class="label label-danger">SuperAdministrador</span>
                  {else}
                    <a href="{$_layoutParams.root}usuarios/editar_role/{$us.id}">
                    {if $us.id_role==0}
                        <span class="label label-default">Sin role</span>
                    {else}
                      {foreach from=$roles item=role}
                        {if $us.id_role==$role.id}
                          <span class="label label-success">{$role.role}</span>
                        {/if}
                      {/foreach}
                    {/if}
                    </a>
                  {/if}
                </td>
                <td>
                  {if $us.id_role==1}
                    Ver
                  {else}
                    <a href="{$_layoutParams.root}usuarios/permisos/{$us.id}">Ver</a>
                  {/if}
                </td>
                <td>
                  {if $us.id_role==1}
                    Activo
                  {else}
                    <a href="{$_layoutParams.root}usuarios/estado/{$us.id}/{$us.state}">{if $us.state==1}Activo{else}Desactivo{/if}</a>
                  {/if}
                </td>
              </tr>
              {/foreach}
            </tbody>
        </table>
      {/if}
    </div>
  </section>
</div>
