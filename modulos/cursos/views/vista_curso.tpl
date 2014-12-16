<div class="row">
  <section class="col-lg-12">
  	<ul class="timeline">
  		{if is_array($datos_curso)}
  			{assign var="modulo" value=0}
  			{foreach from=$datos_curso item=dato}
  				{if $modulo!=$dato.id_module}
				    <!-- timeline time label -->
				    <li class="time-label">
				        <span class="bg-red">
				            {$dato.name_module}
				        </span>
				    </li>
				    <!-- /.timeline-label -->
				    {assign var="modulo" value=$dato.id_module}
				{/if}
			    <!-- timeline item -->
			    <li>
			        <!-- timeline icon -->
			        <i class="{$icono_tipo[$dato.type]} bg-aqua"></i>
			        <div class="timeline-item">
			            <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

			            <h3 class="timeline-header"><a href="#">{$dato.name}</a></h3>

			            <div class="timeline-body">
			                {$dato.description}
			            </div>

			            <div class='timeline-footer'>
			                <a href="{$_layoutParams.root}cursos/{$tipo_clases[$dato.type]}}/{$dato.id_course}/{$dato.id_module}/{$dato.id_class}" class="btn btn-primary btn-xs">Ver</a>
			            </div>
			        </div>
			    </li>
		    	<!-- END timeline item -->
		    {/foreach}
		    <!-- timeline time label -->
		    <li class="time-label">
		        <i class="fa fa-clock-o"></i>
		    </li>
		    <!-- /.timeline-label -->
	    {/if}
	</ul>
  </section>
</div>