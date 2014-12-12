<!DOCTYPE html>
<html>
  <head>
      <title>{$titulo}</title>
      <meta charset="UTF-8"/>
      <title>{$titulo|default:"Sin título"}</title>
      <link href="{$_layoutParams.root}public/css/jQueryUI.min.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="{$_layoutParams.ruta_bootstrap}css/bootstrap.css"/>

      <link rel="stylesheet" type="text/css" href="{$_layoutParams.root}public/dataTablescss/dataTables.bootstrap.css">

      <link rel="stylesheet" href="{$_layoutParams.ruta_css}dashboard.css" />
      <meta name="viewport" content="width=device-width, user-scalable=no">

      {if isset($_layoutParams.css) && count($_layoutParams.css)}
          {foreach item=css from=$_layoutParams.css}
            <link rel="stylesheet" href="{$css}"/>
          {/foreach}
      {/if}

  </head>
  <body>
    <div id="barrita">La barrita</div>
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a class="navbar-brand" href="{$_layoutParams.root}secs">SEC's</a><p class="navbar-text">Sistema Externo de Consulta</p>
        </div>
      </div><!-- /.container-fluid -->
    </nav>

    <div id="wrap-total">
      <div id="wrapper">
        <div id="wrap-contenido">
          {if isset($_errores)}
          <div class="alert alert-warning fade in" id="alert-template">
            <ul>
              {foreach from=$_errores item=error}
              <li>
                {if isset($error)}
                  - <strong>{$error}</strong>
                {/if}
              </li>
              {/foreach}
            </ul>
          </div>
          {/if}

          {if isset($_mensaje)}
          <div class="alert alert-info fade in" id="alert-template">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
              {foreach from=$_mensaje item=mensaje}
              <li>
                {if isset($mensaje)}
                  - <strong>{$mensaje}</strong>
                {/if}
              </li>
              {/foreach}
            </ul>
          </div>
          {/if}

          <div id="contenido">
            <div class="page-header">
              <h3>{if isset($titulo)}{$titulo}{/if}<small> {if isset($subtitulo)}{$subtitulo}{/if}</small></h3>
            </div>
            {include file=$_contenido}
          </div>
          <footer text-center>
            Copyright © 2014 Todos los derechos son reservados para Sinergia FC, Expertos en comercio exterior - Creado sobre: www.artesan.us
          </footer>
        </div>

        <div id="side-bar">
          {if isset($widgets.secs)}
            {foreach item=sidebar from=$widgets.secs}
              {$sidebar}
            {/foreach}
          {/if}


        </div>
      </div>



    </div>
      <script src="{$_layoutParams.root}public/js/jQuery.js" type="text/javascript"></script>
      <script src="{$_layoutParams.root}public/js/jQueryUI.js" type="text/javascript"></script>
      <script src="{$_layoutParams.ruta_bootstrap}js/bootstrap.min.js" type="text/javascript"></script>

      <script src="{$_layoutParams.root}public/js/funciones.js" type="text/javascript"></script>

        <script type="text/javascript">
            var _root_ = '{$_layoutParams.root}';
        </script>

        <script src="{$_layoutParams.ruta_js}funciones.js"></script>
        {if isset($_layoutParams.js) && count($_layoutParams.js)}
            {foreach item=js from=$_layoutParams.js}
                <script src="{$js}"></script>
            {/foreach}
        {/if}
    </body>
</html>

<?php ob_end_flush();?>
