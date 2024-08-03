<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversaoModel extends Model
{

    protected $table = 'conversao';
    use HasFactory;

    protected $fillable = ['ip', 'numero_romano', 'numero_decimal'];

}


