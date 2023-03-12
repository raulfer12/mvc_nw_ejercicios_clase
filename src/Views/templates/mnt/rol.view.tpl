<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Roles&mode={{mode}}&rolescod={{rolescod}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="rolescod" class="col-4">Código</label>
    <input type="hidden" id="rolescod" name="rolescod" value="{{rolescod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
     <input type="hidden" name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="rolescoddummy" value="{{rolescod}}"/>
    </section>
    <section class="row">
      <label for="rolesdsc" class="col-4">Rol</label>
      <input type="text" {{readonly}} name="rolescod" value="{{rolescod}}" maxlength="45" placeholder="Descripcion de Rol"/>
      {{if rolesdsc_error}}
        <span class="error col-12">{{rolesdsc_error}}</span>
      {{endif rolesdsc_error}}
    </section>
    <section class="row">
      <label for="rolesest" class="col-4">Estado</label>
      <select id="rolesest" name="rolesest" {{if readonly}}disabled{{endif readonly}}>
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
        window.location.assign("index.php?page=Mnt_Roles");
      });
  });
</script>