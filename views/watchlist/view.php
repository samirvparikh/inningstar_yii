<?php

use app\models\Tradebook;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\DetailView;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;

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
$totalDays = ($interval->days <= 0) ? 1 : $interval->days + 1;
$desiredProfit = $totalDays * $model->desired_profit;
// echo $data['scrip_name'];
?>
<div class="watchlist-view">

    <h1>#<?= Html::encode($this->title) ?>
        <span class="float-end">
            <?= Html::a('+Add Trade', ['tradebook/create', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </span>
    </h1>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'scrip_name',
                    [
                        'attribute' => 'date',
                        'format' => 'html',
                        'label' => 'Date',
                        'value' => function ($data) {
                            return date('d-M-Y', strtotime($data['date']));
                        },
                    ],
                    'desired_per_share_price',
                    'desired_profit',                    
                ],
            ]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'total_days')->textInput(['value' => $totalDays]) ?>
            <?= $form->field($model, 'total_desired_profit')->textInput(['value' => $desiredProfit]) ?>
            <?= $form->field($model, 'desired_per_share_price')->textInput() ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'current_price')->textInput() ?>            
            <div class="d-flex align-items-center p-3 my-3 text-white rounded shadow-sm" style="background: linear-gradient(-222.93deg, #06c0e3 0%, #f39200 100%)">
                <div class="lh-1">
                    <h1 class="h6 mb-0 text-white lh-1">Required Stock: <?= $data['required_stock'] ?></h1>
                    <br/>
                    <h1 class="h6 mb-0 text-white lh-1">Required Amount: Rs.<?php echo number_format(ceil($data['required_stock']*$model->current_price),2); ?></h1>
                </div>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'id')->hiddenInput(['value' => $model->id])->label(false) ?>
                <?= Html::button('Calculate', ['class' => 'btn btn-success calculate']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="row">
    <?= GridView::widget([
        'dataProvider' => $dataProviderTradebook,
        // 'filterModel' => $searchModelTradebook,
        'showFooter' => true,
        'footerRowOptions'=>['style'=>'font-weight:bold; text-align: right;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'watchlist_id',
            // 'quantity',
            // 'price',
            // 'amount',
            'date',
            [
                'attribute' => 'quantity',
                'format' => 'raw',
                'contentOptions'=>array('style' => 'text-align: right'),
                'footer' => Tradebook::getTotal($dataProviderTradebook->models, 'quantity'),
            ],
            [
                'attribute' => 'price',
                'format' => ['currency', 'INR'],
                'contentOptions'=>array('style' => 'text-align: right'),
                'footer' => Tradebook::getTotalPrice($dataProviderTradebook->models, 'quantity', 'amount'),
            ],
            [
                'attribute' => 'amount',
                'format' => ['currency', 'INR'],
                'contentOptions'=>array('style' => 'text-align: right'),
                'footer' => Tradebook::getTotalAmount($dataProviderTradebook->models, 'amount'),
            ],
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Tradebook $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
            [ 'class' => 'yii\grid\ActionColumn' ,
                'header' => 'Actions' ,
                'template'=>'{view}',
                'buttons'=>[
                    'view'=>function($url,$data, $model){
                    $html = 'Delete';
                    return Html::a($html,["tradebook/delete-trade",'id'=>$data->id, 'watchlist_id'=>$data->watchlist_id]);
                    }
                ],
            ] ,
        ],
    ]); ?>
    </div>
</div>
</div>


<!-- Calculate Modal -->
<div class="modal fade" id="calculateModal" tabindex="-1" aria-labelledby="calculateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calculateModalLabel"><?= $model->scrip_name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p id="responce"></p>
                </div>
                <div class="d-flex align-items-center p-3 my-3 text-white rounded shadow-sm" style="background: linear-gradient(-222.93deg, #06c0e3 0%, #f39200 100%)">
                    <div class="lh-1">
                        <h1 class="h6 mb-0 text-white lh-1" >Required Stock: <span id="required_stock"></span></h1>
                        <br/>
                        <h1 class="h6 mb-0 text-white lh-1">Required Amount: Rs.<span id="required_amount"></span></h1>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.calculate', function() {
            var formData = {
                watchlist_id: $('#watchlist-id').val(),
                total_days: $('#watchlist-total_days').val(),
                total_desired_profit: $('#watchlist-total_desired_profit').val(),
                desired_per_share_price: $('#watchlist-desired_per_share_price').val(),
                current_price: $('#watchlist-current_price').val(),
            };
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl . '/index.php?r=watchlist/calculate' ?>',
                data: formData,
                type: "POST",
                success: function(response) {
                    var data = JSON.parse(response);
                    $('#required_stock').html(data.required_stock);
                    $('#required_amount').html(data.required_amount);
                    $('#calculateModal').modal('show');
                },
                error: function() {
                    console.log("failure");
                }
            });
        });
    });
</script>