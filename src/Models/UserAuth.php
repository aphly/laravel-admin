<?php

namespace Aphly\LaravelAdmin\Models;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class UserAuth extends Model
{
    use HasFactory;
    protected $table = 'user_auth';
    protected $fillable = [
        'uuid','identity_type','identifier','credential','token'
    ];

    function changePassword($uuid,$password){
        $credential = Hash::make($password);
        $this->where(['identity_type'=>'username','uuid'=>$uuid])->update(['credential'=>$credential]);
        $this->where(['identity_type'=>'mobile','uuid'=>$uuid])->update(['credential'=>$credential]);
        $this->where(['identity_type'=>'email','uuid'=>$uuid])->update(['credential'=>$credential]);
        return true;
    }


//    protected static function boot()
//    {
//        parent::boot();
//        static::created(function (UserAuth $user) {
//            $post['uuid'] = $post['token'] = $user->uuid;
//            $post['token_expire'] = time();
//            User::create($post);
//        });
//
//    }
}
