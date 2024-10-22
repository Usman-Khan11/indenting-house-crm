<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavKey extends Model
{
    use HasFactory;
    
    protected $table = 'nav_keys';
    protected $guarded = ['id'];
    
}
