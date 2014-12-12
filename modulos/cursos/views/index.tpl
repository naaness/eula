<div class="row">
  <section class="col-lg-12">
    <div class="box box-primary">
      <div class="box-header">
          <i class="ion ion-clipboard"></i>
          <h3 class="box-title">Listado de Cursos</h3>
          <p></p>
          <a href="{$_layoutParams.root}cursos/crear_curso">
            <button class="btn btn-primary btn-sm">Crear Curso</button>
          </a>
      </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Nombre</th>
              <th></th>
            </tr>
          </thead>
          {if is_array($cursos)}
            <tbody>
              {foreach item=rl from=$cursos}
                <tr>
                  <td>{$rl.name}</td>
                  <td>
                    <div class="box-tools pull-right">
                      <a href="{$_layoutParams.root}cursos/vista_curso/{$rl.id}">
                        <button class="btn btn-primary"><i class="fa fa-sitemap"></i></button>
                      </a>
                    	<a href="{$_layoutParams.root}cursos/editar_curso/{$rl.id}">
  		                  <button class="btn btn-primary">Editar</button>
    		                </a>
                    	<a href="{$_layoutParams.root}cursos/matricular_grupo/{$rl.id}">
      		              <button class="btn btn-primary"><i class="fa fa-users"></i></button>
      		            </a>
                    	<a href="{$_layoutParams.root}cursos/matricular_usuario/{$rl.id}">
      		              <button class="btn btn-primary"><i class="fa fa-user"></i></button>
      		            </a>
                      <a href="{$_layoutParams.root}cursos/modulos/{$rl.id}" >
                        <button class="btn btn-primary" ><i class="fa fa-th"></i> Modulos</button>
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