<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Usuarios&mode={{mode}}&usercod={{usercod}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="usercod" class="col-4">Código</label>
    <input type="hidden" id="usercod" name="usercod" value="{{usercod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
     <input type="hidden" name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="usercoddummy" value="{{usercod}}"/>
    </section>
    <section class="row">
      <label for="username" class="col-4">Usuario</label>
      <input type="text" {{readonly}} name="username" value="{{username}}" maxlength="45" placeholder="Nombre de Usuario"/>
      {{if username_error}}
        <span class="error col-12">{{username_error}}</span>
      {{endif username_error}}
    </section>
    <section class="row">
      <label for="userest" class="col-4">Estado</label>
      <select id="userest" name="userest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{catest_ACT}}>Activo</option>
        <option value="INA" {{catest_INA}}>Inactivo</option>
      </select>
    </section>
    {{if has_errors}}
        <section>
          <ul>
            {{foreach general_errors}}
                <li>{{this}}</li>
            {{endfor general_errors}}
          </ul>
        </section>
    {{endif has_errors}}
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Usuarios");
      });
  });
</script>