@extends('layouts.app')

@section('title', 'Laporan Pemantauan Risiko')

@section('page-title', 'Laporan Pemantauan Risiko')

@section(
    'page-description',
    'Tampilkan dan unduh laporan pemantauan risiko berdasarkan periode triwulan.'
)

@push('styles')
<style>
    .filter-card {
        margin-bottom: 22px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        align-items: end;
        gap: 16px;
    }

    .form-group {
        margin: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 700;
        color: #333;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: white;
        font-size: 14px;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #0B0083;
        box-shadow: 0 0 0 3px rgba(11, 0, 131, 0.1);
    }

    .filter-actions {
        display: flex;
        gap: 9px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 10px 16px;
        border: none;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
    }

    .btn-primary {
        background: #0B0083;
        color: white;
    }

    .btn-download {
        background: #198754;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .period-info {
        margin-bottom: 22px;
        padding: 16px 18px;
        border-left: 4px solid #0B0083;
        border-radius: 8px;
        background: #eeeefe;
        color: #333;
        font-size: 14px;
        line-height: 1.7;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 24px;
    }

    .summary-card {
        padding: 18px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .summary-label {
        display: block;
        margin-bottom: 9px;
        color: #666;
        font-size: 12px;
    }

    .summary-value {
        color: #0B0083;
        font-size: 27px;
        font-weight: 800;
    }

    .report-list {
        display: flex;
        flex-direction: column;
        gap: 26px;
    }

    .report-sheet {
        overflow: hidden;
        border: 1px solid #999;
        border-radius: 4px;
        background: white;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    }

    .report-header {
        padding: 22px 20px 14px;
        text-align: center;
    }

    .report-logo {
        display: block;
        width: 74px;
        max-height: 74px;
        margin: 0 auto 10px;
        object-fit: contain;
    }

    .agency-name {
        margin: 0 0 15px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        line-height: 1.5;
    }

    .report-title {
        margin: 0;
        padding: 9px 15px;
        border: 1px solid #777;
        background: #d9eef8;
        font-size: 20px;
        font-weight: 800;
    }

    .unit-row {
        padding: 9px 14px;
        border-right: 1px solid #777;
        border-bottom: 1px solid #777;
        border-left: 1px solid #777;
        text-align: right;
        font-size: 13px;
        font-weight: 700;
    }

    .report-field {
        border-right: 1px solid #777;
        border-bottom: 1px solid #777;
        border-left: 1px solid #777;
    }

    .field-label {
        padding: 8px 11px;
        border-bottom: 1px solid #aaa;
        background: #f3f8fa;
        font-size: 13px;
        font-weight: 800;
    }

    .field-content {
        min-height: 45px;
        padding: 11px;
        font-size: 13px;
        line-height: 1.6;
        white-space: pre-line;
    }

    .field-content-large {
        min-height: 75px;
    }

    .monitoring-table {
        width: 100%;
        border-collapse: collapse;
    }

    .monitoring-table th,
    .monitoring-table td {
        width: 33.33%;
        padding: 10px;
        border: 1px solid #777;
        vertical-align: top;
        font-size: 12px;
        line-height: 1.6;
    }

    .monitoring-table th {
        background: #f3f8fa;
        text-align: center;
        font-weight: 800;
    }

    .monitoring-table td {
        min-height: 55px;
    }

    .recommendation {
        margin-top: 18px;
        border: 1px solid #777;
    }

    .recommendation-title {
        padding: 9px 11px;
        background: #222;
        color: white;
        font-size: 15px;
        font-weight: 800;
    }

    .recommendation-content {
        min-height: 65px;
        padding: 12px;
        font-size: 13px;
        line-height: 1.6;
        white-space: pre-line;
    }

    .description-box {
        margin-top: 10px;
        border: 1px solid #777;
    }

    .description-label {
        padding: 7px 10px 3px;
        font-size: 13px;
        font-weight: 800;
    }

    .description-content {
        min-height: 72px;
        padding: 8px 10px 12px;
        font-size: 13px;
        line-height: 1.6;
        white-space: pre-line;
    }

    .report-footer {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding: 13px 15px;
        border-top: 1px solid #ddd;
        background: #f8f8fb;
        font-size: 11px;
        color: #555;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 14px;
        background: #e9e9ee;
        color: #333;
        font-size: 11px;
        font-weight: 700;
    }

    .status-success {
        background: #d4edda;
        color: #155724;
    }

    .status-warning {
        background: #fff3cd;
        color: #856404;
    }

    .empty-state {
        padding: 45px 25px;
        border: 1px dashed #bbb;
        border-radius: 10px;
        background: white;
        text-align: center;
        color: #666;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #333;
        font-size: 18px;
    }

    @media (max-width: 1000px) {
        .filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .filter-actions {
            grid-column: 1 / -1;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 650px) {
        .filter-form,
        .summary-grid {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            flex-direction: column;
        }

        .report-title {
            font-size: 16px;
        }

        .monitoring-table,
        .monitoring-table thead,
        .monitoring-table tbody,
        .monitoring-table tr,
        .monitoring-table th,
        .monitoring-table td {
            display: block;
            width: 100%;
        }

        .monitoring-table th {
            border-bottom: none;
        }

        .monitoring-table td {
            margin-bottom: 8px;
        }
    }
</style>
@endpush

@section('content')

<div class="card filter-card">
    <form
        method="GET"
        action="{{ route('laporan.index') }}"
        class="filter-form"
    >
        <div class="form-group">
            <label for="tahun">
                Tahun Laporan
            </label>

            <input
                type="number"
                id="tahun"
                name="tahun"
                min="2000"
                max="2100"
                value="{{ $tahun }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="triwulan">
                Periode Triwulan
            </label>

            <select
                id="triwulan"
                name="triwulan"
                required
            >
                <option
                    value="1"
                    {{ $triwulan === 1 ? 'selected' : '' }}
                >
                    Triwulan I
                </option>

                <option
                    value="2"
                    {{ $triwulan === 2 ? 'selected' : '' }}
                >
                    Triwulan II
                </option>

                <option
                    value="3"
                    {{ $triwulan === 3 ? 'selected' : '' }}
                >
                    Triwulan III
                </option>

                <option
                    value="4"
                    {{ $triwulan === 4 ? 'selected' : '' }}
                >
                    Triwulan IV
                </option>
            </select>
        </div>

        <div class="filter-actions">
            <button
                type="submit"
                class="btn btn-primary"
            >
                Tampilkan Laporan
            </button>

            <a
                href="{{ route('laporan.download', [
                    'tahun' => $tahun,
                    'triwulan' => $triwulan,
                ]) }}"
                class="btn btn-download"
            >
                Unduh PDF
            </a>
        </div>
    </form>
