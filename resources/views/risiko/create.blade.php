@extends('layouts.app')

@section('title', 'Tambah Risk Register')

@section('page-title', 'Tambah Risk Register')

@section(
    'page-description',
    'Catat identifikasi, analisis, dan rencana penanganan risiko.'
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


    .matrix-action {
        display: flex;
        justify-content: flex-end;
        margin: 12px 0 18px;
    }

    .btn-matrix {
        background: #16803b;
        color: #fff;
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
        max-width: 980px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.28);
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .modal-header h3 {
        margin: 0;
        color: #0B0083;
        font-size: 20px;
    }

    .modal-close {
        border: none;
        background: transparent;
        color: #555;
        font-size: 28px;
        cursor: pointer;
    }

    .modal-body {
        padding: 20px;
    }

    .matrix-description {
        margin-bottom: 18px;
        padding: 13px 15px;
        border-left: 4px solid #0B0083;
        border-radius: 7px;
        background: #f2f1ff;
        color: #333;
        font-size: 13px;
        line-height: 1.6;
    }

    .matrix-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(300px, 0.8fr);
        gap: 24px;
        align-items: start;
    }

    .matrix-title {
        margin-bottom: 10px;
        color: #111;
        font-size: 16px;
        text-align: center;
    }

    .matrix-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .risk-matrix,
    .level-table {
        width: 100%;
        border-collapse: collapse;
    }

    .risk-matrix th,
    .risk-matrix td,
    .level-table th,
    .level-table td {
        padding: 12px 10px;
        border: 1px solid #111;
        text-align: center;
        font-size: 13px;
        font-weight: 700;
    }

    .risk-matrix th,
    .level-table th {
        background: #f3f4f6;
        color: #111;
    }

    .matrix-low {
        background: #2ecc40;
        color: #111;
    }

    .matrix-medium {
        background: #fff200;
        color: #111;
    }

    .matrix-high {
        background: #ff9f1c;
        color: #111;
    }

    .matrix-extreme {
        background: #ff1f1f;
        color: #111;
    }

    .matrix-note {
        margin-top: 16px;
        color: #555;
        font-size: 12px;
        line-height: 1.6;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        padding: 16px 20px;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 800px) {
        .form-row,
        .form-row-three {
            grid-template-columns: 1fr;
        }

        .button-group {
            align-items: stretch;
            flex-direction: column-reverse;
        }

        .matrix-layout {
            grid-template-columns: 1fr;
        }

        .matrix-action {
            justify-content: stretch;
        }

        .matrix-action .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="card form-card">

    <form method="POST" action="{{ route('risiko.store') }}">
        @csrf

        {{-- IDENTIFIKASI RISIKO --}}
        <section class="form-section">

            <h2 class="form-section-title">
                1. Identifikasi Risiko
            </h2>

            <p class="form-section-description">
                Catat sasaran strategis, peristiwa risiko, penyebab,
                dan dampak yang mungkin terjadi.
            </p>

            <div class="form-group">
                <label for="sasaran">
                    Sasaran Strategis
                    <span class="required">*</span>
                </label>

                <textarea
                    id="sasaran"
                    name="sasaran"
                    placeholder="Masukkan sasaran strategis unit kerja"
                    required
                >{{ old('sasaran') }}</textarea>

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
                        value="{{ old('kode_risiko') }}"
                        placeholder="Contoh: RSK-001"
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
                                old('kategori_risiko') === $kategori
                                    ? 'selected'
                                    : ''
                            }}
                        >
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>

                @error('kategori_risiko')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
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
                    value="{{ old('nama_risiko') }}"
                    placeholder="Masukkan peristiwa risiko"
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
                        placeholder="Jelaskan penyebab terjadinya risiko"
                        required
                    >{{ old('penyebab_risiko') }}</textarea>

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
                        placeholder="Jelaskan dampak apabila risiko terjadi"
                        required
                    >{{ old('dampak_risiko') }}</textarea>

                    @error('dampak_risiko')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </section>

        {{-- ANALISIS RISIKO SAAT INI --}}
        <section class="form-section">

            <h2 class="form-section-title">
                2. Analisis Risiko Saat Ini
            </h2>

            <p class="form-section-description">
                Nilai kemungkinan dan dampak akan diproses otomatis
                menggunakan matriks risiko BP Batam.
            </p>

            <div class="matrix-action">
                <button
                    type="button"
                    class="btn btn-matrix buka-matriks-risiko"
                >
                    Lihat Matriks Risiko Saat Ini
                </button>
            </div>

            <div class="form-group">
                <label for="kontrol_eksisting">
                    Kontrol Eksisting
                </label>

                <textarea
                    id="kontrol_eksisting"
                    name="kontrol_eksisting"
                    placeholder="Jelaskan kontrol yang saat ini telah diterapkan"
                >{{ old('kontrol_eksisting') }}</textarea>

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

                        <option
                            value="1"
                            {{ old('kemungkinan') == 1 ? 'selected' : '' }}
                        >
                            1 - Sangat Kecil
                        </option>

                        <option
                            value="2"
                            {{ old('kemungkinan') == 2 ? 'selected' : '' }}
                        >
                            2 - Kecil
                        </option>

                        <option
                            value="3"
                            {{ old('kemungkinan') == 3 ? 'selected' : '' }}
                        >
                            3 - Sedang
                        </option>

                        <option
                            value="4"
                            {{ old('kemungkinan') == 4 ? 'selected' : '' }}
                        >
                            4 - Besar
                        </option>

                        <option
                            value="5"
                            {{ old('kemungkinan') == 5 ? 'selected' : '' }}
                        >
                            5 - Sangat Besar
                        </option>
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

                        <option value="1" {{ old('dampak') == 1 ? 'selected' : '' }}>
                            1 - Sangat Rendah
                        </option>

                        <option value="2" {{ old('dampak') == 2 ? 'selected' : '' }}>
                            2 - Rendah
                        </option>

                        <option value="3" {{ old('dampak') == 3 ? 'selected' : '' }}>
                            3 - Sedang
                        </option>

                        <option value="4" {{ old('dampak') == 4 ? 'selected' : '' }}>
                            4 - Tinggi
                        </option>

                        <option value="5" {{ old('dampak') == 5 ? 'selected' : '' }}>
                            5 - Sangat Tinggi
                        </option>
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
                        value="{{ old('kuantifikasi') }}"
                        min="0"
                        step="0.01"
                        placeholder="Dalam juta rupiah"
                    >

                    <div class="helper-text">
                        Masukkan nilai dalam satuan juta rupiah.
                    </div>

                    @error('kuantifikasi')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="automatic-box">
                <strong>Perhitungan otomatis:</strong>
                sistem akan menentukan level risiko dan kategori
                Rendah, Sedang, Tinggi, atau Ekstrim setelah data disimpan.
            </div>

        </section>

        {{-- RENCANA PENANGANAN --}}
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
                    placeholder="Masukkan rencana penanganan risiko"
                >{{ old('rencana_penanganan') }}</textarea>

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
                        value="{{ old('batas_waktu') }}"
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
                        value="{{ old('penanggung_jawab') }}"
                        placeholder="Contoh: Unit PDSI"
                    >

                    @error('penanggung_jawab')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

        </section>

        {{-- ANALISIS RISIKO RESIDUAL --}}
        <section class="form-section">

            <h2 class="form-section-title">
                4. Analisis Risiko Residual
            </h2>

            <p class="form-section-description">
                Nilai residual merupakan target risiko setelah
                rencana penanganan dilaksanakan.
            </p>

            <div class="matrix-action">
                <button
                    type="button"
                    class="btn btn-matrix buka-matriks-risiko"
                >
                    Lihat Matriks Risiko Residual
                </button>
            </div>

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
                                {{ old('target_kemungkinan') == $nilai ? 'selected' : '' }}
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
                                {{ old('target_dampak') == $nilai ? 'selected' : '' }}
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
                        value="{{ old('kuantifikasi_residual') }}"
                        min="0"
                        step="0.01"
                        placeholder="Dalam juta rupiah"
                    >

                    @error('kuantifikasi_residual')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="automatic-box">
                <strong>Perhitungan residual otomatis:</strong>
                level dan kategori risiko residual akan dihitung
                dari target kemungkinan dan target dampak.
            </div>

        </section>

        {{-- PEMANTAUAN RISIKO --}}
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
        >{{ old('proyeksi_risiko') }}</textarea>

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
        >{{ old('mitigasi_terlaksana') }}</textarea>

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
        >{{ old('keterangan_pemantauan') }}</textarea>

        @error('keterangan_pemantauan')
            <div class="error">
                {{ $message }}
            </div>
        @enderror
    </div>

