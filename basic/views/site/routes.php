<?php
   use yii\helpers\Url;
?>

<h4>
   <b>Url::to(['post/index']):</b>
   <?php
      // creates a URL to a route: /index.php?r = post/index
      echo Url::to(['post/index']);
   ?>
</h4>

<h4>
   <b>Url::to(['post/view', 'id' => 100]):</b>
   <?php
      // creates a URL to a route with parameters: /index.php?r = post/view&id=100
      echo Url::to(['post/view', 'id' => 100]);
   ?>
</h4>

<h4>
   <b>Url::to(['post/view', 'id' => 100, '#' => 'content']):</b>
   <?php
      // creates an anchored URL: /index.php?r = post/view&id=100#content
      echo Url::to(['post/view', 'id' => 100, '#' => 'content']);
   ?>
</h4>

<h4>
   <b>Url::to(['post/index'], true):</b>
   <?php
      // creates an absolute URL: http://www.example.com/index.php?r=post/index
      echo Url::to(['post/index'], true);
   ?>
</h4>

<h4>
   <b>Url::to(['post/index'], 'https'):</b>
   <?php
      // creates an absolute URL using the https scheme: https://www.example.com/index.php?r=post/index
      echo Url::to(['post/index'], 'https');
   ?>
</h4>