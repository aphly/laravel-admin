<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RbacRolePermission extends Model
{
    use HasFactory;
    protected $table = 'rbac_role_permission';
    public $timestamps = false;
    protected $fillable = [
        'permission_id',
        'role_id',
    ];
}