</section>

        {{-- STATUS SISTEM --}}
        <section class="form-section">

            <h2 class="form-section-title">
                6. Status Penanganan
            </h2>

            <p class="form-section-description">
                Status ini digunakan aplikasi untuk memantau kemajuan
                pelaksanaan penanganan risiko.
            </p>

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

                    <option
                        value="Belum Ditangani"
                        {{ old('status_penanganan') === 'Belum Ditangani' ? 'selected' : '' }}
                    >
                        Belum Ditangani
                    </option>

                    <option
                        value="Sedang Berjalan"
                        {{ old('status_penanganan') === 'Sedang Berjalan' ? 'selected' : '' }}
                    >
                        Sedang Berjalan
                    </option>

                    <option
                        value="Selesai"
                        {{ old('status_penanganan') === 'Selesai' ? 'selected' : '' }}
                    >
                        Selesai
                    </option>
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
                Simpan Risk Register
            </button>

        </div>

    </form>

</div>


<div
    class="modal-overlay"
    id="modalMatriksRisiko"
>
    <div class="modal-box">

        <div class="modal-header">
            <h3>Matriks Risiko</h3>

            <button
                type="button"
                class="modal-close"
                id="tutupMatriksRisiko"
                aria-label="Tutup"
            >
                &times;
            </button>
        </div>

        <div class="modal-body">

            <div class="matrix-description">
                Matriks ini menjadi acuan penentuan besaran dan level risiko.
                Cocokkan nilai kemungkinan dan dampak, kemudian lihat nilai
                pada titik pertemuan keduanya.
            </div>

            <div class="matrix-layout">

                <div>
                    <h4 class="matrix-title">
                        Matriks Kemungkinan dan Dampak
                    </h4>

                    <div class="matrix-table-wrapper">

                        <table class="risk-matrix">

                            <thead>
                                <tr>
                                    <th rowspan="2">
                                        Kemungkinan
                                    </th>

                                    <th colspan="5">
                                        Dampak
                                    </th>
                                </tr>

                                <tr>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <th>5</th>
                                    <td class="matrix-medium">10</td>
                                    <td class="matrix-medium">12</td>
                                    <td class="matrix-high">19</td>
                                    <td class="matrix-extreme">23</td>
                                    <td class="matrix-extreme">25</td>
                                </tr>

                                <tr>
                                    <th>4</th>
                                    <td class="matrix-low">6</td>
                                    <td class="matrix-medium">11</td>
                                    <td class="matrix-high">17</td>
                                    <td class="matrix-extreme">21</td>
                                    <td class="matrix-extreme">24</td>
                                </tr>

                                <tr>
                                    <th>3</th>
                                    <td class="matrix-low">4</td>
                                    <td class="matrix-medium">8</td>
                                    <td class="matrix-high">13</td>
                                    <td class="matrix-high">18</td>
                                    <td class="matrix-extreme">22</td>
                                </tr>

                                <tr>
                                    <th>2</th>
                                    <td class="matrix-low">2</td>
                                    <td class="matrix-low">5</td>
                                    <td class="matrix-medium">9</td>
                                    <td class="matrix-high">15</td>
                                    <td class="matrix-extreme">20</td>
                                </tr>

                                <tr>
                                    <th>1</th>
                                    <td class="matrix-low">1</td>
                                    <td class="matrix-low">3</td>
                                    <td class="matrix-medium">7</td>
                                    <td class="matrix-high">14</td>
                                    <td class="matrix-high">16</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>
                </div>

                <div>
                    <h4 class="matrix-title">
                        Level Risiko Kuantitatif/Kualitatif
                    </h4>

                    <div class="matrix-table-wrapper">

                        <table class="level-table">

                            <thead>
                                <tr>
                                    <th>Besaran</th>
                                    <th>Level Risiko</th>
                                    <th>Kontrol</th>
                                    <th>Mitigasi</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr class="matrix-low">
                                    <td>1–6</td>
                                    <td>Rendah</td>
                                    <td>Efektif</td>
                                    <td>Tidak perlu</td>
                                </tr>

                                <tr class="matrix-medium">
                                    <td>7–12</td>
                                    <td>Sedang</td>
                                    <td>Kurang Efektif</td>
                                    <td>Tidak perlu, tetapi waspada</td>
                                </tr>

                                <tr class="matrix-high">
                                    <td>13–19</td>
                                    <td>Tinggi</td>
                                    <td>Tidak Efektif</td>
                                    <td>Perlu</td>
                                </tr>

                                <tr class="matrix-extreme">
                                    <td>20–25</td>
                                    <td>Ekstrim</td>
                                    <td>Tidak Ada</td>
                                    <td>Perlu segera</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <p class="matrix-note">
                        Contoh: nilai kemungkinan 3 dan dampak 4 bertemu
                        pada nilai 18. Nilai tersebut termasuk level
                        risiko Tinggi.
                    </p>
                </div>

            </div>

        </div>

        <div class="modal-footer">
            <button
                type="button"
                class="btn btn-secondary"
                id="tutupMatriksRisikoBawah"
            >
                Tutup
            </button>
        </div>

    </div>
