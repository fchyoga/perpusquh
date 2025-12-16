@extends('layouts.app')

@section('content')
  <div class="container pt-5">
    <div class="row justify-content-center mt-3">
      <div class="col-md-10">
        <a href="/" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i> Kembali</a>
        <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 15px;">
          <div class="row g-0">
            <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4">
              <img src="{{ $books[0]['cover_image']}}" class="img-fluid shadow" alt="{{$books[0]['title']}}"
                style="border-radius: 10px; max-height: 400px;">
            </div>
            <div class="col-md-8">
              <div class="card-body p-5">
                <h1 class="fw-bold mb-2">{{$books[0]['title']}}</h1>
                <h4 class="text-muted mb-4">{{$books[0]['author']}}</h4>

                <div class="row mb-4">
                  <div class="col-md-6 mb-3">
                    <small class="text-uppercase text-muted fw-bold">Penerbit</small>
                    <div class="fs-5">{{$books[0]['publisher']}}</div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <small class="text-uppercase text-muted fw-bold">Kategori</small>
                    <div class="fs-5">{{$books[0]['category']}}</div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <small class="text-uppercase text-muted fw-bold">Total Halaman</small>
                    <div class="fs-5">{{$books[0]['total_pages']}} Halaman</div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <small class="text-uppercase text-muted fw-bold">Stok Tersedia</small>
                    <div class="fs-5">{{$books[0]['stock']}} Buku</div>
                  </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Deskripsi Buku</h5>
                <p class="card-text text-secondary" style="line-height: 1.8;">
                  {{$books[0]['description']}}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection