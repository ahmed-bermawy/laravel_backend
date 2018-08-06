<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable =['name','slug','permissions'];

    public function scopeTableName()
    {
        return 'roles';
    }

    public function scopeTablePK()
    {
        return 'id';
    }
    
}
