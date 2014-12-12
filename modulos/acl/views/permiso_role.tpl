<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-user"></i>
          <h3 class="box-title">Role: {$role.role}</h3>
      </div>
      <form name="form1" method="post" action="">
        <input type="hidden" name="guardar" value="1" />
        {if isset($permisos) && count($permisos)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Permiso</th>
                <th>Habilitado</th>
                <th>Denegado</th>
                <th>Ignorar</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=pr from=$permisos}
                <tr>
                  <td>{$pr.nombre}</td>
                  <td>
                    <input type="radio" name="perm_{$pr.id}" value="1" {if ($pr.valor == 1)}checked="checked"{/if}/>
                  </td>
                  <td>
                    <input type="radio" name="perm_{$pr.id}" value="" {if ($pr.valor == "")}checked="checked"{/if}/>
                  </td>
                  <td>
                    <input type="radio" name="perm_{$pr.id}" value="x" {if ($pr.valor === "x")}checked="checked"{/if}/>
                  </td>
                </tr>
              {/foreach}
            </tbody>
          </table>
        {/if}
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" style="width:100%">Modificar</button>
        </div>
      </form>
    </div>
  </section>
</div>