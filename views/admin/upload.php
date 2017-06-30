<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>
<?= $form->field($model, 'postid')->textInput(['name'=>'postid'])->label('Post ID') ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>