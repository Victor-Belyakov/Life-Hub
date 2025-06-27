<?php
use yii\helpers\Url;

/**
 * @var $menuItems
 */

?>

<nav id="sidebar">
    <div class="logo">
        <a href="<?= Yii::$app->homeUrl ?>" style="color: inherit; text-decoration: none;">Life Hub</a>
    </div>

    <ul>
        <?php foreach ($menuItems as $item): ?>
            <?php if (Yii::$app->user->can($item['permission'])): ?>
                <li class="<?= Yii::$app->controller->id === ltrim($item['url'][0], '/') ? 'active' : '' ?>">
                    <i class="bi <?= $item['icon'] ?>"></i>
                    <a href="<?= Url::to($item['url']) ?>">
                        <?= $item['label'] ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
