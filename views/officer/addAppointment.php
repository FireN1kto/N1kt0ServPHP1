<h2>Добавление новой записи</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>Название записи: </label>
        <input type="text" name="title" value="<?= $old['title'] ?? '' ?>" required minlength="15" maxlength="255">
    </div>
    <div class="form-group">
        <label>Пациент: </label>
        <select name="patient_id" required>
            <option value=" ">--Выберите пациента--</option>
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient->id ?>"
                        <?= ($old['patient_id'] ?? '') == $patient->id ? 'selected' : '' ?>><?= $patient->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Врач: </label>
        <select name="patient_id" required>
            <option value=" ">--Выберите врача--</option>
            <?php foreach ($doctors as $doctor): ?>
                <option value="<?= $doctor->id ?>"
                    <?= ($old['doctor_id'] ?? '') == $doctor->id ? 'selected' : '' ?>><?= $doctor->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label>Дата приёма</label>
        <input type="date" name="appointment_date" min="<?= $currentDate ?>" value="<?= $old['appointment_date'] ?? $currentDate ?>" required>
    </div>
    <div class="form-group">
        <label>Время приёма</label>
        <input type="date" name="appointment_time" value="<?= $old['appointment_date'] ?? '09:00' ?>" required>
    </div>
    <div class="form-group">
        <label>Симптомы</label>
        <textarea name="symptoms" required minlength="20" maxlength="500"><?= $old['symptoms'] ?? '' ?></textarea>
    </div>
    <button type="submit">Создать запись</button>
</form>
