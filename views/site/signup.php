<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="post">
    <label>Имя <input type="text" name="name"></label>
    <label>Логин <input type="text" name="login"></label>
    <label>Пароль <input type="password" name="password"></label>
    <div>
        <label>Роль:</label>
        <select id="role_id" name="role_id" <?= !$allowAdmin ? "disabled" : ""; ?>>
            <?php foreach ($roles as $role): ?>
                <?php if ($role->name_role === 'admin' && !$allowAdmin) continue ?>
                <?php if ($role->name_role === 'registration_officer') continue; ?>
                <option value="<?= $role->id ?>" <?= ($role->name_role === 'user' && !$allowAdmin) ? "selected" : ""?>>
                    <?= match($role->name_role) {
                        'admin' => 'Администратор',
                        'user' => 'Посетитель',
                        default => $role->name_role
                    } ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button>Регистрация</button>
</form>