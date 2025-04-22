<h2>Все пациенты</h2>
<table>
    <tr>
        <th>Фаимлия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Дата рождения</th>
        <th>Создатель</th>
        <th>Время создания</th>
    </tr>
    <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?= $patient->surname ?></td>
            <td><?= $patient->name ?></td>
            <td><?= $patient->patronymic ?></td>
            <td><?= date('d.m.Y' ,strtotime($patient->dateOfBirth ))?></td>
            <td>
                <?= $patient->createInfo->user_id->name ?? 'Неизвестно' ?>
            </td>
            <td>
                <?= $patient->createInfo->creation_date ?? 'Неизвестно' ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="officer-menu">
    <a href="/hello">Назад к панели</a>
    <a href="/create-patient">Добавить нового</a>
</div>