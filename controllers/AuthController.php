<?php
namespace controllers;

use helpers\TemplateRenderer;
use JetBrains\PhpStorm\NoReturn;
use middlewares\AuthenticationMiddleware;
use requests\LoginRequest;
use services\UserService;

class AuthController extends BaseController
{
    use AuthenticationMiddleware;

    protected UserService $userService;
    private LoginRequest $request;
    private $validation;
    private $authMiddleware;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->request = new LoginRequest();
    }

    public function prepareLogin(): string
    {
        $params = [
            'errors'    => null,
            'oldValues' => null
        ];

        if (isset($this->validation)) {
            $params = [
                'errors' => $this->validation->errors()->toArray(),
                'oldValues' => $this->validation->getValidatedData(),
            ];
        }

        return TemplateRenderer::execute('auth.php', $params);
    }


    #[NoReturn]
    public function login()
    {
        $user = $this->userService->findByEmail($_POST['email']);

        $this->request->setData($_POST['email'], $_POST['password'], $user);
        $this->validation = $this->request->afterValidation();

        if (!$this->validation->fails()) {
            $_SESSION['user']['id'] = $user['id'];
            $_SESSION['user']['name'] = $user['name'];
            $_SESSION['user']['email'] = $user['email'];

            header("Location: /");
            exit();
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
