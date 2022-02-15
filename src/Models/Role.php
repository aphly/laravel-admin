<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    public $timestamps = false;

    static public function check($request){
        $messages = [
            'name.required' => '角色名称必填',
        ];
        $post = $request->validate([
            'name' => 'required',
        ], $messages);
        return $post;
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class,'role_permission','role_id','permission_id');
    }
}
