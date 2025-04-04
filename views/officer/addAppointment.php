<h2>Добавление новой записи</h2>
<form method="post">
    <div class="form-group">
        <label>Название записи: </label>
        <input type="text" name="title" value="" required minlength="15" maxlength="255">
    </div>
    <div class="form-group">
        <label>Пациент: </label>
        <select name="patient_id" required>
            <option value="">--Выберите пациента--</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient->id ?>"><?= $patient->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Врач: </label>
        <select name="doctor_id" required>
            <option value="">--Выберите врача--</option>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor->id ?>"><?= $doctor->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Дата приёма</label>
        <input type="date" name="appointment_date" min="<?= $currentDate ?>" value="<?= $currentDate ?>" required>
    </div>
    <div class="form-group">
        <label>Время приёма</label>
        <input type="time" name="appointment_time" value="09:00" required>
    </div>
    <div class="form-group">
        <label>Симптомы</label>
        <textarea name="symptoms" required minlength="20" maxlength="500"></textarea>
    </div>
    <button type="submit">Создать запись</button>
</form>
<a href="/hello">Назад к панели</a>

