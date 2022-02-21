<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    function role_permission_cache(){
        return Cache::rememberForever('role_permission', function () {
            $permission = self::with('permission')->get()->toArray();
            $role_permission = [];
            foreach ($permission as $v) {
                $role_permission[$v['role_id']][$v['permission']['id']] = $v['permission']['controller'];
            }
            return $role_permission;
        });
    }
}
