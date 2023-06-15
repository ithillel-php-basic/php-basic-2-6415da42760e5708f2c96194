<?php
namespace services;

use databases\Sql;

class DocumentService
{
    protected Sql $document;

    public function __construct()
    {
        $this->document = new Sql();
    }

    public function downloadFromKanban()
    {
        session_start();

        return $this->document->query('SELECT * FROM tasks WHERE file = :filename AND user_id = :user_id', [
            ':filename' => $_GET['file'],
            ':user_id'  => $_SESSION['user']['id']
        ])->first();
    }
}
