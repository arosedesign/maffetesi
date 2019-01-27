@extends('layouts.app')

@section('content')
    <div class="container pannello">

        @if(Auth::user()->role == 'admin')


            {{ Form::open(array('route' => 'risultati-filtrati')) }}

            <div class="form-group">
                <div class="col-sm-12">
                    {{ Form::select( 'bmi', array('0' =>'18.5-25','1' => '25.1-30','2' =>'> 30.1'), 'BMI', array('class' => 'form-control', 'placeholder' => 'BMI'))  }}
                </div>
            </div>

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

            <hr>

            <div class="row gestioneutenti">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Fassce punteggio Test 1</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Sport</th>
                                    <th scope="col">Punteggio tra 15 e 22</th>
                                    <th scope="col">Punteggio fra 23 e 29</th>
                                    <th scope="col">Punteggio fra 30 e 35</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="background-color: #f0f0f0">Bodybuilding</td>
                                    <td>{{ $bodybuilding1[0] }} - <b>{!! number_format(100/$divisore1*$bodybuilding1[0], 2) !!}%</b></td>
                                    <td>{{ $bodybuilding1[1] }} - <b>{!! number_format(100/$divisore1*$bodybuilding1[1], 2) !!}%</b></td>
                                    <td>{{ $bodybuilding1[2] }} - <b>{!! number_format(100/$divisore1*$bodybuilding1[2], 2) !!}%</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0">Corsi, sport, endurance</td>
                                    <td>{{ $corsi1[0] }} - <b>{!! number_format(100/$divisore1*$corsi1[0], 2) !!}%</b></td>
                                    <td>{{ $corsi1[1] }} - <b>{!! number_format(100/$divisore1*$corsi1[1], 2) !!}%</b></td>
                                    <td>{{ $corsi1[2] }} - <b>{!! number_format(100/$divisore1*$corsi1[2], 2) !!}%</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0">Pesistica prestativa</td>
                                    <td>{{ $pesistica1[0] }} - <b>{!! number_format(100/$divisore1*$pesistica1[0], 2) !!}%</b></td>
                                    <td>{{ $pesistica1[1] }} - <b>{!! number_format(100/$divisore1*$pesistica1[1], 2) !!}%</b></td>
                                    <td>{{ $pesistica1[2] }} - <b>{!! number_format(100/$divisore1*$pesistica1[2], 2) !!}%</b></td>
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
                        <div class="panel-heading">Fassce punteggio Test 2 - Uomini</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Sport</th>
                                    <th scope="col">Punteggio tra 48 e 43</th>
                                    <th scope="col">Punteggio fra 42 e 38</th>
                                    <th scope="col">Punteggio fra 37 e 31</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="background-color: #f0f0f0">Bodybuilding</td>
                                    <td>{{ $bodybuilding2[2] }} - <b>{!! number_format(100/$divisore2*$bodybuilding2[2], 2) !!}%</b></td>
                                    <td>{{ $bodybuilding2[1] }} - <b>{!! number_format(100/$divisore2*$bodybuilding2[1], 2) !!}%</b></td>
                                    <td>{{ $bodybuilding2[0] }} - <b>{!! number_format(100/$divisore2*$bodybuilding2[0], 2) !!}%</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0">Corsi, sport, endurance</td>
                                    <td>{{ $corsi2[2] }} - <b>{!! number_format(100/$divisore2*$corsi2[2], 2) !!}%</b></td>
                                    <td>{{ $corsi2[1] }} - <b>{!! number_format(100/$divisore2*$corsi2[1], 2) !!}%</b></td>
                                    <td>{{ $corsi2[0] }} - <b>{!! number_format(100/$divisore2*$corsi2[0], 2) !!}%</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0">Pesistica prestativa</td>
                                    <td>{{ $pesistica2[2] }} - <b>{!! number_format(100/$divisore2*$pesistica2[2], 2) !!}%</b></td>
                                    <td>{{ $pesistica2[1] }} - <b>{!! number_format(100/$divisore2*$pesistica2[1], 2) !!}%</b></td>
                                    <td>{{ $pesistica2[0] }} - <b>{!! number_format(100/$divisore2*$pesistica2[0], 2) !!}%</b></td>
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
                        <div class="panel-heading">Fassce punteggio Test 2 - Donne</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Sport</th>
                                    <th scope="col">Punteggio tra 48 e 43</th>
                                    <th scope="col">Punteggio fra 42 e 38</th>
                                    <th scope="col">Punteggio fra 37 e 31</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="background-color: #f0f0f0">Bodybuilding</td>
                                    <td>{{ $bodybuilding3[2] }} - <b>{!! number_format(100/$divisore3*$bodybuilding3[2], 2) !!}%</b></td>
                                    <td>{{ $bodybuilding3[1] }} - <b>{!! number_format(100/$divisore3*$bodybuilding3[1], 2) !!}%</b></td>
                                    <td>{{ $bodybuilding3[0] }} - <b>{!! number_format(100/$divisore3*$bodybuilding3[0], 2) !!}%</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0">Corsi, sport, endurance</td>
                                    <td>{{ $corsi3[2] }} - <b>{!! number_format(100/$divisore3*$corsi3[2], 2) !!}%</b></td>
                                    <td>{{ $corsi3[1] }} - <b>{!! number_format(100/$divisore3*$corsi3[1], 2) !!}%</b></td>
                                    <td>{{ $corsi3[0] }} - <b>{!! number_format(100/$divisore3*$corsi3[0], 2) !!}%</b></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f0f0f0">Pesistica prestativa</td>
                                    <td>{{ $pesistica3[2] }} - <b>{!! number_format(100/$divisore3*$pesistica3[2], 2) !!}%</b></td>
                                    <td>{{ $pesistica3[1] }} - <b>{!! number_format(100/$divisore3*$pesistica3[1], 2) !!}%</b></td>
                                    <td>{{ $pesistica3[0] }} - <b>{!! number_format(100/$divisore3*$pesistica3[0], 2) !!}%</b></td>
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




