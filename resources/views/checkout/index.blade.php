@extends('layouts.app ')

@section('title', 'Pagos')

@section('content')
    <h2>Lista de pagos</h2>
    <div class="divider"></div>
    <br/>
    <a href="<?= url('checkout/create') ?>" class="waves-effect waves-light btn"><i class="material-icons right">payment</i>NUEVO PAGO</a>
    <table class="highlight responsive-table">
        <thead>
            <tr>
                <th>Referencia</th>
                <th>Identificación</th>
                <th>Nombre completo</th>
                <th>Descripción del pago</th>
                <th>Valor</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($checkouts as $checkout)
            <tr>
                <td>{{ $checkout->id }}</td>
                <td>({{ $checkout->documentType }}) {{ $checkout->document }}</td>
                <td>{{ $checkout->first_name }} {{ $checkout->last_name }}</td>
                <td>{{ $checkout->description }}</td>
                <td>{{ $checkout->amount }}</td>
                <td>{{ $checkout->status }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection