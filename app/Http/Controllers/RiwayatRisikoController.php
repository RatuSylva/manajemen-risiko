<?php

namespace App\Http\Controllers;

use illuminate\Http\Request;
use App\Models\Risiko;
use App\Models\RiwayatRisiko;
use Illuminate\Support\Facades\Auth;

class RiwayatRisikoController extends Controller
{
    public function index(Request $request)
{
    $query = RiwayatRisiko::with([
            'risiko',
            'user',
        ])
        ->latest();

    /*
     * UPR hanya dapat melihat riwayat miliknya
     * atau riwayat risiko yang dibuat olehnya.
     */
    if (Auth::user()->role === 'UPR') {
        $query->where(function ($builder) {
            $builder
                ->where('user_id', Auth::id())
                ->orWhereHas('risiko', function ($risikoQuery) {
                    $risikoQuery->where(
                        'user_id',
                        Auth::id()
                    );
                });
        });
    }

    /*
     * Pencarian kode risiko, nama risiko,
     * deskripsi aktivitas, atau nama pengguna.
     */
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($builder) use ($search) {
            $builder
                ->where(
                    'deskripsi',
                    'like',
                    "%{$search}%"
                )
                ->orWhereHas(
                    'risiko',
                    function ($risikoQuery) use ($search) {
                        $risikoQuery
                            ->where(
                                'kode_risiko',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'nama_risiko',
                                'like',
                                "%{$search}%"
                            );
                    }
                )
                ->orWhereHas(
                    'user',
                    function ($userQuery) use ($search) {
                        $userQuery->where(
                            'name',
                            'like',
                            "%{$search}%"
                        );
                    }
                );
        });
    }

    /*
     * Filter berdasarkan jenis aktivitas.
     */
    if ($request->filled('jenis_aktivitas')) {
        $query->where(
            'jenis_aktivitas',
            $request->jenis_aktivitas
        );
    }

    /*
     * Filter berdasarkan role pelaksana.
     */
    if ($request->filled('role_pengguna')) {
        $query->where(
            'role_pengguna',
            $request->role_pengguna
        );
    }

    /*
     * Filter berdasarkan tanggal aktivitas.
     */
    if ($request->filled('tanggal_mulai')) {
        $query->whereDate(
            'created_at',
            '>=',
            $request->tanggal_mulai
        );
    }

    if ($request->filled('tanggal_selesai')) {
        $query->whereDate(
            'created_at',
            '<=',
            $request->tanggal_selesai
        );
    }

    $riwayats = $query
        ->paginate(10)
        ->withQueryString();

    return view(
        'riwayat.index',
        compact('riwayats')
    );
}

    public function show(Risiko $risiko)
    {
        if (
            Auth::user()->role === 'UPR' &&
            $risiko->user_id !== Auth::id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke riwayat risiko ini.'
            );
        }

        $riwayats = RiwayatRisiko::with('user')
            ->where('risiko_id', $risiko->id)
            ->oldest()
            ->get();

        return view(
            'riwayat.show',
            compact('risiko', 'riwayats')
        );
    }
}  