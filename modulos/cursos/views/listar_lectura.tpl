<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de PDFs</h3>
      </div>
      {if is_array($pdfs)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach item=rl from=$pdfs}
                <tr>
                  <td>{$rl.name}</td>
                  <td>
                      <a href="{$_layoutParams.root}cursos/ver_lectura/{$rl.id_course}/{$rl.id_module}/{$rl.id_class}/{$rl.id}"><button class="btn btn-primary btn-sm">Ver</button></a>
                  </td>
                </tr>
              {/foreach}
            </tbody>
        </table>
      {/if}
    </div>
  </section>
</div>