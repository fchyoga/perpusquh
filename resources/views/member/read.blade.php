@extends('layouts.master')

@section('content')
    <div class="container pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>{{ $book->title }}</h3>
            <a href="/member/dashboard" class="btn btn-outline-secondary">Kembali</a>
        </div>

        <div class="card shadow">
            <div class="card-body p-0">
                <iframe src="{{ $book->file_path }}#toolbar=0" width="100%" height="800px" style="border: none;">
                    Browser Anda tidak mendukung PDF.
                </iframe>
            </div>
        </div>

        <div class="alert alert-info mt-3">
            <i class="fa fa-info-circle"></i> E-Book ini dilindungi hak cipta. Dilarang mengunduh atau menyebarluaskan.
        </div>
    </div>

    <script>
        // Disable right click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Disable print shortcut
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && (e.key == 'p' || e.key == 's')) {
                e.preventDefault();
                alert('Fitur ini dinonaktifkan untuk melindungi hak cipta.');
            }
        });
    </script>
@endsection