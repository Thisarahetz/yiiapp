<?php
   namespace app\controllers;
   use yii\web\Controller;
   use app\models\User;
   class CustomController extends Controller {
      // public function actionGreet() {
      //    return $this->render('greet');
      // }
      public function actionHello() {
         return $this->render('hello');
      }
      public function actionIndex() {
         return $this->render('index');
      }
      public function actionWorld() {
         return $this->render('world');
      }

      public function actionView() {
         $model = new User();
         return $this->render('customview', [
            'model' => $model,
         ]);
      }
   }
?>