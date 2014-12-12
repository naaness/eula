<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-users"></i>
          <h3 class="box-title">
            Nuevo grupo
          </h3>
      </div>
      <form name="form1" method="post" action="">
        <input type="hidden" name="guardar" value="1" />
        <div class="box-body">
            <div class="form-group">
                <label for="name">Nombre :</label>
                <input type="text" class="form-control" name="name" id="permiso"placeholder="Nombre del grupo" value="">
            </div>
            <div class="form-group">
                {if is_array($usuarios)}
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Usuarios</th>
                        <th>Asignar</th>
                        <th>No asignar</th>
                      </tr>
                    </thead>
                    <tbody>
                      {foreach from=$usuarios item=usuario}
                        <tr>
                            <td>{$usuario.name}</td>
                            <td>
                                <input type="radio" name="perm_{$usuario.id}" value="1" {if isset($values)}{if $values[$usuario.id]==1}checked="checked"{/if}{/if}/>
                            </td>
                            <td>
                                <input type="radio" name="perm_{$usuario.id}" value="x" {if isset($values)}{if $values[$usuario.id]=="x"}checked="checked"{/if}{else}checked="checked"{/if}/>
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