<div class="row">
  <section class="col-lg-7 connectedSortable ui-sortable">
    <div class="box box-primary" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Preguntas del foro</h3>
      </div>
      {if is_array($preguntas)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Pregunta</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$preguntas}
                <tr>
                  <td>{$rl.question}</td>
                  <td>
                      <a href="{$_layoutParams.root}cursos/ver_foro/{$rl.id_course}/{$rl.id_module}/{$rl.id_class}/{$rl.id}"><button class="btn btn-primary btn-sm">Ver</button></a>
                  </td>
                </tr>
              {/foreach}
            </tbody>
        </table>
      {/if}
    </div>
  </section>
    <section class="col-lg-5 connectedSortable ui-sortable">
      <div class="box box-info" style="position: relative;">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="{$icono_tipo[$datos.type]}"></i>
            <h3 class="box-title">Nueva Pregunta</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="guardar" value="1" />
            <div class="box-body">
              <div class="form-group">
                <label>Pregunta: </label>
                <textarea class="form-control" rows="3" name="pregunta" placeholder="Formule su pregunta aqui"></textarea>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" style="width:100%">Crear</button>
              </div>
          </form>
        </div>
      </div>
    </section>
</div>