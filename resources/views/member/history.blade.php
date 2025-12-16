@extends('layouts.master')

@section('content')
    <div class="container pt-5">
        <h2 class="mb-4">Riwayat Peminjaman</h2>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali (Target)</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        @foreach ($loan->loan_items as $item)
                            <tr>
                                <td>{{ $item->book_title }}</td>
                                <td>{{ $loan->created_at->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($loan->return_date)->format('d M Y') }}</td>
                                <td>
                                    @if($loan->returned_date && $loan->status == 'Telah Dikembalikan')
                                        {{ \Carbon\Carbon::parse($loan->returned_date)->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($loan->status == 'Telah Dikembalikan')
                                        <span class="badge bg-success">{{ $loan->status }}</span>
                                    @elseif($loan->status == 'Sedang Dipinjam')
                                        <span class="badge bg-warning text-dark">{{ $loan->status }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $loan->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->penalty_price > 0)
                                        <span class="text-danger">Rp {{ number_format($loan->penalty_price, 0, ',', '.') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    @if($loans->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $loans->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection