@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <div class="container pt-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-5">
                <div class="card auth-card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo-stmik.png') }}" alt="Logo" width="80" class="mb-3">
                            <h4 class="fw-bold">Selamat Datang</h4>
                            <p class="text-muted">Silahkan masuk untuk melanjutkan</p>
                        </div>

                        <form method="POST" action="{{ route('login.custom') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label text-muted small fw-bold">EMAIL / NIM</label>
                                <input id="email" type="text"
                                    class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="username" autofocus
                                    placeholder="Email atau NIM">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label text-muted small fw-bold">PASSWORD</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" placeholder="********">
                                    <span class="input-group-text bg-light border-0 cursor-pointer"
                                        onclick="showPassword()">
                                        <i id="eyePw" class="bi bi-eye-slash"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-muted" for="remember">
                                        Ingat Saya
                                    </label>
                                </div>
                                <!-- <a href="#" class="small text-decoration-none fw-bold">Lupa Password?</a> -->
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary-custom btn-lg text-white fw-bold shadow-sm"
                                    style="background-color: var(--primary-color);">
                                    MASUK
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="small text-muted">Belum punya akun? <a href="{{ route('register-user') }}"
                                        class="fw-bold text-decoration-none" style="color: var(--primary-color);">Daftar
                                        Sekarang</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showPassword() {
            var x = document.getElementById("password");
            var eye = document.getElementById("eyePw");

            if (x.type === "password") {
                x.type = "text";
                eye.className = "bi bi-eye input-group-text"
            } else {
                x.type = "password";
                eye.className = "bi bi-eye-slash input-group-text"
            }
        }
    </script>
@endsection