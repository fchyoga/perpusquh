@extends('layouts.master')
@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-between align-items-center">
            <div class="title">
                <a href="/dashboard/student-management" class="btn btn-outline-danger mb-3"> <- Kembali</a>
                        <!-- <h1 class="title-text">Edit Siswa</h1>
                <p class="title-desc mt-1">Mengedit Siswa di SMPN 1 Nasional</p> -->
            </div>
        </div>
        <form method="POST" action="/dashboard/student-management/update/{{ $student->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input required type="text" name="name" class="form-control" id="name"
                                value="{{ $student->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label">NIM</label>
                            <input required type="text" name="nim" class="form-control" id="nim"
                                value="{{ $student->nim }}">
                        </div>
                        <div class="mb-3">
                            <label for="prodi" class="form-label">Prodi</label>
                            <input required type="text" name="prodi" class="form-control" id="prodi"
                                value="{{ $student->prodi }}">
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input required type="text" name="jurusan" class="form-control" id="jurusan"
                                value="{{ $student->jurusan }}">
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <input required type="number" name="semester" class="form-control" id="semester"
                                value="{{ $student->semester }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6">
                    <button type="submit" class="btn btn-success">Edit</button>
                </div>
            </div>
        </form>
    </div>
@endsection