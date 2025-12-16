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
                            <select required name="prodi" class="form-select" id="prodi">
                                <option value="" disabled>Pilih Prodi</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->nama_prodi }}" {{ $student->prodi == $prodi->nama_prodi ? 'selected' : '' }}>{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select required name="jurusan" class="form-select" id="jurusan">
                                <option value="" disabled>Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->nama_jurusan }}" {{ $student->jurusan == $jurusan->nama_jurusan ? 'selected' : '' }}>{{ $jurusan->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select required name="semester" class="form-select" id="semester">
                                <option value="" disabled>Pilih Semester</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->nama_semester }}" {{ $student->semester == $semester->nama_semester ? 'selected' : '' }}>
                                        {{ $semester->nama_semester }}</option>
                                @endforeach
                            </select>
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