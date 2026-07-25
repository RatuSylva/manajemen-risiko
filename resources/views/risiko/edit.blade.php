@extends('layouts.app')

@section('title', 'Edit Risk Register')

@section('page-title', 'Edit Risk Register')

@section(
    'page-description',
    'Perbarui identifikasi, analisis, dan rencana penanganan risiko.'
)

@push('styles')
<style>
    .form-card {
        max-width: 1050px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 8px;
    }

    .form-section-title {
        margin-bottom: 18px;
        padding: 12px 15px;
        border-left: 5px solid #0B0083;
        border-radius: 5px;
        background: #f2f1ff;
        color: #0B0083;
        font-size: 18px;
    }

    .form-section-description {
        margin: -8px 0 18px;
        color: #666;
        font-size: 13px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .form-row-three {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        color: #222;
        font-size: 14px;
        font-weight: 700;
    }

    .required {
        color: #c62828;
    }

    .helper-text {
        margin-top: 6px;
        color: #6b7280;
        font-size: 12px;
        line-height: 1.5;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        background: #fff;
        font-family: inherit;
        font-size: 14px;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #0B0083;
        box-shadow: 0 0 0 3px rgba(11, 0, 131, 0.1);
    }

    textarea {
        min-height: 105px;
        resize: vertical;
    }

    .error {
        margin-top: 6px;
        color: #c62828;
        font-size: 12px;
    }

    .status-panel {
        margin-bottom: 28px;
        padding: 18px;
        border: 1px solid #ddd;
        border-left: 4px solid #0B0083;
        border-radius: 8px;
        background: #f8f8fc;
    }

    .status-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .status-item {
        padding: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        background: white;
    }

    .status-label {
        display: block;
        margin-bottom: 7px;
        color: #666;
        font-size: 12px;
    }

    .status-value {
        font-size: 14px;
        font-weight: 700;
    }

    .note-box {
        margin-top: 15px;
        padding: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        background: #fff;
        font-size: 13px;
        line-height: 1.6;
    }

    .note-box strong {
        color: #0B0083;
    }

    .automatic-box {
        margin-bottom: 18px;
        padding: 14px 16px;
        border: 1px solid #d8d6ff;
        border-radius: 8px;
        background: #f4f3ff;
        color: #333;
        font-size: 13px;
        line-height: 1.6;
    }

    .automatic-box strong {
        color: #0B0083;
    }

    .result-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 18px;
    }

    .result-box {
        padding: 14px;
        border: 1px solid #d8d6ff;
        border-radius: 8px;
        background: #eeeefe;
        line-height: 1.6;
    }

    .result-box strong {
        color: #0B0083;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 11px 18px;
        border: none;
        border-radius: 7px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-primary {
        background: #0B0083;
        color: #fff;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #333;
    }

    @media (max-width: 800px) {
        .form-row,
        .form-row-three,
        .status-grid,
        .result-grid {
            grid-template-columns: 1fr;
        }

        .button-group {
            align-items: stretch;
            flex-direction: column-reverse;
        }
    }
</style>
@endpush

@section('content')

<div class="card form-card">

    <div class="status-panel">

        <div class="status-grid">

            <div class="status-item">
                <span class="status-label">
                    Status Verifikasi UMR
                </span>

                <span class="status-value">
                    {{ $risiko->status_verifikasi ?? 'Belum Diverifikasi' }}
                </span>
            </div>

            <div class="status-item">
                <span class="status-label">
                    Status Reviu UPI
                </span>

                <span class="status-value">
                    {{ $risiko->status_reviu ?? 'Belum Direviu' }}
                </span>
            </div>

        </div>

        @if ($risiko->catatan_verifikasi)
            <div class="note-box">
                <strong>Catatan Verifikasi UMR:</strong>
                <br>
                {{ $risiko->catatan_verifikasi }}
            </div>
        @endif

        @if ($risiko->catatan_perbaikan)
            <div class="note-box">
                <strong>Catatan Perbaikan UPI:</strong>
                <br>
                {{ $risiko->catatan_perbaikan }}
            </div>
        @endif

    </div>

    <form
        method="POST"
        action="{{ route('risiko.update', $risiko->id) }}"
    >
        @csrf
        @method('PUT')

        <section class="form-section">

            <h2 class="form-section-title">
                1. Identifikasi Risiko
            </h2>

            <p class="form-section-description">
                Perbarui sasaran strategis, peristiwa risiko,
                penyebab, dan dampaknya.
            </p>

            <div class="form-group">
                <label for="sasaran">
                    Sasaran Strategis
                    <span class="required">*</span>
                </label>

                <textarea
                    id="sasaran"
                    name="sasaran"
                    required
                >{{ old('sasaran', $risiko->sasaran) }}</textarea>

                @error('sasaran')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="kode_risiko">
                        Kode Risiko
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="kode_risiko"
                        name="kode_risiko"
                        value="{{ old('kode_risiko', $risiko->kode_risiko) }}"
                        required
                    >

                    @error('kode_risiko')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kategori_risiko">
                        Kategori Risiko
                        <span class="required">*</span>
                    </label>

                    <select
                        id="kategori_risiko"
                        name="kategori_risiko"
                        required
                    >
                        <option value="">
                            Pilih Kategori Risiko
                        </option>

                         @foreach ([
                            'Risiko Reputasi',
                            'Risiko Keuangan (Rupiah)',
                            'Keselamatan dan Kesehatan Kerja',
                            'Layanan',
                            'Proyek',
                            'Kinerja',
                            'Operasional'
                        ] as $kategori)
                            <option
                                value="{{ $kategori }}"
                                {{
                                    old(
                                        'kategori_risiko',
                                        $risiko->kategori_risiko
                                    ) === $kategori
                                        ? 'selected'
                                        : ''
                                }}
                            >
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>

                    @error('kategori_risiko')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="form-group">
                <label for="nama_risiko">
                    Peristiwa Risiko
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="nama_risiko"
                    name="nama_risiko"
                    value="{{ old('nama_risiko', $risiko->nama_risiko) }}"
                    required
                >

                @error('nama_risiko')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="penyebab_risiko">
                        Penyebab Risiko
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="penyebab_risiko"
                        name="penyebab_risiko"
                        required
                    >{{ old('penyebab_risiko', $risiko->penyebab_risiko) }}</textarea>

                    @error('penyebab_risiko')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dampak_risiko">
                        Dampak Risiko
                        <span class="required">*</span>
                    </label>

                    <textarea
                        id="dampak_risiko"
                        name="dampak_risiko"
                        required
                    >{{ old('dampak_risiko', $risiko->dampak_risiko) }}</textarea>

                    @error('dampak_risiko')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </section>

        <section class="form-section">

            <h2 class="form-section-title">
                2. Analisis Risiko Saat Ini
            </h2>

            <div class="form-group">
                <label for="kontrol_eksisting">
                    Kontrol Eksisting
                </label>

                <textarea
                    id="kontrol_eksisting"
                    name="kontrol_eksisting"
                >{{ old('kontrol_eksisting', $risiko->kontrol_eksisting) }}</textarea>

                @error('kontrol_eksisting')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row-three">

                <div class="form-group">
                    <label for="kemungkinan">
                        Tingkat Kemungkinan
                        <span class="required">*</span>
                    </label>

                    <select
                        id="kemungkinan"
                        name="kemungkinan"
                        required
                    >
                        <option value="">
                            Pilih Tingkat Kemungkinan
                        </option>

                        @foreach ([
                            1 => 'Sangat Kecil',
                            2 => 'Kecil',
                            3 => 'Sedang',
                            4 => 'Besar',
                            5 => 'Sangat Besar'
                        ] as $nilai => $label)
                            <option
                                value="{{ $nilai }}"
                                {{
                                    old(
                                        'kemungkinan',
                                        $risiko->kemungkinan
                                    ) == $nilai
                                        ? 'selected'
                                        : ''
                                }}
                            >
                                {{ $nilai }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('kemungkinan')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dampak">
                        Tingkat Dampak
                        <span class="required">*</span>
                    </label>

                    <select
                        id="dampak"
                        name="dampak"
                        required
                    >
                        <option value="">
                            Pilih Tingkat Dampak
                        </option>

                        @foreach ([
                            1 => 'Sangat Rendah',
                            2 => 'Rendah',
                            3 => 'Sedang',
                            4 => 'Tinggi',
                            5 => 'Sangat Tinggi'
                        ] as $nilai => $label)
                            <option
                                value="{{ $nilai }}"
                                {{
                                    old(
                                        'dampak',
                                        $risiko->dampak
                                    ) == $nilai
                                        ? 'selected'
                                        : ''
                                }}
                            >
                                {{ $nilai }} - {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('dampak')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kuantifikasi">
                        Kuantifikasi Risiko
                    </label>

                    <input
                        type="number"
                        id="kuantifikasi"
                        name="kuantifikasi"
                        value="{{ old('kuantifikasi', $risiko->kuantifikasi) }}"
                        min="0"
                        step="0.01"
                        placeholder="Dalam juta rupiah"
                    >

                    @error('kuantifikasi')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="result-grid">

                <div class="result-box">
                    <strong>Level Risiko Saat Ini</strong>
                    <br>
                    Besaran:
                    {{ $risiko->besaran_risiko ?? '-' }}
                    <br>
                    Kategori:
                    {{ $risiko->level_risiko ?? '-' }}
                </div>

                <div class="result-box">
                    <strong>Warna Risiko</strong>
                    <br>
                    {{ $risiko->warna_level ?? '-' }}
                </div>

            </div>

            <div class="automatic-box">
                Nilai level risiko akan dihitung ulang secara otomatis
                setelah perubahan disimpan.
            </div>

        </section>

        <section class="form-section">

            <h2 class="form-section-title">
                3. Rencana Penanganan Risiko
            </h2>

            <div class="form-group">
                <label for="rencana_penanganan">
                    Rencana Penanganan Risiko
                </label>

                <textarea
                    id="rencana_penanganan"
                    name="rencana_penanganan"
                >{{ old('rencana_penanganan', $risiko->rencana_penanganan) }}</textarea>

                @error('rencana_penanganan')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">

                <div class="form-group">
                    <label for="batas_waktu">
                        Target Waktu
                    </label>

                    <input
                        type="date"
                        id="batas_waktu"
                        name="batas_waktu"
                        value="{{
                            old(
                                'batas_waktu',
                                optional($risiko->batas_waktu)->format('Y-m-d')
                            )
                        }}"
                    >

                    @error('batas_waktu')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="penanggung_jawab">
                        Unit Pemilik Risiko
                    </label>

                    <input
                        type="text"
                        id="penanggung_jawab"
                        name="penanggung_jawab"
                        value="{{
                            old(
                                'penanggung_jawab',
                                $risiko->penanggung_jawab
                            )
                        }}"
                    >

                    @error('penanggung_jawab')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </section>

        <section class="form-section">

            <h2 class="form-section-title">
                4. Analisis Risiko Residual
            </h2>

            <div class="form-row-three">

                <div class="form-group">
                    <label for="target_kemungkinan">
                        Target Tingkat Kemungkinan
                    </label>

                    <select
                        id="target_kemungkinan"
                        name="target_kemungkinan"
                    >
                        <option value="">
                            Pilih Target Kemungkinan
                        </option>

                        @for ($nilai = 1; $nilai <= 5; $nilai++)
                            <option
                                value="{{ $nilai }}"
                                {{
                                    old(
                                        'target_kemungkinan',
                                        $risiko->target_kemungkinan
                                    ) == $nilai
                                        ? 'selected'
                                        : ''
                                }}
                            >
                                {{ $nilai }}
                            </option>
                        @endfor
                    </select>

                    @error('target_kemungkinan')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="target_dampak">
                        Target Tingkat Dampak
                    </label>

                    <select
                        id="target_dampak"
                        name="target_dampak"
                    >
                        <option value="">
                            Pilih Target Dampak
                        </option>

                        @for ($nilai = 1; $nilai <= 5; $nilai++)
                            <option
                                value="{{ $nilai }}"
                                {{
                                    old(
                                        'target_dampak',
                                        $risiko->target_dampak
                                    ) == $nilai
                                        ? 'selected'
                                        : ''
                                }}
                            >
                                {{ $nilai }}
                            </option>
                        @endfor
                    </select>

                    @error('target_dampak')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kuantifikasi_residual">
                        Kuantifikasi Risiko Residual
                    </label>

                    <input
                        type="number"
                        id="kuantifikasi_residual"
                        name="kuantifikasi_residual"
                        value="{{
                            old(
                                'kuantifikasi_residual',
                                $risiko->kuantifikasi_residual
                            )
                        }}"
                        min="0"
                        step="0.01"
                    >

                    @error('kuantifikasi_residual')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="result-box">
                <strong>Hasil Risiko Residual Saat Ini</strong>
                <br>
                Besaran:
                {{ $risiko->besaran_risiko_residual ?? '-' }}
                <br>
                Kategori:
                {{ $risiko->level_risiko_residual ?? '-' }}
            </div>

        </section>

        <section class="form-section">

    <h2 class="form-section-title">
        5. Pemantauan Risiko
    </h2>

    <p class="form-section-description">
        Data ini digunakan untuk mengisi laporan pemantauan triwulan.
    </p>

    <div class="form-group">
        <label for="proyeksi_risiko">
            Proyeksi Risiko
        </label>

        <textarea
            id="proyeksi_risiko"
            name="proyeksi_risiko"
            placeholder="Contoh: Risiko diproyeksikan menurun setelah penanganan dilaksanakan"
        >{{ old('proyeksi_risiko', $risiko->proyeksi_risiko) }}</textarea>

        @error('proyeksi_risiko')
            <div class="error">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="mitigasi_terlaksana">
            Mitigasi yang Telah Dilaksanakan
        </label>

        <textarea
            id="mitigasi_terlaksana"
            name="mitigasi_terlaksana"
            placeholder="Jelaskan tindakan mitigasi yang sudah dilaksanakan"
        >{{ old('mitigasi_terlaksana', $risiko->mitigasi_terlaksana) }}</textarea>

        @error('mitigasi_terlaksana')
            <div class="error">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="form-group">
        <label for="keterangan_pemantauan">
            Keterangan Pemantauan
        </label>

        <textarea
            id="keterangan_pemantauan"
            name="keterangan_pemantauan"
            placeholder="Masukkan perkembangan, hambatan, atau keterangan tambahan"
        >{{ old('keterangan_pemantauan', $risiko->keterangan_pemantauan) }}</textarea>

        @error('keterangan_pemantauan')
            <div class="error">
                {{ $message }}
            </div>
        @enderror
    </div>

</section>

        <section class="form-section">

            <h2 class="form-section-title">
                6. Status Penanganan
            </h2>

            <div class="form-group">
                <label for="status_penanganan">
                    Status Penanganan
                    <span class="required">*</span>
                </label>

                <select
                    id="status_penanganan"
                    name="status_penanganan"
                    required
                >
                    <option value="">
                        Pilih Status Penanganan
                    </option>

                    @foreach ([
                        'Belum Ditangani',
                        'Sedang Berjalan',
                        'Selesai'
                    ] as $status)
                        <option
                            value="{{ $status }}"
                            {{
                                old(
                                    'status_penanganan',
                                    $risiko->status_penanganan
                                ) === $status
                                    ? 'selected'
                                    : ''
                            }}
                        >
                            {{ $status }}
                        </option>
                    @endforeach
                </select>

                @error('status_penanganan')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

        </section>

        <div class="button-group">

            <a
                href="{{ route('risiko.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection