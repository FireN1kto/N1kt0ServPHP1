<h2>Добавление новой записи</h2>
<form method="post" class="create-appointment" enctype="multipart/form-data">
    <div class="form-group">
        <label>Название записи: </label>
        <input type="text" name="title" value="" required minlength="15" maxlength="255">
    </div>
    <div class="form-group">
        <label for="patient_id">Пациент:</label>
        <select name="patient_id" required>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient->id ?>">
                    <?= htmlspecialchars($patient->surname . ' ' . $patient->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="doctor_id">Врач:</label>
        <select name="doctor_id" required>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor->id ?>">
                    <?= htmlspecialchars($doctor->surname . ' ' . $doctor->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Дата приёма</label>
        <input type="date" name="appointment_date" min="<?= $currentDate ?>" value="<?= $currentDate ?>" required>
    </div>
    <div class="form-group">
        <label>Симптомы</label>
        <textarea name="symptoms" required minlength="20" maxlength="500"></textarea>
    </div>
    <div class="form-group">
        <label>Фото диагноза:</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/gif">
        <small>Допустимые форматы: JPG, PNG, GIF</small>
    </div>
    <div class="officer-menu">
        <button type="submit">Создать запись</button>
        <a href="/hello" class="back">Назад к панели</a>
    </div>
</form>