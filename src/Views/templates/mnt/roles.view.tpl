<section class="depth-1">
  <h1>Trabajar con Roles</h1>
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
        <a href="index.php?page=Mnt_Roles&mode=INS&id=0">Nuevo</a>
        {{endif CanInsert}}
      </th>
      </tr>
    </thead>
    <tbody>
      {{foreach Roles}}
      <tr>
        <td>{{rolescod}}</td>
        <td>
          {{if ~CanView}}
          <a href="index.php?page=Mnt_Roles&mode=DSO&id={{rolescod}}">{{rolesdsc}}</a>
          {{endif ~CanView}}

          {{ifnot ~CanView}}
              {{rolesdsc}}
          {{endifnot ~CanView}}
        </td>
        <td>{{rolesest}}</td>
        <td>
          {{if ~CanUpdate}}
          <a href="index.php?page=Mnt_Roles&mode=UPD&id={{rolescod}}"
            class="btn depth-1 w48" title="Editar">
            <i class="fas fa-edit"></i>
          </a>
          {{endif ~CanUpdate}}
          &nbsp;
          {{if ~CanDelete}}
          <a href="index.php?page=Mnt_Roles&mode=DEL&id={{rolescod}}"
            class="btn depth-1 w48" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
          </a>
          {{endif ~CanDelete}}
        </td>
      </tr>
      {{endfor Roles}}
    </tbody>
  </table>
</section>
