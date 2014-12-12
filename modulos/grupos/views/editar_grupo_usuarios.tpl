<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-users"></i>
          <h3 class="box-title">
            Asignar usuarios al grupo
          </h3>
      </div>
      <form name="form1" method="post" action="">
        <input type="hidden" name="editar" value="1" />
        <div class="box-body">
            <div class="form-group">
                {if is_array($usuarios)}
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Usuarios</th>
                        <th>Asignar al grupo</th>
                        <th>Quitar del grupo</th>
                      </tr>
                    </thead>
                    <tbody>
                      {foreach from=$usuarios item=usuario}
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
                  </table>
                {/if}
            </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" style="width:100%">Guardar</button>
        </div>
      </form>
    </div>
  </section>
</div>