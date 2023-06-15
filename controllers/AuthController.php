<?php
namespace controllers;

use databases\Sql;
use helpers\TemplateRenderer;
use JetBrains\PhpStorm\NoReturn;
use middlewares\AuthenticationMiddleware;
use requests\LoginRequest;
use requests\RegisterRequest;
use services\UserService;

class AuthController extends BaseController
{
    use AuthenticationMiddleware;

    protected UserService $userService;
    private LoginRequest $request;
    private $validation;
    private Sql $user;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->request = new LoginRequest();
        $this->user = new Sql();
    }

    public function prepareRegister(): string
    {
        $this->isUserLoggedIn();

        $title = 'Завдання та проекти | Реєстрація нового користувача';

        return TemplateRenderer::execute('register.php', [
            'title' => $title,
        ] + $this->params($this->validation));
    }

    public function register()
    {
        $this->isUserLoggedIn();

        $request = new RegisterRequest();
        $sql = 'INSERT INTO users (name, email, password, created_at)
                VALUES (:name, :email, :password, CURRENT_DATE)';

        $request->setData($_POST['name'], $_POST['email'], $_POST['password'], $_POST['password_confirmation']);
        $this->validation = $request->afterValidation();


        if (!$this->validation->fails()) {
            $validated = $this->validation->getValidData();

            $data = [
                ':name'     => $validated['name'],
                ':email'    => $validated['email'],
                ':password' => password_hash($validated['password'], PASSWORD_DEFAULT),
            ];

            $this->user->query($sql, $data);

            $currentUser = $this->userService->findByEmail($validated['email']);
            $this->loggedIn($currentUser['id'], $currentUser['name'], $currentUser['email']);
        }
    }

    public function prepareLogin(): string
    {
        $this->isUserLoggedIn();

        return TemplateRenderer::execute('auth.php', $this->params($this->validation));
    }


    #[NoReturn]
    public function login()
    {
        $this->isUserLoggedIn();

        $user = $this->userService->findByEmail($_POST['email']);

        $this->request->setData($_POST['email'], $_POST['password'], $user);
        $this->validation = $this->request->afterValidation();

        if (!$this->validation->fails()) {
            $this->loggedIn($user['id'], $user['name'], $user['email']);
        }
    }


    public function logout()
    {
        $this->handle();

        session_unset();
        session_destroy();

        header("Location: /");
    }
}
