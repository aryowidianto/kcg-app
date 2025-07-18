@extends('adminlte::page')

@section('title', 'Data Finishing')

@section('content_header')
    <h1>Data Finishing</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('finishings.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Finishing</th>
                        <th>HPP Trial</th>
                        <th>Mesin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finishings as $finishing)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $finishing->jenis_finishing }}</td>
                        <td>Rp {{ number_format($finishing->hpp_trial, 2, ',', '.') }}</td>
                        <td>{{ $finishing->mesinFinishing->nama }}</td>
                        <td>
                            <a href="{{ route('finishings.edit', $finishing->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('finishings.destroy', $finishing->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop