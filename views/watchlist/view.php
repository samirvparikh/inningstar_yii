<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Watchlist $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Watchlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$startDate = $model->date; // Your first date
$endDate = date('Y-m-d'); // Your second date

$date1 = new DateTime($startDate);
$date2 = new DateTime($endDate);

$interval = $date1->diff($date2);
$totalDays = ($interval->days<=0) ? 1 : $interval->days;
$desiredProfit = $totalDays * $model->desired_profit;

?>
<div class="watchlist-view">

    <h1>#<?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-lg-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'scrip_name',
                    'desired_per_share_price',
                    'desired_profit',
                    [
                        'attribute' => 'date',
                        'format' => 'html',
                        'label' => 'Date',
                        'value' => function ($data) {
                            return date('d-M-Y', strtotime($data['date']));
                        },
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'total_days')->textInput(['maxlength' => true, 'value'=>$totalDays]) ?>
            <?= $form->field($model, 'total_desired_profit')->textInput(['maxlength' => true, 'value'=>$desiredProfit]) ?>
            <?= $form->field($model, 'current_price')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
                <?= Html::button('Calculate', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <!-- <div class="col-lg-12">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td>Scrip Name: <?= ($model->scrip_name) ? $model->scrip_name : '' ?></td>
                        <td>Desired Per Share Price: <?= ($model->desired_per_share_price) ? $model->desired_per_share_price : '' ?></td>
                        <td>Desired Profit: <?= ($model->desired_profit) ? $model->desired_profit : '' ?></td>
                        <td>Date: <?= ($model->date) ? date('d-M-Y', strtotime($model->date)) : '' ?></td>
                    </tr>
                </tbody>
            </table>
        </div> -->
        <div class="col-lg-12">

        </div>

    </div>


</div>