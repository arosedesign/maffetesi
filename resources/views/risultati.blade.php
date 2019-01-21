@extends('layouts.app')

@section('content')
    <div class="container pannello">

        @if(Auth::user()->role == 'admin')


            {{ Form::open(array('route' => 'risultati-filtrati')) }}

            @foreach ($filters as $f)

                @if ($f['nome'] != 'Che tipo di sport pratichi?')
                    <div class="form-group">
                        <div class="col-sm-12">
                            {{ Form::select( $f['id'], $f['valore'], $f['nome'], array('class' => 'form-control', 'placeholder' => $f['nome']))  }}
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <div class="col-sm-12">

                            <h4>Sport</h4>

                            @foreach ($f['valore'] as $c)
                                {{ Form::checkbox( $f['id'].'[]', $c)  }}
                                {{ Form::label( $f['id'], $c, '', array('class' => 'form-control'))  }} <br>

                            @endforeach
                            <br>
                        </div>
                    </div>
                @endif

            @endforeach

            {{ Form::submit('Filtra i risultati', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}

            <br><br>

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
                                        <td>{{ $risultati1[0] }} - <b>{!! number_format(100/$risultati1['totale']*$risultati1[0], 2) !!}%</b></td>
                                        <td>{{ $risultati1[1] }} - <b>{!! number_format(100/$risultati1['totale']*$risultati1[1], 2) !!}%</b></td>
                                        <td>{{ $risultati1[2] }} - <b>{!! number_format(100/$risultati1['totale']*$risultati1[2], 2) !!}%</b></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row gestioneutenti">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Risultati Test 2</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Punteggio minore di 31</th>
                                    <th scope="col">Punteggio fra 31 e 48</th>
                                    <th scope="col">Punteggio maggiore di 48</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $risultati2[0] }} - <b>{!! number_format(100/$risultati2['totale']*$risultati2[0], 2) !!}%</b></td>
                                    <td>{{ $risultati2[1] }} - <b>{!! number_format(100/$risultati2['totale']*$risultati2[1], 2) !!}%</b></td>
                                    <td>{{ $risultati2[2] }} - <b>{!! number_format(100/$risultati2['totale']*$risultati2[2], 2) !!}%</b></td>
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




