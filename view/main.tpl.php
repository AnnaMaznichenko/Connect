<!doctype html>
<head>
    <title><?= $title ?></title>
</head>
<body>
    <div class="logout"><a href="/ae/logout.php">Выйти из аккаунта</a></div>
    <?= $content ?>
    <style>
        .error {
            color: red;
        }
        .success{
            color: green;
        }
    </style>
</body>