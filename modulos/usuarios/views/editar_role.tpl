<div class="row">
    <section class="col-lg-12 connectedSortable ui-sortable">
      <div class="box box-info" style="position: relative;">
        <div class="box-header ui-sortable-handle" style="cursor: move;">
            <i class="fa fa-user"></i>
            <h3 class="box-title">Editar role del usuario 
                {foreach from=$info item=pr}
                    {$pr.name}
                    {assign var="rolea" value=$pr.role}
                {/foreach}
            </h3>
        </div>
        <div class="box-body">
          <form name="form1" action="" method="post">
            <input type="hidden" name="editar" value="1" />
            <div class="box-body">
              <div class="form-group">
                <label for="usur_{$actualrol}">Role :</label>
                <select class="form-control" name="usur_{$actualrol}">
                    {if $rolea=="SuperAdministrador"}
                        <option value="1" selected="selected">SuperAdministrador</option>
                    {else}
                        {foreach from=$roles item=rl}
                            {if $rl.id!=1}
                                <option value="{$rl.id}" {if $rolea == $rl.role} selected="selected" {/if} >{$rl.role}</option>
                            {/if}
                        {/foreach}
                    {/if}
                </select>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-block">Modificar</button>
            </div>
          </form>
        </div>
      </div>
    </section>
</div>
    