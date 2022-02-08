<?php

namespace Aphly\LaravelAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RbacUserRole extends Model
{
    use HasFactory;
    protected $table = 'rbac_member_role';
    public $timestamps = false;
    protected $fillable = [
        'guid',
        'role_id',
    ];
}
