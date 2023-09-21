<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tradebook $model */

$this->title = 'Create Tradebook';
$this->params['breadcrumbs'][] = ['label' => 'Tradebooks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tradebook-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
