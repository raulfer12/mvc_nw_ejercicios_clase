<h1>{{modedsc}}</h1>
<section>
  <form action="index.php?page=Mnt_Categoria&mode={{mode}}&catid={{catid}}"
    method="POST" >
    <section>
    <label for="catid">Código</label>
    <input type="hidden" id="catid" name="catid" value="{{catid}}"/>
    <input type="text" readonly name="catiddummy" value="{{catid}}"/>
    </section>
    <section>
      <label for="catnom">Categoría</label>
      <input type="text" {{readonly}} name="catnom" value="{{catnom}}" maxlength="45" placeholder="Nombre de Categoría"/>
    </section>
    <section>
      <label for="catest">Estado</label>
      <select id="catest" name="catest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{catest_ACT}}>Activo</option>
        <option value="INA" {{catest_INA}}>Inactivo</option>
        <option value="PLN" {{catest_PLN}}>Planificación</option>
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
      {{if showaction}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif showaction}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Categorias");
      });
  });
</script>
