<?php
/** @var \yii\web\View $this */

/** @var string $content */

use app\widgets\SidebarWidget;
use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
$hasAccess = !Yii::$app->user->isGuest && !empty(Yii::$app->user->identity->role);
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
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<?php if ($hasAccess): ?>
    <?= SidebarWidget::widget() ?>

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

<?php
$mainClass = '';

if (Yii::$app->user->isGuest) {
    $mainClass = 'guest-content';
} elseif (empty(Yii::$app->user->identity->role)) {
    $mainClass = 'no-role-content';
} else {
    $mainClass = 'auth-content';
}
?>

<main id="content" class=" <?= $mainClass ?>">
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
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
