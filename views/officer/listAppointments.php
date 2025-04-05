<h2>Все записи</h2>
<?php foreach ($appointments as $appointment): ?>
    <div>
        <div>
            <h2><?= $appointment->title ?></h2>
            <div class ="data-appointment">
                <h2>Дата и время записи:</h2>
                <p><?= $appointment-> appointment_date ?></p>
                <p><?= $appointment-> appointment_time ?></p>
            </div>
        </div>
        <div>
            <p><span>Пациент: </span><?= $appointment->patient->name ?></p>
            <p><span>Врач: </span><?= $appointment->doctor->name ?></p>
            <p><span>Симптомы: </span><?= $appointment->symptoms ?></p>
        </div>
        <div>
            <p>Дата создания: <?= $appointment->createInfo->creation_date ?></p>
            <p>Создатель: <?= $appointment->createInfo->user_id->name ?></p>
        </div>
    </div>
<?php endforeach; ?>
<a href="/hello">Назад к панели</a>