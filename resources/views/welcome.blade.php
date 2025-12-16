@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0 bg-white">
        <div class="hero-section text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="mb-5">
                            <img src="{{ asset('images/logo-stmik.png') }}" alt="Logo" width="100" class="mb-4">
                            <h1 class="display-4 hero-title mb-3">Perpustakaan Digital <br> <span
                                    class="text-primary-custom">STMIK Widya Utama</span></h1>
                            <p class="hero-subtitle mb-5">Akses ribuan koleksi buku akademik dan referensi <br> untuk
                                menunjang pembelajaran Anda.</p>

                            <form action="/search" method="GET" class="d-flex justify-content-center">
                                <div class="search-box d-flex align-items-center w-100" style="max-width: 600px;">
                                    <i class="bi bi-search text-muted ms-3"></i>
                                    <input type="text" name="keyword" class="form-control search-input"
                                        placeholder="Cari judul buku, penulis, atau subjek..."
                                        value="{{ request()->input('keyword') }}">
                                    <button class="btn btn-primary-custom rounded-pill px-4 py-2 m-1"
                                        type="submit">Cari</button>
                                </div>
                            </form>
                        </div>

                        <img src="https://res.cloudinary.com/sarjanalidi/image/upload/v1697855383/illus_zeukdj.png"
                            alt="Illustration" class="img-fluid" style="max-height: 250px; opacity: 0.9;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Paling Sering Dipinjam</h3>
            <a href="/search" class="text-decoration-none fw-bold small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row mb-5">
            @foreach ($mostLoanedBook as $key => $book)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 book-card border-0">
                        <div class="position-relative overflow-hidden rounded-4 m-2">
                            <img src="{{ $book['cover_image']}}" class="card-img-top" alt="{{ $book['title']}}"
                                style="height: 320px; object-fit: cover;">
                        </div>
                        <div class="card-body pt-2">
                            <h6 class="card-title fw-bold text-truncate mb-1">{{ $book['title']}}</h6>
                            <p class="text-muted small mb-2">{{ $book['author'] ?? 'Penulis tidak diketahui' }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark border"><i class="bi bi-journal-bookmark"></i>
                                    {{ $book['loan_count'] }}x Pinjam</span>
                            </div>
                            <a href="/book/{{$book['title']}}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Koleksi Terbaru</h3>
            <a href="/search" class="text-decoration-none fw-bold small">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row">
            @foreach ($newBooks as $key => $book)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 book-card border-0">
                        <div class="position-relative overflow-hidden rounded-4 m-2">
                            <img src="{{ $book['cover_image']}}" class="card-img-top" alt="{{ $book['title']}}"
                                style="height: 320px; object-fit: cover;">
                            <span class="position-absolute top-0 end-0 badge bg-primary m-3">Baru</span>
                        </div>
                        <div class="card-body pt-2">
                            <h6 class="card-title fw-bold text-truncate mb-1">{{ $book['title']}}</h6>
                            <p class="text-muted small mb-2">{{ $book['author'] ?? 'Penulis tidak diketahui' }}</p>
                            <a href="/book/{{$book['title']}}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection