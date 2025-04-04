<h1><?= $message ?></h1>
<h2>Добро пожаловать <?= app()->auth::user()->name ?>!</h2>
<div>
    <a href="<?= app()->route->getUrl('/addAppointment') ?>">Создать запись</a>
    <a href="<?= app()->route->getUrl('/listAppointments') ?>">Список записей</a>
    <a href="<?= app()->route->getUrl('/create-patient') ?>">Создать пациента</a>
    <a href="<?= app()->route->getUrl('/create-doctor') ?>">Создать доктора</a>
    <a href="<?= app()->route->getUrl('/listPatients') ?>">Список пациентов</a>
    <a href="<?= app()->route->getUrl('/listDoctors') ?>">Список докторов</a>
</div>