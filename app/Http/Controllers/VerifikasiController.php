<?php

namespace App\Http\Controllers;

use App\Models\Risiko;
use App\Models\RiwayatRisiko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VerifikasiController extends Controller
{
    public function index(Request $request)
{
    $query = Risiko::query()
        ->with([
            'user',
            'verifikator',
        ]);

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

    if ($request->filled('kategori_risiko')) {
        $query->where(
            'kategori_risiko',
            $request->kategori_risiko
        );
    }

    if ($request->filled('level_risiko')) {
        $query->where(
            'level_risiko',
            $request->level_risiko
        );
    }

    if ($request->filled('status_verifikasi')) {
        $query->where(
            'status_verifikasi',
            $request->status_verifikasi
        );
    }

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
        'verifikasi.index',
        compact('risikos')
    );
}

    public function update(
        Request $request,
        Risiko $risiko
    ) {
        $data = $request->validate([
            'status_verifikasi' => [
                'required',
                Rule::in([
                    'Menunggu Verifikasi',
                    'Perlu Perbaikan',
                    'Disetujui',
                ]),
            ],

            'catatan_verifikasi' => [
                'nullable',
                'string',
                'max:1000',
                'required_if:status_verifikasi,Perlu Perbaikan',
            ],
        ], [
            'catatan_verifikasi.required_if' =>
                'Catatan perbaikan wajib diisi ketika status Perlu Perbaikan.',
        ]);

        /*
         * Menyimpan kondisi lengkap sebelum keputusan UMR.
         */
        $dataSebelum = $this->buatSnapshot($risiko);

        $statusSebelum =
            $this->normalisasiStatusLama(
                $risiko->status_verifikasi
            );

        if (
            $data['status_verifikasi']
            === 'Menunggu Verifikasi'
        ) {
            $risiko->update([
                'status_verifikasi' =>
                    'Menunggu Verifikasi',

                'verifikator_id' => null,
                'tanggal_verifikasi' => null,

                'catatan_verifikasi' =>
                    $data['catatan_verifikasi'] ?? null,

                'status_reviu' =>
                    'Belum Direviu',

                'pereviu_id' => null,
                'tanggal_reviu' => null,
                'catatan_perbaikan' => null,
            ]);
        }

        if (
            $data['status_verifikasi']
            === 'Perlu Perbaikan'
        ) {
            $risiko->update([
                'status_verifikasi' =>
                    'Perlu Perbaikan',

                'verifikator_id' =>
                    Auth::id(),

                'tanggal_verifikasi' =>
                    now(),

                'catatan_verifikasi' =>
                    $data['catatan_verifikasi'],

                /*
                 * Belum boleh masuk tahap UPI.
                 */
                'status_reviu' =>
                    'Belum Direviu',

                'pereviu_id' => null,
                'tanggal_reviu' => null,
                'catatan_perbaikan' => null,
            ]);
        }

        if (
            $data['status_verifikasi']
            === 'Disetujui'
        ) {
            $risiko->update([
                'status_verifikasi' =>
                    'Disetujui',

                'verifikator_id' =>
                    Auth::id(),

                'tanggal_verifikasi' =>
                    now(),

                'catatan_verifikasi' =>
                    $data['catatan_verifikasi'] ?? null,

                /*
                 * Setelah disetujui UMR,
                 * data menunggu reviu UPI.
                 */
                'status_reviu' =>
                    'Belum Direviu',

                'pereviu_id' => null,
                'tanggal_reviu' => null,
                'catatan_perbaikan' => null,
            ]);
        }

        $risiko->refresh();

        $dataSesudah = $this->buatSnapshot($risiko);

        $deskripsi =
            'UMR mengubah status verifikasi risiko '
            . $risiko->kode_risiko
            . ' dari '
            . $statusSebelum
            . ' menjadi '
            . $risiko->status_verifikasi
            . '.';

        if (!empty($data['catatan_verifikasi'])) {
            $deskripsi .=
                ' Catatan: '
                . $data['catatan_verifikasi'];
        }

        RiwayatRisiko::create([
            'risiko_id' =>
                $risiko->id,

            'user_id' =>
                Auth::id(),

            'role_pengguna' =>
                Auth::user()->role,

            'jenis_aktivitas' =>
                'Verifikasi Risiko',

            'status_sebelum' =>
                $statusSebelum,

            'status_sesudah' =>
                $risiko->status_verifikasi,

            'data_sebelum' =>
                $dataSebelum,

            'data_sesudah' =>
                $dataSesudah,

            'deskripsi' =>
                $deskripsi,
        ]);

        $pesan = match (
            $risiko->status_verifikasi
        ) {
            'Perlu Perbaikan' =>
                'Data dikembalikan kepada UPR untuk diperbaiki.',

            'Disetujui' =>
                'Data berhasil disetujui dan diteruskan kepada UPI.',

            default =>
                'Status verifikasi dikembalikan menjadi Menunggu Verifikasi.',
        };

        return redirect()
            ->route('verifikasi.index')
            ->with('success', $pesan);
    }

    private function buatSnapshot(
        Risiko $risiko
    ): array {
        return $risiko->attributesToArray();
    }

    /*
     * Membaca data lama agar tetap kompatibel.
     */
    private function normalisasiStatusLama(
        ?string $status
    ): string {
        return match ($status) {
            'Belum Diverifikasi' =>
                'Menunggu Verifikasi',

            'Terverifikasi' =>
                'Disetujui',

            null, '' =>
                'Menunggu Verifikasi',

            default =>
                $status,
        };
    }
}