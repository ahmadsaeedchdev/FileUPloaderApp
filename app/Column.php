<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $fillable = ['name', 'file_id'];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function rows()
    {
        return $this->hasMany(Row::class);
    }
}
