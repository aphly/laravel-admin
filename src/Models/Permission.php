<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permission';
    public $timestamps = false;

    static public function check($request){
        $messages = [
            'route.required' => '路由必填',
        ];
        $post = $request->validate([
            'route' => 'required',
            'name' => '',
        ], $messages);
        return $post;
    }
}
