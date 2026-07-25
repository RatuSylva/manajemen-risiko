@extends('layouts.app')

@section('title', 'Dashboard UPR')

@section('page-title', 'Dashboard UPR')

@section(
    'page-description',
    'Pantau pencatatan, perbaikan, verifikasi, dan penanganan risiko.'
)

@push('styles')
<style>
    .welcome-card {
        margin-bottom: 24px;
        padding: 28px;
        border-radius: 14px;
        background: linear-gradient(135deg, #0B0083, #3025b7);
        color: white;
    }

    .welcome-card h2 {
        margin-bottom: 8px;
        font-size: 26px;
    }

    .welcome-card p {
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.84);
    }

    .section-title {
        margin: 28px 0 14px;
        color: #0B0083;
        font-size: 19px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .stat-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .stat-label {
        margin-bottom: 10px;
        color: #777;
        font-size: 13px;
    }

    .stat-number {
        color: #0B0083;
        font-size: 30px;
        font-weight: bold;
    }

    .stat-note {
        margin-top: 8px;
        color: #888;
        font-size: 12px;
        line-height: 1.4;
    }

    .status-warning {
        border-left: 5px solid #f59e0b;
    }

    .status-danger {
        border-left: 5px solid #dc2626;
    }

    .status-success {
        border-left: 5px solid #16a34a;
    }

    .status-primary {
        border-left: 5px solid #0B0083;
    }

    .progress-card {
        padding: 22px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
    }

    .progress-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
    }

    .progress-item {
        padding: 18px;
        border-radius: 10px;
        background: #f8f8ff;
    }

    .progress-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        gap: 10px;
    }

    .progress-item-header strong {
        color: #262626;
    }

    .progress-value {
        color: #0B0083;
        font-size: 22px;
        font-weight: bold;
    }

    .progress-bar {
        height: 9px;
        overflow: hidden;
        border-radius: 20px;
        background: #e5e7eb;
    }

    .progress-fill {
        height: 100%;
        border-radius: 20px;
        background: #0B0083;
    }

    .progress-description {
        margin-top: 9px;
        color: #777;
        font-size: 12px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .dashboard-card h3 {
        margin-bottom: 9px;
        color: #0B0083;
    }

    .dashboard-card p {
        min-height: 52px;
        margin-bottom: 18px;
        color: #777;
        line-height: 1.5;
    }

    .card-link {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 7px;
        background: #0B0083;
        color: white;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .card-link:hover {
        background: #08005f;
    }

    .attention-card {
        margin-top: 20px;
        padding: 18px 20px;
        border-left: 5px solid #f59e0b;
        border-radius: 10px;
        background: #fff8e8;
        color: #5f4500;
        line-height: 1.6;
    }

    .attention-card strong {
        display: block;
        margin-bottom: 4px;
    }

    @media (max-width: 1100px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .progress-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 950px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }

        .welcome-card {
            padding: 22px;
        }

        .welcome-card h2 {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')

@php
    $totalPenanganan = $belumDitangani + $sedangBerjalan + $selesai;

    $persentaseBelumDitangani = $totalPenanganan > 0
        ? round(($belumDitangani / $totalPenanganan) * 100)
        : 0;

    $persentaseSedangBerjalan = $totalPenanganan > 0
        ? round(($sedangBerjalan / $totalPenanganan) * 100)
        : 0;

    $persentaseSelesai = $totalPenanganan > 0
        ? round(($selesai / $totalPenanganan) * 100)
        : 0;
@endphp

<div class="welcome-card">
    <h2>Selamat Datang, {{ Auth::user()->name }}</h2>

    <p>
        Anda masuk sebagai Unit Pemilik Risiko. Dashboard ini menampilkan
        ringkasan proses pencatatan, verifikasi, perbaikan, persetujuan,
        dan penanganan risiko.
    </p>
</div>

<h2 class="section-title">Ringkasan Proses Risiko</h2>

<div class="stat-grid">

    <div class="stat-card status-primary">
        <div class="stat-label">Total Risiko</div>
        <div class="stat-number">{{ $totalRisiko }}</div>
        <div class="stat-note">
            Seluruh data Risk Register yang telah dicatat.
        </div>
    </div>

    <div class="stat-card status-warning">
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-number">{{ $menungguVerifikasi }}</div>
        <div class="stat-note">
            Data sedang menunggu pemeriksaan oleh UMR.
        </div>
    </div>

    <div class="stat-card status-danger">
        <div class="stat-label">Perlu Perbaikan</div>
        <div class="stat-number">{{ $perluPerbaikan }}</div>
        <div class="stat-note">
            Data perlu diperbaiki berdasarkan catatan UMR atau UPI.
        </div>
    </div>

    <div class="stat-card status-success">
        <div class="stat-label">Disetujui UPI</div>
        <div class="stat-number">{{ $disetujui }}</div>
        <div class="stat-note">
            Data telah selesai melalui proses verifikasi dan reviu.
        </div>
    </div>

</div>

@if ($perluPerbaikan > 0)
    <div class="attention-card">
        <strong>Perhatian</strong>
        Terdapat {{ $perluPerbaikan }} data risiko yang perlu diperbaiki.
        Silakan buka halaman Risk Register dan periksa catatan perbaikannya.
    </div>
@endif

<h2 class="section-title">Progres Penanganan Risiko</h2>

<div class="progress-card">
    <div class="progress-grid">

        <div class="progress-item">
            <div class="progress-item-header">
                <strong>Belum Ditangani</strong>
                <span class="progress-value">
                    {{ $belumDitangani }}
                </span>
            </div>

            <div class="progress-bar">
                <div
                    class="progress-fill"
                    style="width: {{ $persentaseBelumDitangani }}%;"
                ></div>
            </div>

            <div class="progress-description">
                {{ $persentaseBelumDitangani }}% dari seluruh data penanganan.
            </div>
        </div>

        <div class="progress-item">
            <div class="progress-item-header">
                <strong>Sedang Berjalan</strong>
                <span class="progress-value">
                    {{ $sedangBerjalan }}
                </span>
            </div>

            <div class="progress-bar">
                <div
                    class="progress-fill"
                    style="width: {{ $persentaseSedangBerjalan }}%;"
                ></div>
            </div>

            <div class="progress-description">
                {{ $persentaseSedangBerjalan }}% dari seluruh data penanganan.
            </div>
        </div>

        <div class="progress-item">
            <div class="progress-item-header">
                <strong>Selesai</strong>
                <span class="progress-value">
                    {{ $selesai }}
                </span>
            </div>

            <div class="progress-bar">
                <div
                    class="progress-fill"
                    style="width: {{ $persentaseSelesai }}%;"
                ></div>
            </div>

            <div class="progress-description">
                {{ $persentaseSelesai }}% dari seluruh data penanganan.
            </div>
        </div>

    </div>
</div>

<h2 class="section-title">Akses Cepat</h2>

<div class="dashboard-grid">

    <div class="card dashboard-card">
        <h3>Kelola Data Risiko</h3>

        <p>
            Lihat seluruh data Risk Register, status verifikasi,
            status reviu, dan catatan perbaikan.
        </p>

        <a href="{{ route('risiko.index') }}" class="card-link">
            Buka Data Risiko
        </a>
    </div>

    <div class="card dashboard-card">
        <h3>Tambah Risiko</h3>

        <p>
            Catat risiko baru beserta nilai kemungkinan,
            dampak, dan rencana penanganannya.
        </p>

        <a href="{{ route('risiko.create') }}" class="card-link">
            Tambah Risiko
        </a>
    </div>

    <div class="card dashboard-card">
        <h3>Riwayat Aktivitas</h3>

        <p>
            Pantau perubahan data, hasil verifikasi,
            hasil reviu, dan riwayat perbaikan.
        </p>

        <a href="{{ route('riwayat.index') }}" class="card-link">
            Lihat Riwayat
        </a>
    </div>

</div>

@endsection