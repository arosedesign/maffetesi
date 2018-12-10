<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impostazioni extends Model
{
    protected $table = 'impostazioni';

    protected $fillable = array('id','nome', 'descrizione');
}
