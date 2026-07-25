@extends('layouts.app')

@section('title', 'Verifikasi Risk Register')

@section('page-title', 'Verifikasi Risk Register')

@section(
    'page-description',
    'Periksa seluruh data Risk Register dan tentukan hasil verifikasi UMR.'
)

@push('styles')
<style>
    .alert-success,
    .alert-error,
    .information-box {
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
        border-left: 4px solid #0B0083;
        background: #f2f1ff;
        color: #333;
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
    font-size: 12px;
}

.filter-actions {
    display: flex;
    gap: 8px;
    margin-top: 14px;
}

.btn-filter {
    width: auto;
    padding: 10px 16px;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: auto;
    padding: 10px 16px;
    border-radius: 7px;
    background: #6b7280;
    color: white;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
}

.filter-result {
    margin-top: 12px;
    color: #666;
    font-size: 12px;
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

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 3900px;
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

    .badge-menunggu {
        background: #fff3cd;
        color: #856404;
    }

    .badge-perbaikan {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-disetujui {
        background: #d4edda;
        color: #155724;
    }

    .badge-netral {
        background: #eeeeee;
        color: #444;
    }

    .form-verifikasi {
        min-width: 280px;
    }

    .form-verifikasi select,
    .form-verifikasi textarea {
        width: 100%;
        margin-bottom: 8px;
        padding: 9px 10px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: white;
        font-family: inherit;
        font-size: 12px;
    }

    .form-verifikasi textarea {
        min-height: 90px;
        resize: vertical;
    }

    .form-verifikasi select:focus,
    .form-verifikasi textarea:focus {
        outline: none;
        border-color: #0B0083;
        box-shadow: 0 0 0 3px rgba(11, 0, 131, 0.1);
    }

    .helper-text {
        display: block;
        margin: -2px 0 8px;
        color: #777;
        font-size: 10px;
        line-height: 1.5;
    }

    .btn {
        width: 100%;
        padding: 10px 14px;
        border: none;
        border-radius: 7px;
        background: #0B0083;
        color: white;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .data-kosong {
        padding: 35px;
        text-align: center;
        color: #777;
    }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert-error">
        {{ $errors->first() }}
    </div>
@endif

<div class="information-box">
    Geser tabel ke kanan untuk memeriksa seluruh isi Risk Register.
    Pilih <strong>Perlu Perbaikan</strong> apabila data harus dikembalikan
    kepada UPR, atau pilih <strong>Disetujui</strong> agar data diteruskan
    kepada UPI.
</div>

<div class="filter-card">

    <form
        method="GET"
        action="{{ route('verifikasi.index') }}"
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

        </div>

        <div class="filter-actions">
            <button
                type="submit"
                class="btn btn-filter"
            >
                Terapkan Filter
            </button>

            <a
                href="{{ route('verifikasi.index') }}"
                class="btn-reset"
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
                        colspan="7"
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
                        Rencana Penanganan
                    </th>

                    <th
                        colspan="5"
                        class="group-header"
                    >
                        Risiko Residual
                    </th>

                    <th
                        colspan="4"
                        class="group-header"
                    >
                        Verifikasi UMR
                    </th>
                </tr>

                <tr>
                    <th>UPR Pembuat</th>
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

                    <th>Status</th>
                    <th>Verifikator</th>
                    <th>Tanggal Verifikasi</th>
                    <th>Keputusan UMR</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($risikos as $risiko)

                    @php
                        $statusVerifikasi = $risiko->status_verifikasi;

                        /*
                         * Membantu membaca data lama yang masih
                         * menggunakan status sebelumnya.
                         */
                        if ($statusVerifikasi === 'Belum Diverifikasi') {
                            $statusVerifikasi = 'Menunggu Verifikasi';
                        }

                        if ($statusVerifikasi === 'Terverifikasi') {
                            $statusVerifikasi = 'Disetujui';
                        }
                    @endphp

                    <tr>

                        <td class="text-center">
                            {{ $risikos->firstItem() + $loop->index }}
                        </td>

                        {{-- IDENTIFIKASI RISIKO --}}

                        <td class="text-wrap">
                            {{ $risiko->user?->name ?? '-' }}
                        </td>

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

                        <td class="text-wrap">
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

                        {{-- RISIKO RESIDUAL --}}

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

                        {{-- VERIFIKASI UMR --}}

                        <td>

                            @if ($statusVerifikasi === 'Disetujui')
                                <span class="badge badge-disetujui">
                                    Disetujui
                                </span>
                            @elseif ($statusVerifikasi === 'Perlu Perbaikan')
                                <span class="badge badge-perbaikan">
                                    Perlu Perbaikan
                                </span>
                            @else
                                <span class="badge badge-menunggu">
                                    Menunggu Verifikasi
                                </span>
                            @endif

                        </td>

                        <td class="text-wrap">
                            {{ $risiko->verifikator?->name ?? '-' }}
                        </td>

                        <td>
                            {{
                                $risiko->tanggal_verifikasi
                                    ? $risiko->tanggal_verifikasi
                                        ->format('d-m-Y H:i')
                                    : '-'
                            }}
                        </td>

                        <td>

                            <form
                                method="POST"
                                action="{{ route('verifikasi.update', $risiko->id) }}"
                                class="form-verifikasi"
                            >
                                @csrf
                                @method('PUT')

                                <select
                                    name="status_verifikasi"
                                    class="status-verifikasi"
                                    required
                                >
                                    <option value="">
                                        Pilih Hasil Verifikasi
                                    </option>

                                    <option
                                        value="Menunggu Verifikasi"
                                        {{
                                            $statusVerifikasi === 'Menunggu Verifikasi'
                                                ? 'selected'
                                                : ''
                                        }}
                                    >
                                        Menunggu Verifikasi
                                    </option>

                                    <option
                                        value="Perlu Perbaikan"
                                        {{
                                            $statusVerifikasi === 'Perlu Perbaikan'
                                                ? 'selected'
                                                : ''
                                        }}
                                    >
                                        Perlu Perbaikan
                                    </option>

                                    <option
                                        value="Disetujui"
                                        {{
                                            $statusVerifikasi === 'Disetujui'
                                                ? 'selected'
                                                : ''
                                        }}
                                    >
                                        Disetujui
                                    </option>
                                </select>

                                <textarea
                                    name="catatan_verifikasi"
                                    class="catatan-verifikasi"
                                    placeholder="Masukkan catatan verifikasi atau perbaikan"
                                >{{ $risiko->catatan_verifikasi }}</textarea>

                                <span class="helper-text">
                                    Catatan wajib diisi ketika memilih
                                    Perlu Perbaikan.
                                </span>

                                <button
                                    type="submit"
                                    class="btn"
                                >
                                    Simpan Verifikasi
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="25" class="data-kosong">
                            Belum ada Risk Register yang dapat diverifikasi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@if ($risikos->hasPages())
    <div class="pagination-wrapper">
        {{ $risikos->links() }}
    </div>
@endif

<script>
    document.querySelectorAll('.form-verifikasi').forEach(function (form) {
        const status = form.querySelector('.status-verifikasi');
        const catatan = form.querySelector('.catatan-verifikasi');

        function aturCatatanWajib() {
            catatan.required = status.value === 'Perlu Perbaikan';
        }

        status.addEventListener('change', aturCatatanWajib);
        aturCatatanWajib();
    });
</script>

@endsection