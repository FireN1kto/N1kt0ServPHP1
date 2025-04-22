<h2>Список сотрудников регистратуры</h2>
<table class="list-officer">
    <tr>
        <th>ФИО</th>
        <th>Логин</th>
    </tr>
    <?php foreach ($officers as $officer): ?>
        <tr>
            <td><?= $officer->name ?></td>
            <td><?= $officer->login ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="admin-menu">
    <a href="/create-officer">Добавить нового</a>
    <a href="/hello">Назад к панели</a>
</div>
