<?php
namespace services;

use helpers\TemplateRenderer;

class MainTemplateService extends TemplateService
{
    protected KanbanService $kanbanTemplate;
    protected NavbarService $navbarTemplate;
    protected MainSidebarService $mainSidebarTemplate;

    public function __construct()
    {
        parent::__construct();
        $this->kanbanTemplate = new KanbanService();
        $this->navbarTemplate = new NavbarService();
        $this->mainSidebarTemplate = new MainSidebarService();
    }

    public function render(): string
    {
        return TemplateRenderer::execute('main.php', [
            'kanbanTemplate'        => $this->kanbanTemplate->render(),
            'mainSidebarTemplate'   => $this->mainSidebarTemplate->render(),
            'navbarTemplate'        => $this->navbarTemplate->render(),
        ]);
    }
}
