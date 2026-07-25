<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Sistem Manajemen Risiko')
    </title>

    <style>
        :root {
            --primary: #0B0083;
            --primary-dark: #08005f;
            --primary-light: #eeeefe;
            --sidebar-width: 260px;
            --background: #f5f6fa;
            --text: #262626;
            --muted: #777;
            --border: #e5e7eb;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: var(--background);
            color: var(--text);
        }



        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: var(--sidebar-width);
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--primary);
            color: var(--white);
            transition: transform 0.25s ease;
        }

        .sidebar-header {
            min-height: 90px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar-logo {
            width: 52px;
            height: 52px;
            object-fit: contain;
            padding: 2px;
            border-radius: 8px;
            background: var(--white);
        }

        .sidebar-title {
            font-size: 15px;
            line-height: 1.35;
        }

        .sidebar-subtitle {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            font-weight: normal;
            color: rgba(255, 255, 255, 0.72);
        }

        .sidebar-user {
            margin: 18px 16px 8px;
            padding: 14px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
        }

        .sidebar-user-name {
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
        }

        .sidebar-role {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.18);
            font-size: 11px;
            font-weight: bold;
        }

        .sidebar-menu {
            flex: 1;
            padding: 12px 14px;
            overflow-y: auto;
        }

        .menu-label {
            padding: 12px 10px 8px;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.55);
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 11px;
            min-height: 46px;
            margin-bottom: 5px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s ease;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.12);
            color: var(--white);
        }

        .menu-item.active {
            background: var(--white);
            color: var(--primary);
            font-weight: bold;
        }

        .menu-icon {
            width: 27px;
            height: 27px;
            display: grid;
            place-items: center;
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 13px;
            font-weight: bold;
        }

        .menu-item.active .menu-icon {
            background: var(--primary-light);
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .logout-button {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 8px;
            background: transparent;
            color: var(--white);
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background: rgba(255, 255, 255, 0.12);
        }


        .main-wrapper {
            min-height: 100vh;
            margin-left: var(--sidebar-width);
        }

        .topbar {
            height: 72px;
            padding: 0 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu-button {
            display: none;
            width: 40px;
            height: 40px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--white);
            color: var(--primary);
            font-size: 20px;
            cursor: pointer;
        }

        .page-title {
            font-size: 21px;
            color: var(--primary);
        }

        .page-description {
            margin-top: 4px;
            font-size: 13px;
            color: var(--muted);
        }

        .topbar-user {
            text-align: right;
        }

        .topbar-user strong {
            display: block;
            font-size: 14px;
        }

        .topbar-user span {
            font-size: 12px;
            color: var(--muted);
        }

        .content {
            max-width: 1500px;
            margin: auto;
            padding: 28px;
        }


        .card {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--white);
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        }

        .overlay {
            display: none;
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .menu-button {
                display: block;
            }

            .overlay {
                position: fixed;
                inset: 0;
                z-index: 950;
                background: rgba(0, 0, 0, 0.45);
            }

            .overlay.show {
                display: block;
            }

            .content {
                padding: 18px;
            }

            .topbar {
                padding: 0 18px;
            }

            .topbar-user {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

@php
    $role = Auth::user()->role;
@endphp

<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <img
            src="{{ asset('images/Logo BP Batam.gif') }}"
            alt="Logo BP Batam"
            class="sidebar-logo"
        >

        <div class="sidebar-title">
            Sistem Manajemen Risiko

            <span class="sidebar-subtitle">
                Unit PDSI BP Batam
            </span>
        </div>
    </div>

    <div class="sidebar-user">
        <div class="sidebar-user-name">
            {{ Auth::user()->name }}
        </div>

        <span class="sidebar-role">
            {{ $role }}
        </span>
    </div>

    <nav class="sidebar-menu">

        <div class="menu-label">
            MENU UTAMA
        </div>

        @if ($role === 'UPR')

            <a
                href="{{ route('upr.dashboard') }}"
                class="menu-item {{ request()->routeIs('upr.dashboard') ? 'active' : '' }}"
            >
                <span class="menu-icon">D</span>
                Dashboard
            </a>

            <a
                href="{{ route('risiko.index') }}"
                class="menu-item {{ request()->routeIs('risiko.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">R</span>
                Kelola Data Risiko
            </a>

        @elseif ($role === 'UMR')

            <a
                href="{{ route('umr.dashboard') }}"
                class="menu-item {{ request()->routeIs('umr.dashboard') ? 'active' : '' }}"
            >
                <span class="menu-icon">D</span>
                Dashboard
            </a>

            <a
                href="{{ route('verifikasi.index') }}"
                class="menu-item {{ request()->routeIs('verifikasi.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">V</span>
                Verifikasi Risiko
            </a>

        @elseif ($role === 'UPI')

            <a
                href="{{ route('upi.dashboard') }}"
                class="menu-item {{ request()->routeIs('upi.dashboard') ? 'active' : '' }}"
            >
                <span class="menu-icon">D</span>
                Dashboard
            </a>

            <a
                href="{{ route('reviu.index') }}"
                class="menu-item {{ request()->routeIs('reviu.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">R</span>
                Reviu Risiko
            </a>

            <a
                href="{{ route('users.index') }}"
                class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">P</span>
                Pengelolaan Pengguna
            </a>

        @endif

        <div class="menu-label">
            INFORMASI
        </div>

        <a
            href="{{ route('riwayat.index') }}"
            class="menu-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}"
        >
            <span class="menu-icon">H</span>
            Riwayat Aktivitas
        </a>

        <a
    href="{{ route('laporan.index') }}"
    class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
>
    <span class="menu-icon">L</span>
    Laporan Risiko
</a>

    </nav>

    <div class="sidebar-footer">
        <form
            method="POST"
            action="{{ route('logout') }}"
        >
            @csrf

            <button
                type="submit"
                class="logout-button"
            >
                Keluar dari Sistem
            </button>
        </form>
    </div>

</aside>

<div class="overlay" id="overlay"></div>

<div class="main-wrapper">

    <header class="topbar">

        <div class="topbar-left">
            <button
                type="button"
                class="menu-button"
                id="menuButton"
            >
                ☰
            </button>

            <div>
                <h1 class="page-title">
                    @yield('page-title', 'Dashboard')
                </h1>

                <p class="page-description">
                    @yield(
                        'page-description',
                        'Sistem Manajemen Risiko Unit PDSI BP Batam'
                    )
                </p>
            </div>
        </div>

        <div class="topbar-user">
            <strong>{{ Auth::user()->name }}</strong>
            <span>{{ $role }}</span>
        </div>

    </header>

    <main class="content">
        @yield('content')
    </main>

</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const menuButton = document.getElementById('menuButton');
    const overlay = document.getElementById('overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    }

    menuButton?.addEventListener('click', toggleSidebar);
    overlay?.addEventListener('click', toggleSidebar);
</script>

@stack('scripts')

</body>
</html>