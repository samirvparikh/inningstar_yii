<?php

// use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\models\Common;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var app\models\Watchlist $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="watchlist-form">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'scrip_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'current_price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'desired_per_share_price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'desired_profit')->textInput(['maxlength' => true]) ?>

            

            <!-- <?= $form->field($model, 'status')->textInput() ?> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group <?php echo (isset($errors["status"]) ? 'error' : '') ?>">
                        <div class="material_input_block">
                            <?= $form->field($model, 'status')->dropDownList(Common::getStatusArray(), ['class' => 'select2 select2-hidden-accessible']); ?>
                        </div>
                        <?php if (isset($errors["status"])) { ?>
                            <span class="input-required">
                                <i class="material-icons"><small data-material-icon=""></small></i><span><?php echo $errors["status"] ?></span>
                            </span>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
