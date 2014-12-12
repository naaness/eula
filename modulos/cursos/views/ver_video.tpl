<div class="row">
  {foreach item=rl from=$videos}
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary" style="position: relative;">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-film"></i>
          <h3 class="box-title">{$rl.name}</h3>
      </div>
	  <iframe src="//player.vimeo.com/video/{$rl.url}" width="100%" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
	</div>
  </section>
  {/foreach}
</div>