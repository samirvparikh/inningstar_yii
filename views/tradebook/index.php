<?php

use app\models\Tradebook;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\TradebookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tradebooks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tradebook-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tradebook', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'watchlist_id',
            'quantity',
            'price',
            'amount',
            //'date',
            //'status',
            //'ip_address',
            //'created_by',
            //'created_dt',
            //'updated_by',
            //'updated_dt',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tradebook $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
