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
