<?php

namespace services;

use Carbon\Carbon;
use databases\Sql;
use helpers\ErrorHandler;
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
        if (isset($_GET['filter'])) {
            $data[':deadline'] = Carbon::now()->format('Y-m-d');

            switch ($_GET['filter']) {
                case 'today':
                    $sql .= ' AND t.deadline = :deadline';
                    break;
                case 'expired':
                    $sql .= ' AND t.deadline < :deadline';
                    break;
                case 'tomorrow':
                    $data[':deadline'] = Carbon::tomorrow()->format('Y-m-d');
                    $sql .= ' AND t.deadline = :deadline';
                    break;
                default:
                    ErrorHandler::setStatus('404');
            }
        }
        $sql .= ' GROUP BY t.id ORDER BY id DESC';

        return $this->taskService->query($sql, $data)->get();
    }
}
