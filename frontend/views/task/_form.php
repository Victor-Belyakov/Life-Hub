<?php

use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\AutoComplete;
use yii\web\JqueryAsset;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use common\models\Task;

/** @var yii\web\View $this */
/** @var common\models\Task $model */

?>

    <div class="task-form">
        <?php $form = ActiveForm::begin([
            'id' => 'task-form',
            'enableClientValidation' => true,
            'options' => ['data-pjax' => true],
        ]); ?>

        <div class="mb-3" style="color: #6c757d">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="mb-3" style="color: #6c757d">
            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
        </div>

        <div class="mb-3" style="color: #6c757d">
            <?= $form->field($model, 'priority')->dropDownList([
                Task::PRIORITY_LOW => 'Низкий',
                Task::PRIORITY_MEDIUM => 'Средний',
                Task::PRIORITY_HIGH => 'Высокий',
            ]) ?>
        </div>

        <div class="mb-3" style="color: #6c757d">
            <?php
            $dropdownParent = $model->isNewRecord ? '#createTaskModal' : '#updateTaskModal';
            ?>
            <?= $form->field($model, 'executor_id')->widget(Select2::class, [
                'options' => ['placeholder' => 'Выберите исполнителя...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'dropdownParent' => new JsExpression('jQuery("' . $dropdownParent . '")'),
                    'ajax' => [
                        'url' => Url::to(['user/executor-list']),
                        'dataType' => 'json',
                        'delay' => 250,
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                        'processResults' => new JsExpression('function(data) { return {results:data.items}; }'),
                        'cache' => true,
                    ],
                    'escapeMarkup' => new JsExpression('function(markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(data) { return data.text; }'),
                    'templateSelection' => new JsExpression('function(data) { return data.text; }'),
                ],
            ]) ?>
        </div>

        <div class="mb-3" style="color: #6c757d">
            <?= $form->field($model, 'deadline')->input('date', ['class' => 'datepicker form-control']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php

$this->registerCssFile('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/flatpickr', ['depends' => JqueryAsset::class]);
?>

<script>
    flatpickr(".datepicker", {
        dateFormat: "d-m-Y",
        maxDate: "today",
        locale: "ru"
    });
</script>
