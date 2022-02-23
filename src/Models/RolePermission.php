<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected $table = 'role_permission';
    public $timestamps = false;
    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }


}
