
<div class="row">
	{assign var="pregunta" value=0}
	{foreach from=$datos_clase item=dato}
		{if $dato.answer_correct!=0}
			{if $pregunta!=$dato.id_question}
				{if $pregunta!=0}
								</div>
	                		</form>
	            		</div><!-- /.box-body -->
	        		</div>
	        	</section>
				{/if}
		  		<section class="col-lg-12">
		  			<div class="box box-warning">
		            	<div class="box-header">
		                	<h3 class="box-title">{$dato.question}</h3>
				        </div><!-- /.box-header -->
			            <div class="box-body">
			                <form role="form">
			                	 <!-- radio -->
                    			<div class="form-group">
	         	{assign var="pregunta" value=$dato.id_question}
			{/if}
			                        <div class="radio">
			                            <label>
			                                <input type="radio" name="optionsRadios"  value="">
			                                {$dato.answer}
			                            </label>
			                        </div>
        {/if}
    {/foreach}
    {if $pregunta!=0}
								</div>
	                		</form>
	            		</div><!-- /.box-body -->
	        		</div>
	        	</section>
	{/if}
</div>