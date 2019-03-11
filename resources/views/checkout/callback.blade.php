@extends('layouts.app ')

@section('title', 'Resumen')

@section('content')
    <div class="row">
        <div class="col s12">
            <br/>
            <a class="waves-effect waves-light btn-small" href="{{ url('checkout') }}">Regresar</a>
            <a class="waves-effect waves-light btn" onclick="javascript:window.print()">Imprimir</a>
        </div>
    </div>

    <table class="striped responsive-table">
        <tbody>
            <tr>
                <th>NIT</th>
                <td>1036663207-1</td>
            </tr>
            <tr>
                <th>Razón social</th>
                <td>CheckoutPTP</td>
            </tr>
            <tr>
                <th>Valor</th>
                <td>COP {{ $checkout->amount }}</td>
            </tr>
            <tr>
                <th>IVA</th>
                <td>COP 0</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $checkout->created_at }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>{{ $checkout->status }}</td>
            </tr>
            <tr>
                <th>Motivo</th>
                <td>{{ $checkout->reason }}</td>
            </tr>
            <tr>
                <th>Franquicia</th>
                <td>{{ $checkout->franchise }}</td>
            </tr>
            <tr>
                <th>Banco</th>
                <td>{{ $checkout->bank }}</td>
            </tr>
            <tr>
                <th>Autorización</th>
                <td>{{ $checkout->authorization }}</td>
            </tr>
            <tr>
                <th>Referencia</th>
                <td>{{ $checkout->id }}</td>
            </tr>
            <tr>
                <th>Descripción</th>
                <td>{{ $checkout->description }}</td>
            </tr>
            <tr>
                <th>Dirección IP</th>
                <td>{{ $_SERVER['REMOTE_ADDR'] }}</td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td>{{ $checkout->first_name }} {{ $checkout->last_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $checkout->email }}</td>
            </tr>
        </tbody>
    </table>
    <p class="teal lighten-5" style="padding: 15px">Si tiene alguna intquietud contáctenos al teléfono 3147733992 o vía email jdgonzalez907@gmail.com (CheckoutPTP).</p>
@endsection