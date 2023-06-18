<?php
namespace services;

use databases\Sql;

class ProjectService
{
    private Sql $projects;

    public function __construct()
    {
        $this->projects = new Sql();
    }

    public function getAll(): bool|array
    {
        $sql = 'SELECT p.*, count(t.id) AS countTasks
                FROM projects AS p
                LEFT JOIN tasks AS t 
                    ON p.id = t.project_id
                WHERE p.user_id = :user_id
                GROUP BY p.id';

        return $this->projects->query($sql, [':user_id' => $_SESSION['user']['id']])->get();
    }

    public function countProjectsByTitle($value)
    {
        $sql = 'SELECT COUNT(*) FROM projects WHERE title = :title AND user_id = :user_id';

        $projects = $this->projects->query($sql, [
            ':title'    => $value,
            ':user_id'  => $_SESSION['user']['id']
        ]);

        return $projects->fetchColumn();
    }
}
