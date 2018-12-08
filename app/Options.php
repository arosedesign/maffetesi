<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $table = 'opzioni_tabelle';

    protected $fillable = array('id', 'nome', 'tipo', 'valore', 'table_id');

    public function table()
    {
        return $this->hasMany('App\Table');
    }
}
