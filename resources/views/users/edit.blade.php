@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('page-title', 'Edit Pengguna')

@section(
    'page-description',
    'Perbarui identitas, username, role, atau password akun pengguna.'
)

@push('styles')
<style>
    .form-card {
        max-width: 760px;
        padding: 24px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: white;
    }

    .alert-error,
    .information-box {
        margin-bottom: 20px;
        padding: 13px 15px;
        border-radius: 7px;
        font-size: 13px;
        line-height: 1.6;
    }

    .alert-error {
        background: #ffeaea;
        color: #c62828;
    }

    .information-box {
        border-left: 4px solid #0B0083;
        background: #f2f1ff;
        color: #333;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: #333;
        font-size: 13px;
        font-weight: 700;
    }

    .required-mark {
        color: #c62828;
    }

    .form-control {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: white;
        color: #333;
        font-family: inherit;
        font-size: 13px;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #0B0083;
        box-shadow: 0 0 0 3px rgba(11, 0, 131, 0.1);
    }

    .form-control.is-invalid {
        border-color: #c62828;
    }

    .form-control:disabled {
        background: #f3f4f6;
        color: #777;
        cursor: not-allowed;
    }

    .error-text {
        display: block;
        margin-top: 6px;
        color: #c62828;
        font-size: 11px;
    }

    .helper-text {
        display: block;
        margin-top: 6px;
        color: #777;
        font-size: 11px;
        line-height: 1.5;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 24px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border: none;
        border-radius: 7px;
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary {
        background: #0B0083;
    }

    .btn-secondary {
        background: #6b7280;
    }

    .btn:hover {
        opacity: 0.9;
    }

    @media (max-width: 700px) {
        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

@if ($errors->any())
    <div class="alert-error">
        <strong>Data belum dapat diperbarui.</strong>
        <br>
        Silakan periksa kembali data yang diisi.
    </div>
@endif

@if ($user->id === Auth::id())
    <div class="information-box">
        Ini adalah akun yang sedang Anda gunakan. Role akun sendiri
        tidak dapat diubah melalui halaman ini.
    </div>
@endif

<div class="form-card">

    <form
        method="POST"
        action="{{ route('users.update', $user->id) }}"
    >
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">
                Nama Pengguna
                <span class="required-mark">*</span>
            </label>

            <input
                type="text"
                name="name"
                id="name"
                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                value="{{ old('name', $user->name) }}"
                maxlength="255"
                required
                autofocus
            >

            @error('name')
                <span class="error-text">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">
                Username
                <span class="required-mark">*</span>
            </label>

            <input
                type="text"
                name="username"
                id="username"
                class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                value="{{ old('username', $user->username) }}"
                maxlength="100"
                required
            >

            <span class="helper-text">
                Gunakan huruf, angka, tanda minus, atau garis bawah tanpa spasi.
            </span>

            @error('username')
                <span class="error-text">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">
                Email
                <span class="required-mark">*</span>
            </label>

            <input
                type="email"
                name="email"
                id="email"
                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email', $user->email) }}"
                maxlength="255"
                required
            >

            @error('email')
                <span class="error-text">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="role">
                Role Pengguna
                <span class="required-mark">*</span>
            </label>

            <select
                name="role"
                id="role"
                class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}"
                required
                {{ $user->id === Auth::id() ? 'disabled' : '' }}
            >
                <option
                    value="UPR"
                    {{
                        old('role', $user->role) === 'UPR'
                            ? 'selected'
                            : ''
                    }}
                >
                    UPR - Unit Pemilik Risiko
                </option>

                <option
                    value="UMR"
                    {{
                        old('role', $user->role) === 'UMR'
                            ? 'selected'
                            : ''
                    }}
                >
                    UMR - Unit Manajemen Risiko
                </option>

                <option
                    value="UPI"
                    {{
                        old('role', $user->role) === 'UPI'
                            ? 'selected'
                            : ''
                    }}
                >
                    UPI - Unit Pengawas Intern
                </option>
            </select>

            @if ($user->id === Auth::id())
                <input
                    type="hidden"
                    name="role"
                    value="{{ $user->role }}"
                >
            @endif

            @error('role')
                <span class="error-text">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">
                Password Baru
            </label>

            <input
                type="password"
                name="password"
                id="password"
                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                minlength="8"
            >

            <span class="helper-text">
                Kosongkan jika password tidak ingin diubah.
            </span>

            @error('password')
                <span class="error-text">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                minlength="8"
            >
        </div>

        <div class="form-actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>

            <a
                href="{{ route('users.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection