<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Grupos: </h3>
          <h3 class="box-title">{$datoscurso[0]['name']}</h3>
      </div>
      <form name="form1" method="post" action="">
        <input type="hidden" name="guardar" value="1" />
        <div class="box-body">
          <div class="form-group">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Matricular</th>
                  <th>No matricular</th>
                  <th></th>
                </tr>
              </thead>
              {if is_array($grupos)}
                <tbody>
                  {foreach item=grupo from=$grupos}
                    <tr>
                      <td>{$grupo.name}</td>
                      <td>
                        <input type="radio" name="perm_{$grupo.id}" value="1" {if isset($values)}{if $values[$grupo.id]==1}checked="checked"{/if}{elseif $grupo.valor=="1"}checked="checked"{/if}/>
                      </td>
                      <td>
                        <input type="radio" name="perm_{$grupo.id}" value="x" {if isset($values)}{if $values[$grupo.id]=="x"}checked="checked"{/if}{elseif $grupo.valor=="x"}checked="checked"{/if}/>
                      </td>
                    </tr>
                  {/foreach}
                </tbody>
              {/if}
            </table>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" style="width:100%">Guardar</button>
        </div>
      </form>
    </div>
  </section>
</div>