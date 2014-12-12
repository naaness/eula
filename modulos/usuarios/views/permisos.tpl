<div class="row">
  <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="box box-primary">
      <div class="box-header ui-sortable-handle" style="cursor: move;">
          <i class="fa fa-user"></i>
          <h3 class="box-title">
          	{foreach from=$info item=pr}
				{$pr.name}
			{/foreach} (
			{foreach from=$info item=pr}
				{$pr.role}
			{/foreach}
			)
		  </h3>
      </div>
      <form name="form1" method="post" action="">
        <input type="hidden" name="guardar" value="1" />
        {if isset($permisos) && count($permisos)}
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Permisos</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {foreach from=$permisos item=pr}
        				{if $role.$pr.valor == 1}
        					{assign var="v" value="habilitado"}
        				{else}
        					{assign var="v" value="denegado"}
        				{/if}
        				<tr>
        					<td>{$usuario.$pr.permiso}</td>
        					<td>
        						<select class="form-control" name="perm_{$usuario.$pr.id}">
        							<option value="x" {if $usuario.$pr.heredado} selected="selected" {/if}>Heredado ({$v})</option>
        							<option value="1" {if ($usuario.$pr.valor == 1 && $usuario.$pr.heredado == "")} selected="selected" {/if}>Habilitado</option>
        							<option value="" {if ($usuario.$pr.valor == "0" && $usuario.$pr.heredado == "")} selected="selected" {/if}>Denegado</option>
        						</select>
        					</td>
        				</tr>
        			  {/foreach}
            </tbody>
          </table>
        {/if}
        <div class="box-footer">
          <button type="submit" class="btn btn-primary" style="width:100%">Modificar</button>
        </div>
      </form>
    </div>
  </section>
</div>