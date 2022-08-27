<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileValidationRequest;
use App\Service\FileService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $fileProcess;

    public function __construct( FileService $fileProcess)
    {
        $this->fileProcess = $fileProcess;
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('welcome');
    }

    public function calculateCommission( FileValidationRequest $request )
    {

        if (!file_exists($request->file) || ! is_readable($request->file))
        {
            throw new Exception(" Can't open given input file");
        }

        $fileContents = $this->fileProcess->getFileContent($request->file);
        $fileContent = $this->fileProcess->processParams($fileContents);

        return $fileContent;


    }
}
