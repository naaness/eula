
<button class="btn btn-primary btn-sm play">Play</button>
<button class="btn btn-primary btn-sm pause">Stop</button>
<script type="text/javascript">
	var purldf='{$purldf}';
</script>
{if $datosaudio.download==1}
	
	<a href="{$url_download}"><button class="btn btn-primary btn-sm pause">Descarga</button></button></a>
{/if}