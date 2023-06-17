<?php
namespace controllers;

use databases\Sql;
use helpers\TemplateRenderer;
use requests\ProjectStoreRequest;
use services\MainSidebarTemplateService;
use services\NavbarTemplateService;

class ProjectController extends BaseController
{
    private MainSidebarTemplateService $mainSidebarTemplate;
    private NavbarTemplateService $navbarTemplateService;
    private Sql $project;
    private $validation;

    public function __construct()
    {
        $this->mainSidebarTemplate   = new MainSidebarTemplateService();
        $this->navbarTemplateService = new NavbarTemplateService();
        $this->project               = new Sql();
    }

    public function create(): string
    {
        $title = 'Завдання та проекти | Дошка';

        $body = TemplateRenderer::execute('addProjectForm.php', [
            'mainSidebarTemplate'       => $this->mainSidebarTemplate->render(),
            'navbarTemplate'            => $this->navbarTemplateService->render(),
        ] + $this->params($this->validation));

        return TemplateRenderer::execute('layout.php', [
            'title' => $title,
            'body'  => $body,
        ]);
    }

    public function store()
    {
        $request = new ProjectStoreRequest();
        $request->setData($_POST['title']);
        $this->validation = $request->afterValidation();

        if (!$this->validation->fails()) {
            $validated = $request->validated();

            $sql = "INSERT INTO projects(title, user_id, created_at) 
                    VALUES (:title, :user_id, CURRENT_DATE)";

            $data = [
                ':title'    => $validated['title'],
                ':user_id'  => $_SESSION['user']['id']
            ];

            $this->project->query($sql, $data);

            header("Location: /");
        }
    }
}
