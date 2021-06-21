<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Row;
use App\Services\FileUploaderService;

class FileImport implements toCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $columns = $collection->first()->toArray();

        $rows = $collection->except(0);

        $columns = array_map(fn ($element) => ['name' => $element], $columns);


        $columns = FileUploaderService::$file->columns()->createMany($columns);

        $columnIds = $columns->pluck('id')->toArray();

        $data = [];

        $rows->each(function ($row) use ($columnIds, &$data) {
            foreach ($row as $key => $element) {

                $data[] = ['value' => $element, 'column_id' => $columnIds[$key]];
            }
        });

        Row::insert($data);
    }
}
