@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0 text-dark">Detail Peminjaman</h3>
            <a href="/dashboard/loan-management" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center rounded-top-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                    <h5 class="m-0 fw-bold">Informasi Peminjaman</h5>
                    @if($loans['status'] == 'Sedang Dipinjam')
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">{{$loans['status']}}</span>
                    @elseif($loans['status'] == 'Menunggu Persetujuan')
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">{{$loans['status']}}</span>
                    @elseif($loans['status'] == 'Telah Dikembalikan')
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">{{$loans['status']}}</span>
                    @elseif($loans['status'] == 'Ditolak')
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">{{$loans['status']}}</span>
                    @else
                         <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill">{{$loans['status']}}</span>
                    @endif
                </div>
                
                <div class="d-flex gap-2">
                     @if($loans['status'] == 'Sedang Dipinjam')
                        <a href="/dashboard/loan-management/approve/{{ $loans['id'] }}" class="btn btn-success fw-bold px-4" onclick="return confirm('Konfirmasi pengembalian buku?')">
                            <i class="bi bi-check-circle me-1"></i> Kembalikan
                        </a>
                     @elseif($loans['status'] == 'Menunggu Persetujuan')
                        <a href="/dashboard/loan-management/accept/{{ $loans['id'] }}" class="btn btn-primary fw-bold px-4">
                             <i class="bi bi-check-lg me-1"></i> Setujui
                        </a>
                        <a href="/dashboard/loan-management/reject/{{ $loans['id'] }}" class="btn btn-danger fw-bold px-4" onclick="return confirm('Tolak peminjaman ini?')">
                             <i class="bi bi-x-lg me-1"></i> Tolak
                        </a>
                    @endif
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Left Column: Borrower Info -->
                    <div class="col-lg-4 border-end">
                        <form action="/dashboard/loan-management/update/{{ $loans['id'] }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="text-muted text-uppercase small fw-bold mb-3 ls-1">Data Peminjam</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Nama Anggota</label>
                            <p class="fw-bold text-dark fs-5 mb-0">{{$loans['user']['name']}}</p>
                        </div>
                        
                        <div class="row mb-3">
                             <div class="col-6">
                                <label class="form-label text-muted small mb-1">NIM</label>
                                <p class="fw-medium text-dark mb-0">{{$loans['user']['nim'] ?? '-'}}</p>
                             </div>
                             <div class="col-6">
                                <label class="form-label text-muted small mb-1">Prodi</label>
                                <p class="fw-medium text-dark mb-0">{{$loans['user']['prodi'] ?? '-'}}</p>
                             </div>
                        </div>

                         <hr class="my-4 text-muted opacity-25">

                        <h6 class="text-muted text-uppercase small fw-bold mb-3 ls-1">Edit Peminjaman</h6>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Tanggal Pinjam</label>
                            <input type="text" class="form-control bg-light" value="{{ date('d M Y', strtotime($loans['loan_date'] ?? $loans['created_at'])) }}" readonly>
                        </div>

                        <div class="mb-3">
                             <label for="return_date" class="form-label text-muted small mb-1">Tenggat Kembali</label>
                             <input type="date" name="return_date" id="return_date" class="form-control" value="{{$loans['return_date']}}" required>
                        </div>

                        <div class="mb-3">
                             <label for="penalty_per_day" class="form-label text-muted small mb-1">Denda Per Hari (Rp)</label>
                             <input type="number" name="penalty_per_day" id="penalty_per_day" class="form-control" value="{{$loans['penalty_per_day'] ?? 20000}}" required>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="text-muted small mb-1">Catatan</label>
                             <textarea name="note" id="note" class="form-control" rows="2">{{$loans['note']}}</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-sm">Update Data</button>
                        </div>
                        </form>

                    </div>

                    <!-- Right Column: Book List -->
                    <div class="col-lg-8 ps-lg-4">
                        <h6 class="text-muted text-uppercase small fw-bold mb-3 ls-1">Buku yang Dipinjam</h6>
                        
                         <div class="table-responsive">
                            <table class="table table-hover align-middle border-top">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3 ps-3 rounded-start">No</th>
                                        <th class="py-3">Cover</th>
                                        <th class="py-3 w-50">Judul Buku</th>
                                        <th class="py-3 text-center rounded-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($loan_items as $key => $loan_item)
                                        <tr>
                                            <td class="ps-3 fw-bold text-muted">{{$key + 1}}</td>
                                            <td>
                                                <div class="ratio ratio-3x4 rounded overflow-hidden shadow-sm" style="width: 60px;">
                                                    <img src="{{ $loan_item['book']['cover_image'] }}" class="object-fit-cover" alt="cover">
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="fw-bold mb-1 text-dark">{{ $loan_item['book_title'] }}</h6>
                                                <span class="small text-muted">{{ $loan_item['book']['author'] ?? '-' }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($loans['status'] == 'Sedang Dipinjam')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">Dipinjam</span>
                                                @elseif($loans['status'] == 'Menunggu Persetujuan')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill">Menunggu</span>
                                                @elseif($loans['status'] == 'Telah Dikembalikan')
                                                     <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Dikembalikan</span>
                                                @else
                                                     <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">{{$loans['status']}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="bi bi-book fs-1 d-block mb-2 text-secondary opacity-25"></i>
                                                Tidak ada buku dalam peminjaman ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection