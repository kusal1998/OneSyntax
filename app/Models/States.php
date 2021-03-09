<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'country',
        'name',
    ];
    protected $table='tbl_states';
}
