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

    public function getMenu(){
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
}
