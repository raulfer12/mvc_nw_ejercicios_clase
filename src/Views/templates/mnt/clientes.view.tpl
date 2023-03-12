<section class="depth-1">
  <h1>Trabajar con Clientes</h1>
</section>
<section class="WWList">
  <table >
    <thead>
      <tr>
      <th>Código</th>
      <th>Correo</th>
      <th>Estado</th>
      <th>
        {{if CanInsert}}
        <a href="index.php?page=Mnt_Clientes1&mode=INS&id=0">Nuevo</a>
        {{endif CanInsert}}
      </th>
      </tr>
    </thead>
    <tbody>
      {{foreach Clientes}}
      <tr>
        <td>{{clientid}}</td>
        <td>
          {{if ~CanView}}
          <a href="index.php?page=Mnt_Clientes1&mode=DSO&id={{clientid}}">{{clientname}}</a>
          {{endif ~CanView}}

          {{ifnot ~CanView}}
              {{clientname}}
          {{endifnot ~CanView}}
        </td>
        <td>{{clientstatus}}</td>
        <td>
          {{if ~CanUpdate}}
          <a href="index.php?page=Mnt_Clientes1&mode=UPD&id={{clientid}}"
            class="btn depth-1 w48" title="Editar">
            <i class="fas fa-edit"></i>
          </a>
          {{endif ~CanUpdate}}
          &nbsp;
          {{if ~CanDelete}}
          <a href="index.php?page=Mnt_Clientes1&mode=DEL&id={{clientid}}"
            class="btn depth-1 w48" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
          </a>
          {{endif ~CanDelete}}
        </td>
      </tr>
      {{endfor Clientes}}
    </tbody>
  </table>
</section>
