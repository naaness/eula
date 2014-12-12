<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Usuarios: </h3>
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
              {if is_array($usuarios)}
                <tbody>
                  {foreach item=usuario from=$usuarios}
                    <tr>
                      <td>{$usuario.name}</td>
                      <td>
                        <input type="radio" name="perm_{$usuario.id}" value="1" {if isset($values)}{if $values[$usuario.id]==1}checked="checked"{/if}{elseif $usuario.valor=="1"}checked="checked"{/if}/>
                      </td>
                      <td>
                        <input type="radio" name="perm_{$usuario.id}" value="x" {if isset($values)}{if $values[$usuario.id]=="x"}checked="checked"{/if}{elseif $usuario.valor=="x"}checked="checked"{/if}/>
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