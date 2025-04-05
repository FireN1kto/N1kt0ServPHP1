<h2>Добавление нового врача</h2>
<?php if (isset($error)): ?>
    <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="post">
    <label>Фамилия: <input type="text" name="surname" value="<?= $old['surname'] ?? '' ?>" required></label>
    <label>Имя: <input type="text" name="name" value="<?= $old['name'] ?? '' ?>" required></label>
    <label>Отчество: <input type="text" name="patronymic" value="<?= $old['patronymic'] ?? '' ?>" required></label>
    <label>Дата рождения: <input type="date" name="birth_date" value="<?= $old['birth_date'] ?? '' ?>" required></label>
    <label>Специализация: <input type="text" name="specialization" value="<?= $old['specialization'] ?? '' ?>" required></label>
    <label>Должность: <input type="text" name="position" value="<?= $old['position'] ?? 'Врач' ?>"></label>
    <button type="submit">Создать</button>
</form>
