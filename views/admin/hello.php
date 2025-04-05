<h1><?= $message ?></h1>
<h2>Добро пожаловать <?= app()->auth::user()->name ?>!</h2>
<div class="admin-nav">
    <a href="<?= app()->route->getUrl('/create-officer') ?>">Добавить сотрудника</a>
    <a href="<?= app()->route->getUrl('/officers-list') ?>">Список сотрудников</a>
</div>