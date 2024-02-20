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
<style>
.table{
    font-size:12px;
}
</style>
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
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'scrip_name',
            // 'desired_per_share_price',
            [
                'attribute' => 'desired_per_share_price',
                'label' => 'Per Share',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->desired_per_share_price;
                }
            ],        
            [
                'attribute' => 'desired_profit',
                'label' => 'Des. Profit',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->desired_profit;
                }
            ],            
            // 'desired_profit',
            [
                'attribute' => 'Days',
                'label' => 'Days',
                'format' => 'html',
                'value' => function ($model) {
                    $startDate = $model->date; // start date
                    $endDate = date('Y-m-d'); // end date
                    $date1 = new \DateTime($startDate);
                    $date2 = new \DateTime($endDate);
                    $interval = $date1->diff($date2);
                    $totalDays = ($interval->days <= 0) ? 1 : $interval->days + 1;
                    return $totalDays;
                }
            ],            
            // 'date',
            [
                'attribute' => 'date',
                'label' => 'Date',
                'format' => 'html',
                'value' => function ($model) {
                    return date("d-m-Y", strtotime($model->date));
                }
            ],
            // [
            //     'attribute' => 'status',
            //     'label' => 'Status',
            //     'format' => 'html',
            //     'value' => function ($model, $key, $index, $column) {
            //         return ($model->status==1) ? 'Active' : "Inactive";
            //     }
            // ],
            
            // 'status',
            //'ip_address',
            //'created_by',
            //'created_dt',
            //'updated_by',
            //'updated_dt',
            [
                'class' => ActionColumn::className(),
                'header' => 'Action',
                'contentOptions' => function ($model, $key, $index, $column) {
                        return ['style' => 'min-width:80px'];
                },
                'urlCreator' => function ($action, Watchlist $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
