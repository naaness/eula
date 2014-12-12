<div class="row">
  <section class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Modulos </h3>
          <p></p>
          <a href="{$_layoutParams.root}cursos/crear_modulo/{$id_curso}">
            <button class="btn btn-primary btn-sm">Crear Modulo</button>
          </a>
      </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th></th>
            </tr>
          </thead>
          {if is_array($modulos)}
            <tbody>
              {foreach item=rl from=$modulos}
                <tr>
                  <td>{$rl.name}</td>
                  <td>
                    <div class="box-tools pull-right">
                      <a href="{$_layoutParams.root}cursos/vista_curso/{$rl.id_course}/{$rl.id}">
                        <button class="btn btn-primary"><i class="fa fa-sitemap"></i></button>
                      </a>
                    	<a href="{$_layoutParams.root}cursos/editar_modulo/{$rl.id_course}/{$rl.id}">
  		                  <button class="btn btn-primary">Editar</button>
    		              </a>
                      <a href="{$_layoutParams.root}cursos/clases/{$rl.id_course}/{$rl.id}" >
                        <button class="btn btn-primary" ><i class="fa fa-puzzle-piece"></i>  Clases</button>
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