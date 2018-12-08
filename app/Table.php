<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'elenco_tabelle';

    protected $fillable = array('id', 'nome', 'tipo', 'descrizione');

    public function options()
    {
        return $this->hasMany('App\Options');
    }

    public function domande()
    {
        return $this->hasMany('App\Domande');
    }

}
