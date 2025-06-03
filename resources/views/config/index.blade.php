@extends('adminlte::page')

@section('title', 'Master Config')

@section('content_header')
    <h1>Master Config</h1>
@endsection

@section('content')

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tarif PLN (Rp/kWh)</th>
                <th>Gaji Per Jam (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($configs as $item)
                <tr>
                    <td>Rp {{ number_format($item->tarif_pln, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->gaji_per_jam, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('config.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
