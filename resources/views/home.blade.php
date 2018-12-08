@extends('layouts.app')

@section('content')
    <div class="container pannello">

        @if(Auth::user()->role == 'admin')
            <div class="row gestioneutenti">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Gestione utenti</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Ruolo</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            @if(Auth::user()->id != $user->id)

                                                {{ Form::open(array('route' => 'editUser', 'class' => 'form-inline',)) }}
                                                {{ Form::hidden('id', $user->id)  }}
                                                {{ Form::select('azione', array('rendiadmin' => 'Rendi admin', 'elimina' => 'Elimina'), 'rendiadmin', array('class' => 'form-control'))  }}
                                                {{ Form::submit('Modifica', ['class' => 'btn btn-primary btn-esegui']) }}
                                                {{ Form::close() }}

                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row gestioneimpostazioni">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Gestione testi</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Nome testo</th>
                                    <th scope="col">descrizione</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($impostazioni as $i)
                                    <tr>
                                        <td>{{ $i->nome }}</td>
                                        <td>

                                            {{ Form::open(array('route' => 'editTabella', 'class' => 'form-inline',)) }}
                                            {{ Form::hidden('azione', 'impostazioni')  }}
                                            {{ Form::textarea('azione', $i->descrizione, '', array('class' => 'form-control'))  }}
                                            <br>
                                            {{ Form::submit('Modifica', ['class' => 'btn btn-primary btn-esegui']) }}
                                            {{ Form::close() }}

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row gestionetabelle">

                <div class="col-md-12">

                    <h2>Gestione tabelle</h2>
                </div>

                @foreach ($tables as $table)
                    <div class="col-md-12">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h3>Tabella:  {{$table['nome'] }}</h3>

                                {{ Form::open(array('route' => 'editTabella', 'class' => 'form-inline')) }}
                                {{ Form::hidden('id', $table['id'])  }}
                                {{ Form::hidden('azione', 'tabella')  }}
                                <div class="form-group">
                                    <label for="nome">Nome</label>
                                    {{ Form::text('nome', $table['nome'], array('class' => 'form-control'))  }}
                                </div>

                                <div class="form-group">
                                    <label for="nome">Tipo: </label>
                                    <span class="tipotabella">{!! str_replace('_', ' ', ucfirst($table['tipo'])) !!}</span>
                                    {{ Form::hidden('tipo', $table['tipo'])  }}
                                </div>
                                <div class="form-group">
                                    {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                </div>
                                {{ Form::close() }}

                            </div>

                            <div class="panel-body">

                                <div class="blocco_opzioni">

                                    <h4>OPZIONI</h4>

                                    @foreach ($table['opzioni'] as $option)

                                        {{ Form::open(array('route' => 'editTabella', 'class' => 'form-inline', 'style' => 'display: list-item; list-style-type: none;')) }}
                                        {{ Form::hidden('id', $option['id'])  }}
                                        {{ Form::hidden('table_id', $table['id'])  }}
                                        {{ Form::hidden('azione', 'opzione')  }}
                                        <div class="col-sm-2">
                                            @if ($loop->first)
                                                <label for="nome">Nome</label>
                                            @endif
                                            {{ Form::text('nome', $option['nome'], array('class' => 'form-control'))  }}
                                        </div>

                                        @if ($table['tipo'] != 'risposte_fisse')
                                            <div class="col-sm-2">
                                                @if ($loop->first)
                                                    <label for="tipo">Tipo</label>
                                                @endif
                                                {{ Form::select('tipo', array('select' => 'Scelta multipla', 'integer' => 'Numero', 'text' => 'Testo'), $option['tipo'], array('class' => 'form-control'))  }}
                                            </div>
                                        @else
                                            {{ Form::hidden('tipo', 'punteggio')  }}
                                        @endif

                                        <div class="col-sm-2">
                                            @if ($loop->first)
                                                <label for="valore">Ordine</label>
                                            @endif
                                            {{ Form::text('valore', $option['valore'], array('class' => 'form-control'))  }}
                                        </div>
                                        <div class="col-sm-2">
                                            @if ($loop->first)
                                                <br>
                                            @endif
                                            {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                        </div>
                                        {{ Form::close() }}

                                        <div class="deletebtn form-group">
                                            @if ($loop->first)
                                                <br>
                                            @endif
                                            <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#eliminaOpzione-{{$option['id']}}">
                                                X
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="eliminaOpzione-{{$option['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Sei sicuro di voler eliminare l'opzione?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            {{ Form::open(array('route' => 'delete')) }}
                                                            {{ Form::hidden('id', $option['id'])  }}
                                                            {{ Form::hidden('azione', 'opzione')  }}
                                                            {{ Form::submit('Elimina', ['class' => 'btn btn-danger']) }}
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                                            {{ Form::close() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                    @endforeach

                                    <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#aggiungiOpzione-{{$table['id'] }}">
                                        Aggiungi un'opzione
                                    </button>


                                </div>

                                @if ($table['tipo'] != 'risposte_variabili')

                                    <hr>
                                    <div class="blocco_domande">

                                        <h4>DOMANDE</h4>

                                        @foreach ($table['domande'] as $domanda)

                                            {{ Form::open(array('route' => 'editTabella', 'class' => 'form-inline', 'style' => 'display: list-item; list-style-type: none;')) }}
                                            {{ Form::hidden('id', $domanda['id'])  }}
                                            {{ Form::hidden('table_id', $table['id'])  }}
                                            {{ Form::hidden('azione', 'domanda')  }}
                                            <div class="col-sm-6">
                                                @if ($loop->first)
                                                    <label for="domanda">Domande</label>
                                                @endif

                                                {{ Form::text('domanda', $domanda['domanda'], array('class' => 'input_domanda form-control'))  }}
                                            </div>
                                            <div class="col-sm-2">
                                                @if ($loop->first)
                                                    <label for="valori">Valori</label>
                                                @endif
                                                {{ Form::text('valori', $domanda['valori'], array('class' => 'form-control', 'placeholder' => 'valori ordinati separati da,',))  }}

                                            </div>
                                            <div class="col-sm-2">
                                                @if ($loop->first)
                                                    <br>
                                                @endif
                                                {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                            </div>
                                            {{ Form::close() }}

                                            <div class="deletebtn form-group">
                                                @if ($loop->first)
                                                    <br>
                                                @endif
                                                <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#eliminaDomanda-{{$domanda['id']}}">
                                                    X
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="eliminaDomanda-{{$domanda['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">Sei sicuro di voler eliminare la domanda?</h4>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{ Form::open(array('route' => 'delete')) }}
                                                                {{ Form::hidden('id', $domanda['id'])  }}
                                                                {{ Form::hidden('azione', 'domanda')  }}
                                                                {{ Form::submit('Elimina', ['class' => 'btn btn-danger']) }}
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                                                {{ Form::close() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>

                                        @endforeach
                                        <br><br>
                                        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#aggiungiDomanda-{{$table['id'] }}">
                                            Aggiungi una domanda
                                        </button>

                                    </div>

                                @endif

                                <br>
                                <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#eliminaTabella-{{$table['id']}}">
                                    Elimina tabella
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="eliminaTabella-{{$table['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Sei sicuro di voler eliminare la tabella?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Attenzione! Anche tutte le opzioni e le domande verranno eliminate.</p>
                                            </div>
                                            <div class="modal-footer">
                                                {{ Form::open(array('route' => 'delete')) }}
                                                {{ Form::hidden('id', $table['id'])  }}
                                                {{ Form::hidden('azione', 'tabella')  }}
                                                {{ Form::submit('Elimina', ['class' => 'btn btn-danger']) }}
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="aggiungiOpzione-{{$table['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {{ Form::open(array('route' => 'editTabella', 'class' => 'form-horizontal')) }}
                                {{ Form::hidden('azione', 'opzione')  }}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Aggiungi un'opzione alla tabella</h4>
                                </div>
                                <div class="modal-body">
                                    {{ Form::hidden('table_id', $table['id'])  }}
                                    <div class="form-group">
                                        <label for="nome" class="col-sm-2 control-label">Nome</label>
                                        <div class="col-sm-10">
                                            {{ Form::text('nome', "", array('class' => 'form-control'))  }}
                                        </div>
                                    </div>
                                    @if ($table['tipo'] != 'risposte_fisse')
                                        <div class="form-group">
                                            <label for="tipo" class="col-sm-2 control-label">Tipo</label>
                                            <div class="col-sm-10">
                                                {{ Form::select('tipo', array('select' => 'Scelta multipla', 'integer' => 'Numero', 'text' => 'Testo'), 'punteggio', array('class' => 'form-control', 'placeholder' => 'Scelta multipla: Valore 1_Valore 2, Numero: min_max'))  }}
                                            </div>
                                        </div>
                                    @else
                                        {{ Form::hidden('tipo', 'punteggio')  }}
                                    @endif
                                    <div class="form-group">
                                        <label for="valore" class="col-sm-2 control-label">Ordine</label>
                                        <div class="col-sm-10">
                                            {{ Form::text('valore', '', array('class' => 'form-control'))  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="aggiungiDomanda-{{$table['id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                {{ Form::open(array('route' => 'editTabella', 'class' => 'form-horizontal')) }}
                                {{ Form::hidden('azione', 'domanda')  }}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Aggiungi una domanda alla tabella</h4>
                                </div>
                                <div class="modal-body">
                                    {{ Form::hidden('table_id', $table['id'])  }}
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="domanda">Domanda</label>
                                            {{ Form::text('domanda', "", array('class' => 'form-control input_domanda'))  }}
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="valori">Valori</label>
                                            {{ Form::text('valori', '', array('class' => 'form-control', 'placeholder' => 'valori ordinati separati da,',))  }}
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                    {{ Form::close() }}
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

                <br>
                <div class="col-md-9 col-md-offset-1">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#aggiungiTabella">
                        Aggiungi una tabella
                    </button>
                    <br><br>
                </div>



                <!-- Modal -->
                <div class="modal fade" id="aggiungiTabella" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            {{ Form::open(array('route' => 'editTabella', 'class' => 'form-horizontal')) }}
                            {{ Form::hidden('azione', 'tabella')  }}
                            {{ Form::hidden('id', null)  }}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Aggiungi una tabella</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nome" class="col-sm-2 control-label">Nome</label>
                                    <div class="col-sm-10">
                                        {{ Form::text('nome', "", array('class' => 'form-control'))  }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tipo" class="col-sm-2 control-label">Tipo</label>
                                    <div class="col-sm-10">
                                        {{ Form::select('tipo', array('risposte_fisse' => 'Risposte fisse', 'risposte_variabili' => 'Risposte variabili'), 'risposte_fisse', array('class' => 'form-control'))  }}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{ Form::submit('Salva', ['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>




                @else
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-heading">HAI CORRETTAMENTE EFFETTUATO LA LOGIN</div>

                                <div class="panel-body">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    L'amministratore deve ancora accettare la tua registrazione.<br>Per favore, riprova più tardi.
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
            </div>
@endsection




