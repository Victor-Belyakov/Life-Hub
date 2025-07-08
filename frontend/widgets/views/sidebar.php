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

    <ul class="nav flex-column">
        <?php foreach ($menuItems as $item): ?>
            <?php if (!isset($item['permission']) || Yii::$app->user->can($item['permission'])): ?>
                <?php if (isset($item['items'])): ?>
                    <!-- Пункт с подпунктами (выпадающее меню) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenu-<?= md5($item['label']) ?>"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi <?= $item['icon'] ?>"></i> <?= $item['label'] ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu-<?= md5($item['label']) ?>">
                            <?php foreach ($item['items'] as $subItem): ?>
                                <?php if (!isset($subItem['permission']) || Yii::$app->user->can($subItem['permission'])): ?>
                                    <li>
                                        <a class="dropdown-item <?= Yii::$app->controller->id === ltrim($subItem['url'][0], '/') ? 'active' : '' ?>"
                                           href="<?= Url::to($subItem['url']) ?>">
                                            <?= $subItem['label'] ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Обычный пункт -->
                    <li class="nav-item">
                        <a class="nav-link <?= Yii::$app->controller->id === ltrim($item['url'][0], '/') ? 'active' : '' ?>"
                           href="<?= Url::to($item['url']) ?>">
                            <i class="bi <?= $item['icon'] ?>"></i> <?= $item['label'] ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

</nav>
