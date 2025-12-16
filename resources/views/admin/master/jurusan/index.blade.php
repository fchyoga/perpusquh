@extends('layouts.master')

@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Manajemen Jurusan</h3>
            <a href="{{ route('admin.master.jurusan.create') }}" class="btn btn-success">Tambah Jurusan</a>
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
                            <th>Nama Jurusan</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jurusans as $key => $jurusan)
                            <tr>
                                <td class="text-center">{{ $jurusans->firstItem() + $key }}</td>
                                <td>{{ $jurusan->nama_jurusan }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.master.jurusan.edit', $jurusan->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.master.jurusan.destroy', $jurusan->id) }}" method="POST"
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
                {{ $jurusans->links() }}
            </div>
        </div>
    </div>
@endsection