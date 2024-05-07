
<div class="wellcome">
    <?php if ($registered): ?>
        <h3>Привет, <?= $login ?>! Вы успешно зарегистрировались!<h3>
    <?php endif ?>
    <?php if ($authorized): ?>
        <h3>Привет, <?= $login ?>! Вы успешно авторизовались!<h3>
    <?php endif ?>
</div>
<h3><b>Анкета</b></h3>
<form method="post">
    <div>
        <p>Username в социальной сети:</p>
        <p>   
            <input type="text" name="messenger" value="<?= !empty($questions->messenger) ? $questions->messenger : ""?>">
            <?php if (!empty($errors["messenger"])): ?>
                <div class="error"><?= $errors["messenger"]; ?></div>
            <?php endif ?>
        </p>
        <p>
            <input type="radio" id="twitter" name="messengerType" value="twitter" <?= $questions->messengerType === "twitter" ? "checked" : "" ?>>
            <label for="twitter">Twitter</label>
            <input type="radio" id="telegram" name="messengerType" value="telegram" <?= $questions->messengerType === "telegram" ? "checked" : ""?>>
            <label for="telegram">Telegram</label>
            <?php if (!empty($errors["messengerType"])): ?>
                <div class="error"><?= $errors["messengerType"]; ?></div>
            <?php endif ?>
        </p>
    </div>
    <p>Местоположение:</p>
    <select type="select" name="location">
        <option value="23" <?= $questions->location === "23" ? "selected" : ""?>>Краснодарский край</option>
        <option value="61" <?= $questions->location === "61" ? "selected" : ""?>>Ростовская область</option>
        <option value="77" <?= $questions->location === "77" ? "selected" : ""?>>Москва</option>
    </select>
    <p>Вопрос 1:</p>
    <select type="select" name="question1">
        <option value="1" <?= $questions->question1 === "1" ? "selected" : ""?>>Вариант 1</option>
        <option value="2" <?= $questions->question1 === "2" ? "selected" : ""?>>Вариант 2</option>
        <option value="3" <?= $questions->question1 === "3" ? "selected" : ""?>>Вариант 3</option>
    </select>
    <p>Вопрос 2:</p>
    <select type="select" name="question2">
        <option value="1" <?= $questions->question2 === "1" ? "selected" : ""?>>Вариант 1</option>
        <option value="2" <?= $questions->question2 === "2" ? "selected" : ""?>>Вариант 2</option>
        <option value="3" <?= $questions->question2 === "3" ? "selected" : ""?>>Вариант 3</option>
    </select>
    <h3><b>Настройки</b></h3>
    <p>Желаемый % совпадений для выдачи результатов:
        <input type="number" name="pctMatch" value="<?= !empty($questions->pctMatch) ? $questions->pctMatch : ""?>">
        <?php if (!empty($errors["pctMatch"])): ?>
            <div class="error"><?= $errors["pctMatch"]; ?></div>
        <?php endif ?>
    </p>
    <p>
        <input type="radio" id="showShort" name="showQuestions" value="showShort" <?= $questions->showQuestions === "showShort" ? "checked" : ""?>>
        <label for="twitter">Отображать всем совпадающим краткую анкету</label>
        <input type="radio" id="showShort" name="showQuestions" value="showFullPct" <?= $questions->showQuestions === "showFullPct" ? "checked" : ""?>>
        <label for="telegram">Отображать полную анкету только совпадающим на 50% и выше</label>
        <input type="radio" id="showShort" name="showQuestions" value="showFull" <?= $questions->showQuestions === "showFull" ? "checked" : ""?>>
        <label for="telegram">Отображать всем совпадающим полную анкету</label>
        <?php if (!empty($errors["showQuestions"])): ?>
            <div class="error"><?= $errors["showQuestions"]; ?></div>
        <?php endif ?>
    </p>
    <p>Игнорировать местоположение<input type="checkbox" name="ignoreLocation" value="1" <?= $questions->ignoreLocation === 1 ? "checked" : 0?>></p>
    <p><button type="submit" name="send_form">Сохранить</button></p>
    <?php if ($saved): ?>
        <div class="success"><?= "Данные успешно сохранены!"; ?></div>
    <?php endif ?>
    <p><a href="product.php" name="search">Поиск</a></p>
    <p><button type="submit" name="delete_form">Удалить анкету</button></p>
</form>