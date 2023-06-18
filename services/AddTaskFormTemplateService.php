<?php
namespace services;

use helpers\GlobalArrayHandler;
use helpers\TemplateRenderer;
use requests\StoreTaskRequest;

class AddTaskFormTemplateService extends TemplateService
{
    protected MainSidebarTemplateService $mainSideBar;
    protected NavbarTemplateService $navbarService;
    protected TaskService $taskService;


    public function __construct()
    {
        parent::__construct();
        $this->mainSideBar      = new MainSidebarTemplateService();
        $this->navbarService    = new NavbarTemplateService();
        $this->taskService      = new TaskService();
    }

    public function render(): string
    {
        return TemplateRenderer::execute('addTaskForm.php', [
            'mainSidebar'   => $this->mainSideBar->render(),
            'navbar'        => $this->navbarService->render(),
            'projects'      => $this->projectService->getAll(),
            'projectId'     => GlobalArrayHandler::getStringToInt('project_id'),
        ]);
    }
}
