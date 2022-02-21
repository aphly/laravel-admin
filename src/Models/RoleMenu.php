<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class RoleMenu extends Model
{
    use HasFactory;
    protected $table = 'role_menu';
    public $timestamps = false;
    protected $fillable = [
        'menu_id',
        'role_id',
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }

    function role_menu_cache(){
        return Cache::rememberForever('role_menu', function () {
            $menu = self::with('menu')->get()->toArray();
            $role_menu = [];
            foreach ($menu as $v) {
                $role_menu[$v['role_id']][$v['menu']['id']] = $v['menu'];
            }
            return $role_menu;
        });
    }
}
