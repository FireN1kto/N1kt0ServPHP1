<h2>Добавление нового пациента</h2>
<form method="post">
    <label>Фамилия: <input type="text" name="surname" value="" required></label>
    <label>Имя: <input type="text" name="name" value="" required></label>
    <label>Отчество: <input type="text" name="patronymic" value=""></label>
    <label>Дата рождения: <input type="date" name="dateOfBirth" value="" required></label>
    <div class="officer-menu">
        <button type="submit">Создать</button>
        <a href="/hello" class="back">Назад к панели</a>
    </div>
</form>
