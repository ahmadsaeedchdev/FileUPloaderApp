<?php

namespace App\Services;

use App\Imports\FileImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileUploaderService
{
    public static $file;

    private $fileName;

    private $filePath;

    public function storeFile($user, $file)
    {
        $response = null;
        try {

            DB::transaction(function () use ($user, $file) {
                self::$file = $user->files()->create(['name' => $this->fileName($file), 'path' => $this->filePath($file)]);

                \Excel::import(new FileImport, self::$file->path);
            });

            $response = ['class' => 'alert-success', 'message' => 'File data successfully store in database.'];
        } catch (\Exception $exception) {

            Storage::delete($this->filePath);
            $response = ['class' => 'alert-danger', 'message' => $exception->getMessage()];
        }

        return $response;
    }


    private function fileName($file)
    {
        $this->fileName = $file->getClientOriginalName() . '-' . time();

        return $this->fileName;
    }

    private function filePath($file)
    {
        $this->filePath = $file->store('imports');

        return $this->filePath;
    }


    public function showFile($file)
    {
        $file->load('columns:id,name,file_id');

        $columns = $file->columns->pluck('name')->toArray();

        $rows  = $this->formatRows($file->columns->pluck('rows'));

        return collect(['columns' => $columns, 'rows' => $rows]);
    }


    public function formatRows($rows)
    {
        $dataFormate = [];

        $rows->each(function ($row, $key) use (&$dataFormate) {
            if ($key === 0) {
                foreach ($row as $element) {
                    $dataFormate[] = [$element->value];
                }
            } else {
                foreach ($row as $key => $element) {
                    $array = $dataFormate[$key];
                    array_push($array, $element->value);
                    $dataFormate[$key] = $array;
                }
            }
        });

        return $dataFormate;
    }
}
