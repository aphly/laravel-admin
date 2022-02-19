<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'admin_menu';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'controller'
    ];


}
