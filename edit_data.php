<!-- Cargamos las vistas y js adicionales que se usan en el listado -->

<script src="<?=base_url('js/dataTables/controllerDateTable.js')?>"></script>
<?=form_open( ''); ?>
<?php echo form_close();?>
<input id="controlador" hidden value="<?= $controlador; ?>"/>
<!-- Fin carga vistas adicionales -->

<?$attributes = array('id' => 'formulario');
echo form_open('usuarios/guardar_editar',$attributes);?>

<input id="clave_anterior" name="clave_anterior" hidden value="<?=$listado->clave;?>"/>
<input id="id_usuarios" name="id_usuarios" hidden value="<?=$listado->id_usuarios;?>"/>

<?//var_dump($listado);?>
<section class="edicion-datos">
    <div class="row">
        <div class="col-md-12">
            <h4 class="titulo-panel">Información Personal</h4>
        </div>
        
        <div class="col-md-12">
           <div class="datos-personales">
                <h4>Datos Personales</h4>

                <div class="form-group">
                    <label for="exampleInputEmail1">Dni:</label>
                    <input type="number" maxlength="10" class="form-control" name="dni" id="dni" value="<?if((!empty($listado->dni))&&($listado->dni!='0')){echo $listado->dni;}else{echo '---';}?>" <?if((!empty($listado->dni))&&($listado->dni!='0')){echo "placeholder='Ingresar dni'";}?> >                        
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre (*):</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?=$listado->nombre?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Apellido (*):</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?=$listado->apellido?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email (*):</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?=$listado->email?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Domicilio:</label>
                    <input class="form-control" id="domicilio" name="domicilio" value="<?=$listado->domicilio?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Teléfono Celular:</label>
                    <input class="form-control" id="telefono_celular" name="telefono_celular" value="<?=$listado->telefono_celular?>" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Otro Teléfono:</label>
                    <input class="form-control" id="otro_telefono" name="otro_telefono" value="<?=$listado->otro_telefono?>" required>
                </div>

            </div>
        </div>
               
    </div>  
    <!-- Fin ROW -->
</section> 
<!-- Fin Section-edicion-datos -->
<!-- Botones Guardar y Volver -->
<hr>
<section class="edicion-datos">
    <div class="row">
        <div class="col-md-12">
           <!--  <a href="<?=base_url('panel/usuarios/usuarios/ver_datos')?>" class="btn btn-default btn-md pull-left">Volver</a> -->
           <button type="submit" id="btn_guardar" class="btn btn-success btn-md"><i class="glyphicon glyphicon-floppy-disk"></i>&nbsp;&nbsp;Guardar Datos</button>
           <div id="guardando" style="display:none;">
            <b class="pull-right">Guardando...</b>
            <img src="<?=base_url('img/loading.gif');?>" width="40" class="pull-right" /> 
        </div>
    </div>
</div>
</section>
<?php echo form_close();?>

<script>
  $("#btn_guardar").click(function(){ 
      
      if(!validar_dni_usuario()) 
          return;
      
      if(!validar_clave())
          return;      

      $("#formulario").submit(function(){
          $("#btn_guardar").hide();
          $("#guardando").show();
      });

  });

  //valida que las contraseñas que ingresó el usuario coincidan
  function validar_clave() {
      $('#clave')[0].setCustomValidity('');
      
      var clave1 = $("#clave").val();
      var clave2 = $("#clave2").val();

      if(clave1 !== clave2){

          $("#clave").prop("value", "");
          $("#clave2").prop("value", "");
          $('#clave')[0].setCustomValidity('Las contraseñas no coinciden');
          return false;
      }
      else return true;
  }

  //valida que el nombre de usuario ingresado no exista ya en la base
  function validar_dni_usuario() {

      var accion = <?= json_encode($accion); ?>;
      var dni = <?= (($accion == "Editar")? json_encode($listado->dni) : json_encode(false)); ?>;
      if(accion == "Editar" && $("#dni").val() == dni)
          return true;
      
      $('#dni')[0].setCustomValidity('');
      var res = false;

      $.ajax({

          async: false,
                
          url: base_url + "usuarios/verificar_dni_usuario",
          method: "POST",          
          data: {
              token_sistema: $("input:hidden[name='token_sistema']").val() ,
              dni: $("#dni").val()
          },            
          success: function( data ) {
              data = jQuery.parseJSON(data);
              if(data) {
                  $("#dni").prop("value", "");
                  $('#dni')[0].setCustomValidity('Ese dni de Usuario ya está registrado');    
                  res = false;          
              } else res = true;                        
          }
      }); 

      return res;
  }
</script>
