@extends('layouts.master')

@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Dashboard</h2>
            <div class="text-muted">
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid var(--primary-color) !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase fw-bold small">Total Buku</p>
                                <h2 class="fw-bold mb-0 text-dark">{{ $totalBooks }}</h2>
                            </div>
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-book text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #10b981 !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase fw-bold small">Total Anggota</p>
                                <h2 class="fw-bold mb-0 text-dark">{{ $totalMembers }}</h2>
                            </div>
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-people text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-left: 5px solid #f59e0b !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted mb-1 text-uppercase fw-bold small">Peminjaman Aktif</p>
                                <h2 class="fw-bold mb-0 text-dark">{{ $activeLoans }}</h2>
                            </div>
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-arrow-left-right text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-5 text-center">
                <img src="{{ asset('images/logo-stmik.png') }}" alt="Logo" width="100" class="mb-4 opacity-75">
                <h4 class="fw-bold">Selamat Datang, {{ auth()->user()->name }}!</h4>
                <p class="text-muted">Anda login sebagai Administrator. Gunakan menu di sidebar untuk mengelola sistem.</p>
            </div>
        </div>
    </div>
@endsection