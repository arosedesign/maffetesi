@extends('layouts.app')

@section('content')
    <div class="container pannello">

        @if(Auth::user()->role == 'admin')
            <div class="row gestioneutenti">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Risultati Test 1</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Punteggio minore di 35</th>
                                    <th scope="col">Punteggio fra 35 e 40</th>
                                    <th scope="col">Punteggio maggiore di 40</th>
                                </tr>
                                </thead>
                                <tbody>
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
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


@endsection




