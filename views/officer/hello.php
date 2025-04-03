<h1><?= $message ?></h1>
<h2>Добро пожаловать <?= app()->auth::user()->name ?>!</h2>
<div>
    <a href="<?= app()->route->getUrl('/addAppointment') ?>">Создать запись</a>
    <a href="<?= app()->route->getUrl('/listAppointments') ?>">Список записей</a>
</div>