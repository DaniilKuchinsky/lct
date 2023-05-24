<?php

namespace core\forms\auth;

use yii\base\Model;

class EmailForm extends Model
{
    public ?string $email = null;

    public ?string $password = null;

    public bool $rememberMe = true;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => "Пожалуйста, укажите email"],
            ['email', 'email'],
            ['email', 'string', 'min' => 2, 'max' => 250],

            ['password', 'trim'],
            ['password', 'required', 'message' => "Пожалуйста, укажите пароль"],
            ['password', 'string', 'min' => 2, 'max' => 20],

            ['rememberMe', 'safe'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'email'      => 'Email',
            'password'   => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    public function attributePlaceholders(): array
    {
        return [
            'password'   => 'Пароль',
            'email'      => 'Email',
        ];
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getPlaceholderName(string $name): ?string
    {
        $types = self::attributePlaceholders();
        if (array_key_exists($name, $types)) {
            return $types[ $name ];
        }

        return null;
    }
}