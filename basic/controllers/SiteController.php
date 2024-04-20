<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\UploadImageForm;
use app\models\User;
use yii\web\View;
use yii\base\DynamicModel;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\data\Sort;
use app\components\Taxi;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\data\ArrayDataProvider;


class SiteController extends Controller
{
    // public $layout = "newlayout";
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        $model->scenario = ContactForm::SCENARIO_EMAIL_FROM_USER;
        if ($model->load(Yii::$app->request->post()) && $model->
           contact(Yii::$app->params ['adminEmail'])) {
              Yii::$app->session->setFlash('contactFormSubmitted');  
              return $this->refresh();
        }
        return $this->render('contact', [
           'model' => $model,
        ]);
     }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
//         $email = "admin@support.com";
//         $phone = "+78007898100";
//         return $this->render('about',[
//             'email' => $email,
//             'phone' => $phone
//    ]);
        \Yii::$app->view->on(View::EVENT_BEGIN_BODY, function () {
            echo date('m.d.Y H:i:s');
        });
        return $this->render('about');
    }


    public function actionSpeak($message = "default message") { 
        return $this->render("speak",['message' => $message]); 
    } 

    /**
     * Displays the contact model.
     *
     * This action is responsible for rendering and displaying the contact model.
     * It is typically used to show the contact form to the user.
     *
     * @return string The rendered view of the contact model.
     */
    public function actionShowContactModel() {

        // $mContactForm = new \app\models\ContactForm; 
        // $mContactForm->attributes = \Yii::$app->request->post('ContactForm')

        // $mContactForm = new \app\models\ContactForm; 
        // $postData = \Yii::$app->request->post('ContactForm', []); 
        // $mContactForm->name = isset($postData['name']) ? $postData['name'] : null; 
        // $mContactForm->email = isset($postData['email']) ? $postData['email'] : null; 
        // $mContactForm->subject = isset($postData['subject']) ? $postData['subject'] : null; 
        // $mContactForm->body = isset($postData['body']) ? $postData['body'] : null;

        $mContactForm = new \app\models\ContactForm();
        $mContactForm->name = "contactForm";
        $mContactForm->email = "user@gmail.com";
        $mContactForm->subject = "subject";
        $mContactForm->body = "body";
        // var_dump($mContactForm->attributes); 

        return \yii\helpers\Json::encode($mContactForm->attributes);
    }


    //widgets
    public function actionTestWidget() { 
        return $this->render('testwidget'); 
    }

    //request
    public function actionTestGet() {
            //the URL without the host
            var_dump(Yii::$app->request->url);
            
            //the whole URL including the host path
            var_dump(Yii::$app->request->absoluteUrl);
            
            //the host of the URL
            var_dump(Yii::$app->request->hostInfo);
            
            //the part after the entry script and before the question mark
            var_dump(Yii::$app->request->pathInfo);
            
            //the part after the question mark
            var_dump(Yii::$app->request->queryString);
            
            //the part after the host and before the entry script
            var_dump(Yii::$app->request->baseUrl);
            
            //the URL without path info and query string
            var_dump(Yii::$app->request->scriptUrl);
            
            //the host name in the URL
            var_dump(Yii::$app->request->serverName);
            
            //the port used by the web server
            var_dump(Yii::$app->request->serverPort);
        }

        public function actionTestResponse() {
            return $this->redirect('http://www.tutorialspoint.com/');
         }


        public function actionMaintenance() {
            echo "<h1>Maintenance</h1>";
        }

        public function actionRoutes() {
            return $this->render('routes');
        }

        public function actionRegistration() {
            // $mRegistration = new RegistrationForm();
            // return $this->render('registration', ['model' => $mRegistration]);
            $model = new RegistrationForm(); 
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request>post())) { 
                Yii::$app->response->format = Response::FORMAT_JSON; 
                return ActiveForm::validate($model); 
            } 
            return $this->render('registration', ['model' => $model]);
                    }

        public function actionAdHocValidation() {
                $model = DynamicModel::validateData([
                'username' => 'John',
                'email' => 'john@gmail.com'
                ], [
                [['username', 'email'], 'string', 'max' => 12],
                ['email', 'email'],
                ]);
                
                if ($model->hasErrors()) {
                var_dump($model->errors);
                } else {
                echo "success";
                }
        }


        //session
        public function actionOpenAndCloseSession() {
            $session = Yii::$app->session;
            // open a session
            $session->open();
            // check if a session is already opened
            if ($session->isActive) echo "session is active";
            // close a session
            $session->close();
            // destroys all data registered to a session
            $session->destroy();
        }


        public function actionAccessSession() {

                $session = Yii::$app->session;
                
                // set a session variable
                $session->set('language', 'ru-RU');
                
                // get a session variable
                $language = $session->get('language');
                var_dump($language);
                    
                // remove a session variable
                $session->remove('language');
                    
                // check if a session variable exists
                if (!$session->has('language')) echo "language is not set";
                    
                $session['captcha'] = [
                'value' => 'aSBS23',
                'lifetime' => 7200,
                ];
                var_dump($session['captcha']);
        }

        //flash
        public function actionShowFlash() {
            $session = Yii::$app->session;
            // set a flash message named as "greeting"
                $session->setFlash('greeting', 'Hello user!');
                return $this->render('showflash');
        }

        // actionReadCookies
        public function actionReadCookies() { 
            // get cookies from the "request" component 
            $cookies = Yii::$app->request->cookies; 
            // get the "language" cookie value 
            // if the cookie does not exist, return "ru" as the default value 
            $language = $cookies->getValue('language', 'ru'); 
            // an alternative way of getting the "language" cookie value 
            if (($cookie = $cookies->get('language')) !== null) { 
                $language = $cookie->value; 
            } 
            // you may also use $cookies like an array 
            if (isset($cookies['language'])) { 
                $language = $cookies['language']->value; 
            } 
            // check if there is a "language" cookie 
            if ($cookies->has('language')) echo "Current language: $language"; 
        }
        

        //send cookies
        public function actionSendCookies() { 
            // get cookies from the "response" component 
            $cookies = Yii::$app->response->cookies; 
            // add a new cookie to the response to be sent 
            $cookies->add(new \yii\web\Cookie([ 
                'name' => 'language', 
                'value' => 'ru-RU', 
            ])); 
            $cookies->add(new \yii\web\Cookie([
                'name' => 'username', 
                'value' => 'John', 
            ])); 
            $cookies->add(new \yii\web\Cookie([ 
                'name' => 'country', 
                'value' => 'USA', 
            ])); 
            } 

        //upload image
        public function actionUploadImage() {
            $model = new UploadImageForm();
            if (Yii::$app->request->isPost) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->upload()) {
                  // file is uploaded successfully
                    echo "File successfully uploaded";
                    return;
                }
            }
            return $this->render('upload', ['model' => $model]);
        }

        //formatting
        public function actionFormatter(){
            return $this->render('formatter');
        }


        public function actionPagination() {
            //preparing the query
            $query = User::find();
            // get the total number of users
            $count = $query->count();
            //creating the pagination object
            $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => 10]);
            //limit the query using the pagination and retrieve the users
            $models = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                    ->all();
            return $this->render('pagination', [
                'models' => $models,
                'pagination' => $pagination,
                ]);
            }


            public function actionSorting() {
                //declaring the sort object
                $sort = new Sort([
                    'attributes' => ['id', 'name', 'email'], 
                ]);
                //retrieving all users
                $models = User::find()
                    ->orderBy($sort->orders)
                    ->all();
                return $this->render('sorting', [
                    'models' => $models,
                    'sort' => $sort,
                ]);
            
    }


    public function actionProperties() {
        $object = new Taxi();
        // equivalent to $phone = $object->getPhone();
        $phone = $object->phone;
        var_dump($phone);
        // equivalent to $object->setLabel('abc');
        $object->phone = '79005448877';
        var_dump($object);
    }
        

    //data provider
    public function actionDataProvider(){
        $query = User::find();
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 2,
        ],
        ]);
        // returns an array of users objects
        $users = $provider->getModels();
        var_dump($users);
    }

    public function actionSqlDataProvider() {
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM user')->queryScalar();
        $provider = new SqlDataProvider([
           'sql' => 'SELECT * FROM user',
            'totalCount' => $count,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'attributes' => [
                'id',
                'name',
                'email',
            ],
        ],
        ]);
        // returns an array of data rows
        $users = $provider->getModels();
        var_dump($users);
    }

    //array data provider
    public function actionArrayDataProvider() {
        $data = User::find()->asArray()->all();
        $provider = new ArrayDataProvider([
        'allModels' => $data,
        'pagination' => [
            'pageSize' => 3,
        ],
        'sort' => [
            'attributes' => ['id', 'name'],
        ],
    ]);
   // get the rows in the currently requested page
    $users = $provider->getModels();
    var_dump($users);
    }


    ///widgets
    public function actionDataWidget() {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('datawidget', [
            'dataProvider' => $dataProvider
        ]);
    }

    //actionTestEvent
    public function actionTestEvent() {
        $model = new User();
        $model->name = "John";
        $model->email = "john@gmail.com";
        if($model->save()) {
            $model->trigger(MyUser::EVENT_NEW_USER);
        }
    }

    public function actionTestBehavior() {
        //creating a new user
        $model = new User();
        $model->name = "John";
        $model->email = "john@gmail.com";
        if($model->save()){
            var_dump(User::find()->asArray()->all());
        }
    }



    /**
     * This method is responsible for handling the test interface action.
     *
     * @return void
     */
    public function actionTestInterface() {
        // Method implementation goes here
        $container = new \yii\di\Container();
        $container->set
        ("\app\components\MyInterface","\app\components\First");
        $obj = $container->get("\app\components\MyInterface");
        $obj->test(); // print "First class"
        $container->set
                    ("\app\components\MyInterface","\app\components\Second");
        $obj = $container->get("\app\components\MyInterface");
        $obj->test(); // print "Second class"
    }


    public function actionTestDb(){
        // return a set of rows. each row is an associative array of column names and values.
        // an empty array is returned if the query returned no results
        $users = Yii::$app->db->createCommand('SELECT * FROM user LIMIT 5')
            ->queryAll();
        var_dump($users);
        echo "<br>";
        // return a single row (the first row)
        // false is returned if the query has no result
        $user = Yii::$app->db->createCommand('SELECT * FROM user WHERE id=1')
            ->queryOne();
        var_dump($user);
        echo "<br>";
        // return a single column (the first column)
        // an empty array is returned if the query returned no results
        $userName = Yii::$app->db->createCommand('SELECT name FROM user')
            ->queryColumn();
        var_dump($userName);
        echo "<br>";
        // return a scalar value
        // false is returned if the query has no result
        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM user')
            ->queryScalar();
        var_dump($count);
        }
        
        public function actionTestDb1() {
            $firstUser = Yii::$app->db->createCommand('SELECT * FROM user WHERE id = :id')
                ->bindValue(':id', 1)
                ->queryOne();
            var_dump($firstUser);
            $params = [':id' => 2, ':name' => 'User2'];
            $secondUser = Yii::$app->db->createCommand('SELECT * FROM user WHERE
                id = :id AND name = :name')
                ->bindValues($params)
                ->queryOne();
            var_dump($secondUser);
               //another approach
            $params = [':id' => 3, ':name' => 'User3'];
            $thirdUser = Yii::$app->db->createCommand('SELECT * FROM user WHERE
                id = :id AND name = :name', $params)
                ->queryOne();
            var_dump($thirdUser);
        }


            //transaction
            public function actionTestDb3(){
               // INSERT (table name, column values)
            Yii::$app->db->createCommand()->insert('user', [
                'name' => 'My New User',
                'email' => 'mynewuser@gmail.com',
            ])->execute();
               $user = Yii::$app->db->createCommand('SELECT * FROM user WHERE name = :name')
                ->bindValue(':name', 'My New User')
            ->queryOne();
            var_dump($user);
               // UPDATE (table name, column values, condition)
            Yii::$app->db->createCommand()->update('user', ['name' => 'My New User
                Updated'], 'name = "My New User"')->execute();
               $user = Yii::$app->db->createCommand('SELECT * FROM user WHERE name = :name')
                ->bindValue(':name', 'My New User Updated')
                ->queryOne();
            var_dump($user);
               // DELETE (table name, condition)
            Yii::$app->db->createCommand()->delete('user', 'name = "My New User
                Updated"')->execute();
               $user = Yii::$app->db->createCommand('SELECT * FROM user WHERE name = :name')
                ->bindValue(':name', 'My New User Updated')
                ->queryOne();
            var_dump($user);
            }
            
            //query builder
            public function actionTestDb4() {
                //generates "SELECT id, name, email FROM user WHERE name = 'User10';"
                // $user = (new \yii\db\Query())
                //    ->select(['id', 'name', 'email'])
                //    ->from('user')
                //    ->where(['name' => 'User10'])
                //    ->all();
                // var_dump($user);
            
                // $users = (new \yii\db\Query())
                // ->select(['id', 'name', 'email'])
                // ->from('user')
                // ->orderBy('name DESC')
                // ->all();
                // var_dump($users);

                // $user = (new \yii\db\Query())
                // ->select(['id', 'name', 'email'])
                // ->from('user')
                // ->where(['name' => 'User10'])
                // ->one();
                // var_dump($user);

                // $users = (new \yii\db\Query())
                // ->select(['id', 'name', 'email'])
                // ->from('user')
                // ->limit(5)
                // ->offset(5)
                // ->all();
                // var_dump($users);

                 // return a single user whose ID is 1
                // SELECT * FROM `user` WHERE `id` = 1
                // $user = User::find()
                // ->where(['id' => 1])
                // ->one();
                // var_dump($user);
                // // return the number of users
                // // SELECT COUNT(*) FROM `user`
                // $users = User::find()
                // ->count();
                // var_dump($users);
                // // return all users and order them by their IDs
                // // SELECT * FROM `user` ORDER BY `id`
                // $users = User::find()
                // ->orderBy('id')
                // ->all();
                // var_dump($users);

                // $user = MyUser::findOne(1);
                // var_dump($user);
                // // returns customers whose ID is 1,2,3, or 4
                // // SELECT * FROM `user` WHERE `id` IN (1,2,3,4)
                // $users = MyUser::findAll([1, 2, 3, 4]);
                // var_dump($users);
                // // returns a user whose ID is 5
                // // SELECT * FROM `user` WHERE `id` = 5
                // $user = MyUser::findOne([
                //     'id' => 5
                // ]);
                // var_dump($user);

                // insert a new row of data
                // $user = new User();
                // $user->name = 'MyCustomUser2';
                // $user->email = 'mycustomuser@gmail.com';
                // $user->save();
                // var_dump($user->attributes);
                
                // // update an existing row of data
                // $user = User::findOne(['name' => 'MyCustomUser2']);
                // $user->email = 'newemail@gmail.com';
                // $user->save();
                // var_dump($user->attributes);
                $user = User::findOne(2);
                if($user->delete()) {
                    echo "deleted";
                } 
        }

        public function actionTestCache() {
            $cache = Yii::$app->cache;
            // try retrieving $data from cache
            $data = $cache->get("my_cached_data");
            if ($data === false) {
               // $data is not found in cache, calculate it from scratch
                $data = date("d.m.Y H:i:s");
               // store $data in cache so that it can be retrieved next time
                $cache->set("my_cached_data", $data, 30);
            }
            // $data is available here
            var_dump($data);
            }

            public function actionQueryCaching() {
                $duration = 10;
                $result = User::getDb()->cache(function ($db) {
                    return User::find()->count();
                }, $duration);
                var_dump($result);
                $user = new User();
                $user->name = "cached user name";
                $user->email = "cacheduseremail@gmail.com";
                $user->save();
                echo "==========";
                var_dump(User::find()->count());
            }
}
