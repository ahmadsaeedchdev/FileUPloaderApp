<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    protected $fillable = ['name', 'file_id'];

    public function Column()
    {
        return $this->belongsTo(Row::class);
    }
}
