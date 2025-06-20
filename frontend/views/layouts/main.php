<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
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
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    if (Yii::$app->user->isGuest) {
        echo '';
    } else {
        NavBar::begin([
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-light fixed-top',
            ],
        ]);

        $menuItems = [];

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);

        echo Html::beginForm(['/auth/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                '<span style="filter: drop-shadow(0 0 1px #0dcaf0);">
                        <i class="bi bi-box-arrow-right" style="color: #0dcaf0; font-size: 30px;"></i>
                    </span>',
                [
                    'class' => 'btn btn-link logout text-decoration-none p-0',
                    'title' => 'Выйти',
                    'data-bs-toggle' => 'tooltip',
                ]
            )

            . Html::endForm();

        NavBar::end();
    }
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
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

    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
