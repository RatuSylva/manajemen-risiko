@extends('layouts.app')

@section('title', 'Riwayat Aktivitas')

@section('page-title', 'Riwayat Aktivitas Risiko')

@section(
    'page-description',
    'Pantau perubahan data, status, verifikasi, dan reviu risiko.'
)

@push('styles')
<style>
    .filter-card {
        margin-bottom: 20px;
        padding: 18px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: white;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr repeat(4, 1fr);
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

    .btn-filter,
    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: auto;
        padding: 10px 16px;
        border: none;
        border-radius: 7px;
        color: white;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-filter {
        background: #0B0083;
    }

    .btn-reset {
        background: #6b7280;
    }

    .btn-filter:hover,
    .btn-reset:hover {
        opacity: 0.9;
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
        min-width: 1350px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
        font-size: 13px;
        line-height: 1.5;
    }

    th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #0B0083;
        color: white;
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
        padding: 6px 9px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: bold;
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

    .badge-status {
        background: #eeeeee;
        color: #444;
    }

    .aktivitas {
        color: #0B0083;
        font-weight: bold;
    }

    .tanggal {
        color: #666;
        white-space: nowrap;
    }

    .risiko-dihapus {
        color: #c62828;
        font-style: italic;
    }

    .btn-detail {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 7px;
        background: #0B0083;
        color: white;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        white-space: nowrap;
    }

    .btn-detail:hover {
        opacity: 0.9;
    }

    .data-kosong {
        padding: 35px;
        text-align: center;
        color: #777;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

    @media (max-width: 1100px) {
        .filter-form {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 700px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="filter-card">

    <form
        method="GET"
        action="{{ route('riwayat.index') }}"
    >
        <div class="filter-form">

            <div class="filter-group">
                <label for="search">Pencarian</label>

                <input
                    type="text"
                    name="search"
                    id="search"
                    class="filter-control"
                    value="{{ request('search') }}"
                    placeholder="Kode risiko, nama risiko, pengguna, atau deskripsi"
                >
            </div>

            <div class="filter-group">
                <label for="jenis_aktivitas">
                    Jenis Aktivitas
                </label>

                <select
                    name="jenis_aktivitas"
                    id="jenis_aktivitas"
                    class="filter-control"
                >
                    <option value="">
                        Semua Aktivitas
                    </option>

                    @foreach ([
                        'Tambah Risiko',
                        'Perbarui Risiko',
                        'Hapus Risiko',
                        'Verifikasi Risiko',
                        'Reviu Risiko',
                    ] as $aktivitas)
                        <option
                            value="{{ $aktivitas }}"
                            {{
                                request('jenis_aktivitas') === $aktivitas
                                    ? 'selected'
                                    : ''
                            }}
                        >
                            {{ $aktivitas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="role_pengguna">
                    Peran Pengguna
                </label>

                <select
                    name="role_pengguna"
                    id="role_pengguna"
                    class="filter-control"
                >
                    <option value="">
                        Semua Peran
                    </option>

                    @foreach ([
                        'UPR',
                        'UMR',
                        'UPI',
                    ] as $role)
                        <option
                            value="{{ $role }}"
                            {{
                                request('role_pengguna') === $role
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
                <label for="tanggal_mulai">
                    Tanggal Mulai
                </label>

                <input
                    type="date"
                    name="tanggal_mulai"
                    id="tanggal_mulai"
                    class="filter-control"
                    value="{{ request('tanggal_mulai') }}"
                >
            </div>

            <div class="filter-group">
                <label for="tanggal_selesai">
                    Tanggal Selesai
                </label>

                <input
                    type="date"
                    name="tanggal_selesai"
                    id="tanggal_selesai"
                    class="filter-control"
                    value="{{ request('tanggal_selesai') }}"
                >
            </div>

        </div>

        <div class="filter-actions">

            <button
                type="submit"
                class="btn-filter"
            >
                Terapkan Filter
            </button>

            <a
                href="{{ route('riwayat.index') }}"
                class="btn-reset"
            >
                Reset
            </a>

        </div>

        <div class="filter-result">
            Menampilkan {{ $riwayats->count() }} dari
            {{ $riwayats->total() }} riwayat aktivitas.
        </div>

    </form>

</div>

<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Pengguna</th>
                    <th>Peran</th>
                    <th>Risiko</th>
                    <th>Aktivitas</th>
                    <th>Status Sebelum</th>
                    <th>Status Sesudah</th>
                    <th>Deskripsi</th>
                    <th>Detail</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($riwayats as $riwayat)

                    <tr>

                        <td class="text-center">
                            {{
                                $riwayats->firstItem()
                                + $loop->index
                            }}
                        </td>

                        <td class="tanggal">
                            {{
                                $riwayat->created_at
                                    ? $riwayat->created_at
                                        ->format('d-m-Y H:i')
                                    : '-'
                            }}
                        </td>

                        <td>
                            {{
                                $riwayat->user?->name
                                    ?? 'Pengguna tidak tersedia'
                            }}
                        </td>

                        <td>

                            @if ($riwayat->role_pengguna === 'UPR')

                                <span class="badge badge-upr">
                                    UPR
                                </span>

                            @elseif ($riwayat->role_pengguna === 'UMR')

                                <span class="badge badge-umr">
                                    UMR
                                </span>

                            @elseif ($riwayat->role_pengguna === 'UPI')

                                <span class="badge badge-upi">
                                    UPI
                                </span>

                            @else

                                <span class="badge badge-status">
                                    {{
                                        $riwayat->role_pengguna
                                            ?? '-'
                                    }}
                                </span>

                            @endif

                        </td>

                        <td>

                            @if ($riwayat->risiko)

                                <strong>
                                    {{ $riwayat->risiko->kode_risiko }}
                                </strong>

                                <br>

                                {{ $riwayat->risiko->nama_risiko }}

                            @else

                                <span class="risiko-dihapus">
                                    Data risiko telah dihapus
                                </span>

                            @endif

                        </td>

                        <td class="aktivitas">
                            {{ $riwayat->jenis_aktivitas }}
                        </td>

                        <td>
                            <span class="badge badge-status">
                                {{
                                    $riwayat->status_sebelum
                                        ?? '-'
                                }}
                            </span>
                        </td>

                        <td>
                            <span class="badge badge-status">
                                {{
                                    $riwayat->status_sesudah
                                        ?? '-'
                                }}
                            </span>
                        </td>

                        <td>
                            {{ $riwayat->deskripsi ?? '-' }}
                        </td>

                        <td>

                            @if ($riwayat->risiko)

                                <a
                                    href="{{
                                        route(
                                            'riwayat.show',
                                            $riwayat->risiko->id
                                        )
                                    }}"
                                    class="btn-detail"
                                >
                                    Lihat Detail
                                </a>

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="10"
                            class="data-kosong"
                        >
                            Tidak ada riwayat aktivitas yang sesuai.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if ($riwayats->hasPages())
    <div class="pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center;">

        <div>
            @if ($riwayats->onFirstPage())
                <span style="color: #9ca3af;">Previous</span>
            @else
                <a href="{{ $riwayats->previousPageUrl() }}">
                    Previous
                </a>
            @endif
        </div>

        <div>
            @if ($riwayats->hasMorePages())
                <a href="{{ $riwayats->nextPageUrl() }}">
                    Next
                </a>
            @else
                <span style="color: #9ca3af;">Next</span>
            @endif
        </div>

    </div>
@endif

@endsection