</div>

<div class="period-info">
    <strong>
        Laporan Pemantauan Triwulan
        {{ $namaTriwulan }}
        Tahun {{ $tahun }}
    </strong>

    <br>

    Periode:
    {{ $tanggalAwal->format('d-m-Y') }}
    sampai
    {{ $tanggalAkhir->format('d-m-Y') }}
</div>

<div class="summary-grid">

    <div class="summary-card">
        <span class="summary-label">
            Total Risiko
        </span>

        <span class="summary-value">
            {{ $risikos->count() }}
        </span>
    </div>

    <div class="summary-card">
        <span class="summary-label">
            Terverifikasi UMR
        </span>

        <span class="summary-value">
            {{
                $risikos
                    ->where('status_verifikasi', 'Terverifikasi')
                    ->count()
            }}
        </span>
    </div>

    <div class="summary-card">
        <span class="summary-label">
            Disetujui UPI
        </span>

        <span class="summary-value">
            {{
                $risikos
                    ->where('status_reviu', 'Disetujui')
                    ->count()
            }}
        </span>
    </div>

    <div class="summary-card">
        <span class="summary-label">
            Perlu Perbaikan
        </span>

        <span class="summary-value">
            {{
                $risikos
                    ->where('status_reviu', 'Perlu Perbaikan')
                    ->count()
            }}
        </span>
    </div>

</div>

@if ($risikos->isEmpty())

    <div class="empty-state">
        <h3>Belum Ada Data Laporan</h3>

        <p>
            Tidak ditemukan data risiko yang diperbarui pada
            Triwulan {{ $namaTriwulan }} Tahun {{ $tahun }}.
        </p>
    </div>

