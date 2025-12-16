@extends('layouts.master')

@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Manajemen Prodi</h3>
            <a href="{{ route('admin.master.prodi.create') }}" class="btn btn-success">Tambah Prodi</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50" class="text-center">No</th>
                            <th>Nama Prodi</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prodis as $key => $prodi)
                            <tr>
                                <td class="text-center">{{ $prodis->firstItem() + $key }}</td>
                                <td>{{ $prodi->nama_prodi }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.master.prodi.edit', $prodi->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.master.prodi.destroy', $prodi->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $prodis->links() }}
            </div>
        </div>
    </div>
@endsection