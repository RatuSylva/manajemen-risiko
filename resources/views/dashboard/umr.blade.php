@extends('layouts.app')

@section('title', 'Dashboard UMR')

@section('page-title', 'Dashboard UMR')

@section(
    'page-description',
    'Pantau proses pemeriksaan, verifikasi, dan perbaikan data risiko.'
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

    .status-primary {
        border-left: 5px solid #0B0083;
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

    @media (max-width: 1100px) {
        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 800px) {
        .dashboard-grid,
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div class="welcome-card">
    <h2>Selamat Datang, {{ Auth::user()->name }}</h2>

    <p>
        Anda masuk sebagai Unit Manajemen Risiko. Dashboard ini menampilkan
        ringkasan data yang menunggu verifikasi, perlu diperbaiki, dan telah
        disetujui untuk diteruskan kepada UPI.
    </p>
</div>

<h2 class="section-title">Ringkasan Verifikasi Risiko</h2>

<div class="stat-grid">

    <div class="stat-card status-primary">
        <div class="stat-label">Total Risiko</div>
        <div class="stat-number">{{ $totalRisiko }}</div>
        <div class="stat-note">
            Seluruh data Risk Register yang tersedia.
        </div>
    </div>

    <div class="stat-card status-warning">
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-number">{{ $menungguVerifikasi }}</div>
        <div class="stat-note">
            Data yang belum diperiksa oleh UMR.
        </div>
    </div>

    <div class="stat-card status-danger">
        <div class="stat-label">Perlu Perbaikan</div>
        <div class="stat-number">{{ $perluPerbaikan }}</div>
        <div class="stat-note">
            Data telah dikembalikan kepada UPR untuk diperbaiki.
        </div>
    </div>

    <div class="stat-card status-success">
        <div class="stat-label">Disetujui UMR</div>
        <div class="stat-number">{{ $disetujui }}</div>
        <div class="stat-note">
            Data telah disetujui dan dapat diteruskan kepada UPI.
        </div>
    </div>

</div>

@if ($menungguVerifikasi > 0)
    <div class="attention-card">
        <strong>Perlu Ditindaklanjuti</strong>
        Terdapat {{ $menungguVerifikasi }} data risiko yang menunggu proses
        verifikasi oleh UMR.
    </div>
@endif

<h2 class="section-title">Akses Cepat</h2>

<div class="dashboard-grid">

    <div class="card dashboard-card">
        <h3>Verifikasi Risiko</h3>

        <p>
            Periksa seluruh data Risk Register dan tetapkan keputusan
            Disetujui atau Perlu Perbaikan.
        </p>

        <a href="{{ route('verifikasi.index') }}" class="card-link">
            Buka Verifikasi
        </a>
    </div>

    <div class="card dashboard-card">
        <h3>Riwayat Aktivitas</h3>

        <p>
            Lihat riwayat pencatatan, perubahan, verifikasi,
            reviu, dan perbaikan data risiko.
        </p>

        <a href="{{ route('riwayat.index') }}" class="card-link">
            Lihat Riwayat
        </a>
    </div>

    <div class="card dashboard-card">
        <h3>Laporan Risiko</h3>

        <p>
            Tampilkan dan unduh laporan pemantauan risiko
            berdasarkan periode triwulan.
        </p>

        <a href="{{ route('laporan.index') }}" class="card-link">
            Buka Laporan
        </a>
    </div>

</div>

@endsection