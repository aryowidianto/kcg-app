@extends('adminlte::page')

@section('title', 'Edit Config')

@section('content_header')
    <h1>Edit Config</h1>
@endsection

@section('content')
    <form action="{{ route('config.update', $config->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tarif PLN (Rp/kWh)</label>
            <input type="number" name="tarif_pln" class="form-control" value="{{ old('tarif_pln', $config->tarif_pln) }}" required>
        </div>

        <div class="form-group">
            <label>Gaji Per Jam (Rp)</label>
            <input type="number" name="gaji_per_jam" class="form-control" value="{{ old('gaji_per_jam', $config->gaji_per_jam) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('config.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection