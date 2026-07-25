@extends('layouts.app')

@section('title', 'Risk Register')

@section('page-title', 'Risk Register')

@section(
    'page-description',
    'Kelola identifikasi, analisis, dan rencana penanganan risiko Unit PDSI BP Batam.'
)

@push('styles')
<style>
    .page-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 9px 14px;
        border: none;
        border-radius: 7px;
        background: #0B0083;
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

    .btn-edit {
        background: #e6a700;
    }

    .btn-delete {
        background: #c62828;
    }

    .alert-success {
        margin-bottom: 20px;
        padding: 13px 15px;
        border-radius: 7px;
        background: #dff5e3;
        color: #256029;
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
        grid-template-columns: 2fr repeat(5, 1fr);
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
        font-size: 12px;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
        margin-top: 14px;
    }

    .btn-reset {
        background: #6b7280;
    }

    .filter-result {
        margin-top: 12px;
        color: #666;
        font-size: 12px;
    }

    .pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 20px;
        padding: 14px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: white;
    }

    .pagination-info {
        color: #666;
        font-size: 12px;
    }

    .pagination-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination-link,
    .pagination-disabled {
        min-width: 36px;
        height: 36px;
        padding: 0 11px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #0B0083;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .pagination-link:hover {
        border-color: #0B0083;
        background: #f2f1ff;
    }

    .pagination-link.active {
        border-color: #0B0083;
        background: #0B0083;
        color: white;
    }

    .pagination-disabled {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    @media (max-width: 1200px) {
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
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 3600px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
        font-size: 12px;
        line-height: 1.5;
    }

    th {
        position: sticky;
        top: 0;
        z-index: 2;
        background: #0B0083;
        color: white;
        text-align: center;
        white-space: nowrap;
    }

    .group-header {
        background: #29209b;
        font-size: 13px;
    }

    tbody tr:hover {
        background: #f8f8fc;
    }

    .text-center {
        text-align: center;
    }

    .text-wrap {
        min-width: 180px;
        white-space: normal;
    }

    .text-wide {
        min-width: 240px;
        white-space: normal;
    }

    .number-value {
        text-align: center;
        font-weight: 700;
    }

    .aksi {
        display: flex;
        gap: 6px;
    }

    .aksi form {
        margin: 0;
    }

    .badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 14px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .badge-rendah {
        background: #d4edda;
        color: #155724;
    }

    .badge-sedang {
        background: #fff3cd;
        color: #856404;
    }

    .badge-tinggi {
        background: #ffe5b4;
        color: #8a4b00;
    }

    .badge-ekstrim {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-netral {
        background: #eeeeee;
        color: #444;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .peringatan {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 14px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .terlambat {
        background: #f8d7da;
        color: #721c24;
    }

    .hari-ini {
        background: #fff3cd;
        color: #856404;
    }

    .mendekati {
        background: #ffe5b4;
        color: #8a4b00;
    }

    .aman {
        color: #777;
    }

    .catatan-perbaikan {
        color: #c62828;
        font-weight: 700;
    }

    .data-kosong {
        padding: 35px;
        text-align: center;
        color: #777;
    }

    @media (max-width: 700px) {
        .page-actions {
            align-items: stretch;
            flex-direction: column;
        }

        .page-actions .btn {
            text-align: center;
        }

        .pagination-wrapper {
            align-items: stretch;
            flex-direction: column;
        }

        .pagination-buttons {
            flex-wrap: wrap;
        }
    }

</style>
@endpush

@section('content')

<div class="page-actions">
    <a
        href="{{ route('risiko.create') }}"
        class="btn"
    >
        + Tambah Risk Register
    </a>
</div>

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="information-box">
    Geser tabel ke kanan untuk melihat seluruh data Risk Register,
    termasuk analisis risiko saat ini, rencana penanganan, dan risiko residual.
</div>

<div class="filter-card">

    <form
        method="GET"
        action="{{ route('risiko.index') }}"
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
                    placeholder="Kode, peristiwa, sasaran, atau kategori"
                >
            </div>

            <div class="filter-group">
                <label for="kategori_risiko">Kategori</label>

                <select
                    name="kategori_risiko"
                    id="kategori_risiko"
                    class="filter-control"
                >
                    <option value="">Semua Kategori</option>

                    @foreach ([
                        'Risiko Reputasi',
                        'Risiko Keuangan (Rupiah)',
                        'Keselamatan dan Kesehatan Kerja',
                        'Layanan',
                        'Proyek',
                        'Kinerja',
                        'Operasional',
                    ] as $kategori)
                        <option
                            value="{{ $kategori }}"
                            {{ request('kategori_risiko') === $kategori ? 'selected' : '' }}
                        >
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="level_risiko">Level Risiko</label>

                <select
                    name="level_risiko"
                    id="level_risiko"
                    class="filter-control"
                >
                    <option value="">Semua Level</option>

                    @foreach ([
                        'Rendah',
                        'Sedang',
                        'Tinggi',
                        'Ekstrim',
                    ] as $level)
                        <option
                            value="{{ $level }}"
                            {{ request('level_risiko') === $level ? 'selected' : '' }}
                        >
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="status_penanganan">
                    Status Penanganan
                </label>

                <select
                    name="status_penanganan"
                    id="status_penanganan"
                    class="filter-control"
                >
                    <option value="">Semua Status</option>

                    @foreach ([
                        'Belum Ditangani',
                        'Sedang Berjalan',
                        'Selesai',
                    ] as $status)
                        <option
                            value="{{ $status }}"
                            {{ request('status_penanganan') === $status ? 'selected' : '' }}
                        >
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="status_verifikasi">
                    Status Verifikasi
                </label>

                <select
                    name="status_verifikasi"
                    id="status_verifikasi"
                    class="filter-control"
                >
                    <option value="">Semua Status</option>

                    @foreach ([
                        'Menunggu Verifikasi',
                        'Perlu Perbaikan',
                        'Disetujui',
                    ] as $status)
                        <option
                            value="{{ $status }}"
                            {{ request('status_verifikasi') === $status ? 'selected' : '' }}
                        >
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="status_reviu">Status Reviu</label>

                <select
                    name="status_reviu"
                    id="status_reviu"
                    class="filter-control"
                >
                    <option value="">Semua Status</option>

                    @foreach ([
                        'Belum Direviu',
                        'Perlu Perbaikan',
                        'Disetujui',
                    ] as $status)
                        <option
                            value="{{ $status }}"
                            {{ request('status_reviu') === $status ? 'selected' : '' }}
                        >
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="filter-actions">
            <button type="submit" class="btn">
                Terapkan Filter
            </button>

            <a
                href="{{ route('risiko.index') }}"
                class="btn btn-reset"
            >
                Reset
            </a>
        </div>

        <div class="filter-result">
            Menampilkan {{ $risikos->count() }} dari
            {{ $risikos->total() }} data risiko.
        </div>

    </form>

</div>

<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th rowspan="2">No.</th>

                    <th
                        colspan="6"
                        class="group-header"
                    >
                        Identifikasi Risiko
                    </th>

                    <th
                        colspan="6"
                        class="group-header"
                    >
                        Analisis Risiko Saat Ini
                    </th>

                    <th
                        colspan="3"
                        class="group-header"
                    >
                        Rencana Penanganan Risiko
                    </th>

                    <th
                        colspan="5"
                        class="group-header"
                    >
                        Analisis Risiko Residual
                    </th>

                    <th
                        colspan="6"
                        class="group-header"
                    >
                        Status Sistem
                    </th>

                    <th rowspan="2">Aksi</th>
                </tr>

                <tr>
                    <th>Sasaran Strategis</th>
                    <th>Kode</th>
                    <th>Peristiwa Risiko</th>
                    <th>Kategori</th>
                    <th>Penyebab Risiko</th>
                    <th>Dampak Risiko</th>

                    <th>Kontrol Eksisting</th>
                    <th>Kemungkinan</th>
                    <th>Dampak</th>
                    <th>Level Risiko</th>
                    <th>R/M/T/E</th>
                    <th>Kuantifikasi</th>

                    <th>Rencana Penanganan</th>
                    <th>Target Waktu</th>
                    <th>Unit Pemilik Risiko</th>

                    <th>Target Kemungkinan</th>
                    <th>Target Dampak</th>
                    <th>Level Residual</th>
                    <th>R/M/T/E Residual</th>
                    <th>Kuantifikasi Residual</th>

                    <th>Status Penanganan</th>
                    <th>Peringatan</th>
                    <th>Status Verifikasi</th>
                    <th>Status Reviu</th>
                    <th>Catatan Perbaikan</th>
                    <th>Riwayat Terakhir</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($risikos as $risiko)

                    <tr>

                        <td class="text-center">
                            {{ $risikos->firstItem() + $loop->index }}
                        </td>

                        {{-- IDENTIFIKASI RISIKO --}}

                        <td class="text-wide">
                            {{ $risiko->sasaran ?: '-' }}
                        </td>

                        <td>
                            <strong>
                                {{ $risiko->kode_risiko }}
                            </strong>
                        </td>

                        <td class="text-wrap">
                            {{ $risiko->nama_risiko }}
                        </td>

                        <td>
                            {{ $risiko->kategori_risiko }}
                        </td>

                        <td class="text-wide">
                            {{ $risiko->penyebab_risiko ?: '-' }}
                        </td>

                        <td class="text-wide">
                            {{ $risiko->dampak_risiko ?: '-' }}
                        </td>

                        {{-- ANALISIS RISIKO SAAT INI --}}

                        <td class="text-wide">
                            {{ $risiko->kontrol_eksisting ?: '-' }}
                        </td>

                        <td class="number-value">
                            {{ $risiko->kemungkinan ?? '-' }}
                        </td>

                        <td class="number-value">
                            {{ $risiko->dampak ?? '-' }}
                        </td>

                        <td class="number-value">
                            {{ $risiko->besaran_risiko ?? '-' }}
                        </td>

                        <td class="text-center">
                            @if ($risiko->level_risiko === 'Rendah')
                                <span class="badge badge-rendah">
                                    Rendah
                                </span>
                            @elseif ($risiko->level_risiko === 'Sedang')
                                <span class="badge badge-sedang">
                                    Sedang
                                </span>
                            @elseif ($risiko->level_risiko === 'Tinggi')
                                <span class="badge badge-tinggi">
                                    Tinggi
                                </span>
                            @elseif ($risiko->level_risiko === 'Ekstrim')
                                <span class="badge badge-ekstrim">
                                    Ekstrim
                                </span>
                            @else
                                <span class="badge badge-netral">
                                    {{ $risiko->level_risiko ?: '-' }}
                                </span>
                            @endif
                        </td>

                        <td class="number-value">
                            @if ($risiko->kuantifikasi !== null)
                                Rp
                                {{
                                    number_format(
                                        (float) $risiko->kuantifikasi,
                                        2,
                                        ',',
                                        '.'
                                    )
                                }}
                                juta
                            @else
                                -
                            @endif
                        </td>

                        {{-- RENCANA PENANGANAN --}}

                        <td class="text-wide">
                            {{ $risiko->rencana_penanganan ?: '-' }}
                        </td>

                        <td>
                            {{
                                $risiko->batas_waktu
                                    ? $risiko->batas_waktu->format('d-m-Y')
                                    : '-'
                            }}
                        </td>

                        <td class="text-wrap">
                            {{ $risiko->penanggung_jawab ?: '-' }}
                        </td>

                        {{-- ANALISIS RISIKO RESIDUAL --}}

                        <td class="number-value">
                            {{ $risiko->target_kemungkinan ?? '-' }}
                        </td>

                        <td class="number-value">
                            {{ $risiko->target_dampak ?? '-' }}
                        </td>

                        <td class="number-value">
                            {{ $risiko->besaran_risiko_residual ?? '-' }}
                        </td>

                        <td class="text-center">
                            @if ($risiko->level_risiko_residual === 'Rendah')
                                <span class="badge badge-rendah">
                                    Rendah
                                </span>
                            @elseif ($risiko->level_risiko_residual === 'Sedang')
                                <span class="badge badge-sedang">
                                    Sedang
                                </span>
                            @elseif ($risiko->level_risiko_residual === 'Tinggi')
                                <span class="badge badge-tinggi">
                                    Tinggi
                                </span>
                            @elseif ($risiko->level_risiko_residual === 'Ekstrim')
                                <span class="badge badge-ekstrim">
                                    Ekstrim
                                </span>
                            @else
                                <span class="badge badge-netral">
                                    {{ $risiko->level_risiko_residual ?: '-' }}
                                </span>
                            @endif
                        </td>

                        <td class="number-value">
                            @if ($risiko->kuantifikasi_residual !== null)
                                Rp
                                {{
                                    number_format(
                                        (float) $risiko->kuantifikasi_residual,
                                        2,
                                        ',',
                                        '.'
                                    )
                                }}
                                juta
                            @else
                                -
                            @endif
                        </td>

                        {{-- STATUS SISTEM --}}

                        <td>
                            <span class="badge badge-netral">
                                {{ $risiko->status_penanganan }}
                            </span>
                        </td>

                        <td>
                            @php
                                $peringatan = $risiko->statusPeringatan();
                            @endphp

                            @if ($peringatan === 'Terlambat')
                                <span class="peringatan terlambat">
                                    Terlambat
                                </span>
                            @elseif ($peringatan === 'Jatuh Tempo Hari Ini')
                                <span class="peringatan hari-ini">
                                    Jatuh Tempo Hari Ini
                                </span>
                            @elseif ($peringatan === 'Mendekati Batas Waktu')
                                <span class="peringatan mendekati">
                                    Mendekati Batas Waktu
                                </span>
                            @else
                                <span class="aman">-</span>
                            @endif
                        </td>

                        <td>
                            <span
                                class="badge
                                {{
                                    $risiko->status_verifikasi === 'Disetujui'
                                        ? 'badge-success'
                                        : 'badge-warning'
                                }}"
                            >
                                {{
                                    $risiko->status_verifikasi
                                        ?? 'Belum Diverifikasi'
                                }}
                            </span>
                        </td>

                        <td>
                            <span
                                class="badge
                                {{
                                    $risiko->status_reviu === 'Disetujui'
                                        ? 'badge-success'
                                        : (
                                            $risiko->status_reviu === 'Perlu Perbaikan'
                                                ? 'badge-danger'
                                                : 'badge-warning'
                                        )
                                }}"
                            >
                                {{
                                    $risiko->status_reviu
                                        ?? 'Belum Direviu'
                                }}
                            </span>
                        </td>

                        <td class="text-wrap">
                            @if ($risiko->status_reviu === 'Perlu Perbaikan')
                                <span class="catatan-perbaikan">
                                    {{ $risiko->catatan_perbaikan ?: '-' }}
                                </span>
                            @else
                                {{ $risiko->catatan_perbaikan ?: '-' }}
                            @endif
                        </td>

                        <td>
                            {{
                                $risiko->updated_at
                                    ? $risiko->updated_at->format('d-m-Y H:i')
                                    : '-'
                            }}
                        </td>

                        <td>
    <div class="aksi">

        @if ($risiko->dapatDieditOlehUpr())

            <a
                href="{{ route('risiko.edit', $risiko->id) }}"
                class="btn btn-edit"
            >
                Edit
            </a>

            <form
                method="POST"
                action="{{ route('risiko.destroy', $risiko->id) }}"
                onsubmit="return confirm('Yakin ingin menghapus data Risk Register ini?')"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-delete"
                >
                    Hapus
                </button>
            </form>

        @else

            <span class="badge badge-netral">
                Terkunci
            </span>

        @endif

    </div>
</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="28" class="data-kosong">
                            Belum ada data Risk Register.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if ($risikos->hasPages())
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $risikos->firstItem() }}–{{ $risikos->lastItem() }}
            dari {{ $risikos->total() }} data risiko
        </div>

        <div class="pagination-buttons">
            @if ($risikos->onFirstPage())
                <span class="pagination-disabled">&laquo; Previous</span>
            @else
                <a
                    href="{{ $risikos->previousPageUrl() }}"
                    class="pagination-link"
                >
                    &laquo; Previous
                </a>
            @endif

            @foreach (
                $risikos->getUrlRange(
                    max(1, $risikos->currentPage() - 2),
                    min($risikos->lastPage(), $risikos->currentPage() + 2)
                ) as $page => $url
            )
                <a
                    href="{{ $url }}"
                    class="pagination-link {{ $page === $risikos->currentPage() ? 'active' : '' }}"
                >
                    {{ $page }}
                </a>
            @endforeach

            @if ($risikos->hasMorePages())
                <a
                    href="{{ $risikos->nextPageUrl() }}"
                    class="pagination-link"
                >
                    Next &raquo;
                </a>
            @else
                <span class="pagination-disabled">Next &raquo;</span>
            @endif
        </div>
    </div>
@endif

@endsection