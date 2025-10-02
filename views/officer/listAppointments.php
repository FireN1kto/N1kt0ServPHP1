<h2>Все записи</h2>

<div class="filters">
    <div class="filter-group">
        <h3>Выбор записи по пациенту(ам)</h3>
        <label for="patientFilter">Выберите пациента:</label>
        <select id="patientFilter">
            <option value="">Все пациенты</option>
            <?php
            $patients = [];
            foreach ($appointments as $appointment) {
                $patients[$appointment->patient->id] = htmlspecialchars($appointment->patient->surname . ' ' . $appointment->patient->name);
            }
            foreach ($patients as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Фильтр по дате и врачу -->
    <div class="filter-group">
        <h3>Выбор пациентов по врачу и дате</h3>
        <label for="doctorDateFilter">Врач:</label>
        <select id="doctorDateFilter">
            <option value="">Все врачи</option>
            <?php
            $doctors = [];
            foreach ($appointments as $appointment) {
                $doctors[$appointment->doctor->id] = htmlspecialchars($appointment->doctor->surname . ' ' . $appointment->doctor->name);
            }
            foreach ($doctors as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <div class="filter-group">
            <label for="dateFilter">Дата:</label>
            <input type="date" id="dateFilter">
        </div>
    </div>

    <!-- Фильтр по врачу для пациента -->
    <div class="filter-group">
        <h3>Выбор врача(ей) по пациенту</h3>
        <label for="patientForDoctorFilter">Выберите пациента:</label>
        <select id="patientForDoctorFilter">
            <option value="">Выберите пациента</option>
            <?php foreach ($patients as $id => $name): ?>
                <option value="<?= $id ?>"><?= $name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- Список записей -->
<div id="appointmentsList">
    <?php foreach ($appointments as $appointment): ?>
        <?php
        $doctorName = htmlspecialchars($appointment->doctor->surname . ' ' . $appointment->doctor->name);
        $patientName = htmlspecialchars($appointment->patient->surname . ' ' . $appointment->patient->name);
        $date = date('Y-m-d', strtotime($appointment->appointment_date));
        ?>
        <div class="appointment-card"
             data-doctor-id="<?= $appointment->doctor_id ?>"
             data-patient-id="<?= $appointment->patient_id ?>"
             data-appointment-date="<?= $date ?>">
            <div>
                <h2><?= $appointment->title ?></h2>
                <div class="data-appointment">
                    <h2>Дата и время записи:</h2>
                    <p><?= date('d.m.Y H:i', strtotime($appointment->appointment_date)) ?></p>
                </div>
            </div>
            <div>
                <p><span>Пациент: </span><?= $patientName ?></p>
                <p><span>Врач: </span><?= $doctorName ?></p>
                <p><span>Симптомы: </span><?= $appointment->symptoms ?></p>
            </div>
            <?php if ($appointment->image): ?>
                <div class="image">
                    <p><span>Фото диагноза:</span></p>
                    <img src="<?= $appointment->image ?>"
                         alt="Фото диагноза"
                         style="max-width: 300px; max-height: 300px; border: 1px solid #ccc; padding: 5px;">
                    <br>
                    <a href="<?= $appointment->image ?>" target="_blank">Открыть в полном размере</a>
                </div>
            <?php else: ?>
                <p><span>Фото диагноза:</span> не прикреплено</p>
            <?php endif; ?>
            <div>
                <p>Дата создания: <?= date('d.m.Y', strtotime($appointment->createInfo->create_date)) ?></p>
                <p>Создатель:
                    <?= $appointment->createInfo && $appointment->createInfo->user
                        ? htmlspecialchars($appointment->createInfo->user->name)
                        : 'Неизвестно' ?>
                </p>
            </div>
            <!-- Кнопка удаления через POST, без скрытого поля -->
            <div>
                <form action="/listAppointments" method="POST"
                      onsubmit="return confirm('Вы уверены, что хотите отменить эту запись?');">
                    <button type="submit" name="delete_appointment_id" value="<?= $appointment->id ?>">
                        Отменить запись
                    </button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function filterAppointments() {
        const patientId = document.getElementById('patientFilter').value;
        const doctorDateFilter = document.getElementById('doctorDateFilter').value;
        const dateFilter = document.getElementById('dateFilter').value;
        const patientForDoctorId = document.getElementById('patientForDoctorFilter').value;

        const cards = document.querySelectorAll('.appointment-card');

        cards.forEach(card => {
            const cardDoctorId = card.getAttribute('data-doctor-id');
            const cardPatientId = card.getAttribute('data-patient-id');
            const cardDate = card.getAttribute('data-appointment-date');

            let show = true;

            // Если активирован фильтр "врачи пациента"
            if (patientForDoctorId) {
                show = cardPatientId === patientForDoctorId;
            }
            // Иначе применяем другие фильтры
            else {
                if (patientId && cardPatientId !== patientId) show = false;
                if (doctorDateFilter && cardDoctorId !== doctorDateFilter) show = false;
                if (dateFilter && cardDate !== dateFilter) show = false;
            }

            card.style.display = show ? 'block' : 'none';
        });
    }

    // Подписываемся на изменения всех фильтров
    document.getElementById('patientFilter').addEventListener('change', filterAppointments);
    document.getElementById('doctorDateFilter').addEventListener('change', filterAppointments);
    document.getElementById('dateFilter').addEventListener('change', filterAppointments);
    document.getElementById('patientForDoctorFilter').addEventListener('change', filterAppointments);

    // Запускаем фильтр при загрузке страницы
    window.addEventListener('DOMContentLoaded', filterAppointments);
</script>

<div class="officer-menu">
    <a href="/hello">Назад к панели</a>
</div>