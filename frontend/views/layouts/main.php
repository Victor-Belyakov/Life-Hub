<?php
/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\NavBar;

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
        body {
            background-color: #f5f5f5;
            color: #212529;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #fff !important;
            box-shadow: inset 0 -2px 5px -2px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #dee2e6;
        }

        #sidebar {
            position: fixed;
            top: 56px; /* высота navbar */
            left: 0;
            width: 220px;
            height: calc(100vh - 56px);
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            box-shadow: inset -3px 0 6px -3px rgba(0,0,0,0.08);
            transition: width 0.25s ease;
            overflow-x: hidden;
        }

        #sidebar.collapsed {
            width: 65px;
            box-shadow: inset -2px 0 5px -3px rgba(0,0,0,0.06);
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #sidebar ul li {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #2b2f32;
            cursor: pointer;
            transition: background-color 0.15s ease, color 0.15s ease;
        }

        #sidebar ul li:hover {
            color: #0a0a0a;
        }

        #sidebar ul li i {
            margin-right: 15px;
            font-size: 20px;
            min-width: 20px;
            text-align: center;
        }

        #sidebar.collapsed ul li span {
            display: none;
        }

        #content {
            margin-left: 220px;
            padding: 20px;
            transition: margin-left 0.25s ease;
            background-color: #fff;
            box-shadow: inset 0 0 10px -6px rgba(0,0,0,0.1);
            min-height: calc(100vh - 56px);
        }

        #content.expanded {
            margin-left: 65px;
        }

        #sidebarToggleBtn {
            width: 100%;
            padding: 10px 20px;
            border: none;
            background-color: transparent;
            color: #495057;
            cursor: pointer;
            font-weight: 600;
            text-align: left;
            user-select: none;
        }

        #sidebarToggleBtn:hover {
            background-color: #e9ecef;
        }

        .btn-link.logout {
            color: #0d6efd !important;
            font-size: 1.3rem;
        }

        .btn-link.logout:hover {
            color: #0a58ca !important;
        }


    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => ' <div class="d-flex align-items-center" style="padding-left: 30px;">
            <button class="btn btn-link text-info p-0" style="font-weight: 700; font-size: 2rem; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3); text-decoration: none; cursor: pointer;"> Life Hub </button>
        </div>',
        'brandUrl' => Yii::$app->homeUrl,
        'renderInnerContainer' => false,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top d-flex justify-content-between',
            'style' => 'height:56px;',
        ],
    ]);
    ?>

    <div class="d-flex align-items-center" style="margin-left: auto;">
        <?= Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-flex align-items-center']) ?>
        <?= Html::submitButton(
            '<i class="bi bi-box-arrow-right" style="color: #0dcaf0; font-size: 24px;"></i>',
            [
                'class' => 'btn btn-link logout text-decoration-none p-0',
                'title' => 'Выйти',
                'data-bs-toggle' => 'tooltip',
            ]
        ) ?>
        <?= Html::endForm() ?>
    </div>


    <?php NavBar::end(); ?>
</header>

<div id="sidebar">

    <ul>
        <li><i class="bi bi-book-fill text-info" ></i> <a href="" style="color: inherit; text-decoration: none; cursor: pointer;">Журнал</a></li>
        <li><i class="bi bi-calendar-check-fill text-info"></i> <a href="" style="color: inherit; text-decoration: none; cursor: pointer;">Задачи</a></li>
        <li><i class="bi bi-list-task text-info"></i> <a href="" style="color: inherit; text-decoration: none; cursor: pointer;">Статьи</a></li>
        <li><i class="bi bi-piggy-bank-fill text-info"></i> <a href="" style="color: inherit; text-decoration: none; cursor: pointer;">Финансы</a></li>
        <li><i class="bi bi-people-fill text-info"></i> <a href="/user/index" style="color: inherit; text-decoration: none; cursor: pointer;">Пользователи</a></li>
        <li><i class="bi bi-folder-fill text-info"></i> <a href="" style="color: inherit; text-decoration: none; cursor: pointer;">Справочники</a></li>
    </ul>
</div>

<main id="content">
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

    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const toggleBtn = document.getElementById('sidebarToggleBtn');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
