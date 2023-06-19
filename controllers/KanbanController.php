<?php

namespace controllers;

use databases\Sql;
use helpers\ErrorHandler;
use helpers\GlobalArrayHandler;
use helpers\ProjectHandler;
use helpers\TemplateRenderer;
use middlewares\AuthenticationMiddleware;
use requests\StoreTaskRequest;
use requests\UpdateTaskStatus;
use services\AddTaskFormTemplateService;
use services\MainSidebarTemplateService;
use services\MainTemplateService;
use services\NavbarTemplateService;
use services\ProjectService;
use services\TaskService;

class KanbanController extends BaseController
{
    use AuthenticationMiddleware;

    protected MainTemplateService $mainTemplate;
    protected AddTaskFormTemplateService $addTaskFormTemplateService;
    protected MainSidebarTemplateService $mainSideBar;
    protected NavbarTemplateService $navbarService;
    protected ProjectService $projectService;
    protected TaskService $taskService;
    protected Sql $task;
    private StoreTaskRequest $request;
    private $validation;

    public function __construct()
    {
        $this->mainTemplate                 = new MainTemplateService();
        $this->addTaskFormTemplateService   = new AddTaskFormTemplateService();
        $this->projectService               = new ProjectService();
        $this->taskService                  = new TaskService();
        $this->task                         = new Sql();
        $this->request                      = new StoreTaskRequest();
        $this->mainSideBar                  = new MainSidebarTemplateService();
        $this->navbarService                = new NavbarTemplateService();
    }

    public function index(): string
    {
        $title = 'Завдання та проекти | Дошка';
        $body = $this->mainTemplate->render();

        if (ProjectHandler::isExists($this->projectService->getAll(), 'project_id') === false) {
            ErrorHandler::setStatus('404');
        }

        return TemplateRenderer::execute('layout.php', [
            'title' => $title,
            'body' => $body
            ]);
    }

    public function create(): string
    {
        $this->handle();
        $title = 'Завдання та проекти | Створити задачу';

        $body = TemplateRenderer::execute('addTaskForm.php', [
            'mainSidebar'   => $this->mainSideBar->render(),
            'navbar'        => $this->navbarService->render(),
            'projects'      => $this->projectService->getAll(),
            'projectId'     => GlobalArrayHandler::getStringToInt('project_id'),
        ] + $this->params($this->validation));

        return TemplateRenderer::execute('layout.php', [
            'title' => $title,
            'body' => $body
        ]);
    }

    public function store()
    {
        $this->handle();
        $filename = null;

        $sql = 'INSERT INTO tasks(title, `description`, project_id, deadline, `file`, user_id, created_at)
                VALUES (:title, :description, :project_id, :deadline, :file, :user_id, CURRENT_DATE)';


        if (!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $tmpFileName = $_FILES['file']['tmp_name'];
            $originFileName = $_FILES['file']['name'];
            $getExt = explode(".", $originFileName);
            $ext = end($getExt);

            $filename = md5(uniqid(rand(), true)) . '.' . $ext;

            if (!move_uploaded_file($tmpFileName, 'storage/' . $filename)) {
                die('Виникла помилка при завантаженні файлу.');
            }
        }

        $this->request->setData(
            $_POST['title'],
            $_POST['description'],
            $_POST['project'],
            $_POST['deadline'],
        );

        $this->validation = $this->request->afterValidation();

        if (!$this->validation->fails()) {
            $validated = $this->validation->getValidData();

            $data = [
                ':title'        => $validated['title'],
                ':description'  => $validated['description'],
                ':project_id'   => $validated['project'],
                ':deadline'     => $validated['deadline'] === '' ? null : $validated['deadline'],
                ':file'         => $filename,
                ':user_id'      => $_SESSION['user']['id'],
            ];

            $this->task->query($sql, $data);

            header("Location: /");
        }
    }

    /**
     * Оновлює статус завдання
     *
     * @return void
     */
    public function updateStatus(): void
    {
        $data = json_decode((file_get_contents('php://input')), true);

        $request = new UpdateTaskStatus();
        $request->setData($data['id'], $data['status']);
        $validation = $request->afterValidation();

        if (!$validation->fails()) {
            $validated = $request->validated();

            $sql = 'UPDATE tasks SET status = :status WHERE id = :id AND user_id = :user_id';
            $this->task->query($sql, [
            ':status'   => $validated['status'],
            ':id'       => $validated['id'],
            ':user_id'  => $_SESSION['user']['id'],
            ]);

            $response = ['status' => 'OK'];

            echo json_encode($response);
        }
    }
}
