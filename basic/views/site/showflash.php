<?php
use yii\helpers\Html;

// Check if the flash message exists before displaying it
if(Yii::$app->session->hasFlash('greeting')) {
    echo Html::tag('div', Yii::$app->session->getFlash('greeting'), ['class' => 'alert alert-success']);
}
?>
