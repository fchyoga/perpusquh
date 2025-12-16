@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

    <div class="container pt-5">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-md-6">
                <div class="card auth-card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">Buat Akun Baru</h4>
                            <p class="text-muted">Bergabunglah dengan perpustakaan digital kami</p>
                        </div>

                        <form method="POST" action="{{ route('register.custom') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label text-muted small fw-bold">NAMA LENGKAP</label>
                                <input id="name" type="text"
                                    class="form-control bg-light border-0 @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Nama Lengkap Anda">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label text-muted small fw-bold">ALAMAT EMAIL</label>
                                <input pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" id="email" type="email"
                                    class="form-control bg-light border-0 @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label text-muted small fw-bold">NO HANDPHONE</label>
                                <input name="phone" id="phone" required type="text" class="form-control bg-light border-0"
                                    placeholder="08xxxxxxxxxx" title="gunakan nomor yang valid (08xx) atau (628xx)"
                                    pattern="(08|62)\d{10,11}" oninput="
                                        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
                                        if (this.value.length > 13) this.value = this.value.slice(0, 13);
                                        if (typeof this.reportValidity === 'function') {
                                            this.reportValidity();
                                        }
                                    " />
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password" class="form-label text-muted small fw-bold">PASSWORD</label>
                                    <div class="input-group">
                                        <input onkeyup='check();' id="password" type="password"
                                            class="form-control bg-light border-0 @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="new-password" placeholder="********">
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
                                <div class="col-md-6">
                                    <label for="password-confirm"
                                        class="form-label text-muted small fw-bold">KONFIRMASI</label>
                                    <div class="input-group">
                                        <input onkeyup='check();' id="password-confirm" type="password"
                                            class="form-control bg-light border-0" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="********">
                                        <span class="input-group-text bg-light border-0 cursor-pointer"
                                            onclick="showPasswordConfirm()">
                                            <i id="eyePwConfirm" class="bi bi-eye-slash"></i>
                                        </span>
                                    </div>
                                    <p class="mt-1 small" id="errorMsg"></p>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button id="btn-submit" disabled type="submit"
                                    class="btn btn-primary-custom btn-lg text-white fw-bold shadow-sm"
                                    style="background-color: var(--primary-color);">
                                    DAFTAR SEKARANG
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}"
                                        class="fw-bold text-decoration-none" style="color: var(--primary-color);">Masuk
                                        Disini</a></p>
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

        function showPasswordConfirm() {
            var x = document.getElementById("password-confirm");
            var eye = document.getElementById("eyePwConfirm");

            if (x.type === "password") {
                x.type = "text";
                eye.className = "bi bi-eye input-group-text"
            } else {
                x.type = "password";
                eye.className = "bi bi-eye-slash input-group-text"
            }
        }

        var check = function () {
            let pw = document.getElementById('password');
            let pwC = document.getElementById('password-confirm');
            let msg = document.getElementById('errorMsg');
            let btn = document.getElementById('btn-submit');

            console.log(btn.disabled)
            if (pw.value == pwC.value) {
                if (pw.value.length > 0 || pwC.value.length > 0) {
                    msg.style.color = 'green';
                    msg.innerHTML = 'password cocok';
                    btn.disabled = false;
                }
            } else {
                msg.style.color = 'red';
                msg.innerHTML = 'password tidak sama';
                btn.disabled = true;
            }
        }
    </script>
@endsection