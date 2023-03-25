<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Account&mode={{mode}}&account_id={{account_id}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="account_id" class="col-4">Código</label>
    <input type="hidden" id="account_id" name="account_id" value="{{account_id}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
     <input type="hidden" name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="account_iddummy" value="{{account_id}}"/>
    </section>
    <section class="row">
      <label for="account_name" class="col-4">Nombre</label>
      <input type="text" {{readonly}} name="account_name" value="{{account_name}}" maxlength="200" placeholder="Nombre"/>
    </section>
    <section class="row">
      <label for="account_type" class="col-4">Tipo</label>
      <select id="account_type" name="account_type" {{if readonly}}disabled{{endif readonly}}>
        <option value="ASSET" {{account_type_ASSET}}>Activo</option>
        <option value="LIABILITY" {{account_type_LIABILITY}}>Pasivo</option>
        <option value="EQUITY" {{account_type_EQUITY}}>Patrimonio</option>
        <option value="INCOME" {{account_type_INCOME}}>Ingreso</option>
        <option value="EXPENSE" {{account_type_EXPENSE}}>Gasto</option>
      </select>
    </section>
    
    <section class="row">
      <label for="balance" class="col-4">Balance</label>
      <input type="number" {{readonly}} name="balance" value="{{balance}}"/>
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
        window.location.assign("index.php?page=Mnt_Accounts");
      });
  });
</script>