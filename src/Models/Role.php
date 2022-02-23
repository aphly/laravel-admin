<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

    public function menu()
    {
        return $this->belongsToMany(Menu::class,'role_menu','role_id','menu_id');
    }

    public function getRolePermission(): array
    {
        $role_ids = UserRole::where([ 'uuid' => Auth::guard('manager')->user()->uuid ])->select('role_id')->get()->toArray();
        $role_ids = array_column($role_ids,'role_id');
        $role_permission = $this->role_permission_cache();
        $has_permission = [];
        foreach($role_ids as $id){
            if(isset($role_permission[$id])){
                foreach ($role_permission[$id] as $k=>$v){
                    $has_permission[$k] = $v;
                }
            }
        }
        return $has_permission;
    }

    public function getMenu(): array
    {
        $role_ids = UserRole::where([ 'uuid' => Auth::guard('manager')->user()->uuid ])->select('role_id')->get()->toArray();
        $role_ids = array_column($role_ids,'role_id');
        $role_menu = $this->role_menu_cache();
        $has_menu = [];
        foreach($role_ids as $id){
            if(isset($role_menu[$id])){
                foreach ($role_menu[$id] as $k=>$v){
                    $has_menu[$k] = $v;
                }
            }
        }
        return $has_menu;
    }

    function role_permission_cache(){
        return Cache::rememberForever('role_permission', function () {
            $permission = RolePermission::with('permission')->get()->toArray();
            $role_permission = [];
            foreach ($permission as $v) {
                $role_permission[$v['role_id']][$v['permission']['id']] = $v['permission']['controller'];
            }
            return $role_permission;
        });
    }

    public function role_menu_cache(){
        return Cache::rememberForever('role_menu', function () {
            $menu = RoleMenu::with('menu')->get()->toArray();
            $role_menu = [];
            foreach ($menu as $v) {
                $role_menu[$v['role_id']][$v['menu']['id']] = $v['menu'];
            }
            return $role_menu;
        });
    }


}
