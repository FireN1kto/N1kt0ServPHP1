<h2>Все записи</h2>
<?php foreach ($appointments as $appointment): ?>
    <div>
        <div>
            <h2><?= $appointment->title ?></h2>
            <div class ="data-appointment">
                <h2>Дата и время записи:</h2>
                <p><?= date('d.m.Y', strtotime($appointment->appointment_date)) ?></p>
            </div>
        </div>
        <div>
            <p><span>Пациент: </span>
                <?= htmlspecialchars(
                    $appointment->patient->surname . ' ' .
                    $appointment->patient->name
                ) ?></p>
            <p><span>Врач: </span>
                <?= htmlspecialchars(
                    $appointment->doctor->surname . ' ' .
                    $appointment->doctor->name
                ) ?></p>
            <p><span>Симптомы: </span><?= $appointment->symptoms ?></p>
        </div>
        <div>
            <p>Дата создания: <?= date('d.m.Y', strtotime($appointment->createInfo->create_date)) ?></p>
            <p>Создатель:
                <?= $appointment->createInfo && $appointment->createInfo->user
                    ? htmlspecialchars($appointment->createInfo->user->name)
                    : 'Неизвестно' ?>
            </p>
        </div>
    </div>
<?php endforeach; ?>
<div class="officer-menu">
    <a href="/hello">Назад к панели</a>
    <a href="/Filter">Перейти к фильтру</a>
</div>