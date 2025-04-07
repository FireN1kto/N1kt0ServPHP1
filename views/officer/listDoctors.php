<h2>Все врачи</h2>
<table>
    <tr>
        <th>Фаимлия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Дата рождения</th>
        <th>Специализация</th>
        <th>Должность</th>
        <th>Создатель</th>
        <th>Время создания</th>
    </tr>
    <?php foreach ($doctors as $doctor): ?>
        <tr>
            <td><?= $doctor->surname ?></td>
            <td><?= $doctor->name ?></td>
            <td><?= $doctor->patronymic ?></td>
            <td><?= date('d.m.Y' ,strtotime($doctor->dateOfBirth ))?></td>
            <td><?= $doctor->specialization ?></td>
            <td><?= $doctor->position->name_position ?></td>
            <td>
                <?= $doctor->createInfo->user_id->name ?? 'Неизвестно' ?>
            </td>
            <td>
                <?= $doctor->createInfo->creation_date ?? 'Неизвестно' ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="officer-menu">
    <a href="/hello">Назад к панели</a>
    <a href="/create-patient">Добавить нового</a>
</div>