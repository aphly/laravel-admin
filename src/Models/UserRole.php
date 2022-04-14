<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;
    protected $table = 'admin_user_role';
    public $timestamps = false;
    protected $fillable = [
        'uuid',
        'role_id',
    ];
}
