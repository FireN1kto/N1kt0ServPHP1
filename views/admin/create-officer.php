<h2>Добавление сотрудника регистратуры</h2>
<form method="post" class="create-officer">
    <label>ФИО: <input type="text" name="name" required></label>
    <label>Логин: <input type="text" name="login" required></label>
    <label>Пароль: <input type="password" name="password" required></label>
    <button type="submit">Создать</button>
</form>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $field => $errorMessages): ?>
                <?php foreach ($errorMessages as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<div class="admin-menu">
    <a href="/officers-list">Назад к списку</a>
    <a href="/hello">Назад к панели</a>
</div>