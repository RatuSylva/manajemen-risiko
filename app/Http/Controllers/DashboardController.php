<?php

namespace App\Http\Controllers;

use App\Models\Risiko;

class DashboardController extends Controller
{
    public function upr()
    {
        $userId = auth()->id();

        $totalRisiko = Risiko::where('user_id', $userId)->count();

        $menungguVerifikasi = Risiko::where('user_id', $userId)
            ->whereIn('status_verifikasi', [
                'Menunggu Verifikasi',
                'Belum Diverifikasi',
            ])
            ->count();

        $perluPerbaikan = Risiko::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('status_verifikasi', 'Perlu Perbaikan')
                    ->orWhere('status_reviu', 'Perlu Perbaikan');
            })
            ->count();

        $disetujui = Risiko::where('user_id', $userId)
            ->where('status_reviu', 'Disetujui')
            ->count();

        $belumDitangani = Risiko::where('user_id', $userId)
            ->where('status_penanganan', 'Belum Ditangani')
            ->count();

        $sedangBerjalan = Risiko::where('user_id', $userId)
            ->where('status_penanganan', 'Sedang Berjalan')
            ->count();

        $selesai = Risiko::where('user_id', $userId)
            ->where('status_penanganan', 'Selesai')
            ->count();

        return view('dashboard.upr', compact(
            'totalRisiko',
            'menungguVerifikasi',
            'perluPerbaikan',
            'disetujui',
            'belumDitangani',
            'sedangBerjalan',
            'selesai'
        ));
    }

    public function umr()
    {
        $totalRisiko = Risiko::count();

        $menungguVerifikasi = Risiko::whereIn('status_verifikasi', [
            'Menunggu Verifikasi',
            'Belum Diverifikasi',
        ])->count();

        $perluPerbaikan = Risiko::where(
            'status_verifikasi',
            'Perlu Perbaikan'
        )->count();

        $disetujui = Risiko::whereIn('status_verifikasi', [
            'Disetujui',
            'Terverifikasi',
        ])->count();

        return view('dashboard.umr', compact(
            'totalRisiko',
            'menungguVerifikasi',
            'perluPerbaikan',
            'disetujui'
        ));
    }

    public function upi()
    {
        $totalSiapDireviu = Risiko::whereIn('status_verifikasi', [
            'Disetujui',
            'Terverifikasi',
        ])->count();

        $belumDireviu = Risiko::whereIn('status_verifikasi', [
            'Disetujui',
            'Terverifikasi',
        ])
            ->where('status_reviu', 'Belum Direviu')
            ->count();

        $perluPerbaikan = Risiko::where(
            'status_reviu',
            'Perlu Perbaikan'
        )->count();

        $disetujui = Risiko::where(
            'status_reviu',
            'Disetujui'
        )->count();

        return view('dashboard.upi', compact(
            'totalSiapDireviu',
            'belumDireviu',
            'perluPerbaikan',
            'disetujui'
        ));
    }
}
