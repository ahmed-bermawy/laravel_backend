<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = ['title','author','short_description','long_description','published_at','image'];

    public function scopeTableName()
    {
        return 'articles';
    }

    public function scopeTablePK()
    {
        return 'id';
    }
}
