<div class="row">
	<section class="col-lg-12 connectedSortable ui-sortable">
      <div class="box box-info" style="position: relative;">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="fa fa-puzzle-piece"></i>
            <h3 class="box-title">Editar Clase</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post">
            <input type="hidden" name="guardar" value="1">
            <div class="box-body">
              <div class="form-group">
                <label for="name">Nombre :</label>
                <input type="text" class="form-control" name="name" placeholder="Nombre de la clase" value="{$datos.name}">
              </div>
              <div class="form-group">
                <label>Descripcion</label>
                <textarea class="form-control" rows="3" name="description" placeholder="Descripcion del curso">{$datos.description}</textarea>
              </div>
              <div class="form-group">
                <label>Profesor</label>
                <select name="profesor" class="form-control">
                  {if is_array($profesores)}
                    {foreach item=rl from=$profesores}
                      <option value="{$rl.id}">{$rl.name}</option>
                    {/foreach}
                  {else}
                    <option value="0">Sin profesor</option>
                  {/if}
                </select>
              </div>
              <div class="form-group">
                <input type="hidden" name="tipo" id="tipo" value="{$datos.type}">
                <label>Tipo :</label>
                <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                  {for $foo=1 to count($icono_tipo)}
                    <a class="btn btn-default {if $foo==$datos.type}active{/if}" role="button" id="tipo_{$foo}"><i class="{$icono_tipo[$foo]}"></i></a>
                  {/for}
                </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-block">Editar</button>
              </div>
          </form>
        </div>
      </div>
    </section>
</div>