@else

    <div class="report-list">

        @foreach ($risikos as $risiko)

            <article class="report-sheet">

                <div class="report-header">

                    <img
                        src="{{ asset('images/Logo BP Batam.gif') }}"
                        alt="Logo BP Batam"
                        class="report-logo"
                    >

                    <p class="agency-name">
                        Badan Pengusahaan Kawasan Perdagangan Bebas
                        dan Pelabuhan Bebas Batam
                    </p>

                    <h2 class="report-title">
                        @if ($triwulan === 4)
                            Laporan Pemantauan Triwulan IV
                        @else
                            Laporan Pemantauan Triwulan
                            {{ $namaTriwulan }}
                        @endif
                    </h2>

                    <div class="unit-row">
                        UNIT PDSI BP BATAM
                    </div>

                </div>

                <div class="report-field">
                    <div class="field-label">
                        Sasaran:
                    </div>

                    <div class="field-content">
                        {{ $risiko->sasaran ?: '-' }}
                    </div>
                </div>

                <div class="report-field">
                    <div class="field-label">
                        Risiko:
                    </div>

                    <div class="field-content field-content-large">
                        <strong>
                            {{ $risiko->kode_risiko }} –
                            {{ $risiko->nama_risiko }}
                        </strong>

                        @if ($risiko->deskripsi)
                            <br><br>
                            {{ $risiko->deskripsi }}
                        @endif
                    </div>
                </div>

                <div class="report-field">
                    <div class="field-label">
                        Besaran/Level Risiko Aktual:
                    </div>

                    <div class="field-content">
                        Besaran Risiko:
                        <strong>
                            {{ $risiko->besaran_risiko ?? '-' }}
                        </strong>

                        <br>

                        Level Risiko:
                        <strong>
                            {{ $risiko->level_risiko ?? '-' }}
                        </strong>

                        <br>

                        Nilai Kemungkinan:
                        {{ $risiko->kemungkinan ?? '-' }}

                        &nbsp;|&nbsp;

                        Nilai Dampak:
                        {{ $risiko->dampak ?? '-' }}
                    </div>
                </div>

                <div class="report-field">
                    <div class="field-label">
                        Proyeksi Risiko:
                    </div>

                    <div class="field-content">
                        {{ $risiko->proyeksi_risiko ?: '-' }}

                        @if ($risiko->tren_risiko)
                            <br>
                            Tren Risiko:
                            <strong>
                                {{ $risiko->tren_risiko }}
                            </strong>
                        @endif
                    </div>
                </div>

                <div class="report-field">
                    <div class="field-label">
                        Mitigasi yang Telah Dilaksanakan
                    </div>

                    <div class="field-content field-content-large">
                        {{ $risiko->mitigasi_terlaksana ?: '-' }}
                    </div>
                </div>

                @if ($triwulan !== 4)

                    <table class="monitoring-table">
                        <thead>
                            <tr>
                                <th>Rencana Mitigasi</th>
                                <th>Penanggung Jawab</th>
                                <th>Waktu Pelaksanaan</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>
                                    {{
                                        $risiko->rencana_penanganan
                                            ?: '-'
                                    }}
                                </td>

                                <td>
                                    {{
                                        $risiko->penanggung_jawab
                                            ?: '-'
                                    }}
                                </td>

                                <td>
                                    {{
                                        $risiko->batas_waktu
                                            ? $risiko->batas_waktu->format('d-m-Y')
                                            : '-'
                                    }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                @else

                    <div class="recommendation">
                        <div class="recommendation-title">
                            Rekomendasi:
                        </div>

                        <div class="recommendation-content">
                            {{
                                $risiko->catatan_perbaikan
                                    ?: (
                                        $risiko->rencana_penanganan
                                            ?: '-'
                                    )
                            }}
                        </div>
                    </div>

                @endif

                <div class="description-box">
                    <div class="description-label">
                        Keterangan:
                    </div>

                    <div class="description-content">
                        {{ $risiko->keterangan_pemantauan ?: '-' }}
                    </div>
                </div>

                <div class="report-footer">

                    <span class="status-badge">
                        Status Penanganan:
                        {{ $risiko->status_penanganan }}
                    </span>

                    <span
                        class="status-badge
                        {{
                            $risiko->status_verifikasi === 'Terverifikasi'
                                ? 'status-success'
                                : 'status-warning'
                        }}"
                    >
                        Verifikasi:
                        {{ $risiko->status_verifikasi }}
                    </span>

                    <span
                        class="status-badge
                        {{
                            $risiko->status_reviu === 'Disetujui'
                                ? 'status-success'
                                : 'status-warning'
                        }}"
                    >
                        Reviu:
                        {{ $risiko->status_reviu ?? 'Belum Direviu' }}
                    </span>

                    <span class="status-badge">
                        Terakhir diperbarui:
                        {{ $risiko->updated_at->format('d-m-Y H:i') }}
                    </span>

                </div>

            </article>

        @endforeach

    </div>

@endif

@endsection