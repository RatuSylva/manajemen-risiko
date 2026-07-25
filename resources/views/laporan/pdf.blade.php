<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>
        Laporan Pemantauan Triwulan
        {{ $namaTriwulan }}
        Tahun {{ $tahun }}
    </title>

    <style>
        @page {
            margin: 14mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #111;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        .report-page {
            width: 100%;
            page-break-inside: avoid;
        }

        .page-break {
            page-break-after: always;
        }

        .main-table {
            width: 100%;
            border: 1px solid #222;
            border-collapse: collapse;
        }

        .main-table td {
            padding: 0;
            border-bottom: 1px solid #222;
            vertical-align: top;
        }

        .main-table tr:last-child td {
            border-bottom: none;
        }

        .report-title {
            padding: 7px 10px;
            background: #d8eef9;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }

        .unit-name {
            padding: 7px 10px;
            text-align: right;
            font-size: 10px;
            font-weight: normal;
        }

        .field-label {
            padding: 5px 7px;
            background: #edf4f7;
            font-size: 10px;
            font-weight: bold;
        }

        .field-content {
            min-height: 28px;
            padding: 5px 8px;
            line-height: 1.35;
        }

        .risk-content {
            min-height: 42px;
        }

        .actual-content {
            min-height: 30px;
        }

        .projection-content {
            min-height: 34px;
        }

        .mitigation-content {
            min-height: 34px;
        }

        .monitoring-table {
            width: 100%;
            margin-top: 16px;
            border: 1px solid #222;
            border-collapse: collapse;
        }

        .monitoring-table th,
        .monitoring-table td {
            padding: 6px 7px;
            border: 1px solid #222;
            vertical-align: top;
            line-height: 1.4;
        }

        .monitoring-table th {
            background: #f2f2f2;
            text-align: center;
            font-size: 9.5px;
            font-weight: bold;
        }

        .monitoring-table td {
            height: 34px;
            font-size: 9px;
        }

        .column-plan {
            width: 38%;
        }

        .column-person {
            width: 32%;
        }

        .column-time {
            width: 30%;
        }

        .recommendation-box {
            width: 100%;
            margin-top: 16px;
            border: 1px solid #222;
        }

        .recommendation-title {
            padding: 6px 8px;
            background: #1c1c1c;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .recommendation-content {
            min-height: 48px;
            padding: 7px 8px;
            line-height: 1.45;
        }

        .description-section {
            margin-top: 8px;
        }

        .description-label {
            margin-bottom: 4px;
            padding-left: 5px;
            font-size: 10px;
            font-weight: bold;
        }

        .description-content {
            min-height: 62px;
            padding: 7px 8px;
            border: 1px solid #222;
            line-height: 1.45;
        }

        .empty-report {
            padding: 35px 20px;
            border: 1px solid #222;
            text-align: center;
        }
    </style>
</head>

<body>

@forelse ($risikos as $risiko)

    <div class="report-page {{ !$loop->last ? 'page-break' : '' }}">

        <table class="main-table">

            <tr>
                <td>
                    <div class="report-title">
                        @if ($triwulan === 4)
                            Laporan Pemantauan Triwulan IV
                        @else
                            Laporan Pemantauan Triwulan
                            {{ $namaTriwulan }}
                        @endif
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="unit-name">
                        UNIT PDSI BP BATAM
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="field-label">
                        Sasaran :
                    </div>

                    <div class="field-content">
                        {{ $risiko->sasaran ?: '-' }}
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="field-label">
                        Risiko :
                    </div>

                    <div class="field-content risk-content">
                        {{ $risiko->nama_risiko ?: '-' }}

                        @if ($risiko->deskripsi)
                            <br>
                            {{ $risiko->deskripsi }}
                        @endif
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="field-label">
                        Besaran/Level Risiko Aktual dan Proyeksi Risiko :
                    </div>

                    <div class="field-content actual-content">
                        Besaran risiko aktual adalah
                        <strong>{{ $risiko->besaran_risiko ?? '-' }}</strong>
                        dengan level risiko
                        <strong>{{ $risiko->level_risiko ?? '-' }}</strong>.
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="field-label">
                        Proyeksi Risiko :
                    </div>

                    <div class="field-content projection-content">
                        {{ $risiko->proyeksi_risiko ?: '-' }}

                        @if ($risiko->tren_risiko)
                            <br>
                            Tren risiko:
                            <strong>{{ $risiko->tren_risiko }}</strong>
                        @endif
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="field-label">
                        Mitigasi yang Telah Dilaksanakan
                    </div>

                    <div class="field-content mitigation-content">
                        {{ $risiko->mitigasi_terlaksana ?: '-' }}
                    </div>
                </td>
            </tr>

        </table>

        @if ($triwulan !== 4)

            <table class="monitoring-table">
                <thead>
                    <tr>
                        <th class="column-plan">
                            Rencana Penanganan Risiko
                        </th>

                        <th class="column-person">
                            Penanggung Jawab
                        </th>

                        <th class="column-time">
                            Waktu Pelaksanaan
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            {{ $risiko->rencana_penanganan ?: '-' }}
                        </td>

                        <td>
                            {{ $risiko->penanggung_jawab ?: '-' }}
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

            <div class="recommendation-box">
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

        <div class="description-section">
            <div class="description-label">
                Keterangan :
            </div>

            <div class="description-content">
                {{ $risiko->keterangan_pemantauan ?: '-' }}
            </div>
        </div>

    </div>

@empty

    <div class="empty-report">
        <strong>
            Laporan Pemantauan Triwulan
            {{ $namaTriwulan }}
            Tahun {{ $tahun }}
        </strong>

        <br><br>

        Tidak ditemukan data risiko pada periode yang dipilih.
    </div>

@endforelse

</body>
</html>