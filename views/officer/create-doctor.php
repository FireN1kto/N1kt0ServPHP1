<h2>Добавление нового врача</h2>
<form method="post">
    <label>Фамилия: <input type="text" name="surname" value="" required></label>
    <label>Имя: <input type="text" name="name" value="" required></label>
    <label>Отчество: <input type="text" name="patronymic" value=""></label>
    <label>Дата рождения: <input type="date" name="dateOfBirth" value="" required></label>
    <label>Специализация: <input type="text" name="specialization" value="" required></label>
    <label>Должность:
        <select name="position_id" required>
            <option value="">-- Выберите должность --</option>
            <?php foreach ($positions as $position): ?>
                <option value="<?= $position->id ?>"><?= $position->name_position ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <div class="officer-menu">
        <button type="submit">Создать</button>
        <a href="/hello" class="back">Назад к панели</a>
    </div>
</form>
