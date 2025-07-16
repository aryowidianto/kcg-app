@extends('adminlte::page')

@section('title', 'Tambah Finishing')

@section('content_header')
    <h1>Tambah Finishing</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('finishings.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jenis Finishing</label>
                    <input type="text" name="jenis_finishing" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>HPP Trial (Rp)</label>
                    <input type="number" step="0.01" name="hpp_trial" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Mesin Finishing</label>
                    <select name="mesin_finishing_id" class="form-control" required>
                        @foreach($mesinFinishings as $mesin)
                            <option value="{{ $mesin->id }}">
                                {{ $mesin->nama }} (Kecepatan: {{ $mesin->kecepatan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@stop