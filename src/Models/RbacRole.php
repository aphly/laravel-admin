<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RbacRole extends Model
{
    use HasFactory;
    protected $table = 'rbac_role';
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
        return $this->belongsToMany(RbacPermission::class,'rbac_role_permission','role_id','permission_id');
    }
}
