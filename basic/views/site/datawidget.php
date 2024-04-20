<?php
    use yii\widgets\DetailView;
    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
        'id',
         //formatted as html
        'name:html',
        [
            'label' => 'e-mail',
            'value' => $model->email,
        ],
    ],
 ]);
?>