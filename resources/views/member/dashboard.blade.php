@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Katalog Buku</h2>
                <p class="text-muted mb-0">Temukan buku favoritmu untuk dipinjam</p>
            </div>
            <form action="/member/dashboard" method="GET" class="d-flex">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input class="form-control border-start-0 ps-0" type="search" name="keyword"
                        placeholder="Cari judul, penulis..." value="{{ request()->input('keyword') }}">
                    <button class="btn btn-primary-custom" type="submit">Cari</button>
                </div>
            </form>
        </div>

        <div class="row">
            @foreach ($books as $book)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 border-0 shadow-sm book-card">
                        <div class="position-relative overflow-hidden rounded-top m-2">
                            <img src="{{ $book->cover_image }}" class="card-img-top rounded" alt="{{ $book->title }}"
                                style="height: 300px; object-fit: cover;">
                            @if($book->stock <= 0)
                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 rounded">
                                    <span class="badge bg-danger fs-6">Stok Habis</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column pt-2">
                            <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $book->title }}">{{ $book->title }}</h6>
                            <p class="card-text text-muted small mb-2">{{ $book->author }}</p>
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border">{{ $book->category }}</span>
                                @if($book->stock > 0)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Stok:
                                        {{ $book->stock }}</span>
                                @endif
                            </div>

                            <div class="mt-auto d-grid gap-2">
                                @if($book->stock > 0)
                                    <button type="button" class="btn btn-primary-custom btn-sm fw-bold" 
                                        data-bs-toggle="modal" data-bs-target="#loanModal"
                                        data-book-id="{{ $book->id }}" data-book-title="{{ $book->title }}">
                                        <i class="bi bi-plus-circle me-1"></i> Pinjam
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Tidak Tersedia</button>
                                @endif

                                @if($book->file_path)
                                    <a href="/member/read/{{ $book->id }}" class="btn btn-outline-primary btn-sm fw-bold">
                                        <i class="bi bi-book me-1"></i> Baca E-Book
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $books->links('pagination::bootstrap-4') }}
        </div>
    </div>
    <div class="modal fade" id="loanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajukan Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('member.loan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="book_id" id="book_id">
                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="book_title" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" name="loan_date" id="loan_date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" name="return_date" id="return_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Hari</label>
                            <input type="text" class="form-control" id="total_days" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Pinjam Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var loanModal = document.getElementById('loanModal');
            loanModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var bookId = button.getAttribute('data-book-id');
                var bookTitle = button.getAttribute('data-book-title');

                var bookIdInput = document.getElementById('book_id');
                var bookTitleInput = document.getElementById('book_title');

                bookIdInput.value = bookId;
                bookTitleInput.value = bookTitle;
            });

            var loanDateInput = document.getElementById('loan_date');
            var returnDateInput = document.getElementById('return_date');
            var totalDaysInput = document.getElementById('total_days');

            function calculateDays() {
                var start = new Date(loanDateInput.value);
                var end = new Date(returnDateInput.value);

                if (start && end && !isNaN(start) && !isNaN(end)) {
                    var diffTime = Math.abs(end - start);
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    totalDaysInput.value = diffDays + " Hari";
                } else {
                    totalDaysInput.value = "";
                }
            }

            loanDateInput.addEventListener('change', calculateDays);
            returnDateInput.addEventListener('change', calculateDays);
        });
    </script>
@endsection