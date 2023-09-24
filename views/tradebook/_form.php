<?php

//use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\Common;

/** @var yii\web\View $this */
/** @var app\models\Tradebook $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tradebook-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'watchlist_id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput(['class'=>'form-control txt']) ?>

    <?= $form->field($model, 'price')->textInput(['class'=>'form-control txt']) ?>

    <?= $form->field($model, 'amount')->textInput(['readonly'=>'readonly']) ?>

    <?= $form->field($model, 'date')->textInput(['value' => date('Y-m-d')]) ?>

    



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('keyup', '#tradebook-quantity', function() {
            calculateSum();
        });
        
        $(document).on('keyup', '#tradebook-price', function() {
            var quantity = $('#tradebook-quantity').val();
            var price = $('#tradebook-price').val();
            var amount = quantity * price;
            // $('#tradebook-amount').val(amount);
            // $("#tradebook-amount").val(amount.toFixed(2));
            calculateSum();
        });
        

        function calculateSum() {
            var sum = 1;
            //iterate through each textboxes and add the values
            $(".txt").each(function() {
                //add only if the value is number
                if (!isNaN(this.value) && this.value.length != 0) {
                    console.log(this.value);
                    sum = parseFloat(sum) * parseFloat(this.value);
                    $(this).css("background-color", "#FEFFB0");
                } else if (this.value.length != 0) {
                    $(this).css("background-color", "red");
                }
            });

            $("input#tradebook-amount").val(sum.toFixed(2));
        }
    });
</script>