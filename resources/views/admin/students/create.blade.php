@extends('layouts.master') @section('content')

    <head>
        <div class="container pt-5">
            <div class="d-flex justify-content-between align-items-center">
                <div class="title">
                    <a href="/dashboard/student-management" class="btn btn-outline-danger mb-3"> <- Kembali</a>
                </div>
            </div>
            <form method="POST" action="/dashboard/student-management/store" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input required type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input required type="text" name="nim" class="form-control" id="nim">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email (Opsional)</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Jika kosong, akan digenerate dari NIM">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password (Opsional)</label>
                                <input type="password" name="password" class="form-control" id="password"
                                    placeholder="Jika kosong, default: NIM">
                            </div>
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Prodi</label>
                                <input required type="text" name="prodi" class="form-control" id="prodi">
                            </div>
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input required type="text" name="jurusan" class="form-control" id="jurusan">
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <input required type="number" name="semester" class="form-control" id="semester">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
@endsection