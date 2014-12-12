<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Grupos</h3>
          <p></p>
          <a href="{$_layoutParams.root}grupos/crear_grupo">
            <button class="btn btn-primary btn-sm">Crear Grupo</button>
          </a>
      </div>
      {if is_array($grupos)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$grupos}
                <tr>
                  <td>{$rl.id}</td>
                  <td>{$rl.name}</td>
                  <td>
                    {if $_acl->acceso_bloque("group_editar")}
                      <a href="{$_layoutParams.root}grupos/editar_grupo/{$rl.id}"><button class="btn btn-primary btn-sm">Editar</button></a>
                    {else}
                      Editar
                    {/if}
                  </td>
                  <td>
                    {if $_acl->acceso_bloque("group_eliminar")}
                      <a href="{$_layoutParams.root}grupos/eliminar/{$rl.id}"><div id="eliminar_{$rl.id}"><button class="btn btn-danger btn-sm">Eliminar</button></div></a>
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
</div>