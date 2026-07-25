@extends('layouts.app')

@section('title', 'Pengelolaan Pengguna')

@section('page-title', 'Pengelolaan Pengguna')

@section(
    'page-description',
    'Kelola akun UPR, UMR, dan UPI serta status aktif pengguna.'
)

@push('styles')
<style>
    .page-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 14px;
        border: none;
        border-radius: 7px;
        color: white;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .btn-primary {
        background: #0B0083;
    }

    .btn-edit {
        background: #e6a700;
    }

    .btn-aktif {
        background: #16803b;
    }

    .btn-nonaktif {
        background: #c62828;
    }

    .btn-disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    .alert-success,
    .alert-error {
        margin-bottom: 20px;
        padding: 13px 15px;
        border-radius: 7px;
        font-size: 13px;
        line-height: 1.6;
    }

    .alert-success {
        background: #dff5e3;
        color: #256029;
    }

    .alert-error {
        background: #ffeaea;
        color: #c62828;
    }

    .information-box {
        margin-bottom: 20px;
        padding: 14px 16px;
        border-left: 4px solid #0B0083;
        border-radius: 7px;
        background: #f2f1ff;
        color: #333;
        font-size: 13px;
        line-height: 1.6;
    }

    .filter-card {
        margin-bottom: 20px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: white;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 12px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .filter-group label {
        color: #444;
        font-size: 12px;
        font-weight: 700;
    }

    .filter-control {
        width: 100%;
        height: 40px;
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: white;
        color: #333;
        font-family: inherit;
        font-size: 12px;
    }

    .filter-control:focus {
        outline: none;
        border-color: #0B0083;
        box-shadow: 0 0 0 3px rgba(11, 0, 131, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }

    .btn-filter {
        background: #0B0083;
    }

    .btn-reset {
        background: #6b7280;
    }

    .filter-result {
        margin-top: 12px;
        color: #666;
        font-size: 12px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 1000px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: middle;
        font-size: 13px;
    }

    th {
        background: #0B0083;
        color: white;
        text-align: center;
        white-space: nowrap;
    }

    tbody tr:hover {
        background: #f8f8fc;
    }

    .text-center {
        text-align: center;
    }

    .badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-upr {
        background: #e8e5ff;
        color: #0B0083;
    }

    .badge-umr {
        background: #fff3cd;
        color: #856404;
    }

    .badge-upi {
        background: #d4edda;
        color: #155724;
    }

    .badge-aktif {
        background: #d4edda;
        color: #155724;
    }

    .badge-nonaktif {
        background: #f8d7da;
        color: #721c24;
    }

    .akun-sendiri {
        display: block;
        margin-top: 5px;
        color: #0B0083;
        font-size: 10px;
        font-weight: 700;
    }

    .aksi {
        display: flex;
        justify-content: center;
        gap: 7px;
    }

    .aksi form {
        margin: 0;
    }

    .data-kosong {
        padding: 35px;
        text-align: center;
        color: #777;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

    @media (max-width: 800px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-actions,
        .page-actions {
            flex-direction: column;
        }

        .filter-actions .btn,
        .page-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="page-actions">
    <a
        href="{{ route('users.create') }}"
        class="btn btn-primary"
    >
        + Tambah Pengguna
    </a>
</div>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-error">
        {{ $errors->first() }}
    </div>
@endif

<div class="information-box">
    Akun pengguna sebaiknya dinonaktifkan apabila pegawai pindah unit,
    pensiun, mengundurkan diri, atau tidak lagi memiliki tanggung jawab.
    Akun tidak perlu dihapus agar riwayat aktivitas tetap tersimpan.
</div>

<div class="filter-card">

    <form
        method="GET"
        action="{{ route('users.index') }}"
    >
        <div class="filter-form">

            <div class="filter-group">
                <label for="search">
                    Pencarian
                </label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="filter-control"
                    value="{{ request('search') }}"
                    placeholder="Cari nama, email, atau role"
                >
            </div>

            <div class="filter-group">
                <label for="role">
                    Role
                </label>

                <select
                    name="role"
                    id="role"
                    class="filter-control"
                >
                    <option value="">
                        Semua Role
                    </option>

                    @foreach (['UPR', 'UMR', 'UPI'] as $role)
                        <option
                            value="{{ $role }}"
                            {{
                                request('role') === $role
                                    ? 'selected'
                                    : ''
                            }}
                        >
                            {{ $role }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="status">
                    Status Akun
                </label>

                <select
                    name="status"
                    id="status"
                    class="filter-control"
                >
                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="aktif"
                        {{
                            request('status') === 'aktif'
                                ? 'selected'
                                : ''
                        }}
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        {{
                            request('status') === 'nonaktif'
                                ? 'selected'
                                : ''
                        }}
                    >
                        Nonaktif
                    </option>
                </select>
            </div>

        </div>

        <div class="filter-actions">

            <button
                type="submit"
                class="btn btn-filter"
            >
                Terapkan Filter
            </button>

            <a
                href="{{ route('users.index') }}"
                class="btn btn-reset"
            >
                Reset
            </a>

        </div>

        <div class="filter-result">
            Menampilkan {{ $users->count() }} dari
            {{ $users->total() }} pengguna.
        </div>

    </form>

</div>

<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status Akun</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($users as $user)

                    <tr>

                        <td class="text-center">
                            {{
                                $users->firstItem()
                                + $loop->index
                            }}
                        </td>

                        <td>
                            <strong>
                                {{ $user->name }}
                            </strong>

                            @if ($user->id === Auth::id())
                                <span class="akun-sendiri">
                                    Akun Anda
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $user->username }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td class="text-center">

                            @if ($user->role === 'UPR')

                                <span class="badge badge-upr">
                                    UPR
                                </span>

                            @elseif ($user->role === 'UMR')

                                <span class="badge badge-umr">
                                    UMR
                                </span>

                            @elseif ($user->role === 'UPI')

                                <span class="badge badge-upi">
                                    UPI
                                </span>

                            @else

                                <span class="badge">
                                    {{ $user->role ?? '-' }}
                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            @if ($user->is_active)

                                <span class="badge badge-aktif">
                                    Aktif
                                </span>

                            @else

                                <span class="badge badge-nonaktif">
                                    Nonaktif
                                </span>

                            @endif

                        </td>

                        <td class="text-center">
                            {{
                                $user->created_at
                                    ? $user->created_at
                                        ->format('d-m-Y H:i')
                                    : '-'
                            }}
                        </td>

                        <td>

                            <div class="aksi">

                                <a
                                    href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-edit"
                                >
                                    Edit
                                </a>

                                @if ($user->id === Auth::id())

                                    <button
                                        type="button"
                                        class="btn btn-disabled"
                                        disabled
                                    >
                                        Akun Sendiri
                                    </button>

                                @else

                                    <form
                                        method="POST"
                                        action="{{
                                            route(
                                                'users.toggle-status',
                                                $user->id
                                            )
                                        }}"
                                        onsubmit="return confirm(
                                            '{{ $user->is_active
                                                ? 'Yakin ingin menonaktifkan akun ini?'
                                                : 'Yakin ingin mengaktifkan kembali akun ini?'
                                            }}'
                                        )"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="btn {{
                                                $user->is_active
                                                    ? 'btn-nonaktif'
                                                    : 'btn-aktif'
                                            }}"
                                        >
                                            {{
                                                $user->is_active
                                                    ? 'Nonaktifkan'
                                                    : 'Aktifkan'
                                            }}
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="8"
                            class="data-kosong"
                        >
                            Tidak ada pengguna yang sesuai.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if ($users->hasPages())
    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
@endif

@endsection