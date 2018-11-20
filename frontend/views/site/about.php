<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(); ?>

<?php

echo \peng\evaluation\RadioButtonMatrix::widget([
    'id' => 'self-evalution',
    'questions' => ['Strength of Mind', 'Open Communication', 'Leadership',
        'Understanding', 'Teamwork', 'Integrity', 'Originality', 'Notification',
    ],
    'scale' => ['min' => 0, 'max' => 5],
    'sections' => ['2015 Scores', '2016 Scores'],
    'enableComment' => true,
]);

?>

<?= $form->field($model, 'comments') ?>

<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>

