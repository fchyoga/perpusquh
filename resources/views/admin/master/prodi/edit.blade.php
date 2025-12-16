@extends('layouts.master')

@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Edit Prodi</h3>
            <a href="{{ route('admin.master.prodi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.master.prodi.update', $prodi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama Prodi</label>
                        <input type="text" name="nama_prodi" class="form-control" value="{{ $prodi->nama_prodi }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection