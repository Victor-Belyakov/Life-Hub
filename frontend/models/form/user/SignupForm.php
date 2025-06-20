<?php

namespace frontend\models\form\user;

use common\models\User;
use yii\base\Model;

class SignupForm extends Model
{
    /**
     * @var string
     */
    public string $first_name = '';

    /**
     * @var string
     */
    public string $last_name = '';

    /**
     * @var string
     */
    public string $middle_name = '';

    /**
     * @var string
     */
    public string $birth_date = '';

    /**
     * @var string
     */
    public string $email = '';

    /**
     * @var string
     */
    public string $password = '';

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['email', 'first_name', 'last_name', 'birth_date', 'password'], 'required', 'message' => 'Поле {attribute} обязательно для заполнения.'],
            ['email', 'email'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'min' => 2],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'birth_date' => 'Дата рождения',
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    /**
     * @return User
     */
    public function toUser(): User
    {
        $date = \DateTime::createFromFormat('d-m-Y', $this->birth_date);

        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->middle_name = $this->middle_name;
        $user->birth_date = $date->format('Y-m-d');
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user;
    }
}
