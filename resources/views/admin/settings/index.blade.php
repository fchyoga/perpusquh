@extends('layouts.master')

@section('content')
    <div class="container-fluid pt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0 text-dark">Pengaturan Sistem</h3>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white py-3 px-4 rounded-top-4 border-bottom">
                        <h5 class="m-0 fw-bold">Pengaturan Peminjaman</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="penalty_per_day" class="form-label fw-bold">Nominal Denda Per Hari</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="penalty_per_day" name="penalty_per_day"
                                        value="{{ $penaltyPerDay }}" required>
                                </div>
                                <div class="form-text">Nilai ini akan menjadi default untuk setiap peminjaman baru (termasuk
                                    request dari member).</div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection