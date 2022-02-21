<?php

namespace Aphly\LaravelAdmin\Models;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLogin extends Model
{
    use HasFactory;
    protected $table = 'failed_login';
    protected $primaryKey = 'ip';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'ip',
        'count',
        'lastupdate',
    ];

    const LIMITTIMES=5;

    function logincheck($ip) {
        $currTime = time();
        $login = self::find($ip);
        if($login) {
            if($currTime - $login['lastupdate'] > 900){
                $login->count=0;
                $login->lastupdate=$currTime;
                $login->save();
            }else{
                if(self::LIMITTIMES<=$login['count']){
                    throw new ApiException(['code'=>11001,'msg'=>'密码错误超过'.self::LIMITTIMES.'次数，请15分钟后再试']);
                }
            }
        }else{
            self::create([
                'ip' => $ip,
                'count' => 0,
                'lastupdate' => $currTime,
            ]);
        }
    }

    function update_failed($ip){
        $currTime = time();
        $login = self::find($ip);
        if($login) {
            $login->count=$login->count+1;
            $login->lastupdate = $currTime;
            $login->save();
            $times=max((self::LIMITTIMES - $login->count),0);
        }else{
            self::create([
                'ip' => $ip,
                'count' => 0,
                'lastupdate' => $currTime,
            ]);
            $times=self::LIMITTIMES;
        }
        $msg = $times>0?'密码错误，还有'.$times.'次尝试机会':'密码错误，请等待15分钟再试';
        throw new ApiException(['code'=>11002,'msg'=>$msg]);
    }

}
