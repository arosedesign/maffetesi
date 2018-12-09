<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Risposta extends Model
{
    protected $table = 'risposte';

    protected $fillable = array('id', 'utente', 'id_domanda', 'id_opzione', 'risposta');

    public function domanda()
    {
        return $this->belongsTO('App\Domande','id_domanda', 'id');
    }

    public function opzione()
    {
        return $this->belongsTO('App\Options','id_opzione', 'id');
    }
}
