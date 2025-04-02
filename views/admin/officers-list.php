<h2>Список сотрудников регистратуры</h2>
<table>
    <tr>
        <th>ФИО</th>
        <th>Логин</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($officers as $officer): ?>
        <tr>
            <td><?= $officer->name ?></td>
            <td><?= $officer->login ?></td>
            <td>
                <form method="post" action="/officers-list">
                    <input type="hidden" name="id" value="<?= $officer->id ?>">
                    <button type="submit">Удалить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="/create-officer">Добавить нового</a>
<a href="/hello">Назад к панели</a>
