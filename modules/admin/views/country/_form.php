<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use app\models\Continent;

/* @var $this yii\web\View */
/* @var $model app\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 2]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => 255]) ?>

    <?php /* $form->field($model, 'continent_code')->textInput(['maxlength' => 2]) */ ?>
	
	<?= $form->field($model, 'continent_code')->widget(Select2::classname(), [
			'data' => Continent::getAllContinentsList(),
			'attribute' => 'continent_code',
			'options' => ['placeholder' => 'Select a continent...']
		]);
	?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
