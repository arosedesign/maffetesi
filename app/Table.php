<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'elenco_tabelle';

    protected $fillable = array('id', 'nome', 'tipo');

    public function options()
    {
        return $this->hasMany('App\Options');
    }

}
