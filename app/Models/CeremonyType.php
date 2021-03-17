<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeremonyType extends Model
{
    use HasFactory;

    protected $table = 'ceremony_types';

    protected $fillable = [
        'name'
    ];
}
