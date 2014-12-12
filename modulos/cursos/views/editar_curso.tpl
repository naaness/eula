<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-users"></i>
          <h3 class="box-title">
            Editar Curso
          </h3>
      </div>
      <form name="form1" method="post" action="">
        <input type="hidden" name="editar" value="1" />
        <div class="box-body">
            <div class="form-group">
                <label for="name">Nombre :</label>
                <input type="text" class="form-control" name="name" placeholder="Nombre del curso" value="{$datoscurso[0]['name']}">
            </div>
            <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" rows="3" name="description" placeholder="Descripcion del curso">{$datoscurso[0]['description']}</textarea>
            </div>
            <div class="form-group">
                {if is_array($profesores)}
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Profesores</th>
                        <th>Asignar</th>
                        <th>No asignar</th>
                      </tr>
                    </thead>
                    <tbody>
                      {foreach from=$profesores item=profesor}
                        <tr>
                            <td>{$profesor.name}</td>
                            <td>
                                <input type="radio" name="perm_{$profesor.id}" value="1" {if isset($values)}{if $values[$profesor.id]==1}checked="checked"{/if}{elseif $profesor.valor=="1"}checked="checked"{/if}/>
                            </td>
                            <td>
                                <input type="radio" name="perm_{$profesor.id}" value="x" {if isset($values)}{if $values[$profesor.id]=="x"}checked="checked"{/if}{elseif $profesor.valor=="x"}checked="checked"{/if}/>
                            </td>
                        </tr>
                      {/foreach}
                    </tbody>
                  </table>
                {/if}
            </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" style="width:100%">Editar</button>
        </div>
      </form>
    </div>
  </section>
</div>