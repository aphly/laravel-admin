<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function permission()
    {
        return $this->belongsToMany(Permission::class,'role_permission','role_id','permission_id');
    }
}
