<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permission';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'controller',
        'pid',
        'is_leaf',
        'status',
        'sort',
    ];

//    protected static function boot()
//    {
//        parent::boot();
//        static::deleted(function (User $user) {
//            UserUni::destroy($user->id);
//            UserInfo::destroy($user->id);
//            self::delAvatar($user->avatar);
//        });
//    }
}
