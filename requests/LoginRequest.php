<?php
namespace requests;

class LoginRequest extends Request
{
    private string $email;
    private string $password;
    private array|bool $user;

    public function __construct()
    {
        parent::__construct();
    }

    public function setData(string $email, string $password, array|bool $user): void
    {
        $this->email = $email;
        $this->password = $password;
        $this->user = $user;
    }

    public function inputs(): array
    {
        return [
            'email'     => $this->email,
            'password'  => $this->password,
        ];
    }

    public function rules(): array
    {
        $user = $this->user;

        return [
            'email'     => [
                'required',
                'email',
                function ($value) use ($user) {
                    return isset($user['email']) ? true : 'Користувача не знайдено';
                },
            ],
            'password'  => [
                'required',
                'min:6',
                function ($value) use ($user) {

                    if (!isset($user['password'])) {
                        return false;
                    }

                    if (password_verify($value, $user['password'])) {
                        return true;
                    }

                    return 'Невірно вказаний пароль.';
                }
            ],
        ];
    }
}
