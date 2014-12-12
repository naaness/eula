<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-list"></i>
          <h3 class="box-title">
            Grupos a mi cargo
          </h3>
      </div>
    <div class="box-body">
        <div class="form-group">
            {if is_array($misgrupos)}
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Nombre del Grupo</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$misgrupos item=grupo}
                    <tr>
                      <td>{$grupo.name}</td>
                      <td>
                          <a href="{$_layoutParams.root}grupos/editar_grupo_usuarios/{$grupo.id}"><button class="btn btn-primary btn-sm">Asignar usuarios</button></a>
                      </td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
            {/if}
        </div>
    </div>
  </section>
</div>