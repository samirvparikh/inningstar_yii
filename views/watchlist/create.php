<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Watchlist $model */

$this->title = 'Create Watchlist';
$this->params['breadcrumbs'][] = ['label' => 'Watchlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="watchlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
