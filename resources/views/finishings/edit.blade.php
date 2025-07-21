@extends('adminlte::page')

@section('title', 'Edit Finishing')

@section('content_header')
    <h1>Edit Finishing</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('finishings.update', $finishing->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Jenis Finishing</label>
                    <input type="text" name="jenis_finishing" class="form-control" value="{{ $finishing->jenis_finishing }}" required>
                </div>
                <div class="form-group">
                    <label>HPP Trial (Rp)</label>
                    <input type="number" step="0.001" name="hpp_trial" class="form-control" value="{{ $finishing->hpp_trial }}" required>
                </div>
                <div class="form-group">
                    <label>Mesin Finishing</label>
                    <select name="mesin_finishing_id" class="form-control" required>
                        @foreach($mesinFinishings as $mesin)
                            <option value="{{ $mesin->id }}" {{ $finishing->mesin_finishing_id == $mesin->id ? 'selected' : '' }}>
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