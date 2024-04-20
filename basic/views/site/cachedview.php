<?php if ($this->beginCache('cachedview')) { ?>
   <?php foreach ($models as $model): ?>
      <?= $model->id; ?>
      <?= $model->name; ?>
      <?= $model->email; ?>
      <br/>
   <?php endforeach; ?>
<?php $this->endCache(); } ?>
<?php echo "Count:", \app\models\User::find()->count(); ?>