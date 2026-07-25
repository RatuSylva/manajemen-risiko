@extends('layouts.app')

@section('title', 'Detail Riwayat Risiko')

@section('page-title', 'Detail Riwayat Risiko')

@section(
    'page-description',
    'Lihat seluruh kondisi Risk Register sebelum dan sesudah perubahan.'
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
        padding: 10px 15px;
        border-radius: 7px;
        background: #0B0083;
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .risk-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .summary-item {
        padding: 16px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fafafa;
    }

    .summary-label {
        display: block;
        margin-bottom: 6px;
        color: #777;
        font-size: 12px;
    }

    .summary-value {
        color: #333;
        font-size: 14px;
        font-weight: 700;
        word-break: break-word;
    }

    .history-card {
        margin-top: 22px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: white;
    }

    .history-header {
        padding: 18px;
        border-bottom: 1px solid #e5e7eb;
        background: #f8f8fc;
    }

    .history-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 15px;
    }

    .history-title {
        margin: 0 0 8px;
        color: #0B0083;
        font-size: 17px;
    }

    .history-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 14px;
        color: #666;
        font-size: 12px;
    }

    .history-description {
        margin-top: 12px;
        color: #444;
        font-size: 13px;
        line-height: 1.6;
    }

    .badge {
        display: inline-block;
        padding: 6px 9px;
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

    .badge-netral {
        background: #eeeeee;
        color: #444;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .snapshot-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .snapshot-table th,
    .snapshot-table td {
        padding: 11px 12px;
        border: 1px solid #e5e7eb;
        text-align: left;
        vertical-align: top;
        font-size: 12px;
        line-height: 1.6;
        word-break: break-word;
    }

    .snapshot-table th {
        background: #0B0083;
        color: white;
    }

    .snapshot-table .section-row td {
        background: #eeecff;
        color: #0B0083;
        font-weight: 700;
    }

    .snapshot-table .changed-row td {
        background: #fff8d9;
    }

    .snapshot-table .field-name {
        width: 24%;
        font-weight: 700;
    }

    .snapshot-table .before-value,
    .snapshot-table .after-value {
        width: 38%;
    }

    .change-label {
        display: inline-block;
        margin-left: 6px;
        padding: 3px 7px;
        border-radius: 10px;
        background: #f4b400;
        color: #4d3a00;
        font-size: 9px;
        font-weight: 700;
    }

    .empty-value {
        color: #999;
        font-style: italic;
    }

    .old-history-notice {
        margin: 16px;
        padding: 14px;
        border-radius: 7px;
        background: #fff3cd;
        color: #856404;
        font-size: 13px;
        line-height: 1.6;
    }

    .data-kosong {
        padding: 35px;
        text-align: center;
        color: #777;
    }

    @media (max-width: 1000px) {
        .risk-summary {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .risk-summary {
            grid-template-columns: 1fr;
        }

        .page-actions {
            justify-content: stretch;
        }

        .page-actions .btn {
            width: 100%;
        }

        .history-header-top {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

@php
    /*
     * Susunan kolom yang ditampilkan pada detail riwayat.
     * Dibuat menyerupai susunan Risk Register.
     */
    $kelompokKolom = [
        'Identifikasi Risiko' => [
            'sasaran' => 'Sasaran Strategis',
            'kode_risiko' => 'Kode Risiko',
            'nama_risiko' => 'Peristiwa Risiko',
            'kategori_risiko' => 'Kategori Risiko',
            'penyebab_risiko' => 'Penyebab Risiko',
            'dampak_risiko' => 'Dampak Risiko',
        ],

        'Analisis Risiko Saat Ini' => [
            'kontrol_eksisting' => 'Kontrol Eksisting',
            'kemungkinan' => 'Tingkat Kemungkinan',
            'dampak' => 'Tingkat Dampak',
            'besaran_risiko' => 'Level Risiko',
            'level_risiko' => 'Kategori R/M/T/E',
            'warna_level' => 'Warna Risiko',
            'kuantifikasi' => 'Kuantifikasi Risiko',
        ],

        'Rencana Penanganan Risiko' => [
            'rencana_penanganan' => 'Rencana Penanganan Risiko',
            'batas_waktu' => 'Target Waktu',
            'penanggung_jawab' => 'Unit Pemilik Risiko',
            'status_penanganan' => 'Status Penanganan',
        ],

        'Analisis Risiko Residual' => [
            'target_kemungkinan' => 'Target Tingkat Kemungkinan',
            'target_dampak' => 'Target Tingkat Dampak',
            'besaran_risiko_residual' => 'Level Risiko Residual',
            'level_risiko_residual' => 'Kategori R/M/T/E Residual',
            'kuantifikasi_residual' => 'Kuantifikasi Risiko Residual',
        ],

        'Verifikasi UMR' => [
            'status_verifikasi' => 'Status Verifikasi',
            'verifikator_id' => 'ID Verifikator',
            'tanggal_verifikasi' => 'Tanggal Verifikasi',
            'catatan_verifikasi' => 'Catatan Verifikasi',
        ],

        'Reviu UPI' => [
            'status_reviu' => 'Status Reviu',
            'pereviu_id' => 'ID Pereviu',
            'tanggal_reviu' => 'Tanggal Reviu',
            'catatan_perbaikan' => 'Catatan Perbaikan',
        ],

        'Pemantauan Triwulan' => [
            'proyeksi_risiko' => 'Proyeksi Risiko',
            'tren_risiko' => 'Tren Risiko',
            'mitigasi_terlaksana' => 'Mitigasi yang Telah Dilaksanakan',
            'keterangan_pemantauan' => 'Keterangan Pemantauan',
        ],
    ];

    /*
     * Fungsi untuk menampilkan nilai agar lebih mudah dibaca.
     */
    $formatNilai = function ($kolom, $nilai) {
        if ($nilai === null || $nilai === '') {
            return '-';
        }

        if (
            in_array($kolom, [
                'kuantifikasi',
                'kuantifikasi_residual',
            ])
        ) {
            return 'Rp '
                . number_format((float) $nilai, 2, ',', '.')
                . ' juta';
        }

        if ($kolom === 'batas_waktu') {
            try {
                return \Carbon\Carbon::parse($nilai)
                    ->format('d-m-Y');
            } catch (\Exception $exception) {
                return $nilai;
            }
        }

        if (
            in_array($kolom, [
                'tanggal_verifikasi',
                'tanggal_reviu',
                'created_at',
                'updated_at',
            ])
        ) {
            try {
                return \Carbon\Carbon::parse($nilai)
                    ->format('d-m-Y H:i');
            } catch (\Exception $exception) {
                return $nilai;
            }
        }

        if (is_bool($nilai)) {
            return $nilai ? 'Ya' : 'Tidak';
        }

        if (is_array($nilai)) {
            return json_encode(
                $nilai,
                JSON_UNESCAPED_UNICODE
                | JSON_PRETTY_PRINT
            );
        }

        return (string) $nilai;
    };
@endphp

<div class="page-actions">
    <a
        href="{{ route('riwayat.index') }}"
        class="btn"
    >
        Kembali ke Riwayat
    </a>
</div>

<div class="card">

    <div class="risk-summary">

        <div class="summary-item">
            <span class="summary-label">
                Kode Risiko
            </span>

            <span class="summary-value">
                {{ $risiko->kode_risiko }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Peristiwa Risiko
            </span>

            <span class="summary-value">
                {{ $risiko->nama_risiko }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Kategori Risiko
            </span>

            <span class="summary-value">
                {{ $risiko->kategori_risiko }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Level Risiko Saat Ini
            </span>

            <span class="summary-value">
                {{ $risiko->besaran_risiko ?? '-' }}
                /
                {{ $risiko->level_risiko ?? '-' }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Level Risiko Residual
            </span>

            <span class="summary-value">
                {{ $risiko->besaran_risiko_residual ?? '-' }}
                /
                {{ $risiko->level_risiko_residual ?? '-' }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Status Penanganan
            </span>

            <span class="summary-value">
                {{ $risiko->status_penanganan ?? '-' }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Status Verifikasi
            </span>

            <span class="summary-value">
                {{ $risiko->status_verifikasi ?? 'Belum Diverifikasi' }}
            </span>
        </div>

        <div class="summary-item">
            <span class="summary-label">
                Status Reviu
            </span>

            <span class="summary-value">
                {{ $risiko->status_reviu ?? 'Belum Direviu' }}
            </span>
        </div>

    </div>

</div>

@forelse ($riwayats as $riwayat)

    @php
        $dataSebelum = $riwayat->data_sebelum ?? [];
        $dataSesudah = $riwayat->data_sesudah ?? [];
    @endphp

    <div class="history-card">

        <div class="history-header">

            <div class="history-header-top">

                <div>
                    <h2 class="history-title">
                        {{ $loop->iteration }}.
                        {{ $riwayat->jenis_aktivitas }}
                    </h2>

                    <div class="history-meta">

                        <span>
                            <strong>Waktu:</strong>
                            {{
                                $riwayat->created_at
                                    ? $riwayat->created_at->format('d-m-Y H:i')
                                    : '-'
                            }}
                        </span>

                        <span>
                            <strong>Pengguna:</strong>
                            {{
                                $riwayat->user?->name
                                    ?? 'Pengguna tidak tersedia'
                            }}
                        </span>

                        <span>
                            <strong>Status:</strong>
                            {{ $riwayat->status_sebelum ?? '-' }}
                            →
                            {{ $riwayat->status_sesudah ?? '-' }}
                        </span>

                    </div>
                </div>

                <div>
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
                        <span class="badge badge-netral">
                            {{ $riwayat->role_pengguna ?? '-' }}
                        </span>
                    @endif
                </div>

            </div>

            <div class="history-description">
                {{ $riwayat->deskripsi ?? '-' }}
            </div>

        </div>

        @if (empty($dataSebelum) && empty($dataSesudah))

            <div class="old-history-notice">
                Detail data sebelum dan sesudah tidak tersedia untuk
                riwayat ini karena aktivitas tersebut dibuat sebelum
                fitur snapshot Risk Register ditambahkan.
            </div>

        @else

            <div class="table-wrapper">

                <table class="snapshot-table">

                    <thead>
                        <tr>
                            <th>Kolom Risk Register</th>
                            <th>Data Sebelum</th>
                            <th>Data Sesudah</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($kelompokKolom as $namaKelompok => $kolomKolom)

                            <tr class="section-row">
                                <td colspan="3">
                                    {{ $namaKelompok }}
                                </td>
                            </tr>

                            @foreach ($kolomKolom as $namaKolom => $labelKolom)

                                @php
                                    $nilaiSebelum =
                                        $dataSebelum[$namaKolom] ?? null;

                                    $nilaiSesudah =
                                        $dataSesudah[$namaKolom] ?? null;

                                    $nilaiBerubah =
                                        (string) $nilaiSebelum
                                        !== (string) $nilaiSesudah;
                                @endphp

                                <tr class="{{ $nilaiBerubah ? 'changed-row' : '' }}">

                                    <td class="field-name">
                                        {{ $labelKolom }}

                                        @if ($nilaiBerubah)
                                            <span class="change-label">
                                                BERUBAH
                                            </span>
                                        @endif
                                    </td>

                                    <td class="before-value">
                                        @if (
                                            $nilaiSebelum === null
                                            || $nilaiSebelum === ''
                                        )
                                            <span class="empty-value">
                                                -
                                            </span>
                                        @else
                                            {{
                                                $formatNilai(
                                                    $namaKolom,
                                                    $nilaiSebelum
                                                )
                                            }}
                                        @endif
                                    </td>

                                    <td class="after-value">
                                        @if (
                                            $nilaiSesudah === null
                                            || $nilaiSesudah === ''
                                        )
                                            <span class="empty-value">
                                                -
                                            </span>
                                        @else
                                            {{
                                                $formatNilai(
                                                    $namaKolom,
                                                    $nilaiSesudah
                                                )
                                            }}
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

@empty

    <div class="card data-kosong">
        Belum ada riwayat untuk risiko ini.
    </div>

@endforelse

@endsection