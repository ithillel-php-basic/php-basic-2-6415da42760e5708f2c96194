<?php
namespace controllers;

use helpers\ErrorHandler;
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
            ErrorHandler::setStatus('404');
        }

        header('Content-Disposition: attachment; filename="'.$document['file'].'"');
        readfile('storage/'.$document['file']);
        exit();
    }
}
