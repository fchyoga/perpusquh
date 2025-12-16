@extends('layouts.master')

@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Tambah Jurusan</h3>
            <a href="{{ route('admin.master.jurusan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.master.jurusan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
@endsection