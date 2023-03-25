<main>
    <table>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Balance</th>
            <th>
                <a href="index.php?page=Mnt-Account&mode=INS">Nuevo</a>
            </th>
        </tr>
        {{foreach accounts}}
        <tr>
            <td>{{account_id}}</td>
            <td>{{account_name}}</td>
            <td>{{account_type}}</td>
            <td>{{balance}}</td>
            <td>
                <a href="index.php?page=Mnt-Account&mode=UPD&account_id={{account_id}}">Editar</a> &nbsp; <a href="index.php?page=Mnt-Account&mode=DEL&account_id={{account_id}}">Eliminar</a>
            </td>
        </tr>
        {{endfor accounts}}
    </table>
</main>