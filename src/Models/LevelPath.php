<?php

namespace Aphly\LaravelAdmin\Models;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class LevelPath extends Model
{
    use HasFactory;
    protected $table = 'admin_level_path';
    protected $primaryKey = ['path_id','level_id'];
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'path_id','level_id','level'
    ];

    public function add($id,$pid){
        $level = 0;
        $data =  self::where('level_id',$pid)->orderBy('level','asc')->get()->toArray();
        $insertData = [];
        foreach ($data as $val){
            $insertData[] = ['level_id'=>$id,'path_id'=>$val['path_id'],'level'=>$level];
            $level++;
        }
        $insertData[] = ['level_id'=>$id,'path_id'=>$id,'level'=>$level];
        DB::table($this->table)->upsert($insertData, ['level_id', 'path_id']);
    }

    public function getByIds($ids){
        return self::leftJoin('admin_level as c1','c1.id','=','admin_level_path.level_id')
            ->leftJoin('admin_level as c2','c2.id','=','admin_level_path.path_id')
            ->whereIn('c1.id', $ids)
            ->groupBy('level_id')
            ->selectRaw('any_value(c1.`id`) AS id,any_value(admin_level_path.`level_id`) AS level_id,
            GROUP_CONCAT(c2.`name` ORDER BY admin_level_path.level SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\') AS name')
            ->get()->keyBy('id')->toArray();
    }
}
