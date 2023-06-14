<?php
namespace controllers;

use JetBrains\PhpStorm\NoReturn;
use services\DocumentService;

class DocumentController extends BaseController
{
    private DocumentService $document;

    public function __construct()
    {
        $this->document = new DocumentService();
    }

    #[NoReturn]
    public function show()
    {
        $document = $this->document->downloadFromKanban();

        if (!isset($document['file']) || !file_exists('storage/'.$document['file'])) {
            http_response_code(404);
            include('templates/404.php');
            exit();
        }

        header('Content-Disposition: attachment; filename="'.$document['file'].'"');
        readfile('storage/'.$document['file']);
        exit();
    }
}
