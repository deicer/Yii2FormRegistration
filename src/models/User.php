<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $email
 * @property string $phone
 * @property string $name
 * @property boolean $sex
 * @property string $lastname
 * @property string $password_hash
 * @property int $created_at
 * @property int $updated_at
 * @property int $year_of_birth;
 * @property int $month_of_birth;
 * @property int $day_of_birth;
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public static function findByUsername(string $email)
    {
        return self::find()->where('email = :email',[':email' => $email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'email',
                    'phone',
                    'name',
                    'lastname',
                    'password_hash',
                ],
                'required'
            ],
            [[ 'created_at', 'updated_at'], 'integer'],
            [
                ['email', 'phone', 'name', 'lastname', 'password_hash'],
                'string',
                'max' => 255
            ],
            ['email', 'unique','message' =>'Указанный e-mail уже используется'],
            ['phone', 'unique','message' =>'Указанный телефон уже используется'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'phone' => 'Phone',
            'name' => 'Name',
            'sex' => 'Sex',
            'lastname' => 'Lastname',
            'password_hash' => 'Password Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => [
                        'created_at',
                        'updated_at'
                    ],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    public function validatePassword(string $password)
    {
        return password_verify($password, $this->password_hash) ? true : false;
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
        // TODO: Implement findIdentity() method.
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        // TODO: Implement getId() method.
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
