@extends('layouts.app')

@section('title', 'Reviu Risk Register')

@section('page-title', 'Reviu Risk Register')

@section(
    'page-description',
    'Tinjau seluruh data Risk Register yang telah disetujui UMR dan tetapkan hasil reviu UPI.'
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

.filter-result {
    margin-top: 12px;
    color: #666;
    font-size: 12px;
}

.pagination-wrapper {
    margin-top: 20px;
}

.btn-reviu {
    width: auto;
    white-space: nowrap;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(0, 0, 0, 0.55);
}

.modal-overlay.active {
    display: flex;
}

.modal-box {
    width: 100%;
    max-width: 520px;
    border-radius: 12px;
    background: white;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.modal-header h3 {
    margin: 0;
    color: #0B0083;
    font-size: 18px;
}

.modal-close {
    border: none;
    background: transparent;
    color: #555;
    font-size: 25px;
    cursor: pointer;
}

.modal-body {
    padding: 20px;
}

.modal-risk-info {
    margin-bottom: 16px;
    padding: 12px 14px;
    border-left: 4px solid #0B0083;
    border-radius: 6px;
    background: #f2f1ff;
    font-size: 13px;
    line-height: 1.6;
}

.modal-form-group {
    margin-bottom: 15px;
}

.modal-form-group label {
    display: block;
    margin-bottom: 7px;
    color: #333;
    font-size: 13px;
    font-weight: 700;
}

.modal-form-group select,
.modal-form-group textarea {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    font-family: inherit;
    font-size: 13px;
}

.modal-form-group textarea {
    min-height: 110px;
    resize: vertical;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
}

.btn-batal {
    width: auto;
    background: #6b7280;
}

.btn-simpan {
    width: auto;
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

    .filter-actions,
    .modal-footer {
        flex-direction: column;
    }

    .btn-filter,
    .btn-reset,
    .btn-batal,
    .btn-simpan {
        width: 100%;
    }
}

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table {
        width: 100%;
        min-width: 4300px;
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

    .badge-belum {
        background: #fff3cd;
        color: #856404;
    }

    .badge-disetujui {
        background: #d4edda;
        color: #155724;
    }

    .badge-perbaikan {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-netral {
        background: #eeeeee;
        color: #444;
    }

    .form-reviu {
        min-width: 290px;
    }

    .form-reviu select,
    .form-reviu textarea {
        width: 100%;
        margin-bottom: 8px;
        padding: 9px 10px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: white;
        font-family: inherit;
        font-size: 12px;
    }

    .form-reviu textarea {
        min-height: 90px;
        resize: vertical;
    }

    .form-reviu select:focus,
    .form-reviu textarea:focus {
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
    Halaman ini hanya menampilkan Risk Register yang sudah
    <strong>Disetujui UMR</strong>. Geser tabel ke kanan untuk memeriksa
    seluruh data. Pilih <strong>Perlu Perbaikan</strong> untuk mengembalikan
    data kepada UPR atau pilih <strong>Disetujui</strong> untuk menetapkan
    data sebagai hasil final.
</div>

<div class="filter-card">

    <form
        method="GET"
        action="{{ route('reviu.index') }}"
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
                class="btn-filter"
            >
                Terapkan Filter
            </button>

            <a
                href="{{ route('reviu.index') }}"
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
                        colspan="3"
                        class="group-header"
                    >
                        Persetujuan UMR
                    </th>

                    <th
                        colspan="4"
                        class="group-header"
                    >
                        Reviu UPI
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

                    <th>Verifikator UMR</th>
                    <th>Tanggal Verifikasi</th>
                    <th>Catatan Verifikasi</th>

                    <th>Status Reviu</th>
                    <th>Pereviu UPI</th>
                    <th>Tanggal Reviu</th>
                    <th>Keputusan UPI</th>
                </tr>

            </thead>

            <tbody>

                @forelse ($risikos as $risiko)

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

                        {{-- PERSETUJUAN UMR --}}

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

                        <td class="text-wide">
                            {{ $risiko->catatan_verifikasi ?: '-' }}
                        </td>

                        {{-- REVIU UPI --}}

                        <td>
                            @if ($risiko->status_reviu === 'Disetujui')
                                <span class="badge badge-disetujui">
                                    Disetujui
                                </span>
                            @elseif ($risiko->status_reviu === 'Perlu Perbaikan')
                                <span class="badge badge-perbaikan">
                                    Perlu Perbaikan
                                </span>
                            @else
                                <span class="badge badge-belum">
                                    Belum Direviu
                                </span>
                            @endif
                        </td>

                        <td class="text-wrap">
                            {{ $risiko->pereviu?->name ?? '-' }}
                        </td>

                        <td>
                            {{
                                $risiko->tanggal_reviu
                                    ? $risiko->tanggal_reviu
                                        ->format('d-m-Y H:i')
                                    : '-'
                            }}
                        </td>

                        <td>
                            <button
                                type="button"
                                class="btn btn-reviu buka-modal-reviu"
                                data-action="{{ route('reviu.update', $risiko->id) }}"
                                data-kode="{{ $risiko->kode_risiko }}"
                                data-nama="{{ $risiko->nama_risiko }}"
                                data-status="{{ $risiko->status_reviu ?? 'Belum Direviu' }}"
                                data-catatan="{{ $risiko->catatan_perbaikan ?? '' }}"
                            >
                                Input Reviu
                            </button>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="29" class="data-kosong">
                            Belum ada Risk Register yang telah disetujui
                            UMR dan dapat direviu UPI.
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

<div
    class="modal-overlay"
    id="modalReviu"
>
    <div class="modal-box">

        <div class="modal-header">
            <h3>Input Reviu UPI</h3>

            <button
                type="button"
                class="modal-close"
                id="tutupModalReviu"
            >
                &times;
            </button>
        </div>

        <form
            method="POST"
            id="formModalReviu"
        >
            @csrf
            @method('PUT')

            <div class="modal-body">

                <div class="modal-risk-info">
                    <strong id="modalKodeRisiko">-</strong>
                    <br>
                    <span id="modalNamaRisiko">-</span>
                </div>

                <div class="modal-form-group">
                    <label for="modalStatusReviu">
                        Hasil Reviu
                    </label>

                    <select
                        name="status_reviu"
                        id="modalStatusReviu"
                        required
                    >
                        <option value="Belum Direviu">
                            Belum Direviu
                        </option>

                        <option value="Perlu Perbaikan">
                            Perlu Perbaikan
                        </option>

                        <option value="Disetujui">
                            Disetujui
                        </option>
                    </select>
                </div>

                <div class="modal-form-group">
                    <label for="modalCatatanPerbaikan">
                        Catatan Reviu atau Perbaikan
                    </label>

                    <textarea
                        name="catatan_perbaikan"
                        id="modalCatatanPerbaikan"
                        placeholder="Masukkan catatan reviu atau perbaikan"
                    ></textarea>

                    <span class="helper-text">
                        Catatan wajib diisi ketika memilih Perlu Perbaikan.
                    </span>
                </div>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-batal"
                    id="batalModalReviu"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn btn-simpan"
                >
                    Simpan Reviu
                </button>

            </div>

        </form>

    </div>
</div>

<script>
    const modalReviu =
        document.getElementById('modalReviu');

    const formModalReviu =
        document.getElementById('formModalReviu');

    const modalKodeRisiko =
        document.getElementById('modalKodeRisiko');

    const modalNamaRisiko =
        document.getElementById('modalNamaRisiko');

    const modalStatusReviu =
        document.getElementById('modalStatusReviu');

    const modalCatatanPerbaikan =
        document.getElementById('modalCatatanPerbaikan');

    const tutupModalReviu =
        document.getElementById('tutupModalReviu');

    const batalModalReviu =
        document.getElementById('batalModalReviu');

    document
        .querySelectorAll('.buka-modal-reviu')
        .forEach(function (button) {
            button.addEventListener('click', function () {
                formModalReviu.action =
                    button.dataset.action;

                modalKodeRisiko.textContent =
                    button.dataset.kode;

                modalNamaRisiko.textContent =
                    button.dataset.nama;

                modalStatusReviu.value =
                    button.dataset.status || 'Belum Direviu';

                modalCatatanPerbaikan.value =
                    button.dataset.catatan || '';

                aturCatatanWajib();

                modalReviu.classList.add('active');
            });
        });

    function aturCatatanWajib() {
        modalCatatanPerbaikan.required =
            modalStatusReviu.value === 'Perlu Perbaikan';
    }

    function tutupModal() {
        modalReviu.classList.remove('active');
    }

    modalStatusReviu.addEventListener(
        'change',
        aturCatatanWajib
    );

    tutupModalReviu.addEventListener(
        'click',
        tutupModal
    );

    batalModalReviu.addEventListener(
        'click',
        tutupModal
    );

    modalReviu.addEventListener(
        'click',
        function (event) {
            if (event.target === modalReviu) {
                tutupModal();
            }
        }
    );

    document.addEventListener(
        'keydown',
        function (event) {
            if (event.key === 'Escape') {
                tutupModal();
            }
        }
    );
</script>

@endsection