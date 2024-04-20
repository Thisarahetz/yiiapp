<?php
    namespace app\models;
    use Yii;
    use yii\base\Model;
    class RegistrationForm extends Model {
        public $username;
      public $password;
      public $email;
      public $country;
      public $city;
      public $phone;

        public function rules() {
             return [
                [['username', 'password', 'email', 'country', 'city', 'phone'], 'required'],
                ['email', 'email'],
                ['phone', 'number'],
                ['username', 'required', 'message' => 'Please enter your name'],
                ['password', 'required', 'message' => 'Please enter your password'],
                ['email', 'required', 'message' => 'Please enter your email'],
                ['country', 'required', 'message' => 'Please enter your country'],
                ['city', 'required', 'message' => 'Please enter your city'],
                ['phone', 'required', 'message' => 'Please enter your phone'],
             ];
        }

        public function attributeLabels() {
            return [
                'username' => 'Username',
                'password' => 'Password',
                'email' => 'Email',
                'country' => 'Country',
                'city' => 'City',
                'phone' => 'Phone',
            ];
        }
        
    }
?>