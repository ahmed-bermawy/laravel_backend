<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeTableName()
    {
        return 'users';
    }

    public function scopeTablePK()
    {
        return 'id';
    }
    
    public function getUserName($user_id)
    {
        return User::select('first_name','last_name')->where('id', $user_id)->first();
    }

    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='')
        {
            $query->where(function ($query) use ($keyword)
            {
                $query->where("first_name", "LIKE","%$keyword%")
                    ->orWhere("last_name", "LIKE", "%$keyword%")
                    ->orWhere("email", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }
}
