<div class="row">
  <section class="col-lg-7 connectedSortable ui-sortable">
    <div class="box box-primary" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Videos</h3>
      </div>
      {if is_array($videos)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th></th>
                <th>Descargar</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$videos}
                <tr>
                  <td>{$rl.name}</td>
                  <td>
                      <a href="{$_layoutParams.root}cursos/ver_video/{$rl.id_course}/{$rl.id_module}/{$rl.id_class}/{$rl.id}"><button class="btn btn-primary btn-sm">Ver</button></a>
                  </td>
                  <td>
                      <a href="{$_layoutParams.root}cursos/descargar_video/{$rl.id_course}/{$rl.id_module}/{$rl.id_class}/{$rl.id}/{$rl.download}"><button class="btn btn-primary btn-sm">{if $rl.download==1}Si{else}No{/if}</button></a>
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
            <h3 class="box-title">Nuevo Video</h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="guardar" value="1" />
            <div class="box-body">
              <div class="form-group">
                <label for="name">Nombre :</label>
                <input type="text" class="form-control" name="name" placeholder="Nombre del archivo" value="">
              </div>
              <div class="form-group">
                <label for="url">Url :</label>
                <input type="text" class="form-control" name="url" placeholder="Ruta donde esta alojado el video" value="">
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" style="width:100%">Crear</button>
              </div>
          </form>
        </div>
      </div>
    </section>
</div>