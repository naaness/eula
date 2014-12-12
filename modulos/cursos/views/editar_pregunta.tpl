<div class="row">
  <section class="col-lg-5 connectedSortable ui-sortable">
    <div class="box box-info" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="{$icono_tipo}"></i>
          <h3 class="box-title">Nueva Pregunta Examen</h3>
      </div>
      <div class="box-body">
        <form name="form1" action="" method="post" >
          <input type="hidden" name="editar" value="1" />
          <div class="box-body">
            <div class="form-group">
              <label for="pregunta">Pregunta :</label>
              <input type="text" class="form-control" name="pregunta" placeholder="Ingrese la pregunta" value="{$datos.question}">
            </div>
            {if is_array($respuestas)}
              <div class="form-group">
                <label>Respuesta correcta</label>
                <select class="form-control" name="respuesta">
                  {foreach item=rl from=$respuestas}
                    <option value="{$rl.id}">{$rl.answer}</option>
                  {/foreach}
                </select>
              </div>
            {else}
              <input type="hidden" name="respuesta" value="0" />
            {/if}
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary" style="width:100%">Editar</button>
          </div>
        </form>
      </div>
    </div>
  </section>
  <section class="col-lg-7 connectedSortable ui-sortable">
    <div class="box box-primary" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Respuestas</h3>
          <p></p>
          <a href="{$_layoutParams.root}cursos/nueva_respuesta/{$datos.id}"><button class="btn btn-primary btn-sm">Nueva Respuesta</button></a>
      </div>
      {if is_array($respuestas)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Respuesta</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$respuestas}
                <tr>
                  <td>
                    <input type="text" class="form-control" name="pregunta" placeholder="Ingrese la pregunta" value="{$rl.answer}" id="txt_{$rl.id}">
                  </td>
                  <td>
                    <button class="btn btn-primary btn-sm" id="edit_{$rl.id}">Modificar</button>
                  </td>
                  <td>
                    <button class="btn btn-danger btn-sm" id="delete_{$rl.id}">Eliminar</button>
                  </td>
                </tr>
              {/foreach}
            </tbody>
        </table>
      {/if}
    </div>
  </section>
</div>