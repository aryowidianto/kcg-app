@extends('adminlte::page')

@section('title', 'Daftar Finishing')

@section('content_header')
    <h1 class="m-0 text-dark">Daftar Finishing</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">List Finishing</h3>
                <a href="{{ route('finishings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Finishing
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="finishing-table">
                    <thead class="bg-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Finishing</th>
                            <th>HPP Trial</th>
                            <th>Mesin Digunakan</th>
                            <th>Kecepatan Mesin</th>
                            <th>Biaya Operator</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($finishings as $key => $finishing)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $finishing->nama }}</td>
                            <td>Rp {{ number_format($finishing->hpp_trial, 0, ',', '.') }}</td>
                            <td>{{ $finishing->mesin->nama }}</td>
                            <td>{{ $finishing->mesin->kecepatan }} unit/jam</td>
                            <td>Rp {{ number_format($finishing->mesin->upah_operator * $finishing->mesin->jumlah_operator, 0, ',', '.') }}/jam</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('finishings.edit', $finishing->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('finishings.destroy', $finishing->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@stop

@section('css')
    <style>
        #finishing-table th {
            vertical-align: middle;
            text-align: center;
        }
        .btn-group {
            display: flex;
            gap: 5px;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#finishing-table').DataTable({
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });
        });
    </script>
@stop