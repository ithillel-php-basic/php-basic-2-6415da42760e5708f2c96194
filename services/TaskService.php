<?php
    namespace services;

    use databases\Sql;
    use helpers\GlobalArrayHandler;

class TaskService
{
    protected Sql $taskService;

    public function __construct()
    {
        $this->taskService = new Sql();
    }

    public function getUserTasks(): bool|array
    {
        session_start();
        $data = [];
        $data[':user_id'] = $_SESSION['user']['id'];

        $sql = 'SELECT t.id, t.title, t.description, p.id as project_id, 
                p.title as project_title, t.deadline, t.file, t.status, t.created_at
                FROM tasks AS t
                LEFT JOIN projects AS p
                    ON t.project_id = p.id
                WHERE p.user_id = :user_id';
        if (isset($_GET['project_id'])) {
            $data[':project_id'] = GlobalArrayHandler::getStringToInt('project_id');
            $sql .= ' AND t.project_id = :project_id';
        }
        $sql .= ' GROUP BY t.id ORDER BY id DESC';

        return $this->taskService->query($sql, $data)->get();
    }
}
