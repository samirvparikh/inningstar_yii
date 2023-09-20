<?php

use app\models\Watchlist;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\WatchlistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Watchlists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="watchlist-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Watchlist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'scrip_name',
            'desired_per_share_price',
            'desired_profit',
            'date',
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'html',
                'value' => function ($model, $key, $index, $column) {
                    return ($model->status==1) ? 'Active' : "Inactive";
                }
            ],
            // 'status',
            //'ip_address',
            //'created_by',
            //'created_dt',
            //'updated_by',
            //'updated_dt',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Watchlist $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
