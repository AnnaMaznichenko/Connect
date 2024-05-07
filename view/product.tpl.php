<?php
$locations = [
    "23" => "Краснодарский край",
    "61" => "Ростовская область",
    "77" => "Москва"
];

$question1 = [
    "1" => "Вариант 1",
    "2" => "Вариант 2",
    "3" => "Вариант 3"
];

$question2 = [
    "1" => "Вариант 1",
    "2" => "Вариант 2",
    "3" => "Вариант 3"
];
?>

<div><a href="/ae/questions.php">Вернуться к анкете</a></div>
<div>
    <?php if (!$userQuestionsExists): ?>
        <h3>Вернитесь к анкете и убедитесь, что сохранили данные.</h3>
    <?php elseif (empty($searchResult->getMatches())): ?>
        <h3>К сожалению, по заданным настройкам никто не найден. Вы можете отредактировать анкету и попробовать еще раз.</h3>
    <?php else: ?>
        </b><h3>
        <h3><b>Ваши ответы совпадают минимум на <?= $searchResult->getUserQuestions()->pctMatch ?>% со следующими пользователями:</b></h3>
        <?php foreach($searchResult->getMatches() as $scoredQuestions): ?>
            <?php if (($scoredQuestions->getQuestions()->showQuestions === "showShort") ||
                (($scoredQuestions->getQuestions()->showQuestions === "showFullPct") && $scoredQuestions->getScore() < 50)): ?>
                    <div>
                        <?= $scoredQuestions->getScore() ?>% :<br>
                        <?= $scoredQuestions->getQuestions()->messenger ?> (<?= $scoredQuestions->getQuestions()->messengerType ?>)<br>
                        Местоположение: <?= $locations[$scoredQuestions->getQuestions()->location] ?>
                        <br><br>
                    </div>
            <?php endif; ?>
            <?php if (($scoredQuestions->getQuestions()->showQuestions === "showFull") ||
                (($scoredQuestions->getQuestions()->showQuestions === "showFullPct") && $scoredQuestions->getScore() >= 50)): ?>
                    <div>
                        <?= $scoredQuestions->getScore() ?>% :<br>
                        <?= $scoredQuestions->getQuestions()->messenger ?> (<?= $scoredQuestions->getQuestions()->messengerType ?>)<br>
                        Местоположение: <?= $locations[$scoredQuestions->getQuestions()->location] ?><br>
                        Вопрос 1: <?= $question1[$scoredQuestions->getQuestions()->question1] ?><br>
                        Вопрос 2: <?= $question2[$scoredQuestions->getQuestions()->question2] ?><br>
                        <br><br>
                    </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>