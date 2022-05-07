<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'admin_setting';
    public $timestamps = false;
    protected $fillable = [
        'code','key','value','is_json','module_id','name'
    ];

    function saveInput($request){
        $input = $request->all();
        $input['key'] = trim($input['key']);
        $input['code'] = trim($input['code']);
        Setting::updateOrCreate(['id'=>$request->query('id',0)],$input);
        Cache::forget('setting_'.$input['code']);
    }

    function getByCode($code){
        return Cache::rememberForever('setting_'.$code, function () use ($code){
            $arr = self::where('code',$code)->get()->toArray();
            $res = [];
            foreach ($arr as $val){
                $res[$val['code']][$val['key']] = $val['value'];
            }
            return $res;
        });
    }
}
