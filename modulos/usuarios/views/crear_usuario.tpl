<form role="form" method="POST" action="">
  <input type="hidden" name="crear" value="1" />
    <div class="form-group col-md-12">
      <label for="nombre_prospecto">Nombre<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="nombre" name="nombre" placeholder="Nombre" value="{$_POST.nombre|default:''}">
    </div>
    <div class="form-group col-md-12">
      <label for="nombre_prospecto">Usuario<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="usuario" name="usuario" placeholder="Usuario" value="{$_POST.usuario|default:''}">
    </div>
    <div class="form-group col-md-12">
      <label for="nombre_prospecto">Email<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="email" name="email" placeholder="Email" value="{$_POST.email|default:''}">
    </div>
    <div class="form-group col-md-6">
      <label for="nombre_prospecto">Contraseña<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="pass" name="pass" placeholder="Contraseña" value="">
    </div>
    <div class="form-group col-md-6">
      <label for="nombre_prospecto">Repetir contraseña<span class="obligatorio">*</span></label>
      <input type="text" class="form-control input-lg" id="pass_r" name="pass_r" placeholder="Repetir contraseña" value="">
    </div>
    <div class="form-group col-md-12">
      <button type="submit" class="btn btn-primary" style="width:100%">Crear</button>
    </div>
</form>
