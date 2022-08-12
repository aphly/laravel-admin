<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class News extends Model
{
    use HasFactory;
    protected $table = 'admin_news';
    public $timestamps = false;
    protected $fillable = [
        'title','content','view','status'
    ];


}
