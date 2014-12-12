<div class="row">
  <section class="col-lg-7 connectedSortable ui-sortable">
    <div class="box box-primary" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Preguntas de Examen</h3>
          <p></p>
          <a href="{$_layoutParams.root}cursos/ver_video"><button class="btn btn-primary btn-sm">Ver</button></a>
      </div>
      {if is_array($examenes)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$examenes}
                <tr>
                  <td>{$rl.question}</td>
                  <td>
                      <a href="{$_layoutParams.root}cursos/editar_pregunta/{$rl.id_course}/{$rl.id_module}/{$rl.id_class}/{$rl.id}"><button class="btn btn-primary btn-sm">Editar</button></a>
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
            <h3 class="box-title">Nueva Pregunta Examen</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="guardar" value="1" />
            <div class="box-body">
              <div class="form-group">
                <label for="pregunta">Pregunta :</label>
                <input type="text" class="form-control" name="pregunta" placeholder="Ingrese la pregunta" value="">
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" style="width:100%">Crear</button>
              </div>
          </form>
        </div>
      </div>
    </section>
</div>