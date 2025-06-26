<?php
/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #6c757d;
        }

        .auth-content {
            margin-left: 220px;
            padding: 20px;
            background-color: #fff;
            min-height: calc(100vh - 56px);
            transition: margin-left 0.25s ease;
        }

        /* Для гостей — центрирование содержимого */
        .guest-content {
            margin: 0 auto;
            padding: 40px 20px;
            max-width: 400px; /* или ширина формы авторизации */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: transparent;
        }
        .no-role-content {
            margin: 0 auto;
            padding: 40px 20px;
            max-width: 800px; /* или ширина формы авторизации */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: transparent;
        }
        #profile {
            color: #6c757d;
        }
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            box-shadow: inset -3px 0 6px -3px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
        }
        #sidebar .logo {
            height: 60px;
            padding: 10px;
            font-weight: 700;
            font-size: 1.75rem;
            color: #0dcaf0;
            text-align: center;
            user-select: none;
        }
        #sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            flex-grow: 1;
            overflow-y: auto;
        }
        #sidebar ul li {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #6c757d;
            cursor: pointer;
            transition: background-color 0.15s ease, color 0.15s ease;
            border-left: 4px solid transparent;
        }
        #sidebar ul li:hover {
            color: #0dcaf0;
        }
        #sidebar ul li:hover i,
        #sidebar ul li:hover a {
            color: #0dcaf0;
        }
        #sidebar ul li.active {
            color: #0dcaf0;
            border-left-color: #0dcaf0;
        }
        #sidebar ul li.active i,
        #sidebar ul li.active a {
            color: #0dcaf0;
        }
        #sidebar ul li i,
        #sidebar ul li a {
            color: inherit;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        /* Навбар сверху, сдвинут вправо на ширину меню */
        #navbar {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            height: 60px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            padding: 0 20px;
            color: #000;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.20);
            z-index: 1000;
        }

        #navbar .logout-button {
            margin-left: auto;
        }

        /* Контент ниже навбара, с отступом слева под меню */
        #main-content {
            margin-top: 60px;
            margin-left: 220px;
            padding: 20px;
            min-height: calc(100vh - 60px);
            background-color: #fff;
            box-shadow: inset 0 0 10px -6px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .btn-link.logout {
            color: #0dcaf0 !important;
            font-size: 1.3rem;
        }
        .btn-link.logout:hover {
            color: #0a58ca !important;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<?php if (!Yii::$app->user->isGuest && !empty(Yii::$app->user->identity->role)): ?>
    <nav id="sidebar">
        <div class="logo">
            <a href="<?= Yii::$app->homeUrl ?>" style="color: inherit; text-decoration: none;">Life Hub</a>
        </div>

        <ul>
<!--            <li class="--><?php //= Yii::$app->controller->id == 'journal' ? 'active' : '' ?><!--">-->
<!--                <i class="bi bi-book-fill"></i>-->
<!--                <a href="/journal/index">Журнал</a>-->
<!--            </li>-->
            <li class="<?= Yii::$app->controller->id == 'task' ? 'active' : '' ?>">
                <i class="bi bi-calendar-check-fill"></i>
                <a href="/task/index">Задачи</a>
            </li>
<!--            <li class="--><?php //= Yii::$app->controller->id == 'article' ? 'active' : '' ?><!--">-->
<!--                <i class="bi bi-list-task"></i>-->
<!--                <a href="/article/index">Статьи</a>-->
<!--            </li>-->
<!--            <li class="--><?php //= Yii::$app->controller->id == 'finance' ? 'active' : '' ?><!--">-->
<!--                <i class="bi bi-piggy-bank-fill"></i>-->
<!--                <a href="/finance/index">Финансы</a>-->
<!--            </li>-->
            <li class="<?= Yii::$app->controller->id == 'user' ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i>
                <a href="/user/index">Пользователи</a>
            </li>
            <li class="<?= Yii::$app->controller->id == 'reference' ? 'active' : '' ?>">
                <i class="bi bi-folder-fill"></i>
                <a href="/reference/index">Справочники</a>
            </li>
        </ul>
    </nav>

    <header id="navbar">
        <?= Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-flex align-items-center logout-button']) ?>

        <div id="profile" class="me-3"><?= Yii::$app->user->identity->fullName ?? '' ?></div>

        <?= Html::submitButton(
            '<i class="bi bi-box-arrow-right ml-2" style="color: #0dcaf0; font-size: 24px;"></i>',
            [
                'class' => 'btn btn-link logout text-decoration-none p-0',
                'title' => 'Выйти',
                'data-bs-toggle' => 'tooltip',
            ]
        ) ?>
        <?= Html::endForm() ?>
    </header>
<?php endif; ?>


<main id="content" class=" <?= Yii::$app->user->isGuest
        ? 'guest-content'
        : (empty(Yii::$app->user->identity->role)
            ? 'no-role-content'
            : 'auth-content')
    ?>">
    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ru.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        maxDate: "today",
        locale: "ru"
    });

    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
