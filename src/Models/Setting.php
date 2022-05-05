<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'admin_setting';
    public $timestamps = false;
    protected $fillable = [
        'code','key','value','is_json','module_id'
    ];

    function saveByCode($code,$key,$input){
        return self::updateOrCreate(['code'=>$code,'key'=>$key],$input);
    }

    function getByCode($code,$key){
        $arr = self::get()->toArray();
        $res = [];
        foreach ($arr as $val){
            $res[$val['code']][$val['key']] = $val['value'];
        }
        return $res;
    }
}
