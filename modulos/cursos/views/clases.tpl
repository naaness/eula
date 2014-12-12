<div class="row">
  <section class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Clases </h3>
          <p></p>
          <a href="{$_layoutParams.root}cursos/crear_clase/{$id_curso}/{$id_modulo}">
            <button class="btn btn-primary btn-sm">Crear Clase</button>
          </a>
      </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th></th>
            </tr>
          </thead>
          {if is_array($clases)}
            <tbody>
              {foreach item=rl from=$clases}
                <tr>
                  <td>{$rl.name}</td>
                  <td>
                    <div class="box-tools pull-right">
                      <a href="{$_layoutParams.root}cursos/vista_curso/{$id_curso}/{$id_modulo}/{$rl.id}">
                        <button class="btn btn-primary"><i class="fa fa-sitemap"></i></button>
                      </a>
                    	<a href="{$_layoutParams.root}cursos/editar_clase/{$id_curso}/{$id_modulo}/{$rl.id}">
  		                  <button class="btn btn-primary">Editar</button>
    		              </a>
                      <a href="{$_layoutParams.root}cursos/{$url_tipo[$rl.type]}/{$id_curso}/{$id_modulo}/{$rl.id}" >
                        <button class="btn btn-primary" ><i class="{$icono_tipo[$rl.type]}"></i></button>
                      </a>
                    </div>
                  </td>
                </tr>
              {/foreach}
            </tbody>
          {/if}
        </table>
    </div>
  </section>
</div>