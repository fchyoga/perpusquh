@extends('layouts.app')

@section('content')
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" /> -->

    <div class="container pt-5">
        <div class="row">
            <div class="text-center mb-4">
                <h2 class="fw-bold mb-3">Cari Buku Favorit Kamu</h2>
                <form action="/search" method="GET" class="d-flex justify-content-center">
                    <div class="search-box d-flex align-items-center w-100" style="max-width: 600px;">
                        <i class="bi bi-search text-muted ms-3"></i>
                        <input type="text" name="keyword" class="form-control search-input"
                            placeholder="Cari judul buku, penulis, atau subjek..."
                            value="{{ request()->input('keyword') }}">
                        <button class="btn btn-primary-custom rounded-pill px-4 py-2 m-1" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12 mt-4">
                <div class="row">
                    @foreach ($books as $key => $book)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 book-card border-0 shadow-sm">
                                <div class="card-img-top-wrapper"
                                    style="height: 300px; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                    <img src="{{ $book['cover_image'] }}" class="card-img-top" alt="{{ $book['title'] }}"
                                        style="max-height: 100%; width: auto; object-fit: contain;">
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-truncate" title="{{ $book['title'] }}">{{ $book['title'] }}</h5>
                                    <p class="card-text text-muted small mb-2">{{ $book['author'] }}</p>
                                    <div class="mt-auto">
                                        <a href="book/{{$book['title']}}" class="btn btn-primary w-100">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(count($books) < 1)
                    <div class="text-center py-5">
                        <h5 class="text-muted">Buku Tidak Ditemukan</h5>
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-center" style="background: none;">
                {{$books->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
@endsection