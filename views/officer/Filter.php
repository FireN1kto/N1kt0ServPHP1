<div class="filter-container">
    <div class="filter-sidebar">
        <h2>Фильтрация данных</h2>
        <form method="post">
            <div class="form-group">
                <label>Тип фильтра:</label>
                <select name="filter_type" id="filter-type" class="form-control">
                    <option value="appointments" <?= $filterType === 'appointments' ? 'selected' : '' ?>>Все записи</option>
                    <option value="patient_appointments" <?= $filterType === 'patient_appointments' ? 'selected' : '' ?>>Записи пациента</option>
                    <option value="doctor_schedule" <?= $filterType === 'doctor_schedule' ? 'selected' : '' ?>>Расписание врача</option>
                    <option value="patient_doctors" <?= $filterType === 'patient_doctors' ? 'selected' : '' ?>>Врачи пациента</option>
                </select>
            </div>
            <div id="filter-fields">
                <?php if ($filterType === 'patient_appointments'): ?>
                    <div class="form-group">
                        <label>Пациент:</label>
                        <select name="patient_id" class="form-control">
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?= $patient->id ?>">
                                    <?= htmlspecialchars("$patient->surname $patient->name $patient->patronymic") ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php elseif ($filterType === 'doctor_schedule'): ?>
                    <div class="form-group">
                        <label>Врач:</label>
                        <select name="doctor_id" class="form-control">
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor->id ?>">
                                    <?= htmlspecialchars("$doctor->surname $doctor->name $doctor->patronymic") ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Дата:</label>
                        <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>">
                    </div>
                <?php elseif ($filterType === 'patient_doctors'): ?>
                    <div class="form-group">
                        <label>Пациент:</label>
                        <select name="patient_id" class="form-control">
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?= $patient->id ?>">
                                    <?= htmlspecialchars("$patient->surname $patient->name $patient->patronymic") ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Применить фильтр</button>
        </form>
    </div>
    <div class="filter-content">
        <?php if (!empty($results)): ?>
            <?php if ($filterType === 'patient_doctors'): ?>
                <h3>Врачи пациента</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Специализация</th>
                        <th>Должность</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($results as $doctor): ?>
                        <tr>
                            <td><?= htmlspecialchars("$doctor->surname $doctor->name $doctor->patronymic") ?></td>
                            <td><?= htmlspecialchars($doctor->specialization) ?></td>
                            <td><?= htmlspecialchars($doctor->position->name ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h3>Результаты фильтрации</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Пациент</th>
                        <th>Врач</th>
                        <th>Симптомы</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($results as $appointment): ?>
                        <tr>
                            <td><?= date('d.m.Y', strtotime($appointment->appointment_date)) ?></td>
                            <td><?= $appointment->appointment_time ?></td>
                            <td><?= htmlspecialchars("{$appointment->patient->surname} {$appointment->patient->name}") ?></td>
                            <td><?= htmlspecialchars("{$appointment->doctor->surname} {$appointment->doctor->name}") ?></td>
                            <td><?= htmlspecialchars($appointment->symptoms) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">Выберите параметры фильтрации и нажмите "Применить"</div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('filter-type').addEventListener('change', function() {
        this.form.submit();
    });
</script>