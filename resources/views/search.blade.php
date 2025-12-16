@extends('layouts.app')

@section('content')
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" /> -->

    <div class="container pt-5">
        <div class="row">
            <h2>Cari Buku Favorit Kamu</h2>
            <form action="/search" method="GET">
                <div class="input-group mb-3 mt-2">
                    <input class="i-search" type="text" name="keyword" placeholder="Cari judul buku / penulis / penerbit"
                        value="{{ request()->input('keyword') }}">
                    <input type="submit" class="btn btn-outline-secondary" value="Cari"
                        style="border: 1px solid #D0D0D0;height: 50px !important; width: 70px;" />
                </div>
            </form>
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