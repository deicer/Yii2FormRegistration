<?php

namespace app\models;

use borales\extensions\phoneInput\PhoneInputValidator;
use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{
    public $name;
    public $lastname;
    public $email;
    public $phone;
    public $sex;
    public $year_of_birth;
    public $month_of_birth;
    public $day_of_birth;
    public $acceptRules = true;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Укажите имя'],
            ['name', 'trim'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['lastname', 'required', 'message' => 'Укажите фамилию'],
            ['lastname', 'trim'],
            ['lastname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required', 'message' => 'Укажите e-mail'],
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [
                'email',
                'unique',
                'targetClass' => '\app\models\User',
                'message' => 'Этот e-mail адрес уже используется',
            ],

            ['phone', 'required', 'message' => 'Укажите номер телефона'],
            ['phone', 'trim'],
            [['phone'], 'string'],
            [
                ['phone'],
                PhoneInputValidator::className(),
                'message' => 'Формат телефона неверный'
            ],

            [
                ['phone'],
                'unique',
                'targetClass' => '\app\models\User',
                'message' => 'Этот телефон уже используется',
            ],

            ['sex', 'required', 'message' => 'Укажите ваш пол'],
            ['sex', 'boolean'],


            ['year_of_birth', 'required', 'message' => 'Укажите год рождения'],
            [
                'month_of_birth',
                'required',
                'message' => 'Укажите месяц рождения'
            ],
            ['day_of_birth', 'required', 'message' => 'Укажите день рождения'],


            [
                'acceptRules',
                'compare',
                'compareValue' => 1,
                'message' => 'Ознакомьтесь с Правилами использования сервиса'
            ],


        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'lastname' => 'Фамилия',
            'email' => 'Ваш E-mail',
            'phone' => 'Номер телефона',
            'sex' => 'Пол',
        ];
    }


    public function sendPassword(string $email, string $password)
    {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(
                [Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']]
            )
            ->setReplyTo([$this->email => $this->name])
            ->setSubject('Ваш пароль')
            ->setTextBody(
                'Ваш пароль для входа в учетную запись - ' . $password
            )
            ->send();
    }

    public function registration()
    {
        if ($this->validate()) {
            $user = new User();
            $user->email = $this->email;
            $user->phone = $this->phone;
            $user->name = $this->name;
            $user->lastname = $this->lastname;
            $user->sex = $this->sex;
            $user->year_of_birth = $this->year_of_birth;
            $user->month_of_birth = $this->month_of_birth;
            $user->day_of_birth = $this->day_of_birth;

            $password = $this->generatePassword();
            $user->password_hash = password_hash($password, PASSWORD_DEFAULT);


            if ($user->save()) {
                $this->sendPassword($user->email,$password);
                return $user;
            }
        }

        return false;
    }

    private function generatePassword()
    {
            $length = 12;
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password = '';

            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[mt_rand(0, strlen($characters)-1)];
            }

            return $password;
    }
}
