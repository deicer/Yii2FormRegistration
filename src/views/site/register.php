<?php

use app\models\RegistrationForm;
use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model RegistrationForm */
/* @var $form ActiveForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(
    '/css/form.css',
    ['depends' => [BootstrapAsset::className()]]
);

?>
<div class="register">
    <div class="container">
        <?php $form = ActiveForm::begin(
            [
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnType' => false,
                'validateOnChange' => false,
                'validateOnSubmit' => true,
                'options' => ['class' => 'reg-form'],
                'errorCssClass' => ''
            ]
        );
        ?>

        <?= $form->errorSummary($model, ['header' => ' ', 'footer' => null]) ?>
        <label class="control-label">Ваше имя</label>
        <div class="l-row">
            <div class="l-row__element">
                <?= $form->field(
                    $model,
                    'name',
                    ['template' => "{label}\n{input}"]
                )->textInput(
                    ['autofocus' => true, 'placeholder' => 'Имя',]
                )->label(false) ?>
            </div>
            <div class="l-row__element">
                <?= $form->field(
                    $model,
                    'lastname',
                    ['template' => "{label}\n{input}"]
                )->textInput(
                    ['placeholder' => 'Фамилия']

                )->label(false) ?>
            </div>
        </div>
        <?= $form->field($model, 'sex')->radioList(
            [
                0 => 'Женщина',
                1 => 'Мужчина',
            ],
            ['value' => 0]
        ) ?>
        <label class="control-label">Дата рождения</label>
        <div class="l-row">
            <div class="l-row__element l-row__element--33">
                <?= $form->field($model, 'day_of_birth')->dropDownList(
                    range(1, 31),
                    ['prompt' => 'День']
                )->label(false) ?>
            </div>
            <div class="l-row__element l-row__element--33">
                <?= $form->field($model, 'month_of_birth')->dropDownList(
                    range(1, 12),
                    ['prompt' => 'Месяц']
                )->label(false) ?>
            </div>
            <div class="l-row__element l-row__element--33">
                <?= $form->field($model, 'year_of_birth')->dropDownList(
                    range(1919, 2005),
                    ['prompt' => 'Год']
                )->label(false) ?>
            </div>
        </div>
        <label class="control-label">Номер телефона</label>
        <?= $form->field(
            $model,
            'phone',
            ['template' => "{label}\n{input}"]
        )->widget(
            PhoneInput::className(),
            [
                'jsOptions' => [
                    'preferredCountries' => ['ru', 'ua'],
                    'separateDialCode' => true,

                ]
            ]
        )->label(false) ?>
        <label class="control-label">Ваш e-mail</label>
        <?= $form->field(
            $model,
            'email',
            ['template' => "{label}\n{input}"]
        )->textInput(
            ['placeholder' => 'На этот адрес мы отправим пароль']
        )->label(false) ?>

        <?= $form->field($model, 'acceptRules')->checkBox(
            [
                'label' => 'Я принимаю условия пользовательского  <a href="https://astro7.ru/info/public-agreement/" target="_blank">соглашения</a>',
                'class' => 'reg-form__checkbox',
                'value' => 1,
                'uncheckValue' => 0
            ]
        ) ?>


        <div class="form-group">
            <?= Html::submitButton(
                'Зарегистрироваться',
                ['class' => 'reg-form__button btn btn-primary']
            ) ?>
        </div>
        <p class="safe">Astro7.ru заботится о безопасности. Наши серверы надёжно
            защищены.
            Данные вашей регистрации являются строго конфиденциальными, не
            передаются третьим лицам и не публикуются</p>
        <?php ActiveForm::end(); ?>

    </div>
</div>
