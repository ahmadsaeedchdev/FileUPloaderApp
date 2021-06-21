<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\FileUploaderService;
use App\File;

class FileController extends Controller
{

    public function index()
    {
        $files = Auth::user()->files;

        return view('files.index', compact('files'));
    }



    public function store(Request $request, FileUploaderService $fileUploaderService)
    {
        $data = $this->validator($request)->validated();

        $response = $fileUploaderService->storeFile(Auth::user(), $data['file']);

        $request->session()->flash('class', $response['class']);
        $request->session()->flash('message', $response['message']);

        return redirect(route('files.index'));
    }



    public function show(File $file, FileUploaderService $fileUploaderService)
    {
        $fileResponse = $fileUploaderService->showFile($file);

        return view('files.show', compact('file', 'fileResponse'));
    }




    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'file' => ['required', 'file', 'mimes:csv,xlsx,xls']
        ]);
    }
}
