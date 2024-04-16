<?php 
   namespace app\controllers; 
   use yii\web\Controller; 
   class ExampleController extends Controller { 

    public function actions() { 
         return [ 
            'greeting' => 'app\components\GreetingAction' 
         ]; 
      }

      public function actionIndex() { 
         $message = "index action of the ExampleController"; 
         return $this->render("example",[ 
            'message' => $message 
         ]); 
      } 
      public function actionHelloWorld() { 
         $message = "Hello World"; 
         return $this->render("example",[ 
            'message' => $message 
         ]); 
      }

      public function actionOpenGoogle() { 
         return $this->redirect('http://www.google.com'); 
      }

      public function actionTestParams($first, $second) {
        return "$first $second";
     }
   } 
?>