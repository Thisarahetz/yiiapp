<?php

namespace app\models;

use Yii;
use app\components\UppercaseBehavior;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 */
class User extends \yii\db\ActiveRecord
{
    const EVENT_NEW_USER = 'new-user';

    public function fields() {
        return [
        'id',
        'name',
           //PHP callback
        'datetime' => function($model) {
            return date("d:m:Y H:i:s");
        }
        ];
    }

    public function extraFields() {
        return ['email'];
    }

    public function behaviors() {
        return [
            // anonymous behavior, behavior class name only
            UppercaseBehavior::className(),
        ];
    }

    public function init() {
        $this->on(self::EVENT_NEW_USER, [$this, 'sendMailToAdmin']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }

    public function sendMailToAdmin($event) {
        echo 'mail sent to admin using the event';
     }
}

// class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
// {
//     public $id;
//     public $username;
//     public $password;
//     public $authKey;
//     public $accessToken;

//     private static $users = [
//         '100' => [
//             'id' => '100',
//             'username' => 'admin',
//             'password' => 'admin',
//             'authKey' => 'test100key',
//             'accessToken' => '100-token',
//         ],
//         '101' => [
//             'id' => '101',
//             'username' => 'demo',
//             'password' => 'demo',
//             'authKey' => 'test101key',
//             'accessToken' => '101-token',
//         ],
//     ];


//     /**
//      * {@inheritdoc}
//      */
//     public static function findIdentity($id)
//     {
//         return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
//     }

//     /**
//      * {@inheritdoc}
//      */
//     public static function findIdentityByAccessToken($token, $type = null)
//     {
//         foreach (self::$users as $user) {
//             if ($user['accessToken'] === $token) {
//                 return new static($user);
//             }
//         }

//         return null;
//     }

//     /**
//      * Finds user by username
//      *
//      * @param string $username
//      * @return static|null
//      */
//     public static function findByUsername($username)
//     {
//         foreach (self::$users as $user) {
//             if (strcasecmp($user['username'], $username) === 0) {
//                 return new static($user);
//             }
//         }

//         return null;
//     }

//     /**
//      * {@inheritdoc}
//      */
//     public function getId()
//     {
//         return $this->id;
//     }

//     /**
//      * {@inheritdoc}
//      */
//     public function getAuthKey()
//     {
//         return $this->authKey;
//     }

//     /**
//      * {@inheritdoc}
//      */
//     public function validateAuthKey($authKey)
//     {
//         return $this->authKey === $authKey;
//     }

//     /**
//      * Validates password
//      *
//      * @param string $password password to validate
//      * @return bool if password provided is valid for current user
//      */
//     public function validatePassword($password)
//     {
//         return $this->password === $password;
//     }
// }