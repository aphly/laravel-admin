<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'user';
    protected $primaryKey = 'uuid';
    public $incrementing = false;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'uuid','nickname',
        'token',
        'token_expire','avatar','status','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
       //'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
//        static::created(function (User $user) {
//            UserUni::create(['user_id'=>$user->id]);
//            UserInfo::create(['user_id'=>$user->id]);
//        });
//
//        static::deleted(function (User $user) {
//            UserUni::destroy($user->id);
//            UserInfo::destroy($user->id);
//            self::delAvatar($user->avatar);
//        });
    }

    public function userAuth()
    {
        return $this->hasMany(UserAuth::class,'uuid');
    }

    static public function delAvatar($avatar) {
        if($avatar){
            Storage::delete($avatar);
        }
    }
}
