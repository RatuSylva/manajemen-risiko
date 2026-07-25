<?php

namespace App\Http\Controllers;

use App\Models\Risiko;
use App\Models\RiwayatRisiko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviuController extends Controller
{
   public function index(Request $request)
{
    /*
     * UPI hanya melihat risiko yang sudah
     * disetujui oleh UMR.
     */
    $query = Risiko::query()
        ->with([
            'user',
            'verifikator',
            'pereviu',
        ])
        ->where('status_verifikasi', 'Disetujui');

    /*
     * Pencarian berdasarkan kode, peristiwa,
     * sasaran, atau kategori risiko.
     */
    if ($request->filled('search')) {
        $search = trim($request->search);

        $query->where(function ($subQuery) use ($search) {
            $subQuery
                ->where('kode_risiko', 'like', "%{$search}%")
                ->orWhere('nama_risiko', 'like', "%{$search}%")
                ->orWhere('sasaran', 'like', "%{$search}%")
                ->orWhere('kategori_risiko', 'like', "%{$search}%");
        });
    }

    /*
     * Filter kategori risiko.
     */
    if ($request->filled('kategori_risiko')) {
        $query->where(
            'kategori_risiko',
            $request->kategori_risiko
        );
    }

    /*
     * Filter level risiko.
     */
    if ($request->filled('level_risiko')) {
        $query->where(
            'level_risiko',
            $request->level_risiko
        );
    }

    /*
     * Filter status reviu.
     */
    if ($request->filled('status_reviu')) {
        $query->where(
            'status_reviu',
            $request->status_reviu
        );
    }

    /*
     * Filter status penanganan.
     */
    if ($request->filled('status_penanganan')) {
        $query->where(
            'status_penanganan',
            $request->status_penanganan
        );
    }

    $risikos = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view(
        'reviu.index',
        compact('risikos')
    );
}
    public function update(
        Request $request,
        Risiko $risiko
    ) {
        /*
         * Risiko yang belum disetujui UMR
         * tidak boleh direviu oleh UPI.
         */
        abort_if(
            $risiko->status_verifikasi !== 'Disetujui',
            403,
            'Risiko belum disetujui oleh UMR.'
        );

        $data = $request->validate([
            'status_reviu' => [
                'required',
                Rule::in([
                    'Belum Direviu',
                    'Perlu Perbaikan',
                    'Disetujui',
                ]),
            ],

            'catatan_perbaikan' => [
                'nullable',
                'string',
                'max:1000',
                'required_if:status_reviu,Perlu Perbaikan',
            ],
        ], [
            'catatan_perbaikan.required_if' =>
                'Catatan perbaikan wajib diisi ketika status Perlu Perbaikan.',
        ]);

        /*
         * Kondisi lengkap sebelum keputusan UPI.
         */
        $dataSebelum = $this->buatSnapshot($risiko);

        $statusSebelum =
            $risiko->status_reviu
            ?? 'Belum Direviu';

        if (
            $data['status_reviu']
            === 'Belum Direviu'
        ) {
            $risiko->update([
                'status_reviu' =>
                    'Belum Direviu',

                'pereviu_id' =>
                    null,

                'tanggal_reviu' =>
                    null,

                'catatan_perbaikan' =>
                    $data['catatan_perbaikan']
                    ?? null,
            ]);
        }

        if (
            $data['status_reviu']
            === 'Perlu Perbaikan'
        ) {
            $risiko->update([
                'status_reviu' =>
                    'Perlu Perbaikan',

                'pereviu_id' =>
                    Auth::id(),

                'tanggal_reviu' =>
                    now(),

                'catatan_perbaikan' =>
                    $data['catatan_perbaikan'],
            ]);
        }

        if (
            $data['status_reviu']
            === 'Disetujui'
        ) {
            $risiko->update([
                'status_reviu' =>
                    'Disetujui',

                'pereviu_id' =>
                    Auth::id(),

                'tanggal_reviu' =>
                    now(),

                /*
                 * Catatan perbaikan lama dibersihkan
                 * jika dokumen sudah disetujui.
                 */
                'catatan_perbaikan' =>
                    null,
            ]);
        }

        $risiko->refresh();

        /*
         * Kondisi lengkap setelah keputusan UPI.
         */
        $dataSesudah = $this->buatSnapshot($risiko);

        $deskripsi =
            'UPI mengubah status reviu risiko '
            . $risiko->kode_risiko
            . ' dari '
            . $statusSebelum
            . ' menjadi '
            . $risiko->status_reviu
            . '.';

        if (!empty($data['catatan_perbaikan'])) {
            $deskripsi .=
                ' Catatan: '
                . $data['catatan_perbaikan'];
        }

        RiwayatRisiko::create([
            'risiko_id' =>
                $risiko->id,

            'user_id' =>
                Auth::id(),

            'role_pengguna' =>
                Auth::user()->role,

            'jenis_aktivitas' =>
                'Reviu Risiko',

            'status_sebelum' =>
                $statusSebelum,

            'status_sesudah' =>
                $risiko->status_reviu,

            'data_sebelum' =>
                $dataSebelum,

            'data_sesudah' =>
                $dataSesudah,

            'deskripsi' =>
                $deskripsi,
        ]);

        $pesan = match (
            $risiko->status_reviu
        ) {
            'Perlu Perbaikan' =>
                'Data dikembalikan kepada UPR untuk diperbaiki.',

            'Disetujui' =>
                'Hasil reviu disetujui dan data telah menjadi final.',

            default =>
                'Status reviu dikembalikan menjadi Belum Direviu.',
        };

        return redirect()
            ->route('reviu.index')
            ->with('success', $pesan);
    }

    private function buatSnapshot(
        Risiko $risiko
    ): array {
        return $risiko->attributesToArray();
    }
}