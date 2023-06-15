<?php
namespace requests;

class RegisterRequest extends Request
{
    private string $name;
    private string $email;
    private string $password;
    private string $password_confirmation;

    public function __construct()
    {
        parent::__construct();
    }

    public function setData(string $name, string $email, string $password, string $password_confirmation): void
    {
        $this->name                     = $name;
        $this->email                    = $email;
        $this->password                 = $password;
        $this->password_confirmation    = $password_confirmation;
    }

    public function inputs(): array
    {
        return [
            'name'                  => $this->name,
            'email'                 => $this->email,
            'password'              => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ];
    }

    public function rules(): array
    {
        return [
            'name'      => [
                'required',
                'alpha',
            ],
            'email'     => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password'  => [
                'required',
                'min:6',
            ],
            'password_confirmation' => [
                'required',
                'same:password'
            ]
        ];
    }
}
