<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domande extends Model
{
    protected $table = 'domande';

    protected $fillable = array('id', 'domanda', 'table_id', 'valori');

    public function table()
    {
        return $this->belongsTO('App\Table','table_id', 'id');
    }
}