</div>

<script>
    const modalMatriksRisiko =
        document.getElementById('modalMatriksRisiko');

    const tutupMatriksRisiko =
        document.getElementById('tutupMatriksRisiko');

    const tutupMatriksRisikoBawah =
        document.getElementById('tutupMatriksRisikoBawah');

    function bukaModalMatriks() {
        modalMatriksRisiko.classList.add('active');
    }

    function tutupModalMatriks() {
        modalMatriksRisiko.classList.remove('active');
    }

    document
        .querySelectorAll('.buka-matriks-risiko')
        .forEach(function (button) {
            button.addEventListener(
                'click',
                bukaModalMatriks
            );
        });

    tutupMatriksRisiko.addEventListener(
        'click',
        tutupModalMatriks
    );

    tutupMatriksRisikoBawah.addEventListener(
        'click',
        tutupModalMatriks
    );

    modalMatriksRisiko.addEventListener(
        'click',
        function (event) {
            if (event.target === modalMatriksRisiko) {
                tutupModalMatriks();
            }
        }
    );

    document.addEventListener(
        'keydown',
        function (event) {
            if (
                event.key === 'Escape'
                && modalMatriksRisiko.classList.contains('active')
            ) {
                tutupModalMatriks();
            }
        }
    );
</script>

@endsection 